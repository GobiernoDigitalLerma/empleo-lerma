@extends('layouts.dashboard')

@section('title', 'Ciudadano | Empleo Lerma')
@section('heading', 'Panel ciudadano')

@section('content')
{{-- Estado del perfil: indica si el ciudadano ya puede postularse. --}}
<section class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Perfil</p>
                <h2 class="h5">{{ $profile?->full_name ?? auth()->user()->name }}</h2>
                <span class="badge {{ $profile?->hasMinimumProfile() ? 'text-bg-success' : 'text-bg-warning' }}">
                    {{ $profile?->hasMinimumProfile() ? 'Completo' : 'Pendiente' }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Postulaciones</p>
                <strong class="fs-3">{{ $applications->count() }}</strong>
            </div>
        </div>
    </div>
</section>

{{-- Acciones frecuentes para completar perfil antes de aplicar. --}}
<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h2 class="h5">Acciones rápidas</h2>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary btn-sm" href="{{ route('citizen.profile.edit') }}">Completar mis datos</a>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('citizen.resume.edit') }}">Actualizar currículum</a>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('citizen.vacancies.recommended') }}">Vacantes para mí</a>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('vacancies.index') }}">Buscar vacantes</a>
        </div>
    </div>
</section>

{{-- Historial reciente de postulaciones del ciudadano. --}}
<section class="card border-0 shadow-sm">
    <div class="card-body">
        <h2 class="h5">Historial de postulaciones</h2>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Vacante</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td>{{ $application->vacancy?->title }}</td>
                            <td>{{ $application->status->label() }}</td>
                            <td>{{ optional($application->submitted_at)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Aún no hay postulaciones.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
