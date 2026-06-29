<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AccessStatus;
use App\Enums\CompanyStatus;
use App\Http\Controllers\Admin\Concerns\RecordsAdminAudit;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

/**
 * Gestiona empresas registradas y su autorización operativa.
 *
 * Las acciones de aprobación/suspensión modifican tanto la empresa como el
 * usuario relacionado, porque la publicación depende de ambos estados.
 */
class CompanyController extends Controller
{
    use RecordsAdminAudit;

    /**
     * Lista empresas con filtros básicos de operación.
     */
    public function index(Request $request)
    {
        $companies = Company::query()
            ->with(['user', 'approver'])
            ->withCount(['vacancies', 'applications'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = $request->string('q');

                $query->where(function ($query) use ($search) {
                    $query->where('business_name', 'like', "%{$search}%")
                        ->orWhere('rfc', 'like', "%{$search}%")
                        ->orWhere('primary_email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.companies.index', [
            'companies' => $companies,
            'statuses' => CompanyStatus::cases(),
        ]);
    }

    /**
     * Aprueba una empresa y habilita el usuario relacionado.
     */
    public function approve(Company $company)
    {
        $oldValues = $company->only(['status', 'approved_at', 'approved_by']);

        $company->forceFill([
            'status' => CompanyStatus::Active,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejection_reason' => null,
        ])->save();

        if ($company->user) {
            $company->user->forceFill([
                'status' => AccessStatus::Active,
                'access_expires_at' => now()->addYear(),
                'revoked_at' => null,
            ])->save();
        }

        $this->audit('admin.companies.approve', $company, $oldValues, $company->only(['status', 'approved_at', 'approved_by']));

        return back()->with('status', 'Empresa aprobada.');
    }

    /**
     * Suspende una empresa sin borrar su historial ni sus vacantes.
     */
    public function suspend(Company $company)
    {
        $oldValues = $company->only(['status']);

        $company->forceFill(['status' => CompanyStatus::Suspended])->save();
        if ($company->user) {
            $company->user->forceFill(['status' => AccessStatus::Suspended])->save();
        }

        $this->audit('admin.companies.suspend', $company, $oldValues, $company->only(['status']));

        return back()->with('status', 'Empresa suspendida.');
    }

    /**
     * Rechaza una empresa con motivo administrativo opcional.
     */
    public function reject(Request $request, Company $company)
    {
        $data = $request->validate(['rejection_reason' => ['nullable', 'string', 'max:1000']]);
        $oldValues = $company->only(['status', 'rejection_reason']);

        $company->forceFill([
            'status' => CompanyStatus::Rejected,
            'rejection_reason' => $data['rejection_reason'] ?? 'Rechazo administrativo.',
        ])->save();

        $this->audit('admin.companies.reject', $company, $oldValues, $company->only(['status', 'rejection_reason']));

        return back()->with('status', 'Empresa rechazada.');
    }
}
