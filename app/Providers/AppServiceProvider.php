<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

/**
 * Punto central para registrar servicios globales de la aplicación.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Registra bindings o singletons compartidos por la aplicación.
     */
    public function register(): void
    {
        //
    }

    /**
     * Ejecuta configuración global después de que Laravel inicia servicios.
     */
    public function boot(): void
    {
        // La aplicación usa Bootstrap 5; esto evita paginadores con markup de Tailwind.
        Paginator::useBootstrapFive();
    }
}
