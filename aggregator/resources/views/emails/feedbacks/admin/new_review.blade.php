<h4>Оставлен отзыв на сайте <a href="{{config('app.url')}}"> {{config('app.name')}} </a></h4>
<p>
    Имя: {{$review['name'] ?? ''}}
</p>
<p>
    Email или телефон: {{$review['contact'] ?? ''}}
</p>
<p>
    Оценка: {{$review['rating'] ?? ''}}
</p>
<p>
    Отзыв: {{$review['text'] ?? ''}}
</p>
