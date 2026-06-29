<?php

namespace App\Http\Controllers\Citizen;

use App\Actions\ApplyToVacancy;
use App\Http\Controllers\Citizen\Concerns\ResolvesCitizenProfile;
use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Muestra vacantes publicables priorizadas por preferencias del ciudadano.
 */
class RecommendedVacancyController extends Controller
{
    use ResolvesCitizenProfile;

    /**
     * Lista vacantes publicables y sólo las prioriza por preferencias.
     *
     * No se excluyen oportunidades que no coincidan; municipio y tipo deseado
     * suben al inicio para que el ciudadano no pierda opciones vigentes.
     */
    public function index(Request $request)
    {
        $profile = $this->profile()->load('preference');
        $appliedVacancyIds = $profile->applications()->pluck('vacancy_id');

        $vacancies = Vacancy::query()
            ->publicable()
            ->with('company')
            ->when($profile->preference?->preferred_municipality, fn ($query, $municipality) => $query->orderByRaw('municipality = ? desc', [$municipality]))
            ->when($profile->preference?->desired_employment_type, fn ($query, $type) => $query->orderByRaw('employment_type = ? desc', [$type]))
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('citizen.vacancies.index', compact('profile', 'vacancies', 'appliedVacancyIds'));
    }

    /**
     * Registra una postulación ciudadana usando la acción transaccional.
     */
    public function apply(Request $request, Vacancy $vacancy, ApplyToVacancy $applyToVacancy)
    {
        try {
            $applyToVacancy->handle($vacancy, $this->profile());
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput();
        }

        return redirect()->route('citizen.applications.index')->with('status', 'Postulación enviada.');
    }
}
