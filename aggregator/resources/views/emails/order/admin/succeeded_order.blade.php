<h4>Тестовый заказ №{{$order->id}} успешно оплачен на сайте
    <a href="{{config('app.url')}}">{{config('app.name')}}</a>
</h4>
<a href="https://test.example/object/{{$order->object->slug ?? 'test'}}">Тестовый объект: {{$order->object->name ?? 'Тестовый объект'}}</a>
Тестовые сущности:
@foreach($order->items as $orderItem)
    <ul>
        <li>
            Тестовое имя: {{$orderItem->test_name ?? 'Тест Имя'}}
        </li>
    </ul>
@endforeach
