@props(['user'])

@php
    /*
     * Navegación principal para usuarios autenticados.
     *
     * El componente concentra los menús por rol para que el layout no tenga
     * condiciones duplicadas y un desarrollador junior pueda ubicar rápido
     * dónde se agregan nuevas secciones del dashboard.
     */
    $navigation = match (true) {
        $user->isAdmin() => [
            ['label' => 'Resumen', 'route' => 'admin.dashboard', 'icon' => 'home'],
            ['label' => 'Ciudadanos', 'route' => 'admin.users.index', 'icon' => 'users'],
            ['label' => 'Empresas', 'route' => 'admin.companies.index', 'icon' => 'building'],
            ['label' => 'Vacantes', 'route' => 'admin.vacancies.index', 'icon' => 'briefcase'],
            ['label' => 'Eventos', 'route' => 'admin.events.index', 'icon' => 'calendar'],
            ['label' => 'Catálogos', 'route' => 'admin.catalogs.index', 'icon' => 'tags'],
            ['label' => 'Notificaciones', 'route' => 'admin.notifications.index', 'icon' => 'bell'],
            ['label' => 'Auditoría', 'route' => 'admin.audit.index', 'icon' => 'audit'],
        ],
        $user->isCompany() => [
            ['label' => 'Resumen', 'route' => 'company.dashboard', 'icon' => 'home'],
            ['label' => 'Datos empresariales', 'route' => 'company.profile.edit', 'icon' => 'building'],
            ['label' => 'Vacantes', 'route' => 'company.vacancies.index', 'icon' => 'briefcase'],
            ['label' => 'Nueva vacante', 'route' => 'company.vacancies.create', 'icon' => 'file'],
            ['label' => 'Postulados', 'route' => 'company.applicants.index', 'icon' => 'users'],
            ['label' => 'Notificaciones', 'route' => 'company.notifications.index', 'icon' => 'bell'],
        ],
        default => [
            ['label' => 'Mi cuenta', 'route' => 'citizen.dashboard', 'icon' => 'home'],
            ['label' => 'Mis datos', 'route' => 'citizen.profile.edit', 'icon' => 'user'],
            ['label' => 'Mi currículum', 'route' => 'citizen.resume.edit', 'icon' => 'file'],
            ['label' => 'Mis postulaciones', 'route' => 'citizen.applications.index', 'icon' => 'briefcase'],
            ['label' => 'Vacantes para mí', 'route' => 'citizen.vacancies.recommended', 'icon' => 'search'],
            ['label' => 'Notificaciones', 'route' => 'citizen.notifications.index', 'icon' => 'bell'],
        ],
    };
@endphp

<div class="dashboard-nav-shell">
    <a href="{{ route('home') }}" class="dashboard-brand">
        <img src="{{ asset('images/brand/logo_lerma_oficial.svg') }}" alt="Ayuntamiento de Lerma">
        <span>
            <strong>Empleo Lerma</strong>
            <small>Portal municipal</small>
        </span>
    </a>

    <nav class="dashboard-menu" aria-label="Menú de usuario">
        @foreach($navigation as $item)
            <a
                href="{{ route($item['route']) }}"
                @class(['dashboard-menu-link', 'active' => request()->routeIs($item['route'])])
            >
                <x-ui-icon :name="$item['icon']" class="dashboard-menu-icon" />
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
