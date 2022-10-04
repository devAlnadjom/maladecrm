@component('mail::message')
# Salut.
{{ $message}}

Vous pouvez telecharger la facture via ce lien.
@component('mail::button', ['url' => $url])
Lien direct
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
