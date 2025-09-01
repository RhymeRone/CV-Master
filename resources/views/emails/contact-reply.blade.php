@component('mail::message')
# Merhaba {{ $contact->name }},

"{{ $contact->subject }}" konulu mesajınıza cevabımız aşağıdadır:

@component('mail::panel')
{{ $contact->reply }}
@endcomponent

Orijinal mesajınız:
@component('mail::panel')
{{ $contact->message }}
@endcomponent

Teşekkür ederiz,<br>
{{ config('app.name') }}
@endcomponent 