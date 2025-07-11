<h4>Отправлено резюме на сайте <a href="{{config('app.url')}}"> {{config('app.name')}} </a></h4>
<p>
    Имя: {{$feedback->user_data['name'] ?? ''}}
</p>
<p>
    Email или Телефон: {{$feedback->user_data['contact'] ?? ''}}
</p>
Резюме:
<ul>
    @foreach($feedback->user_data['files'] ?? [] as $file)
        <li>{{$file}}</li>
    @endforeach
</ul>
