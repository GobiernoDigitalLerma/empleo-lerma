@extends('layouts.public')

@section('title', $vacancy->title.' | Empleo Lerma')

@section('content')
{{-- Detalle público: separa información de la vacante y datos de empresa en sidebar. --}}
<section class="vacancy-detail-page">
    <div class="container">
        <a href="{{ route('vacancies.index') }}" class="text-decoration-none">Volver a vacantes</a>

        <header class="vacancy-detail-header">
            <h1>{{ $vacancy->title }}</h1>
        </header>

        <div class="row g-4 align-items-start">
            <div class="col-12 col-lg-8">
                <div class="vacancy-stats">
                    <div>
                        <span>Sueldo mensual</span>
                        <strong>
                            {{ $vacancy->monthly_salary ? '$'.number_format((float) $vacancy->monthly_salary, 0) : 'Por confirmar' }}
                        </strong>
                    </div>
                    <div>
                        <span>Lugar</span>
                        <strong>{{ $vacancy->municipality ?: 'Lerma' }}</strong>
                    </div>
                    <div>
                        <span>Tipo</span>
                        <strong>{{ $vacancy->employment_type ?: 'Vacante vigente' }}</strong>
                    </div>
                </div>

                <article class="vacancy-detail-content">
                    <h2>Descripción</h2>
                    <p>{{ $vacancy->short_description ?: 'Vacante vigente publicada en Empleo Lerma.' }}</p>

                    <h2>Funciones</h2>
                    <p>{{ $vacancy->functions ?: 'Información disponible al postularse con registro vigente.' }}</p>

                    <h2>Conocimientos requeridos</h2>
                    <p>{{ $vacancy->required_knowledge ?: 'Información disponible al postularse con registro vigente.' }}</p>

                    <h2>Datos generales</h2>
                    <ul class="vacancy-detail-list">
                        <li><strong>Plazas:</strong> {{ $vacancy->open_positions }}</li>
                        <li><strong>Días laborales:</strong> {{ $vacancy->work_days ?: 'Por confirmar' }}</li>
                        <li><strong>Vigencia:</strong> {{ optional($vacancy->expires_at)->format('d/m/Y') ?: 'Por confirmar' }}</li>
                    </ul>
                </article>
            </div>

            <aside class="col-12 col-lg-4">
                <div class="vacancy-company-card">
                    <div class="vacancy-company-logo">
                        @if($vacancy->company?->logo_path)
                            <img src="{{ asset($vacancy->company->logo_path) }}" alt="Logo de {{ $vacancy->company->business_name }}">
                        @else
                            <span>{{ str($vacancy->company?->business_name ?? 'Empresa')->substr(0, 1)->upper() }}</span>
                        @endif
                    </div>

                    <h2>{{ $vacancy->company?->business_name ?? 'Empresa registrada' }}</h2>
                    <p>{{ $vacancy->company?->economic_activity ?: 'Empresa participante' }}</p>

                    <div class="vacancy-company-rating" aria-label="Empresa verificada">
                        <span>★</span>
                        <span>★</span>
                        <span>★</span>
                        <span>☆</span>
                        <span>☆</span>
                    </div>

                    @auth
                        @if(auth()->user()->isCitizen())
                            <a href="{{ route('citizen.dashboard') }}" class="btn btn-primary w-100">Ir a mi perfil para postular</a>
                        @else
                            <a href="{{ route('vacancies.index') }}" class="btn btn-primary w-100">Ver más vacantes</a>
                        @endif
                    @else
                        <a href="{{ route('register', 'citizen') }}" class="btn btn-primary w-100">Registrarme para postular</a>
                    @endauth
                </div>

                <div class="vacancy-share">
                    <span>Comparte esta vacante</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener" aria-label="Compartir en Facebook">
                        Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($vacancy->title) }}" target="_blank" rel="noopener" aria-label="Compartir en X">
                        X
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>

<section class="similar-vacancies-section">
    <div class="container">
        <h2>Vacantes similares</h2>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @forelse($similarVacancies as $similarVacancy)
                <div class="col">
                    <a href="{{ route('vacancies.show', $similarVacancy) }}" class="similar-vacancy-card">
                        <h3>{{ $similarVacancy->title }}</h3>
                        <p>{{ $similarVacancy->short_description ?: 'Vacante vigente publicada en Empleo Lerma.' }}</p>
                        <small>{{ $similarVacancy->municipality ?: 'Lerma' }} / {{ optional($similarVacancy->published_at)->diffForHumans() }}</small>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">Aún no hay vacantes similares publicadas.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
