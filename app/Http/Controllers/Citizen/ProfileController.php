<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Citizen\Concerns\ResolvesCitizenProfile;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Illuminate\Http\Request;

/**
 * Gestiona datos personales y domicilio del ciudadano.
 */
class ProfileController extends Controller
{
    use ResolvesCitizenProfile;

    /**
     * Muestra el formulario de perfil ciudadano.
     */
    public function edit()
    {
        return view('citizen.profile.edit', [
            'profile' => $this->profile(),
            ...$this->catalogOptions(),
        ]);
    }

    /**
     * Actualiza datos personales requeridos para poder postular.
     */
    public function update(Request $request)
    {
        $profile = $this->profile();

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'string', 'max:255'],
            'birth_state' => ['nullable', 'string', 'max:255'],
            'curp' => ['nullable', 'string', 'size:18'],
            'phone' => ['required', 'string', 'max:50'],
            'street' => ['nullable', 'string', 'max:255'],
            'external_number' => ['nullable', 'string', 'max:50'],
            'internal_number' => ['nullable', 'string', 'max:50'],
            'neighborhood' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'has_disability' => ['nullable', 'boolean'],
            'disability_description' => ['nullable', 'string'],
            'how_did_you_hear' => ['nullable', 'string', 'max:255'],
        ]);

        $data['has_disability'] = $request->boolean('has_disability');
        $profile->fill($data);

        if (filled($profile->full_name) && filled($profile->curp) && filled($profile->phone)) {
            $profile->completed_at ??= now();
        }

        $profile->save();

        return back()->with('status', 'Perfil ciudadano actualizado.');
    }

    /**
     * Catálogos usados por selects para evitar captura libre innecesaria.
     */
    private function catalogOptions(): array
    {
        return [
            'genders' => Catalog::active()->where('type', 'gender')->orderBy('sort_order')->pluck('name'),
            'maritalStatuses' => Catalog::active()->where('type', 'marital_status')->orderBy('sort_order')->pluck('name'),
            'municipalities' => Catalog::active()->where('type', 'municipality')->orderBy('sort_order')->pluck('name'),
            'states' => Catalog::active()->where('type', 'state')->orderBy('sort_order')->pluck('name'),
            'sources' => Catalog::active()->where('type', 'source')->orderBy('sort_order')->pluck('name'),
        ];
    }
}
