@extends('layouts.dashboard')

@section('title', 'Empresa | Empleo Lerma')
@section('heading', 'Panel empresa')

@section('content')
{{-- Resumen operativo de empresa: perfil, vacantes y postulaciones recibidas. --}}
<section class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Empresa</p>
                <h2 class="h5">{{ $company?->business_name ?? 'Perfil pendiente' }}</h2>
                <span class="badge text-bg-secondary">{{ $company?->status?->label() ?? 'Sin perfil' }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Vacantes</p>
                <strong class="fs-3">{{ $vacanciesCount }}</strong>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Postulaciones</p>
                <strong class="fs-3">{{ $applicationsCount }}</strong>
            </div>
        </div>
    </div>
</section>

{{-- Acciones frecuentes orientadas a publicar y revisar candidatos. --}}
<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h2 class="h5">Acciones rápidas</h2>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary btn-sm" href="{{ route('company.vacancies.create') }}">Nueva vacante</a>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('company.vacancies.index') }}">Ver vacantes</a>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('company.applicants.index') }}">Ver postulados</a>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('company.profile.edit') }}">Actualizar datos</a>
        </div>
    </div>
</section>

{{-- Tabla compacta de vacantes recientes de la empresa. --}}
<section class="card border-0 shadow-sm">
    <div class="card-body">
        <h2 class="h5">Vacantes recientes</h2>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Vacante</th>
                        <th>Estado</th>
                        <th>Publicada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vacancies as $vacancy)
                        <tr>
                            <td>{{ $vacancy->title }}</td>
                            <td>{{ $vacancy->status->label() }}</td>
                            <td>{{ optional($vacancy->published_at)->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Aún no hay vacantes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
