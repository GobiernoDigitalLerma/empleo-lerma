@extends('layouts.dashboard')

@section('title', 'Mi currículum | Ciudadano')
@section('heading', 'Mi currículum')

@section('content')
{{-- Currículum ciudadano: escolaridad, experiencia, preferencias y archivo CV. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('citizen.resume.update') }}" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-12"><h2 class="h5">Escolaridad</h2></div>
            <div class="col-md-4">
                <label class="form-label" for="education_level">Escolaridad</label>
                <select id="education_level" class="form-select" name="education_level">
                    <option value="">Selecciona</option>
                    @foreach($educationLevels as $value)
                        <option value="{{ $value }}" @selected(old('education_level', $profile->education?->education_level) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="career_or_specialty">Carrera o especialidad</label>
                <input id="career_or_specialty" class="form-control" name="career_or_specialty" value="{{ old('career_or_specialty', $profile->education?->career_or_specialty) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="academic_status">Estado académico</label>
                <select id="academic_status" class="form-select" name="academic_status">
                    <option value="">Selecciona</option>
                    @foreach($academicStatuses as $value)
                        <option value="{{ $value }}" @selected(old('academic_status', $profile->education?->academic_status) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="language">Idioma</label>
                <select id="language" class="form-select" name="language">
                    <option value="">Selecciona</option>
                    @foreach($languages as $value)
                        <option value="{{ $value }}" @selected(old('language', $profile->education?->language) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="language_level">Nivel</label>
                <select id="language_level" class="form-select" name="language_level">
                    <option value="">Selecciona</option>
                    @foreach($languageLevels as $value)
                        <option value="{{ $value }}" @selected(old('language_level', $profile->education?->language_level) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="computer_skills">Conocimientos de computación</label>
                <input id="computer_skills" class="form-control" name="computer_skills" value="{{ old('computer_skills', $profile->education?->computer_skills) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="special_knowledge">Conocimientos especiales</label>
                <textarea id="special_knowledge" class="form-control" name="special_knowledge" rows="3">{{ old('special_knowledge', $profile->education?->special_knowledge) }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="special_skills">Habilidades especiales</label>
                <textarea id="special_skills" class="form-control" name="special_skills" rows="3">{{ old('special_skills', $profile->education?->special_skills) }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="courses">Cursos</label>
                <textarea id="courses" class="form-control" name="courses" rows="3">{{ old('courses', $profile->education?->courses) }}</textarea>
            </div>

            <div class="col-12"><hr><h2 class="h5">Experiencia</h2></div>
            <div class="col-md-3">
                <div class="form-check mt-4">
                    <input id="currently_working" class="form-check-input" type="checkbox" name="currently_working" value="1" @checked(old('currently_working', $profile->experience?->currently_working))>
                    <label class="form-check-label" for="currently_working">Actualmente trabajo</label>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="company_name">Empresa</label>
                <input id="company_name" class="form-control" name="company_name" value="{{ old('company_name', $profile->experience?->company_name) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="job_title">Puesto</label>
                <input id="job_title" class="form-control" name="job_title" value="{{ old('job_title', $profile->experience?->job_title) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="employment_type">Tipo de empleo</label>
                <select id="employment_type" class="form-select" name="employment_type">
                    <option value="">Selecciona</option>
                    @foreach($employmentTypes as $value)
                        <option value="{{ $value }}" @selected(old('employment_type', $profile->experience?->employment_type) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="functions">Funciones</label>
                <textarea id="functions" class="form-control" name="functions" rows="3">{{ old('functions', $profile->experience?->functions) }}</textarea>
            </div>
            <div class="col-md-2">
                <label class="form-label" for="monthly_salary">Sueldo</label>
                <input id="monthly_salary" class="form-control" type="number" min="0" step="0.01" name="monthly_salary" value="{{ old('monthly_salary', $profile->experience?->monthly_salary) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="started_at">Inicio</label>
                <input id="started_at" class="form-control" type="date" name="started_at" value="{{ old('started_at', optional($profile->experience?->started_at)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="ended_at">Fin</label>
                <input id="ended_at" class="form-control" type="date" name="ended_at" value="{{ old('ended_at', optional($profile->experience?->ended_at)->format('Y-m-d')) }}">
            </div>

            <div class="col-12"><hr><h2 class="h5">Preferencias laborales</h2></div>
            <div class="col-md-4">
                <label class="form-label" for="desired_position">Puesto deseado</label>
                <input id="desired_position" class="form-control" name="desired_position" value="{{ old('desired_position', $profile->preference?->desired_position) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="desired_employment_type">Tipo de empleo deseado</label>
                <select id="desired_employment_type" class="form-select" name="desired_employment_type">
                    <option value="">Selecciona</option>
                    @foreach($employmentTypes as $value)
                        <option value="{{ $value }}" @selected(old('desired_employment_type', $profile->preference?->desired_employment_type) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="experience_level">Experiencia</label>
                <select id="experience_level" class="form-select" name="experience_level">
                    <option value="">Selecciona</option>
                    @foreach($experienceLevels as $value)
                        <option value="{{ $value }}" @selected(old('experience_level', $profile->preference?->experience_level) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="expected_salary">Sueldo esperado</label>
                <input id="expected_salary" class="form-control" type="number" min="0" step="0.01" name="expected_salary" value="{{ old('expected_salary', $profile->preference?->expected_salary) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="preferred_municipality">Municipio preferido</label>
                <select id="preferred_municipality" class="form-select" name="preferred_municipality">
                    <option value="">Selecciona</option>
                    @foreach($municipalities as $value)
                        <option value="{{ $value }}" @selected(old('preferred_municipality', $profile->preference?->preferred_municipality) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="preferred_state">Estado preferido</label>
                <select id="preferred_state" class="form-select" name="preferred_state">
                    <option value="">Selecciona</option>
                    @foreach($states as $value)
                        <option value="{{ $value }}" @selected(old('preferred_state', $profile->preference?->preferred_state) === $value)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input id="available_to_travel" class="form-check-input" type="checkbox" name="available_to_travel" value="1" @checked(old('available_to_travel', $profile->preference?->available_to_travel))>
                    <label class="form-check-label" for="available_to_travel">Disponible para viajar</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input id="available_to_relocate" class="form-check-input" type="checkbox" name="available_to_relocate" value="1" @checked(old('available_to_relocate', $profile->preference?->available_to_relocate))>
                    <label class="form-check-label" for="available_to_relocate">Disponible para reubicarse</label>
                </div>
            </div>

            <div class="col-12 d-flex flex-wrap gap-2">
                <button class="btn btn-primary" type="submit">Guardar currículum</button>
                <a class="btn btn-outline-secondary" href="{{ route('citizen.resume.pdf') }}">Generar PDF</a>
            </div>
        </form>
    </div>
</section>

<section class="card border-0 shadow-sm">
    <div class="card-body">
        {{-- CV privado: se guarda en storage local, no en public/. --}}
        <h2 class="h5">CV privado</h2>
        @if($currentCv)
            <p class="text-muted">Archivo vigente: {{ $currentCv->original_name }} · {{ optional($currentCv->uploaded_at)->format('d/m/Y H:i') }}</p>
        @else
            <p class="text-muted">Aún no has cargado un CV.</p>
        @endif
        <form method="POST" action="{{ route('citizen.resume.cv.upload') }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-8">
                <label class="form-label" for="cv_file">Archivo PDF, DOC o DOCX</label>
                <input id="cv_file" class="form-control" type="file" name="cv_file" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-outline-primary w-100" type="submit">Cargar CV</button>
            </div>
        </form>
    </div>
</section>
@endsection
