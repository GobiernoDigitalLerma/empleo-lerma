@extends('layouts.dashboard')

@section('title', 'Detalle de vacante | Admin')
@section('heading', 'Detalle de vacante')

@section('content')
{{-- Detalle interno: permite revisar vacantes pendientes sin publicarlas. --}}
@include('admin.partials.status')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.vacancies.index') }}">Volver a vacantes</a>

    <div class="d-flex flex-wrap gap-2">
        @if($vacancy->isPubliclyVisible())
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('vacancies.show', $vacancy) }}" target="_blank" rel="noopener">Ver público</a>
        @endif
        <form method="POST" action="{{ route('admin.vacancies.approve', $vacancy) }}">
            @csrf
            @method('PATCH')
            <button class="btn btn-success btn-sm" type="submit">Aprobar y publicar</button>
        </form>
        <form method="POST" action="{{ route('admin.vacancies.reject', $vacancy) }}">
            @csrf
            @method('PATCH')
            <button class="btn btn-outline-danger btn-sm" type="submit">Rechazar</button>
        </form>
    </div>
</div>

<section class="row g-4">
    <div class="col-lg-8">
        <article class="card border-0 shadow-sm h-100">
            <div class="card-body">
                {{-- Datos principales de revisión administrativa. --}}
                <div class="d-flex flex-wrap justify-content-between gap-3 mb-3">
                    <div>
                        <h2 class="h4 mb-1">{{ $vacancy->title }}</h2>
                        <p class="text-muted mb-0">{{ $vacancy->employment_type ?: 'Tipo de empleo pendiente' }}</p>
                    </div>
                    <span class="badge text-bg-secondary align-self-start">{{ $vacancy->status->label() }}</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 h-100">
                            <p class="text-muted mb-1">Sueldo mensual</p>
                            <strong>{{ $vacancy->monthly_salary ? '$'.number_format((float) $vacancy->monthly_salary, 2) : 'No definido' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 h-100">
                            <p class="text-muted mb-1">Ubicación</p>
                            <strong>{{ $vacancy->municipality ?: 'Municipio pendiente' }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 h-100">
                            <p class="text-muted mb-1">Vigencia</p>
                            <strong>{{ optional($vacancy->expires_at)->format('d/m/Y') ?: 'Sin fecha' }}</strong>
                        </div>
                    </div>
                </div>

                <h3 class="h5">Descripción</h3>
                <p>{{ $vacancy->short_description ?: 'Sin descripción capturada.' }}</p>

                <h3 class="h5">Funciones</h3>
                <p>{{ $vacancy->functions ?: 'Sin funciones capturadas.' }}</p>

                <h3 class="h5">Conocimientos requeridos</h3>
                <p>{{ $vacancy->required_knowledge ?: 'Sin conocimientos capturados.' }}</p>

                <h3 class="h5">Dirección</h3>
                <p class="mb-0">{{ $vacancy->full_address ?: 'Sin dirección capturada.' }}</p>
            </div>
        </article>
    </div>

    <aside class="col-lg-4">
	        <div class="card border-0 shadow-sm mb-4">
	            <div class="card-body">
	                {{-- Empresa propietaria de la vacante. --}}
	                <h2 class="h5">Empresa</h2>
	                <div class="company-logo-thumb mb-3">
	                    @if($vacancy->company?->logoUrl())
	                        <img src="{{ $vacancy->company->logoUrl() }}" alt="Logo de {{ $vacancy->company->business_name }}">
	                    @else
	                        <span>{{ str($vacancy->company?->business_name ?? 'Empresa')->substr(0, 1)->upper() }}</span>
	                    @endif
	                </div>
	                <p class="mb-1"><strong>{{ $vacancy->company?->business_name ?? 'Sin empresa' }}</strong></p>
	                <p class="text-muted mb-1">{{ $vacancy->company?->primary_email ?: 'Correo pendiente' }}</p>
	                <p class="text-muted mb-0">{{ $vacancy->company?->primary_phone ?: 'Teléfono pendiente' }}</p>
	            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                {{-- Resumen operativo para decidir aprobación o seguimiento. --}}
                <h2 class="h5">Seguimiento</h2>
                <dl class="row mb-0">
                    <dt class="col-6">Postulaciones</dt>
                    <dd class="col-6 text-end">{{ $vacancy->applications_count }}</dd>
                    <dt class="col-6">Plazas</dt>
                    <dd class="col-6 text-end">{{ $vacancy->open_positions }}</dd>
                    <dt class="col-6">Publicada</dt>
                    <dd class="col-6 text-end">{{ optional($vacancy->published_at)->format('d/m/Y') ?: 'No' }}</dd>
                    <dt class="col-6">Aprobada</dt>
                    <dd class="col-6 text-end">{{ optional($vacancy->approved_at)->format('d/m/Y') ?: 'No' }}</dd>
                </dl>
            </div>
        </div>
    </aside>
</section>
@endsection
