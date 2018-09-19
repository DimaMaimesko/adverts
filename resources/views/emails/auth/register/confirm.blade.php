
@component('mail::message')
    # Email confirmation

   Please, refer to the following link:

    @component('mail::button', ['url' => route('verify',['token'=> $user->verify_token])])
       Verify Email
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent