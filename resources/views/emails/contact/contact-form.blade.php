@component('mail::message')
# Introduction

Vous avez recu un message de la part de {{ $data['name'] }} ({{$data['email']}})

Objet
{{ $data['message'] }}

Message

{{ $data['message'] }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
