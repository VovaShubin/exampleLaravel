<h4>Мы получили Ваш вопрос на сайте <a href="{{config('app.url')}}"> {{config('app.name')}}</a>. В скором времени мы с Вами свяжемся.</h4>
<p>
    Имя: {{$feedback->user_data['name']}}
</p>
<p>
    Email: {{$feedback->user_data['email']}}
</p>
<p>
    Сообщение: {{$feedback->user_data['question']}}
</p>
