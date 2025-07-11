<h4>Новый тестовый заказ на сайте <a href="{{config('app.url')}}">{{config('app.name')}}</a></h4>
<p>Сумма заказа: {{$order->sum}}</p>
<a href="https://test.example/object/{{$order->object->slug ?? 'test'}}">Тестовый объект: {{$order->object->name ?? 'Тестовый объект'}}</a>
Тестовые сущности:
@foreach($order->items as $orderItem)
    <ul>
        <li>
            Тестовое имя: {{$orderItem->test_name ?? 'Тест Имя'}}
        </li>
        <li>Тестовая дата: {{$orderItem->test_date ?? '2023-01-01'}}</li>
        <li>Тестовая цена: {{$orderItem->test_price ?? '0'}}</li>
        <li>Тестовая сущность: {{$orderItem->test_entity ?? 'Тестовая сущность'}}</li>
    </ul>
@endforeach
