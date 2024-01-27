<x-mail::message>
# Good day Mr/Ms {{ $student->last_name }},

Your TOR Accreditation has been forwarded to the corresponding program chairman. You may check your TOR subject accreditation status on USTPAS website using your tracking code: {{ $code->code }}.

@component('mail::button', ['url' => 'http://127.0.0.1:8000'])
Proceed
@endcomponent

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
