<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Enums\CompanyStatus;
use App\Models\Company;
use App\Models\Vacancy;

/**
 * Construye el home público de Empleo Lerma.
 *
 * La pantalla mantiene la composición del legacy: hero con buscador,
 * empresas destacadas y oportunidades laborales recientes.
 */
class HomeController extends Controller
{
    /**
     * Muestra el home con datos públicos limitados y vigentes.
     */
    public function __invoke()
    {
        $publicVacancies = Vacancy::query()->publicable();

        return view('public.home', [
            'companies' => Company::query()
                ->where('status', CompanyStatus::Active)
                ->latest()
                ->limit(12)
                ->get(),
            'vacancies' => (clone $publicVacancies)
                ->with('company')
                ->latest('published_at')
                ->limit(10)
                ->get(),
            'vacanciesCount' => (clone $publicVacancies)->count(),
            'municipalities' => (clone $publicVacancies)
                ->whereNotNull('municipality')
                ->distinct()
                ->orderBy('municipality')
                ->pluck('municipality'),
            'recentSearches' => (clone $publicVacancies)
                ->whereNotNull('employment_type')
                ->distinct()
                ->orderBy('employment_type')
                ->limit(8)
                ->pluck('employment_type'),
        ]);
    }
}
