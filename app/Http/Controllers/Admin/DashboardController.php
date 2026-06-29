<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\AuditLog;
use App\Models\Company;
use App\Models\Event;
use App\Models\Vacancy;

/**
 * Muestra el resumen operativo del administrador.
 *
 * Este panel concentra métricas y auditoría reciente para que el equipo
 * municipal pueda detectar pendientes antes de entrar a módulos específicos.
 */
class DashboardController extends Controller
{
    /**
     * Carga métricas globales y últimos registros de auditoría.
     */
    public function __invoke()
    {
        return view('admin.dashboard', [
            'metrics' => [
                'Empresas' => Company::count(),
                'Vacantes activas' => Vacancy::query()->publicable()->count(),
                'Postulaciones' => Application::count(),
                'Eventos' => Event::count(),
            ],
            'audits' => AuditLog::with('user')->latest()->limit(8)->get(),
        ]);
    }
}
