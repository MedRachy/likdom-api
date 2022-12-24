<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Espace admin') }}</title>
    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/e807f8aa79.js" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
    <!-- admin template -->
    <link href="{{ asset('css/template-admin.css') }}" rel="stylesheet">

</head>

<body class="sb-nav-fixed">
    @include('Components.topnav_admin')
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('Components.sidebar_nav')
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                @include('Components.footer_admin')
            </footer>
        </div>
    </div>
    {{-- toast notif for new reservation --}}
    <div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('script')
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            // Toggle the side navigation
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            if (sidebarToggle) {
                // Uncomment Below to persist sidebar toggle between refreshes
                // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
                //     document.body.classList.toggle('sb-sidenav-toggled');
                // }
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                    localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains(
                        'sb-sidenav-toggled'));
                });
            }

        });
    </script>

</body>

</html>
