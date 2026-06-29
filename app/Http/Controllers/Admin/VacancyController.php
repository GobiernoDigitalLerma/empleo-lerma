<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VacancyStatus;
use App\Http\Controllers\Admin\Concerns\RecordsAdminAudit;
use App\Http\Controllers\Controller;
use App\Models\Vacancy;
use App\Notifications\CitizenVacancyCoveredNotification;
use App\Notifications\CompanyVacancyCoveredNotification;
use App\Notifications\VacancyApprovedNotification;
use App\Notifications\VacancyRejectedNotification;
use Illuminate\Http\Request;

/**
 * Revisa y gobierna el ciclo de vida de vacantes desde administración.
 *
 * Este primer corte permite aprobar, rechazar y marcar vacantes cubiertas,
 * manteniendo el detalle público protegido por el scope publicable.
 */
class VacancyController extends Controller
{
    use RecordsAdminAudit;

    /**
     * Lista vacantes con datos de empresa y conteo de postulaciones.
     */
    public function index(Request $request)
    {
        $vacancies = Vacancy::query()
            ->with('company')
            ->withCount('applications')
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.vacancies.index', [
            'vacancies' => $vacancies,
            'statuses' => VacancyStatus::cases(),
        ]);
    }

    /**
     * Muestra una vacante en revisión aunque todavía no sea pública.
     */
    public function show(Vacancy $vacancy)
    {
        $vacancy->load(['company', 'requirement', 'contact'])->loadCount('applications');

        return view('admin.vacancies.show', compact('vacancy'));
    }

    /**
     * Aprueba y publica una vacante.
     */
    public function approve(Vacancy $vacancy)
    {
        $oldValues = $vacancy->only(['status', 'published_at', 'approved_at', 'approved_by']);

        $vacancy->forceFill([
            'status' => VacancyStatus::Published,
            'published_at' => $vacancy->published_at ?? now(),
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejected_at' => null,
            'rejection_reason' => null,
        ])->save();

        $this->audit('admin.vacancies.approve', $vacancy, $oldValues, $vacancy->only(['status', 'published_at', 'approved_at', 'approved_by']));
        $vacancy->company?->user?->notify(new VacancyApprovedNotification($vacancy));

        return back()->with('status', 'Vacante aprobada y publicada.');
    }

    /**
     * Rechaza una vacante con motivo administrativo opcional.
     */
    public function reject(Request $request, Vacancy $vacancy)
    {
        $data = $request->validate(['rejection_reason' => ['nullable', 'string', 'max:1000']]);
        $oldValues = $vacancy->only(['status', 'rejected_at', 'rejection_reason']);

        $vacancy->forceFill([
            'status' => VacancyStatus::Rejected,
            'rejected_at' => now(),
            'rejection_reason' => $data['rejection_reason'] ?? 'Rechazo administrativo.',
        ])->save();

        $this->audit('admin.vacancies.reject', $vacancy, $oldValues, $vacancy->only(['status', 'rejected_at', 'rejection_reason']));
        $vacancy->company?->user?->notify(new VacancyRejectedNotification($vacancy));

        return back()->with('status', 'Vacante rechazada.');
    }

    /**
     * Marca una vacante como cubierta para retirarla del público.
     */
    public function markCovered(Vacancy $vacancy)
    {
        $oldValues = $vacancy->only(['status', 'is_covered', 'covered_on_platform']);

        $vacancy->forceFill([
            'status' => VacancyStatus::Covered,
            'is_covered' => true,
            'covered_on_platform' => true,
        ])->save();

        $this->audit('admin.vacancies.covered', $vacancy, $oldValues, $vacancy->only(['status', 'is_covered', 'covered_on_platform']));
        $this->notifyCoveredVacancy($vacancy);

        return back()->with('status', 'Vacante marcada como cubierta.');
    }

    /**
     * Notifica a empresa y ciudadanos postulados que la vacante ya fue cubierta.
     */
    private function notifyCoveredVacancy(Vacancy $vacancy): void
    {
        $vacancy->loadMissing(['company.user', 'applications.citizenProfile.user']);

        $vacancy->company?->user?->notify(new CompanyVacancyCoveredNotification($vacancy));

        $vacancy->applications
            ->pluck('citizenProfile.user')
            ->filter()
            ->unique('id')
            ->each(fn ($user) => $user->notify(new CitizenVacancyCoveredNotification(
                $vacancy->applications->firstWhere('citizenProfile.user_id', $user->id)
            )));
    }
}
