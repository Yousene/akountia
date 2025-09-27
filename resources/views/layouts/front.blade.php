<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Afrique Academy')</title>
    <meta name="description" content="@yield('meta_description', 'Afrique Academy - Formation professionnelle en ligne')">

    <!-- OpenGraph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'Afrique Academy')">
    <meta property="og:description" content="@yield('meta_description', 'Afrique Academy - Formation professionnelle en ligne')">
    <meta property="og:image" content="@yield('og_image', asset('assets/img/logo/logo_home_afrique-academy.svg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Afrique Academy">
    <meta property="og:locale" content="fr_FR">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Afrique Academy')">
    <meta name="twitter:description" content="@yield('meta_description', 'Afrique Academy - Formation professionnelle en ligne')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/img/logo/logo_home_afrique-academy.svg'))">

    <!-- Autres Meta Tags -->
    <meta name="author" content="Afrique Academy">
    <meta name="theme-color" content="#00556e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <style>
        :root {
            /* Couleurs principales d'Afrique Academy */
            --primary: #00556e;
            --primary-hover: #004a61;
            --primary-active: #003f54;
            --primary-light: #e5f0f3;
            --secondary: #46aac6;
            --text-primary: #00556e;
            --text-secondary: #697a8d;
            --bg-primary: #fff;
            --bg-secondary: #f5f9fa;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: var(--bg-secondary);
            color: var(--text-secondary);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-primary:active {
            background-color: var(--primary-active) !important;
            border-color: var(--primary-active) !important;
        }

        .card {
            border-radius: 0.375rem;
            box-shadow: 0 0.25rem 1rem rgba(161, 172, 184, 0.45);
            border: 0;
        }

        .card-header {
            background-color: var(--primary);
            color: black;
            border-radius: 0.375rem 0.375rem 0 0 !important;
            border-bottom: 0;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 85, 110, 0.25);
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 15px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            max-width: 200px;
            height: auto;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('assets/img/logo/logo_home_afrique-academy.svg') }}" alt="Afrique Academy" />
        </div>
        @yield('content')
    </div>

    <!-- Chargement des scripts dans le bon ordre -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    @yield('js')
</body>

</html>
