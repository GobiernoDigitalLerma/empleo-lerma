@extends('layouts.dashboard')

@section('title', 'Mis datos | Ciudadano')
@section('heading', 'Mis datos')

@section('content')
{{-- Perfil ciudadano: datos mínimos para habilitar postulaciones. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('citizen.profile.update') }}" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-8">
                <label class="form-label" for="full_name">Nombre completo</label>
                <input id="full_name" class="form-control" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="curp">CURP</label>
                <input id="curp" class="form-control" name="curp" maxlength="18" value="{{ old('curp', $profile->curp) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label" for="birth_date">Fecha de nacimiento</label>
                <input id="birth_date" class="form-control" type="date" name="birth_date" value="{{ old('birth_date', optional($profile->birth_date)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="gender">Género</label>
                <select id="gender" class="form-select" name="gender">
                    <option value="">Selecciona una opción</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender }}" @selected(old('gender', $profile->gender) === $gender)>{{ $gender }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="marital_status">Estado civil</label>
                <select id="marital_status" class="form-select" name="marital_status">
                    <option value="">Selecciona una opción</option>
                    @foreach($maritalStatuses as $status)
                        <option value="{{ $status }}" @selected(old('marital_status', $profile->marital_status) === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label" for="phone">Teléfono</label>
                <input id="phone" class="form-control" name="phone" value="{{ old('phone', $profile->phone) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="birth_state">Estado de nacimiento</label>
                <select id="birth_state" class="form-select" name="birth_state">
                    <option value="">Selecciona una opción</option>
                    @foreach($states as $state)
                        <option value="{{ $state }}" @selected(old('birth_state', $profile->birth_state) === $state)>{{ $state }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="how_did_you_hear">Cómo se enteró</label>
                <select id="how_did_you_hear" class="form-select" name="how_did_you_hear">
                    <option value="">Selecciona una opción</option>
                    @foreach($sources as $source)
                        <option value="{{ $source }}" @selected(old('how_did_you_hear', $profile->how_did_you_hear) === $source)>{{ $source }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12"><hr><h2 class="h5">Domicilio</h2></div>

            <div class="col-md-6">
                <label class="form-label" for="street">Calle</label>
                <input id="street" class="form-control" name="street" value="{{ old('street', $profile->street) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="external_number">Número exterior</label>
                <input id="external_number" class="form-control" name="external_number" value="{{ old('external_number', $profile->external_number) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="internal_number">Número interior</label>
                <input id="internal_number" class="form-control" name="internal_number" value="{{ old('internal_number', $profile->internal_number) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label" for="neighborhood">Colonia</label>
                <input id="neighborhood" class="form-control" name="neighborhood" value="{{ old('neighborhood', $profile->neighborhood) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="postal_code">Código postal</label>
                <input id="postal_code" class="form-control" name="postal_code" value="{{ old('postal_code', $profile->postal_code) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="municipality">Municipio</label>
                <select id="municipality" class="form-select" name="municipality">
                    <option value="">Selecciona</option>
                    @foreach($municipalities as $municipality)
                        <option value="{{ $municipality }}" @selected(old('municipality', $profile->municipality) === $municipality)>{{ $municipality }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="state">Estado</label>
                <select id="state" class="form-select" name="state">
                    <option value="">Selecciona</option>
                    @foreach($states as $state)
                        <option value="{{ $state }}" @selected(old('state', $profile->state) === $state)>{{ $state }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <div class="form-check mt-4">
                    <input id="has_disability" class="form-check-input" type="checkbox" name="has_disability" value="1" @checked(old('has_disability', $profile->has_disability))>
                    <label class="form-check-label" for="has_disability">Tengo alguna discapacidad</label>
                </div>
            </div>
            <div class="col-md-8">
                <label class="form-label" for="disability_description">Descripción de discapacidad</label>
                <input id="disability_description" class="form-control" name="disability_description" value="{{ old('disability_description', $profile->disability_description) }}">
            </div>

            <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary" type="submit">Guardar datos</button>
                <a class="btn btn-outline-secondary" href="{{ route('citizen.dashboard') }}">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
