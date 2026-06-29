<?php

namespace App\Http\Controllers\Public;

use App\Enums\CompanyStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;

/**
 * Lista empresas activas visibles en la sección pública.
 *
 * No expone datos sensibles; sólo muestra información básica útil para que
 * ciudadanos reconozcan organizaciones con presencia en el portal.
 */
class CompanyController extends Controller
{
    /**
     * Muestra empresas aprobadas y activas con paginación.
     */
    public function index()
    {
        $companies = Company::query()
            ->where('status', CompanyStatus::Active)
            ->latest()
            ->paginate(12);

        return view('public.companies.index', compact('companies'));
    }
}
