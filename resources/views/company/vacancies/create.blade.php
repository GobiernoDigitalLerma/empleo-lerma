@extends('layouts.dashboard')

@section('title', 'Nueva vacante | Empresa')
@section('heading', 'Nueva vacante')

@section('content')
{{-- Alta de vacante: la empresa decide si guarda borrador o envía a revisión. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm">
    <div class="card-body">
        <h2 class="h5 mb-3">Información de la vacante</h2>
        {{-- El formulario real vive aquí; el partial sólo contiene campos reutilizables. --}}
        <form method="POST" action="{{ route('company.vacancies.store') }}">
            @include('company.vacancies._form', [
                'method' => 'POST',
                'vacancy' => $vacancy,
            ])
        </form>
    </div>
</section>
@endsection
