@extends('layouts.dashboard')

@section('title', 'Vacantes | Admin')
@section('heading', 'Vacantes')

@section('content')
{{-- Vacantes: revisión municipal antes y después de publicación. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.vacancies.index') }}">
            <div class="col-md-6">
                <label class="form-label" for="q">Buscar</label>
                <input id="q" class="form-control" name="q" value="{{ request('q') }}" placeholder="Nombre de vacante">
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
                <a class="btn btn-outline-secondary" href="{{ route('admin.vacancies.index') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<section class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Vacante</th>
                    <th>Empresa</th>
                    <th>Estado</th>
                    <th>Vigencia</th>
                    <th>Postulaciones</th>
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
                        <td>{{ $vacancy->company?->business_name ?? 'Sin empresa' }}</td>
                        <td><span class="badge text-bg-secondary">{{ $vacancy->status->label() }}</span></td>
                        <td>{{ optional($vacancy->expires_at)->format('d/m/Y') ?: 'Sin fecha' }}</td>
                        <td>{{ $vacancy->applications_count }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.vacancies.show', $vacancy) }}">Ver</a>
                                <form method="POST" action="{{ route('admin.vacancies.approve', $vacancy) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success">Aprobar</button></form>
                                <form method="POST" action="{{ route('admin.vacancies.reject', $vacancy) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-danger">Rechazar</button></form>
                                <form method="POST" action="{{ route('admin.vacancies.covered', $vacancy) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-primary">Cubierta</button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted">No hay vacantes con esos filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $vacancies->links() }}</div>
</section>
@endsection
