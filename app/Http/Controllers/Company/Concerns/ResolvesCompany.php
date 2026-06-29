<?php

namespace App\Http\Controllers\Company\Concerns;

use App\Models\Company;

/**
 * Resuelve la empresa autenticada para controladores del dashboard empresa.
 *
 * Centralizar esta consulta evita repetir validaciones y reduce el riesgo de
 * operar datos de otra empresa por accidente.
 */
trait ResolvesCompany
{
    /**
     * Devuelve la empresa del usuario autenticado o aborta si no existe perfil.
     */
    protected function company(): Company
    {
        $company = auth()->user()->company;

        abort_unless($company, 404);

        return $company;
    }
}
