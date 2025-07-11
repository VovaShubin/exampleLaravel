<h4>Получен новый вопрос на сайте <a href="{{config('app.url')}}"> {{config('app.name')}} </a></h4>
<p>
    Имя: {{$feedback->user_data['name']}}
</p>
<p>
    Email: {{$feedback->user_data['email']}}
</p>
<p>
    Сообщение: {{$feedback->user_data['question']}}
</p>
