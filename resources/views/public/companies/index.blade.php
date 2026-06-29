@extends('layouts.public')

@section('title', 'Empresas | Empleo Lerma')

@section('content')
{{-- Listado público de empresas activas; mantiene información limitada. --}}
<section class="public-flow-page">
    <div class="container">
        <header class="public-flow-header text-center">
            <h1>Empresas participantes</h1>
            <p>Organizaciones activas que publican oportunidades en Empleo Lerma.</p>
        </header>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
            @forelse($companies as $company)
                <div class="col">
                    <a href="{{ route('vacancies.index') }}" class="legacy-company-card">
                        <div class="legacy-company-card__mark">
                            @if($company->logo_path)
                                <img src="{{ asset($company->logo_path) }}" alt="Logo de {{ $company->business_name }}">
                            @else
                                <span>{{ str($company->business_name)->substr(0, 1)->upper() }}</span>
                            @endif
                        </div>
                        <h4>{{ $company->business_name }}</h4>
                        <p>{{ $company->website ?: $company->economic_activity ?: 'Empresa registrada' }}</p>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center">Aún no hay empresas activas para mostrar.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $companies->links() }}
        </div>
    </div>
</section>
@endsection
