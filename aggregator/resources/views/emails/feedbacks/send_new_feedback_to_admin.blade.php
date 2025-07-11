<h4>Новый результат по форме обратной связи '{{$feedback->feedbackForm->title}}'</h4>
@if(isset($feedback->user_data['name']))
    <p>
        Имя: {{$feedback->user_data['name']}}
    </p>
@endif
@if(isset($feedback->user_data['message']))
    <p>
        Сообщение: {{$feedback->user_data['message']}}
    </p>
@endif
@if(isset($feedback->user_data['question']))
    <p>
        Вопрос: {{$feedback->user_data['question']}}
    </p>
@endif
@if(isset($feedback->user_data['contact']))
    <p>
        Контакт: {{$feedback->user_data['contact']}}
    </p>
@endif
@if(isset($feedback->user_data['email']))
    <p>
        Email: {{$feedback->user_data['email']}}
    </p>
@endif
@if(isset($feedback->user_data['phone']))
    <p>
        Телефон: {{$feedback->user_data['phone']}}
    </p>
@endif
<br>
