<?php

namespace App\Http\Controllers\Company;

use App\Enums\ApplicationStatus;
use App\Enums\DocumentType;
use App\Http\Controllers\Admin\Concerns\RecordsAdminAudit;
use App\Http\Controllers\Company\Concerns\ResolvesCompany;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Notifications\CitizenHiredNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Gestiona postulaciones recibidas por las vacantes de la empresa.
 */
class ApplicantController extends Controller
{
    use RecordsAdminAudit;
    use ResolvesCompany;

    /**
     * Lista postulados de la empresa con filtros por vacante y estado.
     */
    public function index(Request $request)
    {
        $company = $this->company();

        $applications = Application::query()
            ->where('company_id', $company->id)
            ->with(['vacancy', 'citizenProfile.documents'])
            ->when($request->filled('vacancy_id'), fn ($query) => $query->where('vacancy_id', $request->integer('vacancy_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('company.applicants.index', [
            'applications' => $applications,
            'vacancies' => $company->vacancies()->orderBy('title')->get(['id', 'title']),
            'statuses' => ApplicationStatus::cases(),
        ]);
    }

    /**
     * Actualiza el estado de una postulación recibida.
     */
    public function updateStatus(Request $request, Application $application)
    {
        $this->authorizeApplication($application);

        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_column(ApplicationStatus::cases(), 'value'))],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $oldStatus = $application->status;

        $application->forceFill([
            'status' => $data['status'],
            'was_contacted' => $data['status'] === ApplicationStatus::Contacted->value ? true : $application->was_contacted,
            'contacted_at' => $data['status'] === ApplicationStatus::Contacted->value ? now() : $application->contacted_at,
        ])->save();

        ApplicationStatusHistory::create([
            'application_id' => $application->id,
            'from_status' => $oldStatus->value,
            'to_status' => $data['status'],
            'changed_by' => auth()->id(),
            'notes' => $data['notes'] ?? null,
            'created_at' => now(),
        ]);

        $this->audit('company.applications.status', $application, ['status' => $oldStatus->value], ['status' => $data['status']]);
        if ($data['status'] === ApplicationStatus::Hired->value && $oldStatus !== ApplicationStatus::Hired) {
            $application->load(['vacancy', 'citizenProfile.user']);
            $application->citizenProfile?->user?->notify(new CitizenHiredNotification($application));
        }

        return back()->with('status', 'Estado de postulación actualizado.');
    }

    /**
     * Descarga el CV privado de un postulante si existe y pertenece a la empresa.
     */
    public function downloadCv(Application $application)
    {
        $this->authorizeApplication($application);

        $document = $application->citizenProfile
            ->documents()
            ->where('type', DocumentType::Cv->value)
            ->where('is_current', true)
            ->latest('uploaded_at')
            ->first();

        abort_unless($document && Storage::disk('local')->exists($document->path), 404);

        $this->audit('company.applications.download_cv', $application, [], [], ['document_id' => $document->id]);

        return Storage::disk('local')->download($document->path, $document->original_name);
    }

    /**
     * Evita que una empresa consulte postulaciones de otra empresa.
     */
    private function authorizeApplication(Application $application): void
    {
        abort_unless($application->company_id === $this->company()->id, 404);
    }
}
