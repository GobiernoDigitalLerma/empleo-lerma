@extends('layouts.dashboard')

@section('title', 'Usuarios | Admin')
@section('heading', 'Ciudadanos')

@section('content')
{{-- Ciudadanos: filtros operativos y acciones de vigencia/acceso. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.users.index') }}">
            <div class="col-md-6">
                <label class="form-label" for="q">Buscar</label>
                <input id="q" class="form-control" name="q" value="{{ request('q') }}" placeholder="Nombre, correo o teléfono">
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
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<section class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Ciudadano</th>
                    <th>Estado</th>
                    <th>Vigencia</th>
                    <th>Perfil</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            <div class="text-muted">{{ $user->email }}</div>
                        </td>
                        <td><span class="badge text-bg-secondary">{{ $user->status->label() }}</span></td>
                        <td>{{ optional($user->access_expires_at)->format('d/m/Y') ?: 'Sin vencimiento' }}</td>
                        <td>{{ $user->citizenProfile?->full_name ?? 'Sin perfil' }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <form method="POST" action="{{ route('admin.users.activate', $user) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success">Activar</button></form>
                                <form method="POST" action="{{ route('admin.users.renew', $user) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-primary">Renovar</button></form>
                                <form method="POST" action="{{ route('admin.users.suspend', $user) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-warning">Suspender</button></form>
                                <form method="POST" action="{{ route('admin.users.revoke', $user) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-danger">Revocar</button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">No hay ciudadanos con esos filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $users->links() }}</div>
</section>
@endsection
