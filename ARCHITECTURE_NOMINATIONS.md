# Архитектура работы с номинациями и номинантами

Данный документ описывает архитектуру работы с номинациями и номинантами через паттерн CQRS (Command Query Responsibility Segregation) с использованием Resources и Requests в Laravel.

## Общая структура

Проект использует следующий подход:
1. **Request** - валидация входящих данных
2. **Controller** - точка входа, обработка HTTP запросов
3. **Query** - объект запроса (DTO)
4. **QueryHandler** - обработчик запроса, бизнес-логика
5. **Resource** - трансформация данных для API ответа

## Номинации (Nominations)

### Модель данных

**Модель:** `App\Models\Nomination`

**Структура:**
- `id` - идентификатор номинации
- `year_id` - связь с годом премии
- `nominee_category_id` - связь с категорией номинанта
- `name` - название номинации
- `active` - флаг активности

**Связи:**
- `year()` - BelongsTo `Year`
- `category()` - BelongsTo `NomineeCategory`

### API Endpoints

#### 1. Список номинаций (справочник)

**Endpoint:** `GET /api/references/nominations`

**Параметры запроса:**
- `year_ids[]` (опционально) - массив ID годов из таблицы `years` для фильтрации

**Пример запроса:**
```
GET /api/references/nominations?year_ids[]=1&year_ids[]=2
```

**Поток выполнения:**

1. **Route** (`routes/api.php`)
   ```php
   Route::get('/nominations', [ReferencesController::class, 'nominations']);
   ```

2. **Controller** (`App\Http\Controllers\Api\ReferencesController`)
   ```php
   public function nominations(Request $request): AnonymousResourceCollection
   {
       $yearIds = $request->input('year_ids');
       if ($yearIds !== null && !is_array($yearIds)) {
           $yearIds = [$yearIds];
       }

       $query = new ReferenceNominationsListQuery(
           yearIds: $yearIds,
       );

       $items = $this->nominationsListHandler->execute($query);

       return NominationResource::collection($items);
   }
   ```

3. **Query** (`App\CQRS\Queries\ReferenceNominationsListQuery`)
   ```php
   final readonly class ReferenceNominationsListQuery
   {
       public function __construct(
           public ?array $yearIds = null,
       ) {
       }
   }
   ```
   - Immutable объект (readonly)
   - Содержит только параметры запроса
   - Не содержит бизнес-логики

4. **QueryHandler** (`App\CQRS\Handlers\ReferenceNominationsListQueryHandler`)
   ```php
   final readonly class ReferenceNominationsListQueryHandler
   {
       public function execute(ReferenceNominationsListQuery $query): Collection
       {
           $builder = Nomination::query()
               ->with(['year', 'category'])
               ->active()
               ->ordered();

           if ($query->yearIds !== null && !empty($query->yearIds)) {
               $builder->whereIn('year_id', $query->yearIds);
           }

           return $builder->get();
       }
   }
   ```
   - Выполняет запрос к БД
   - Применяет фильтры
   - Загружает связанные данные (eager loading)
   - Возвращает коллекцию моделей

5. **Resource** (`App\Http\Resources\NominationResource`)
   ```php
   final class NominationResource extends JsonResource
   {
       public function toArray(Request $request): array
       {
           return [
               'id' => $this->id,
               'category' => $this->whenLoaded('category', 
                   fn() => NomineeCategoryResource::make($this->category)->toArray($request)
               ),
               'year' => $this->whenLoaded('year', 
                   fn() => YearResource::make($this->year)->toArray($request)
               ),
               'name' => $this->name,
           ];
       }
   }
   ```
   - Трансформирует модель в массив для JSON ответа
   - Использует `whenLoaded()` для условной загрузки связанных данных
   - Вложенные ресурсы для связанных моделей

**Ответ API:**
```json
{
  "data": [
    {
      "id": 1,
      "category": {
        "id": 1,
        "name": "Лучший сайт",
        "slug": "best-site"
      },
      "year": {
        "year": 2024,
        "name": "2024 год"
      },
      "name": "Номинация 2024"
    }
  ]
}
```

### Связанные ресурсы

#### YearResource
**Файл:** `App\Http\Resources\YearResource`

Используется для представления года премии:
```php
return [
    'year' => $this->year,
    'name' => $this->name,
];
```

#### NomineeCategoryResource
**Файл:** `App\Http\Resources\NomineeCategoryResource`

Используется для представления категории:
```php
return [
    'id' => $this->id,
    'name' => $this->name,
    'slug' => $this->slug,
];
```

## Номинанты (Nominees)

### Модель данных

**Модель:** `App\Models\Nominee`

**Структура:**
- `id` - идентификатор номинанта
- `name` - название номинанта
- `website_url` - ссылка на сайт
- `image` - путь к изображению
- `rating` - общий рейтинг
- `active` - флаг активности

**Связи:**
- `types()` - BelongsToMany `NomineeType` (через `nominee_type`)
- `nominations()` - BelongsToMany `Nomination` (через `nominee_nomination`)
  - Pivot поля: `nominee_category_id`, `rating`, `place`

### API Endpoints

#### 1. Список номинантов

**Endpoint:** `GET /api/nominees`

**Параметры запроса:**
- `page` (опционально, default: 1) - номер страницы
- `per_page` (опционально, default: 20, max: 100) - количество на странице
- `nomination_ids[]` (опционально) - фильтр по номинациям
- `type_ids[]` (опционально) - фильтр по типам
- `year_ids[]` (опционально) - фильтр по годам (массив годов, например [2024, 2023])

**Пример запроса:**
```
GET /api/nominees?page=1&per_page=20&nomination_ids[]=1&nomination_ids[]=2&year_ids[]=2024
```

**Поток выполнения:**

1. **Route** (`routes/api.php`)
   ```php
   Route::get('/nominees', [NomineesController::class, 'list']);
   ```

2. **Request** (`App\Http\Requests\NomineeListRequest`)
   ```php
   final class NomineeListRequest extends FormRequest
   {
       public function rules(): array
       {
           return [
               'page' => ['sometimes', 'integer', 'min:1'],
               'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
               'nomination_ids' => ['sometimes', 'array'],
               'nomination_ids.*' => ['integer'],
               'type_ids' => ['sometimes', 'array'],
               'type_ids.*' => ['integer'],
               'year_ids' => ['sometimes', 'array'],
               'year_ids.*' => ['integer'],
           ];
       }
   }
   ```
   - Валидирует входящие данные
   - Автоматически применяется Laravel при инъекции в контроллер

3. **Controller** (`App\Http\Controllers\Api\NomineesController`)
   ```php
   public function list(NomineeListRequest $request): AnonymousResourceCollection
   {
       $validated = $request->validated();

       $query = new NomineeListQuery(
           page: isset($validated['page']) ? (int) $validated['page'] : 1,
           perPage: isset($validated['per_page']) ? (int) $validated['per_page'] : 20,
           winners: false,
           nominationIds: $validated['nomination_ids'] ?? null,
           typeIds: $validated['type_ids'] ?? null,
           yearIds: $validated['year_ids'] ?? null,
       );

       $result = $this->listHandler->execute($query);

       return NomineeResource::collection($result);
   }
   ```
   - Получает валидированные данные из Request
   - Создает Query объект
   - Вызывает Handler
   - Возвращает Resource коллекцию

4. **Query** (`App\CQRS\Queries\NomineeListQuery`)
   ```php
   final readonly class NomineeListQuery
   {
       public function __construct(
           public int $page = 1,
           public int $perPage = 20,
           public ?bool $winners = null,
           public ?array $nominationIds = null,
           public ?array $typeIds = null,
           public ?array $yearIds = null,
       ) {
       }
   }
   ```

5. **QueryHandler** (`App\CQRS\Handlers\NomineeListQueryHandler`)
   ```php
   final readonly class NomineeListQueryHandler
   {
       public function execute(NomineeListQuery $query): LengthAwarePaginator
       {
           $builder = Nominee::query()
               ->with([
                   'types' => fn($q) => $q->active()->ordered(),
                   'nominations' => fn($q) => $q->active()
                       ->with(['year', 'category'])
                       ->ordered()
               ])
               ->active()
               ->when($query->nominationIds, fn ($q) => 
                   $q->whereHas('nominations', fn ($subQ) => 
                       $subQ->whereIn('nominations.id', $query->nominationIds)
                   )
               )
               ->when($query->typeIds, fn ($q) => 
                   $q->whereHas('types', fn ($subQ) => 
                       $subQ->whereIn('nominee_types.id', $query->typeIds)
                   )
               )
               ->when($query->yearIds, fn ($q) => 
                   $q->whereHas('nominations', fn ($subQ) => 
                       $subQ->whereHas('year', fn ($yearQ) => 
                           $yearQ->whereIn('years.year', $query->yearIds)
                       )
                   )
               )
               ->when(!$query->winners, fn($q) => $q->ordered());

           return $builder->paginate($query->perPage, ['*'], 'page', $query->page);
       }
   }
   ```
   - Eager loading связанных данных для оптимизации запросов
   - Условные фильтры через `when()`
   - Использование `whereHas()` для фильтрации по связям
   - Возвращает пагинированный результат

6. **Resource** (`App\Http\Resources\NomineeResource`)
   ```php
   final class NomineeResource extends JsonResource
   {
       public function toArray(Request $request): array
       {
           return [
               'id' => $this->id,
               'name' => $this->name,
               'website_url' => $this->website_url,
               'image' => $this->image,
               'rating' => $this->rating !== null ? (float) $this->rating : null,
               'types' => $this->whenLoaded('types', 
                   fn() => NomineeTypeResource::collection($this->types)
               ),
               'nominations' => $this->whenLoaded('nominations', 
                   fn() => NomineeNominationResource::collection($this->nominations)
               ),
           ];
       }
   }
   ```

**Ответ API:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Номинант 1",
      "website_url": "https://example.com",
      "image": "/storage/nominees/1.jpg",
      "rating": 4.5,
      "types": [
        {
          "id": 1,
          "name": "Сайт",
          "slug": "site"
        }
      ],
      "nominations": [
        {
          "nomination": {
            "id": 1,
            "category": {
              "id": 1,
              "name": "Лучший сайт",
              "slug": "best-site"
            },
            "year": {
              "year": 2024,
              "name": "2024 год"
            },
            "name": "Номинация 2024"
          },
          "rating": 4.5,
          "place": 1
        }
      ]
    }
  ],
  "links": {...},
  "meta": {...}
}
```

#### 2. Номинанты-победители

**Endpoint:** `GET /api/nominees/winners`

Аналогичен списку номинантов, но:
- `winners: true` в Query
- Использует `NomineeWinnerResource` вместо `NomineeResource`
- Специальная логика для победителей (места 1, 2, 3)

#### 3. Количество номинантов по категориям

**Endpoint:** `GET /api/nominees/count-by-category`

**Параметры:**
- `year_ids[]` (опционально) - фильтр по годам

**Handler:** `App\CQRS\Handlers\NomineeCountByCategoryQueryHandler`

Возвращает массив: `{category_id: count}`

### Связанные ресурсы

#### NomineeNominationResource
**Файл:** `App\Http\Resources\NomineeNominationResource`

Используется для представления связи номинанта с номинацией:
```php
return [
    'nomination' => NominationResource::make($this)->toArray($request),
    'rating' => $this->pivot->rating !== null ? (float) $this->pivot->rating : null,
    'place' => $this->pivot->place ?? null,
];
```

- `nomination` - полный объект номинации (через NominationResource)
- `rating` - рейтинг номинанта в этой номинации (из pivot таблицы)
- `place` - место номинанта в этой номинации (из pivot таблицы)

#### NomineeTypeResource
**Файл:** `App\Http\Resources\NomineeTypeResource`

Используется для представления типа номинанта:
```php
return [
    'id' => $this->id,
    'name' => $this->name,
    'slug' => $this->slug,
];
```

## Жюри (Juries)

### Использование номинаций в жюри

**Endpoint:** `GET /api/juries`

**Resource:** `App\Http\Resources\JuryResource`

Поле `nominations` возвращает массив `NominationResource[]`:

```php
'nominations' => $this->whenLoaded('nominations', 
    fn () => NominationResource::collection($this->nominations)
),
```

**Handler:** `App\CQRS\Handlers\JuryListQueryHandler`

Загружает номинации с связанными данными:
```php
'nominations' => fn($q) => $q->active()->with(['year', 'category'])
```

## Преимущества архитектуры

### 1. Разделение ответственности
- **Request** - валидация
- **Controller** - координация
- **Query/Handler** - бизнес-логика
- **Resource** - представление данных

### 2. Тестируемость
- Каждый компонент можно тестировать изолированно
- Handlers легко мокать
- Resources можно тестировать отдельно

### 3. Переиспользование
- Resources можно использовать в разных контроллерах
- Handlers можно вызывать из разных мест
- Queries - чистые DTO объекты

### 4. Типобезопасность
- Readonly классы для Queries
- Строгая типизация в PHP 8.2+
- PHPDoc аннотации для массивов

### 5. Производительность
- Eager loading предотвращает N+1 проблемы
- Условная загрузка через `whenLoaded()`
- Оптимизированные запросы в Handlers

## Диаграмма потока данных

```
HTTP Request
    ↓
Route
    ↓
Controller
    ↓
Request (валидация)
    ↓
Query (DTO)
    ↓
QueryHandler (бизнес-логика, запрос к БД)
    ↓
Model Collection
    ↓
Resource (трансформация)
    ↓
JSON Response
```

## Примеры использования

### Получение номинаций за 2024 год

```php
// Controller
$query = new ReferenceNominationsListQuery(yearIds: [1]); // где 1 - ID года 2024
$nominations = $handler->execute($query);
return NominationResource::collection($nominations);
```

### Фильтрация номинантов по номинациям

```php
// Controller
$query = new NomineeListQuery(
    nominationIds: [1, 2, 3], // ID номинаций
    page: 1,
    perPage: 20
);
$nominees = $handler->execute($query);
return NomineeResource::collection($nominees);
```

## Заметки по разработке

1. **Всегда используйте eager loading** для связанных данных в Handlers
2. **Проверяйте загрузку** через `whenLoaded()` в Resources
3. **Используйте readonly** для Query объектов
4. **Валидируйте данные** через FormRequest
5. **Документируйте API** через OpenAPI атрибуты

