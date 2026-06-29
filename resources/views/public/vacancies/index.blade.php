@extends('layouts.public')

@section('title', 'Vacantes | Empleo Lerma')

@section('content')
{{-- Buscador público: filtra únicamente vacantes vigentes y publicables. --}}
<section class="public-vacancies-page">
    <div class="container">
        <header class="public-vacancies-header">
            <div>
                <h1>Vacantes</h1>
                <p>Consulta oportunidades vigentes de empresas activas registradas en Empleo Lerma.</p>
            </div>
            <span>{{ $vacancies->total() }} vacantes vigentes</span>
        </header>

        <form class="vacancy-filter-panel" method="GET" action="{{ route('vacancies.index') }}">
            <div>
                <label class="form-label" for="q">Puesto o palabra clave</label>
                <div class="input-group search-field">
                    <span class="input-group-text">
                        <x-ui-icon name="search" class="form-field-icon" />
                    </span>
                    <input id="q" class="form-control" name="q" value="{{ request('q') }}" placeholder="Ej. auxiliar, ventas, soporte">
                </div>
            </div>

            <div>
                <label class="form-label" for="municipality">Municipio</label>
                <div class="input-group search-field">
                    <span class="input-group-text">
                        <x-ui-icon name="map-pin" class="form-field-icon" />
                    </span>
                    <select id="municipality" class="form-select" name="municipality">
                        <option value="">Todos los municipios</option>
                        @foreach($municipalities as $municipality)
                            <option value="{{ $municipality }}" @selected(request('municipality') === $municipality)>{{ $municipality }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label" for="employment_type">Tipo de vacante</label>
                <div class="input-group search-field">
                    <span class="input-group-text">
                        <x-ui-icon name="briefcase" class="form-field-icon" />
                    </span>
                    <select id="employment_type" class="form-select" name="employment_type">
                        <option value="">Todos los tipos</option>
                        @foreach($employmentTypes as $employmentType)
                            <option value="{{ $employmentType }}" @selected(request('employment_type') === $employmentType)>{{ $employmentType }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="vacancy-filter-actions">
                <button class="btn btn-primary" type="submit">
                    <x-ui-icon name="search" class="button-icon" />
                    Filtrar
                </button>
                <a href="{{ route('vacancies.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>

        {{-- Resultados públicos limitados: el controlador ya filtró vacantes publicables. --}}
        <section class="vacancy-results-panel" aria-label="Resultados de vacantes">
            <div class="vacancy-results-heading">
                <h2>Resultados</h2>
                <p>Se muestran hasta 12 vacantes por página antes de paginar.</p>
            </div>

            <div class="row g-4">
                @forelse($vacancies as $vacancy)
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('vacancies.show', $vacancy) }}" class="vacancy-list-card">
                            {{-- Avatar de empresa: acompaña la vacante sin competir con el puesto. --}}
                            <div class="vacancy-list-card__header">
                                <div class="vacancy-list-card__avatar">
                                    @if($vacancy->company?->logo_path)
                                        <img src="{{ asset($vacancy->company->logo_path) }}" alt="Logo de {{ $vacancy->company->business_name }}">
                                    @else
                                        <span>{{ str($vacancy->company?->business_name ?? $vacancy->title)->substr(0, 1)->upper() }}</span>
                                    @endif
                                </div>

                                <small>{{ $vacancy->company?->business_name ?? 'Empresa registrada' }}</small>
                            </div>

                            <div class="vacancy-list-card__body">
                                <h3>{{ $vacancy->title }}</h3>
                                <strong class="vacancy-list-card__salary">
                                    {{ $vacancy->monthly_salary ? '$'.number_format((float) $vacancy->monthly_salary, 0) : 'Sueldo por confirmar' }}
                                </strong>
                                <p>{{ $vacancy->short_description ?: 'Vacante vigente publicada en Empleo Lerma.' }}</p>
                                <div class="vacancy-list-card__meta">
                                    <span>
                                        {{ $vacancy->municipality ?: 'Lerma' }}
                                    </span>
                                    <span>
                                        {{ $vacancy->employment_type ?: 'Vacante vigente' }}
                                    </span>
                                    <span>
                                        Publicada {{ optional($vacancy->published_at)->diffForHumans() ?: 'recientemente' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border">No se encontraron vacantes vigentes con esos filtros.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">{{ $vacancies->links() }}</div>
        </section>
    </div>
</section>
@endsection
