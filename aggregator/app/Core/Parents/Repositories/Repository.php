<?php

namespace App\Core\Parents\Repositories;

use App\Core\Exceptions\NotFoundException;
use App\Core\Parents\Models\Model;
use Closure;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Throwable;

abstract class Repository
{
    public const SORT_DEFAULT = 'id';
    protected array $detailRelations = [];

    protected array $listRelations = [];

    protected array $calls = [];

    abstract public function model(): string;

    /**@throws Throwable */
    public function queryOrNotFoundException(string $method, ...$params): mixed
    {
        $result = $this->resolve($method, ...$params);
        if (empty($result)) {
            throw new NotFoundException();
        }
        return $result;
    }

    protected function resolve(string $method, ...$params): mixed
    {
        if (!method_exists($this, $method)) {
            throw new \InvalidArgumentException('method not exists');
        }
        return $this->$method(...$params);
    }

    public function byId(int $id): ?Model
    {
        /** @var Model|null $model */
        $model = $this->buildBaseQuery($this->detailRelations)
            ->where('id', $id)
            ->first();
        return $model;
    }

    public function bySlug(string $slug): ?Model
    {
        /** @var Model|null $model */
        $model = $this->buildBaseQuery($this->detailRelations)
            ->where('slug', $slug)
            ->first();
        return $model;
    }

    public function byUniqueKey(string $value)
    {
        return intval($value) == 0
            ? $this->bySlug($value)
            : $this->byId($value);
    }

    /**
     * @param array $filters
     * @param array|null $sorts
     * @param array $paginationParams
     * @return LengthAwarePaginator
     */
    public function listPaginated(array $filters = [], ?array $sorts = [], array $paginationParams = []): LengthAwarePaginator
    {
        $q = $this->buildQuery($filters, $sorts);

        return $q->paginate(...$paginationParams);
    }

    /**
     * @param array $filters
     * @param array|null $sorts
     * @return array
     */
    public function list(array $filters = [], ?array $sorts = []): array
    {
        $q = $this->buildQuery($filters, $sorts);

        return $q->get()->toArray();
    }

    /**
     * @param array $filters
     * @return int
     */
    public function count(array $filters = []): int
    {
        $q = $this->buildQuery($filters, null);

        return $q->count();
    }

    protected function buildQuery(array $filters, ?array $sorts, ?array $additionalRelations = []): Builder
    {
        $q = $this->buildBaseQuery($additionalRelations);

        $q = $this->addFiltersToQuery($q, $filters);

        $q = $this->addSortingToQuery($q, $sorts);

        return $q;
    }

    /**
     * Override this method to specify needed fields and relationship loadings
     *
     * @param array|null $additionalRelations
     * @return Builder
     */
    protected function buildBaseQuery(?array $additionalRelations = []): Builder
    {
        /** @var Model $model */
        $model = $this->model();

        $q = $model::query();

        return !empty($additionalRelations) ? $q->with($additionalRelations) : $q;
    }

    /**
     * Override this method to add filter logic
     *
     * @param Builder $q
     * @param array $filters
     * @return Builder
     */
    protected function addFiltersToQuery(Builder $q, array $filters): Builder
    {
        return $q;
    }

    /**
     * Implements base sorting logic
     *
     * @param Builder $q
     * @param array|null $sorts
     * @return Builder
     */
    protected function addSortingToQuery(Builder $q, ?array $sorts = []): Builder
    {
        // no sorting if null passed
        if ($sorts === null) {
            return $q;
        }

        // default sorting
        if ($sorts === []) {
            return $q->orderBy(static::SORT_DEFAULT);
        }

        // sorting
        foreach ($sorts as $sortField) {

            //add some extra validation to check sort field is existed
            //throw_if(!$q->getModel()->isFillable($sortField), \App\Core\Exceptions\Exception::class, 'Incorrect sort field');

            if (str_starts_with($sortField, '-')) {
                $q->orderByDesc(substr($sortField, 1));
            } else {
                $q->orderBy($sortField);
            }
        }

        return $q;
    }

    public function update(int $id, array $payload): bool
    {
        $model = $this->buildBaseQuery()->find($id);
        return $model->update($payload);
    }

    public function insert(array $payload): ?Model
    {
        $payment = new ($this->model())($payload);
        return $payment->save() ? $payment : null;
    }
}
