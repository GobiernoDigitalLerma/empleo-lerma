<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Empleo Lerma')</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body>
<div class="app-shell d-flex flex-column">
    <div class="official-strip">
        <div class="container">
            <span>Aplicación Oficial del Municipio de Lerma</span>
            <a href="https://lerma.gob.mx/" target="_blank" rel="noopener">lerma.gob.mx</a>
        </div>
    </div>

    <header class="public-header">
        <div class="container">
            <div class="public-identity-bar">
                <a class="public-navbar__brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/brand/logo_lerma_oficial.svg') }}" alt="Ayuntamiento de Lerma">
                    <span>Empleo Lerma</span>
                </a>

                <div class="public-account-actions">
                    @auth
                        <a class="public-account-link" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isCompany() ? route('company.dashboard') : route('citizen.dashboard')) }}">Dashboard</a>
                    @else
                        <a class="public-account-link" href="{{ route('login') }}">Entrar</a>
                        <a class="public-account-link" href="{{ route('register', 'citizen') }}">Registrarme</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg public-menu-bar" aria-label="Navegación pública">
        <div class="container">
            <button class="navbar-toggler public-menu-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav" aria-controls="publicNav" aria-expanded="false" aria-label="Abrir menú público">
                <span>Menú</span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="publicNav">
                <ul class="navbar-nav public-menu">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('home')]) href="{{ route('home') }}">
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('public.job-seeker')]) href="{{ route('public.job-seeker') }}">
                            <span>Busco empleo</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('public.employer')]) href="{{ route('public.employer') }}">
                            <span>Ofrezco empleo</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('vacancies.*')]) href="{{ route('vacancies.index') }}">
                            <span>Vacantes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('events.*')]) href="{{ route('events.index') }}">
                            <span>Eventos</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1">@yield('content')</main>
    <x-app-footer />
</div>
</body>
</html>
