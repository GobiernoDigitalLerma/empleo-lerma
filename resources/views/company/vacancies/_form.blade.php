{{-- Formulario compartido para crear/editar vacantes de empresa. --}}
@csrf
@isset($method)
    @method($method)
@endisset

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label" for="title">Nombre de la vacante</label>
        <input id="title" class="form-control" name="title" value="{{ old('title', $vacancy->title) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="employment_type">Tipo de empleo</label>
        <select id="employment_type" class="form-select" name="employment_type">
            <option value="">Selecciona una opción</option>
            @foreach($employmentTypes as $employmentType)
                <option value="{{ $employmentType }}" @selected(old('employment_type', $vacancy->employment_type) === $employmentType)>{{ $employmentType }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label" for="short_description">Descripción corta</label>
        <textarea id="short_description" class="form-control" name="short_description" rows="3">{{ old('short_description', $vacancy->short_description) }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="functions">Funciones</label>
        <textarea id="functions" class="form-control" name="functions" rows="4">{{ old('functions', $vacancy->functions) }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="required_knowledge">Conocimientos requeridos</label>
        <textarea id="required_knowledge" class="form-control" name="required_knowledge" rows="4">{{ old('required_knowledge', $vacancy->required_knowledge) }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="monthly_salary">Sueldo mensual</label>
        <input id="monthly_salary" class="form-control" type="number" min="0" step="0.01" name="monthly_salary" value="{{ old('monthly_salary', $vacancy->monthly_salary) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label" for="open_positions">Plazas</label>
        <input id="open_positions" class="form-control" type="number" min="1" name="open_positions" value="{{ old('open_positions', $vacancy->open_positions ?: 1) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="expires_at">Vigencia</label>
        <input id="expires_at" class="form-control" type="date" name="expires_at" value="{{ old('expires_at', optional($vacancy->expires_at)->format('Y-m-d')) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label" for="municipality">Municipio</label>
        <select id="municipality" class="form-select" name="municipality">
            <option value="">Selecciona una opción</option>
            @foreach($municipalities as $municipality)
                <option value="{{ $municipality }}" @selected(old('municipality', $vacancy->municipality) === $municipality)>{{ $municipality }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="state">Estado</label>
        <input id="state" class="form-control" name="state" value="{{ old('state', $vacancy->state) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label" for="work_days">Días laborales</label>
        <input id="work_days" class="form-control" name="work_days" value="{{ old('work_days', $vacancy->work_days) }}">
    </div>
    <div class="col-12">
        <label class="form-label" for="full_address">Dirección completa</label>
        <textarea id="full_address" class="form-control" name="full_address" rows="2">{{ old('full_address', $vacancy->full_address) }}</textarea>
    </div>
    <div class="col-12 d-flex flex-wrap gap-2">
        <button class="btn btn-outline-primary" name="intent" value="draft" type="submit">Guardar borrador</button>
        <button class="btn btn-primary" name="intent" value="submit" type="submit">Enviar a revisión</button>
        <a class="btn btn-outline-secondary" href="{{ route('company.vacancies.index') }}">Cancelar</a>
    </div>
</div>
