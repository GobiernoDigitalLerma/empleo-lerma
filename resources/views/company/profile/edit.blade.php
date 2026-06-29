@extends('layouts.dashboard')

@section('title', 'Datos empresariales | Empresa')
@section('heading', 'Datos empresariales')

@section('content')
{{-- Perfil empresarial: datos fiscales, contacto, domicilio y logo público. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('company.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label" for="business_name">Razón social / nombre comercial</label>
                    <input id="business_name" class="form-control" name="business_name" value="{{ old('business_name', $company->business_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="rfc">RFC</label>
                    <input id="rfc" class="form-control" name="rfc" value="{{ old('rfc', $company->rfc) }}" maxlength="13">
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="economic_activity">Actividad económica</label>
                    <input id="economic_activity" class="form-control" name="economic_activity" value="{{ old('economic_activity', $company->economic_activity) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="employee_count">Empleados</label>
                    <input id="employee_count" class="form-control" type="number" min="0" name="employee_count" value="{{ old('employee_count', $company->employee_count) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="website">Sitio web</label>
                    <input id="website" class="form-control" type="url" name="website" value="{{ old('website', $company->website) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label" for="primary_email">Correo principal</label>
                    <input id="primary_email" class="form-control" type="email" name="primary_email" value="{{ old('primary_email', $company->primary_email) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="primary_phone">Teléfono principal</label>
                    <input id="primary_phone" class="form-control" name="primary_phone" value="{{ old('primary_phone', $company->primary_phone) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="secondary_phone">Teléfono secundario</label>
                    <input id="secondary_phone" class="form-control" name="secondary_phone" value="{{ old('secondary_phone', $company->secondary_phone) }}">
                </div>

                <div class="col-md-5">
                    <label class="form-label" for="street">Calle</label>
                    <input id="street" class="form-control" name="street" value="{{ old('street', $company->street) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="external_number">No. ext.</label>
                    <input id="external_number" class="form-control" name="external_number" value="{{ old('external_number', $company->external_number) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="internal_number">No. int.</label>
                    <input id="internal_number" class="form-control" name="internal_number" value="{{ old('internal_number', $company->internal_number) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="postal_code">Código postal</label>
                    <input id="postal_code" class="form-control" name="postal_code" value="{{ old('postal_code', $company->postal_code) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="neighborhood">Colonia</label>
                    <input id="neighborhood" class="form-control" name="neighborhood" value="{{ old('neighborhood', $company->neighborhood) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="municipality">Municipio</label>
                    <input id="municipality" class="form-control" name="municipality" value="{{ old('municipality', $company->municipality) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="state">Estado</label>
                    <input id="state" class="form-control" name="state" value="{{ old('state', $company->state) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="logo_file">Logo de empresa</label>
                    <input id="logo_file" class="form-control" type="file" name="logo_file" accept="image/jpeg,image/png,image/webp,image/svg+xml">
                    <div class="form-text">Formatos permitidos: JPG, PNG, WebP o SVG. Máximo 2 MB.</div>
                </div>
                <div class="col-md-6">
                    @if($company->logo_path)
                        <p class="form-label">Logo actual</p>
                        <img src="{{ asset($company->logo_path) }}" alt="Logo de {{ $company->business_name }}" class="event-admin-preview">
                    @endif
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar datos</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
