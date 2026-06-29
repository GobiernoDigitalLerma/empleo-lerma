<?php

namespace App\Http\Controllers\Citizen\Concerns;

use App\Models\CitizenProfile;

/**
 * Resuelve el perfil ciudadano autenticado para controladores del dashboard.
 */
trait ResolvesCitizenProfile
{
    /**
     * Devuelve el perfil existente o lo crea con datos mínimos del usuario.
     */
    protected function profile(): CitizenProfile
    {
        return auth()->user()->citizenProfile()->firstOrCreate([], [
            'full_name' => auth()->user()->name,
            'phone' => auth()->user()->phone,
        ]);
    }
}
