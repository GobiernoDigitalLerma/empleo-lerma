<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Renderiza secciones operativas que todavía no tienen CRUD completo.
 *
 * Este controlador permite que la navegación por rol sea usable desde ahora:
 * cada enlace lleva a una pantalla clara y documentada, mientras el módulo
 * definitivo se implementa en controladores especializados.
 */
class DashboardSectionController extends Controller
{
    /**
     * Muestra una sección temporal configurada desde la ruta.
     */
    public function __invoke(Request $request)
    {
        return view('dashboard.section', [
            'heading' => $request->route()->defaults['heading'] ?? 'Sección',
            'description' => $request->route()->defaults['description'] ?? 'Esta sección está lista para recibir su flujo completo.',
            'items' => $request->route()->defaults['items'] ?? [],
        ]);
    }
}
