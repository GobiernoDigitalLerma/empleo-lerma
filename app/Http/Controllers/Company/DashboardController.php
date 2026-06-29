<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;

/**
 * Muestra el resumen operativo de la empresa autenticada.
 *
 * La vista ayuda a la empresa a revisar su perfil, vacantes recientes y
 * cantidad de postulaciones recibidas.
 */
class DashboardController extends Controller
{
    /**
     * Obtiene la empresa relacionada al usuario y sus datos principales.
     */
    public function __invoke()
    {
        $company = auth()->user()->company;

        return view('company.dashboard', [
            'company' => $company,
            'vacancies' => $company?->vacancies()->latest()->limit(8)->get() ?? collect(),
            'vacanciesCount' => $company?->vacancies()->count() ?? 0,
            'applicationsCount' => $company ? Application::where('company_id', $company->id)->count() : 0,
        ]);
    }
}
