@extends('layouts.dashboard')

@section('title', 'Auditoría | Admin')
@section('heading', 'Auditoría')

@section('content')
{{-- Auditoría: trazabilidad de cambios sensibles del panel. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.audit.index') }}">
            <div class="col-md-3">
                <label class="form-label" for="user_id">Usuario</label>
                <select id="user_id" class="form-select" name="user_id">
                    <option value="">Todos</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected((string) request('user_id') === (string) $user->id)>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="action">Acción</label>
                <input id="action" class="form-control" name="action" value="{{ request('action') }}" placeholder="admin.vacancies">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="from">Desde</label>
                <input id="from" class="form-control" type="date" name="from" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="to">Hasta</label>
                <input id="to" class="form-control" type="date" name="to" value="{{ request('to') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.audit.index') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<section class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Usuario</th>
                    <th>Entidad</th>
                    <th>IP</th>
                    <th>Fecha</th>
                    <th>Valores</th>
                </tr>
            </thead>
            <tbody>
                @forelse($audits as $audit)
                    <tr>
                        <td><code>{{ $audit->action }}</code></td>
                        <td>{{ $audit->user?->name ?? 'Sistema' }}</td>
                        <td>{{ class_basename($audit->auditable_type) ?: 'N/A' }} {{ $audit->auditable_id ? '#'.$audit->auditable_id : '' }}</td>
                        <td>{{ $audit->ip_address ?: 'N/A' }}</td>
                        <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                        <td><code>{{ str(json_encode($audit->new_values, JSON_UNESCAPED_UNICODE))->limit(100) }}</code></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted">No hay registros de auditoría con esos filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $audits->links() }}</div>
</section>
@endsection
