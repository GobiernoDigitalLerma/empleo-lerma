@extends('layouts.dashboard')

@section('title', 'Editar vacante | Empresa')
@section('heading', 'Editar vacante')

@section('content')
{{-- Edición de vacante: conserva propiedad de empresa desde el controlador. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h2 class="h5 mb-1">{{ $vacancy->title }}</h2>
                <span class="badge text-bg-secondary">{{ $vacancy->status->label() }}</span>
            </div>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('company.vacancies.index') }}">Volver</a>
        </div>

        {{-- El partial se reutiliza, pero cada vista define su action explícito. --}}
        <form method="POST" action="{{ route('company.vacancies.update', $vacancy) }}">
            @include('company.vacancies._form', [
                'method' => 'PUT',
                'vacancy' => $vacancy,
            ])
        </form>
    </div>
</section>
@endsection
