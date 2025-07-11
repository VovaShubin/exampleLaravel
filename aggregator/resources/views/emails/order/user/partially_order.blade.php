<h4>Ваш тестовый заказ №{{$order->id}} на сумму {{$order->sum}} частично оплачен и ожидает оплату 50% на сайте
    <a href="{{config('app.url')}}">{{config('app.name')}}</a>
</h4>
<p>Оплачено: {{$order->balance}}</p>
<p>Сумма к оплате: {{($order->sum ?? 0) - ($order->balance ?? 0)}}</p>
<p>
    <a href="https://test.example/order/{{$order->id}}">Ссылка на тестовый заказ</a>
</p>
