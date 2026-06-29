@extends('layouts.dashboard')

@section('title', 'Empresas | Admin')
@section('heading', 'Empresas')

@section('content')
{{-- Empresas: revisión y control de autorización para publicar. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.companies.index') }}">
            <div class="col-md-6">
                <label class="form-label" for="q">Buscar</label>
                <input id="q" class="form-control" name="q" value="{{ request('q') }}" placeholder="Empresa, RFC o correo">
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
                <a class="btn btn-outline-secondary" href="{{ route('admin.companies.index') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<section class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Contacto</th>
                    <th>Estado</th>
                    <th>Vacantes</th>
                    <th>Postulaciones</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($companies as $company)
                    <tr>
                        <td>
                            <strong>{{ $company->business_name }}</strong>
                            <div class="text-muted">{{ $company->rfc ?: 'RFC pendiente' }}</div>
                        </td>
                        <td>
                            {{ $company->primary_email ?: $company->user?->email }}
                            <div class="text-muted">{{ $company->primary_phone ?: 'Teléfono pendiente' }}</div>
                        </td>
                        <td><span class="badge text-bg-secondary">{{ $company->status->label() }}</span></td>
                        <td>{{ $company->vacancies_count }}</td>
                        <td>{{ $company->applications_count }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <form method="POST" action="{{ route('admin.companies.approve', $company) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success">Aprobar</button></form>
                                <form method="POST" action="{{ route('admin.companies.suspend', $company) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-warning">Suspender</button></form>
                                <form method="POST" action="{{ route('admin.companies.reject', $company) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-danger">Rechazar</button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted">No hay empresas con esos filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $companies->links() }}</div>
</section>
@endsection
