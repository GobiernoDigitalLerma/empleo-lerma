<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Admin\Concerns\RecordsAdminAudit;
use App\Http\Controllers\Company\Concerns\ResolvesCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Permite a la empresa mantener sus datos fiscales, contacto, domicilio y logo.
 */
class ProfileController extends Controller
{
    use RecordsAdminAudit;
    use ResolvesCompany;

    /**
     * Muestra el formulario de edición del perfil empresarial.
     */
    public function edit()
    {
        return view('company.profile.edit', ['company' => $this->company()]);
    }

    /**
     * Actualiza los datos editables por la empresa autenticada.
     */
    public function update(Request $request)
    {
        $company = $this->company();

        $data = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'rfc' => ['nullable', 'string', 'max:13'],
            'economic_activity' => ['nullable', 'string', 'max:255'],
            'employee_count' => ['nullable', 'integer', 'min:0'],
            'website' => ['nullable', 'url', 'max:255'],
            'primary_email' => ['nullable', 'email', 'max:255'],
            'primary_phone' => ['nullable', 'string', 'max:50'],
            'secondary_phone' => ['nullable', 'string', 'max:50'],
            'street' => ['nullable', 'string', 'max:255'],
            'external_number' => ['nullable', 'string', 'max:50'],
            'internal_number' => ['nullable', 'string', 'max:50'],
            'neighborhood' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'municipality' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'logo_file' => ['nullable', 'file', 'extensions:jpg,jpeg,png,webp,svg', 'max:2048'],
        ]);

        $oldValues = $company->only(array_keys($company->getAttributes()));

        if ($request->hasFile('logo_file')) {
            $data['logo_path'] = $this->storeLogo($request);
        }

        unset($data['logo_file']);

        $company->update($data);

        $this->audit('company.profile.update', $company, $oldValues, $company->fresh()->only(array_keys($data)));

        return back()->with('status', 'Datos empresariales actualizados.');
    }

    /**
     * Guarda el logo en public/images/companies para servirlo con asset().
     */
    private function storeLogo(Request $request): string
    {
        $file = $request->file('logo_file');
        $directory = public_path('images/companies');

        File::ensureDirectoryExists($directory);

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'images/companies/'.$filename;
    }
}
