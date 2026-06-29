@extends('layouts.dashboard')

@section('title', 'Vacantes para mí | Ciudadano')
@section('heading', 'Vacantes para mí')

@section('content')
{{-- Recomendaciones: prioriza preferencias, pero siempre respeta el scope publicable. --}}
@include('admin.partials.status')

@unless($profile->hasMinimumProfile())
    <div class="alert alert-warning">
        Completa tus datos personales antes de postularte. Puedes revisar vacantes, pero el envío requiere perfil mínimo.
    </div>
@endunless

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('citizen.vacancies.recommended') }}">
            <div class="col-md-8">
                <label class="form-label" for="q">Buscar</label>
                <input id="q" class="form-control" name="q" value="{{ request('q') }}" placeholder="Puesto o palabra clave">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                <a class="btn btn-outline-secondary" href="{{ route('citizen.vacancies.recommended') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<section class="row g-4">
    @forelse($vacancies as $vacancy)
        <div class="col-md-6 col-xl-4">
            <article class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex gap-3 align-items-start mb-3">
                        @if($vacancy->company?->logo_path)
                            <img src="{{ asset($vacancy->company->logo_path) }}" alt="Logo de {{ $vacancy->company->business_name }}" class="citizen-vacancy-card__logo">
                        @else
                            <span class="citizen-vacancy-card__logo citizen-vacancy-card__logo--placeholder">
                                {{ str($vacancy->company?->business_name ?? 'E')->substr(0, 1)->upper() }}
                            </span>
                        @endif
                        <div>
                            <h2 class="h5 mb-1">{{ $vacancy->title }}</h2>
                            <p class="text-muted mb-0">{{ $vacancy->company?->business_name }}</p>
                        </div>
                    </div>

                    <p class="text-muted">{{ str($vacancy->short_description ?: 'Vacante vigente en Empleo Lerma.')->limit(120) }}</p>
                    <p class="mb-1"><strong>Sueldo:</strong> {{ $vacancy->monthly_salary ? '$'.number_format((float) $vacancy->monthly_salary, 2) : 'Por confirmar' }}</p>
                    <p class="mb-3"><strong>Ubicación:</strong> {{ $vacancy->municipality ?: 'Lerma' }} · {{ $vacancy->employment_type ?: 'Tipo pendiente' }}</p>

                    <div class="mt-auto d-grid gap-2">
                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('vacancies.show', $vacancy) }}" target="_blank" rel="noopener">Ver detalle público</a>

                        @if($appliedVacancyIds->contains($vacancy->id))
                            <span class="btn btn-outline-success btn-sm disabled">Ya postulaste</span>
                        @else
                            <form method="POST" action="{{ route('citizen.vacancies.apply', $vacancy) }}">
                                @csrf
                                <button class="btn btn-primary btn-sm w-100" type="submit">Postularme</button>
                            </form>
                        @endif
                    </div>
                </div>
            </article>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-light border">No encontramos vacantes con esos criterios.</div>
        </div>
    @endforelse
</section>

<div class="mt-4">{{ $vacancies->links() }}</div>
@endsection
