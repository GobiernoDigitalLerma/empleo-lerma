<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\Request;

/**
 * Atiende la consulta pública de vacantes.
 *
 * Sólo expone vacantes publicables para evitar mostrar información vencida,
 * cubierta o asociada a empresas inactivas.
 */
class VacancyController extends Controller
{
    /**
     * Lista vacantes públicas con filtros simples de búsqueda.
     */
    public function index(Request $request)
    {
        $publicVacancies = Vacancy::query()->publicable();

        $municipalities = (clone $publicVacancies)
            ->whereNotNull('municipality')
            ->distinct()
            ->orderBy('municipality')
            ->pluck('municipality');

        $employmentTypes = (clone $publicVacancies)
            ->whereNotNull('employment_type')
            ->distinct()
            ->orderBy('employment_type')
            ->pluck('employment_type');

        $vacancies = (clone $publicVacancies)
            ->with('company')
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('municipality'), fn ($query) => $query->where('municipality', $request->string('municipality')))
            ->when($request->filled('employment_type'), fn ($query) => $query->where('employment_type', $request->string('employment_type')))
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('public.vacancies.index', compact('vacancies', 'municipalities', 'employmentTypes'));
    }

    /**
     * Muestra el detalle público limitado de una vacante.
     */
    public function show(Vacancy $vacancy)
    {
        abort_unless(Vacancy::query()->whereKey($vacancy->id)->publicable()->exists(), 404);

        $vacancy->load('company');

        $similarVacancies = Vacancy::query()
            ->publicable()
            ->with('company')
            ->whereKeyNot($vacancy->id)
            ->when($vacancy->employment_type, fn ($query) => $query->where('employment_type', $vacancy->employment_type))
            ->latest('published_at')
            ->limit(4)
            ->get();

        return view('public.vacancies.show', compact('vacancy', 'similarVacancies'));
    }
}
