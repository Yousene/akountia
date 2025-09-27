<!DOCTYPE html>
<html lang="fr" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="/assets/" data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title') | {{ $apparence->label }}</title>
    <meta name="description" content="@yield('description')" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-afrique-academy.css') }}">

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">

    @yield('custom_styles')
</head>

<body>
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            @if ($apparence && $apparence->logo_home)
                <div class="app-brand mb-4">
                    <img src="{{ asset($apparence->logo_home) }}" alt="{{ $apparence->label }}" class="img-fluid"
                        style="max-width: 200px; height: auto;" />
                </div>
            @endif

            @yield('content')
            @if (!isset(auth()->user()->role))
                <a href="{{ route('home') }}" class="btn btn-primary">Revenir à la page d'accueil</a>
            @endif
            @yield('return_button')
        </div>
    </div>

    @if ($apparence && $apparence->logo)
        <div class="brand-logo-bottom">
            <img src="{{ asset($apparence->logo) }}" alt="{{ $apparence->label }}" height="70">
        </div>
    @endif

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>

    @yield('custom_scripts')
</body>

</html>
