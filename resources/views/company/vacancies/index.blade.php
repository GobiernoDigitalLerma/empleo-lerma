@extends('layouts.dashboard')

@section('title', 'Vacantes | Empresa')
@section('heading', 'Vacantes')

@section('content')
{{-- Vacantes de empresa: sólo muestra registros pertenecientes a la empresa autenticada. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        {{-- Filtros ligeros para operación diaria: estado y texto libre. --}}
        <form class="row g-3 align-items-end" method="GET" action="{{ route('company.vacancies.index') }}">
            <div class="col-md-6">
                <label class="form-label" for="q">Buscar</label>
                <input id="q" class="form-control" name="q" value="{{ request('q') }}" placeholder="Nombre, descripción o municipio">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="status">Estado</label>
                <select id="status" class="form-select" name="status">
                    <option value="">Todos</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                <a class="btn btn-outline-secondary" href="{{ route('company.vacancies.index') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <p class="text-muted mb-0">Administra borradores, vacantes enviadas a revisión y vacantes publicadas.</p>
    <a class="btn btn-primary" href="{{ route('company.vacancies.create') }}">Nueva vacante</a>
</div>

<section class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Vacante</th>
                    <th>Estado</th>
                    <th>Sueldo</th>
                    <th>Vigencia</th>
                    <th>Postulados</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vacancies as $vacancy)
                    <tr>
                        <td>
                            <strong>{{ $vacancy->title }}</strong>
                            <div class="text-muted">{{ $vacancy->employment_type ?: 'Tipo pendiente' }} · {{ $vacancy->municipality ?: 'Municipio pendiente' }}</div>
                        </td>
                        <td><span class="badge text-bg-secondary">{{ $vacancy->status->label() }}</span></td>
                        <td>{{ $vacancy->monthly_salary ? '$'.number_format((float) $vacancy->monthly_salary, 2) : 'No definido' }}</td>
                        <td>{{ optional($vacancy->expires_at)->format('d/m/Y') ?: 'Sin fecha' }}</td>
                        <td>{{ $vacancy->applications_count }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                @if($vacancy->isPubliclyVisible())
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('vacancies.show', $vacancy) }}" target="_blank" rel="noopener">Ver público</a>
                                @endif
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('company.vacancies.edit', $vacancy) }}">Editar</a>
                                @unless($vacancy->is_covered)
                                    <form method="POST" action="{{ route('company.vacancies.covered', $vacancy) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-success" type="submit">Marcar cubierta</button>
                                    </form>
                                @endunless
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">No hay vacantes con esos filtros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $vacancies->links() }}</div>
</section>
@endsection
