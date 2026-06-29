<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard | Empleo Lerma')</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
</head>
<body>
{{-- Layout operativo para usuarios autenticados: sidebar en escritorio y offcanvas en móvil. --}}
@php
    /*
     * Estado visible de sesión para la barra superior.
     *
     * Mantenerlo fuera del menú vertical evita que la navegación cambie de alto
     * entre vistas y deja las acciones de cuenta en una zona esperada.
     */
    $user = auth()->user();
    $accessTone = match ($user->status->value) {
        'active' => 'success',
        'expired' => 'warning',
        'suspended', 'revoked' => 'danger',
        default => 'secondary',
    };

    $accessLabel = $user->status->label();
@endphp

<div class="dashboard-layout">
    <aside class="dashboard-sidebar d-none d-lg-flex">
        <x-dashboard-navigation :user="$user" />
    </aside>

    <div class="offcanvas offcanvas-start dashboard-offcanvas" tabindex="-1" id="dashboardMenu" aria-labelledby="dashboardMenuLabel">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title h5" id="dashboardMenuLabel">Menú</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body">
            <x-dashboard-navigation :user="$user" />
        </div>
    </div>

    <main class="dashboard-content">
        <header class="dashboard-topbar">
            <div class="dashboard-mobilebar d-lg-none">
                <a href="{{ route('home') }}" class="dashboard-mobilebrand">
                    <img src="{{ asset('images/brand/logo_lerma_oficial.svg') }}" alt="Ayuntamiento de Lerma">
                    <span>Empleo Lerma</span>
                </a>

                <button class="btn btn-outline-primary btn-sm dashboard-menu-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#dashboardMenu" aria-controls="dashboardMenu">
                    <x-ui-icon name="menu" class="button-icon" />
                    Menú
                </button>
            </div>

            <div class="dashboard-accountbar">
                <div class="dashboard-account-summary">
                    <strong>{{ $user->name }}</strong>
                </div>

                <a class="btn btn-outline-secondary btn-sm" href="{{ route('home') }}">
                    Sitio público
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" type="submit">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </header>

        <div class="dashboard-main-area">
            <header class="dashboard-page-header">
                <p class="text-muted mb-1">{{ $user->role->label() }}</p>
                <h1 class="section-title h3 mb-0">@yield('heading')</h1>
            </header>

            @yield('content')
        </div>

        <x-app-footer />
    </main>
</div>
</body>
</html>
