<?php

namespace App\Http\Controllers\Company;

use App\Enums\VacancyStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Admin\Concerns\RecordsAdminAudit;
use App\Http\Controllers\Company\Concerns\ResolvesCompany;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\User;
use App\Models\Vacancy;
use App\Notifications\AdminVacancyRegisteredNotification;
use App\Notifications\CitizenVacancyCoveredNotification;
use App\Notifications\CompanyVacancyCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * CRUD de vacantes propias de la empresa autenticada.
 *
 * Las vacantes se crean como borrador o pendientes de revisión; la publicación
 * final queda en manos de administración municipal.
 */
class VacancyController extends Controller
{
    use RecordsAdminAudit;
    use ResolvesCompany;

    /**
     * Lista vacantes de la empresa con filtros por estado y texto.
     */
    public function index(Request $request)
    {
        $company = $this->company();

        $vacancies = $company->vacancies()
            ->with('company')
            ->withCount('applications')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->string('q').'%';

                $query->where(function ($query) use ($term) {
                    $query->where('title', 'like', $term)
                        ->orWhere('short_description', 'like', $term)
                        ->orWhere('municipality', 'like', $term);
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('company.vacancies.index', [
            'company' => $company,
            'vacancies' => $vacancies,
            'statuses' => VacancyStatus::cases(),
        ]);
    }

    /**
     * Muestra el formulario para capturar una vacante.
     */
    public function create()
    {
        return view('company.vacancies.create', [
            'vacancy' => new Vacancy(),
            ...$this->catalogOptions(),
        ]);
    }

    /**
     * Guarda una vacante como borrador o pendiente de revisión.
     */
    public function store(Request $request)
    {
        $company = $this->company();
        $data = $this->validatedVacancy($request);
        $status = $request->input('intent') === 'submit' ? VacancyStatus::PendingReview : VacancyStatus::Draft;

        $this->ensureCanSubmitForReview($request, $status);

        $vacancy = $company->vacancies()->create($this->payload($data, $status));

        $company->user?->notify(new CompanyVacancyCreatedNotification($vacancy));
        if ($status === VacancyStatus::PendingReview) {
            User::where('role', UserRole::Admin->value)->get()
                ->each(fn (User $admin) => $admin->notify(new AdminVacancyRegisteredNotification($vacancy)));
        }

        $this->audit('company.vacancies.create', $vacancy, [], $vacancy->only(['title', 'status', 'expires_at']));

        return redirect()->route('company.vacancies.index')->with('status', 'Vacante guardada.');
    }

    /**
     * Muestra el formulario de edición de una vacante propia.
     */
    public function edit(Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);

        return view('company.vacancies.edit', [
            'vacancy' => $vacancy,
            ...$this->catalogOptions(),
        ]);
    }

    /**
     * Actualiza una vacante propia y opcionalmente la envía a revisión.
     */
    public function update(Request $request, Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);

        $data = $this->validatedVacancy($request);
        $oldValues = $vacancy->only(['title', 'status', 'expires_at', 'is_covered']);
        $status = $request->input('intent') === 'submit' ? VacancyStatus::PendingReview : $vacancy->status;

        $this->ensureCanSubmitForReview($request, $status);

        $vacancy->update($this->payload($data, $status, $vacancy));

        if ($status === VacancyStatus::PendingReview && $oldValues['status'] !== VacancyStatus::PendingReview->value) {
            User::where('role', UserRole::Admin->value)->get()
                ->each(fn (User $admin) => $admin->notify(new AdminVacancyRegisteredNotification($vacancy)));
        }

        $this->audit('company.vacancies.update', $vacancy, $oldValues, $vacancy->only(['title', 'status', 'expires_at', 'is_covered']));

        return redirect()->route('company.vacancies.index')->with('status', 'Vacante actualizada.');
    }

    /**
     * Marca una vacante propia como cubierta.
     */
    public function markCovered(Vacancy $vacancy)
    {
        $this->authorizeVacancy($vacancy);

        $oldValues = $vacancy->only(['status', 'is_covered', 'covered_on_platform']);

        $vacancy->forceFill([
            'status' => VacancyStatus::Covered,
            'is_covered' => true,
            'covered_on_platform' => true,
        ])->save();

        $this->audit('company.vacancies.covered', $vacancy, $oldValues, $vacancy->only(['status', 'is_covered', 'covered_on_platform']));
        $this->notifyApplicantsAboutCoveredVacancy($vacancy);

        return back()->with('status', 'Vacante marcada como cubierta.');
    }

    /**
     * Avisa a ciudadanos postulados cuando la empresa cierra la vacante.
     */
    private function notifyApplicantsAboutCoveredVacancy(Vacancy $vacancy): void
    {
        $vacancy->loadMissing('applications.citizenProfile.user');

        $vacancy->applications
            ->filter(fn ($application) => $application->citizenProfile?->user)
            ->unique('citizen_profile_id')
            ->each(fn ($application) => $application->citizenProfile->user->notify(
                new CitizenVacancyCoveredNotification($application)
            ));
    }

    /**
     * Valida los campos principales de la vacante.
     */
    private function validatedVacancy(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'functions' => ['nullable', 'string'],
            'required_knowledge' => ['nullable', 'string'],
            'full_address' => ['nullable', 'string'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'monthly_salary' => ['nullable', 'numeric', 'min:0'],
            'work_days' => ['nullable', 'string', 'max:255'],
            'open_positions' => ['required', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'],
        ]);
    }

    /**
     * Normaliza datos para persistirlos en la tabla vacancies.
     */
    private function payload(array $data, VacancyStatus $status, ?Vacancy $vacancy = null): array
    {
        $titleChanged = is_null($vacancy) || $vacancy->title !== $data['title'];

        return $data + [
            'slug' => $titleChanged ? Str::slug($data['title']).'-'.Str::lower(Str::random(6)) : $vacancy->slug,
            'status' => $status,
            'is_covered' => false,
            'covered_on_platform' => false,
        ];
    }

    /**
     * Obtiene catálogos para evitar captura libre inconsistente.
     */
    private function catalogOptions(): array
    {
        return [
            'municipalities' => Catalog::active()->where('type', 'municipality')->orderBy('sort_order')->pluck('name'),
            'employmentTypes' => Catalog::active()->where('type', 'employment_type')->orderBy('sort_order')->pluck('name'),
        ];
    }

    /**
     * Bloquea envío a revisión cuando la empresa aún no está activa.
     */
    private function ensureCanSubmitForReview(Request $request, VacancyStatus $status): void
    {
        if ($status !== VacancyStatus::PendingReview || $this->company()->isActive()) {
            return;
        }

        back()
            ->withErrors(['intent' => 'La empresa debe estar activa para enviar vacantes a revisión.'])
            ->withInput()
            ->throwResponse();
    }

    /**
     * Evita que una empresa opere vacantes ajenas.
     */
    private function authorizeVacancy(Vacancy $vacancy): void
    {
        abort_unless($vacancy->company_id === $this->company()->id, 404);
    }
}
