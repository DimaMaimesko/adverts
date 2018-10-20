@component('mail::message')

    {{$message}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
    {{$email}}<br>{{$name}}<br>{{ config('app.name') }}
@endcomponent
