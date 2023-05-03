@component('mail::message')
    # Bienvenu {{ $userName }} chez Likdom

    l'équipe de likdom vous souhaite le bienvenu.
    Si vous avez des questions ou besoin d'assistance,
    n'hésitez pas à nous contacter à l'adresse : support@likdom.ma

    {{ config('app.name') }}
@endcomponent
