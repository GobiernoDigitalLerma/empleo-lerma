<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;

/**
 * Muestra el resumen operativo del ciudadano autenticado.
 *
 * Esta pantalla concentra estado del perfil y postulaciones para que el
 * ciudadano sepa si ya puede aplicar a vacantes.
 */
class DashboardController extends Controller
{
    /**
     * Carga perfil ciudadano y últimas postulaciones relacionadas.
     */
    public function __invoke()
    {
        $profile = auth()->user()->citizenProfile;

        return view('citizen.dashboard', [
            'profile' => $profile,
            'applications' => $profile?->applications()->with('vacancy')->latest()->limit(8)->get() ?? collect(),
        ]);
    }
}
