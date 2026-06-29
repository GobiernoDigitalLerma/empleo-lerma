<?php

namespace App\Http\Controllers\Citizen;

use App\Enums\DocumentType;
use App\Http\Controllers\Citizen\Concerns\ResolvesCitizenProfile;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Administra currículum, experiencia, preferencias y CV privado del ciudadano.
 */
class ResumeController extends Controller
{
    use ResolvesCitizenProfile;

    /**
     * Muestra el formulario integral de currículum.
     */
    public function edit()
    {
        $profile = $this->profile()->load(['education', 'experience', 'preference', 'documents']);

        return view('citizen.resume.edit', [
            'profile' => $profile,
            'currentCv' => $profile->documents->first(fn ($document) => $document->type === DocumentType::Cv && $document->is_current),
            ...$this->catalogOptions(),
        ]);
    }

    /**
     * Actualiza escolaridad, experiencia y preferencias laborales.
     */
    public function update(Request $request)
    {
        $profile = $this->profile();

        $data = $request->validate([
            'education_level' => ['nullable', 'string', 'max:255'],
            'career_or_specialty' => ['nullable', 'string', 'max:255'],
            'academic_status' => ['nullable', 'string', 'max:255'],
            'language' => ['nullable', 'string', 'max:255'],
            'language_level' => ['nullable', 'string', 'max:255'],
            'computer_skills' => ['nullable', 'string'],
            'special_knowledge' => ['nullable', 'string'],
            'special_skills' => ['nullable', 'string'],
            'courses' => ['nullable', 'string'],
            'currently_working' => ['nullable', 'boolean'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'functions' => ['nullable', 'string'],
            'monthly_salary' => ['nullable', 'numeric', 'min:0'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date'],
            'job_search_started_at' => ['nullable', 'date'],
            'separation_reason' => ['nullable', 'string'],
            'availability' => ['nullable', 'string', 'max:255'],
            'desired_position' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'desired_employment_type' => ['nullable', 'string', 'max:255'],
            'expected_salary' => ['nullable', 'numeric', 'min:0'],
            'experience_level' => ['nullable', 'string', 'max:255'],
            'available_to_travel' => ['nullable', 'boolean'],
            'available_to_relocate' => ['nullable', 'boolean'],
            'preferred_municipality' => ['nullable', 'string', 'max:255'],
            'preferred_state' => ['nullable', 'string', 'max:255'],
        ]);

        $profile->education()->updateOrCreate([], collect($data)->only([
            'education_level', 'career_or_specialty', 'academic_status', 'language', 'language_level',
            'computer_skills', 'special_knowledge', 'special_skills', 'courses',
        ])->all());

        $profile->experience()->updateOrCreate([], collect($data)->only([
            'company_name', 'job_title', 'functions', 'monthly_salary', 'employment_type',
            'started_at', 'ended_at', 'job_search_started_at', 'separation_reason', 'availability',
        ])->merge(['currently_working' => $request->boolean('currently_working')])->all());

        $profile->preference()->updateOrCreate([], collect($data)->only([
            'desired_position', 'occupation', 'desired_employment_type', 'expected_salary',
            'experience_level', 'preferred_municipality', 'preferred_state',
        ])->merge([
            'available_to_travel' => $request->boolean('available_to_travel'),
            'available_to_relocate' => $request->boolean('available_to_relocate'),
        ])->all());

        return back()->with('status', 'Currículum actualizado.');
    }

    /**
     * Carga el CV en storage privado y marca versiones anteriores como no vigentes.
     */
    public function uploadCv(Request $request)
    {
        $profile = $this->profile();

        $data = $request->validate([
            'cv_file' => ['required', 'file', 'extensions:pdf,doc,docx', 'max:4096'],
        ]);

        $file = $data['cv_file'];
        $path = $file->storeAs('citizen-documents/'.$profile->id, Str::uuid().'.'.$file->getClientOriginalExtension(), 'local');

        $profile->documents()->where('type', DocumentType::Cv)->update(['is_current' => false]);
        $profile->documents()->create([
            'type' => DocumentType::Cv,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'is_current' => true,
            'uploaded_at' => now(),
        ]);

        return back()->with('status', 'CV cargado correctamente.');
    }

    /**
     * Genera un PDF simple desde los datos capturados en el perfil.
     */
    public function downloadPdf()
    {
        $profile = $this->profile()->load(['education', 'experience', 'preference']);

        $pdf = Pdf::loadView('citizen.resume.pdf', compact('profile'));

        return $pdf->download('cv-'.$profile->id.'.pdf');
    }

    /**
     * Catálogos usados en la captura del currículum.
     */
    private function catalogOptions(): array
    {
        return [
            'educationLevels' => Catalog::active()->where('type', 'education_level')->orderBy('sort_order')->pluck('name'),
            'academicStatuses' => Catalog::active()->where('type', 'academic_status')->orderBy('sort_order')->pluck('name'),
            'employmentTypes' => Catalog::active()->where('type', 'employment_type')->orderBy('sort_order')->pluck('name'),
            'experienceLevels' => Catalog::active()->where('type', 'experience_level')->orderBy('sort_order')->pluck('name'),
            'municipalities' => Catalog::active()->where('type', 'municipality')->orderBy('sort_order')->pluck('name'),
            'states' => Catalog::active()->where('type', 'state')->orderBy('sort_order')->pluck('name'),
            'languages' => Catalog::active()->where('type', 'language')->orderBy('sort_order')->pluck('name'),
            'languageLevels' => Catalog::active()->where('type', 'language_level')->orderBy('sort_order')->pluck('name'),
        ];
    }
}
