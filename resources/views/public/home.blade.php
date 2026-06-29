@extends('layouts.public')

@section('title', 'Empleo Lerma')

@section('content')
{{-- Hero legacy: imagen amplia y buscador superpuesto para iniciar la búsqueda laboral. --}}
<section class="legacy-home-hero">
    <div class="legacy-home-hero__media" aria-hidden="true"></div>

    <div class="container legacy-home-hero__content">
        <div class="legacy-search-panel">
            <h1>Portal del Empleo Lerma</h1>
            <p class="legacy-search-panel__summary">
                Aquí encuentras {{ number_format($vacanciesCount) }} oportunidades laborales vigentes.
            </p>
            <form action="{{ route('vacancies.index') }}" method="GET" class="legacy-search-form">
                <div>
                    <div class="input-group">
                        <span class="input-group-text" title="puesto">
                            <x-ui-icon name="search" class="form-field-icon" />
                        </span>
                        <input
                            id="home-q"
                            class="form-control"
                            type="search"
                            name="q"
                            placeholder="Puesto o área deseada"
                        >
                    </div>
                </div>

                <div>
                    <div class="input-group">
                        <span class="input-group-text" title="lugar">
                            <x-ui-icon name="map-pin" class="form-field-icon" />
                        </span>
                        <select id="home-municipality" class="form-select" name="municipality">
                            <option value="">Todos los municipios</option>
                            @foreach($municipalities as $municipality)
                                <option value="{{ $municipality }}">{{ $municipality }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="legacy-search-form__action">
                    <button class="btn btn-primary" type="submit">
                        <x-ui-icon name="search" class="button-icon" />
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Empresas: muestra estática con acceso al listado completo. --}}
<section class="legacy-companies-section">
    <div class="container">
        <div class="legacy-section-heading">
            <div>
                <h2 class="legacy-section-title">Empresas que confían en nuestro talento</h2>
                <p class="text-muted mb-0">Conoce algunas de las organizaciones que actualmente cuentan con vacantes disponibles para ti.</p>
            </div>
            <a href="{{ route('companies.index') }}" class="btn btn-outline-primary">Ver todas</a>
        </div>

        @if($companies->isNotEmpty())
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-6 g-4">
                @foreach($companies->take(6) as $company)
                    <div class="col">
                        <a href="{{ route('vacancies.index') }}" class="legacy-company-card">
                            <div class="legacy-company-card__mark">
                                @if($company->logo_path)
                                    <img src="{{ asset($company->logo_path) }}" alt="Logo de {{ $company->business_name }}">
                                @else
                                    <span>{{ str($company->business_name)->substr(0, 1)->upper() }}</span>
                                @endif
                            </div>
                            <h6>{{ $company->business_name }}</h6>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-light border text-center">Aún no hay empresas activas para mostrar.</div>
        @endif
    </div>
</section>

{{-- Oportunidades recientes: reproduce el bloque legacy con sidebar y lista de vacantes. --}}
<section class="legacy-opportunities-section">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="legacy-section-title">Oportunidades Laborales Recientes</h2>
            <p class="text-muted mb-0">Consulta las vacantes más recientes publicadas por empresas aliadas.</p>
        </div>

        <div class="row g-4">
            <aside class="col-12 col-lg-4">
                <div class="legacy-sidebar-card">
                    <h3>Búsquedas Recientes</h3>

                    @forelse($recentSearches as $search)
                        <a href="{{ route('vacancies.index', ['employment_type' => $search]) }}">
                            {{ $search }}
                        </a>
                    @empty
                        <p class="text-muted mb-0">Las búsquedas aparecerán cuando existan más vacantes publicadas.</p>
                    @endforelse
                </div>
            </aside>

            <div class="col-12 col-lg-8">
                <div class="legacy-vacancy-list">
                    @forelse($vacancies as $vacancy)
                        <a href="{{ route('vacancies.show', $vacancy) }}" class="legacy-vacancy-card">
                            <div class="legacy-vacancy-card__image">
                                @if($vacancy->company?->logo_path)
                                    <img src="{{ asset($vacancy->company->logo_path) }}" alt="Logo de {{ $vacancy->company->business_name }}">
                                @else
                                    <span>{{ str($vacancy->company?->business_name ?? $vacancy->title)->substr(0, 1)->upper() }}</span>
                                @endif
                            </div>

                            <div class="legacy-vacancy-card__body">
                                <div class="legacy-vacancy-card__heading">
                                    <h5>{{ $vacancy->title }}</h5>
                                    @if($vacancy->monthly_salary)
                                        <strong>${{ number_format((float) $vacancy->monthly_salary, 0) }}</strong>
                                    @endif
                                </div>

                                <p>{{ $vacancy->short_description ?: 'Vacante vigente publicada en Empleo Lerma.' }}</p>

                                <small>
                                    {{ $vacancy->municipality ?: 'Lerma' }}
                                    <span>/</span>
                                    Publicada {{ optional($vacancy->published_at)->diffForHumans() ?: 'recientemente' }}
                                </small>
                            </div>
                        </a>
                    @empty
                        <div class="alert alert-light border">Aún no hay vacantes publicadas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
