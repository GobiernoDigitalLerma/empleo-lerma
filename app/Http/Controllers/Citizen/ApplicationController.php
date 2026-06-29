<?php

namespace App\Http\Controllers\Citizen;

use App\Enums\ApplicationStatus;
use App\Http\Controllers\Citizen\Concerns\ResolvesCitizenProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Presenta el historial de postulaciones realizadas por el ciudadano.
 */
class ApplicationController extends Controller
{
    use ResolvesCitizenProfile;

    /**
     * Lista postulaciones propias con filtros de estado.
     */
    public function index(Request $request)
    {
        $profile = $this->profile();

        $applications = $profile->applications()
            ->with(['company', 'vacancy.company'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('submitted_at')
            ->paginate(12)
            ->withQueryString();

        return view('citizen.applications.index', [
            'applications' => $applications,
            'statuses' => ApplicationStatus::cases(),
        ]);
    }
}
