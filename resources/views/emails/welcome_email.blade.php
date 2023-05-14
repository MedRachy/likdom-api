@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => 'https://likdom.ma'])
            <img src="https://likdom.ma/storage/Shape@2x.png" alt="likdom logo" class="logo">
        @endcomponent
    @endslot

    {{-- Body --}}
    <h1>Bienvenu chez Likdom</h1>

    <p>L'équipe de likdom vous souhaite le bienvenu.
        Nous proposons des passages ponctuels ou des abonnements à travers des offres préétablies, nous mettons à votre
        disposition des agents qualifiés et formés qui travaillent pour assurer votre satisfaction.

        Si vous avez des questions ou besoin d'assistance,
        n'hésitez pas à nous contacter à l'adresse support@likdom.ma
    </p>

    {{-- Subcopy --}}
    {{-- @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset --}}

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
