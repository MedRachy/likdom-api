@component('mail::message')
    # Bienvenu {{ $userName }} chez Likdom

    l'équipe de likdom vous souhaite le bienvenu


    Merci,<br>
    {{ config('app.name') }}
@endcomponent
