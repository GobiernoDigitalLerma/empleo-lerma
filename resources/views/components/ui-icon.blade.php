@props(['name', 'class' => 'ui-icon'])

@php
    /*
     * Íconos SVG internos de la aplicación.
     *
     * Usamos SVG inline en lugar de una fuente completa para evitar assets
     * pesados y asegurar que los íconos funcionen igual con Docker, producción
     * y ejecución local sin depender de Bootstrap Icons.
     */
    $paths = [
        'audit' => '<path d="M9 3.5h6l2 2V20a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V4.5a1 1 0 0 1 1-1h1Z"/><path d="M14 3.5V6h3"/><path d="M9.5 9h5"/><path d="M9.5 12h5"/><path d="M9.5 15h3"/>',
        'bell' => '<path d="M18 9a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9Z"/><path d="M10 21h4"/>',
        'briefcase' => '<path d="M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1"/><path d="M4 7h16v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z"/><path d="M4 12h16"/><path d="M10 12v2h4v-2"/>',
        'building' => '<path d="M5 21V4a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v17"/><path d="M3 21h18"/><path d="M9 7h1"/><path d="M13 7h1"/><path d="M9 11h1"/><path d="M13 11h1"/><path d="M9 15h1"/><path d="M13 15h1"/>',
        'calendar' => '<path d="M7 3v3"/><path d="M17 3v3"/><path d="M4 8h16"/><path d="M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>',
        'file' => '<path d="M7 3h7l3 3v15H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/><path d="M14 3v4h4"/><path d="M9 12h6"/><path d="M9 16h6"/>',
        'home' => '<path d="m3 11 9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/>',
        'map-pin' => '<path d="M12 21s7-5.2 7-11a7 7 0 0 0-14 0c0 5.8 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>',
        'menu' => '<path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h16"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m16.5 16.5 4 4"/>',
        'tags' => '<path d="M20 13 11 4H5v6l9 9a2 2 0 0 0 3 0l3-3a2 2 0 0 0 0-3Z"/><circle cx="8" cy="7" r="1"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
        'users' => '<path d="M16 21a6 6 0 0 0-12 0"/><circle cx="10" cy="8" r="4"/><path d="M22 21a5 5 0 0 0-5-5"/><path d="M15 4a4 4 0 0 1 0 8"/>',
    ];

    $path = $paths[$name] ?? $paths['file'];
@endphp

<svg
    {{ $attributes->merge(['class' => $class]) }}
    aria-hidden="true"
    focusable="false"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-linecap="round"
    stroke-linejoin="round"
    stroke-width="2"
>
    {!! $path !!}
</svg>
