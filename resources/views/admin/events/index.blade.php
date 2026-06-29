@extends('layouts.dashboard')

@section('title', 'Eventos | Admin')
@section('heading', 'Eventos')

@section('content')
{{-- Eventos: listado y acciones de publicación. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-end mb-3">
            <form class="row g-3 flex-grow-1 align-items-end" method="GET" action="{{ route('admin.events.index') }}">
                <div class="col-md-6">
                    <label class="form-label" for="q">Buscar</label>
                    <input id="q" class="form-control" name="q" value="{{ request('q') }}" placeholder="Título de evento">
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
                    <a class="btn btn-outline-secondary" href="{{ route('admin.events.index') }}">Limpiar</a>
                </div>
            </form>
            <a class="btn btn-success" href="{{ route('admin.events.create') }}">Nuevo evento</a>
        </div>
    </div>
</section>

<section class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>
                            <strong>{{ $event->title }}</strong>
                            <div class="text-muted">{{ $event->location ?: 'Ubicación pendiente' }}</div>
                        </td>
                        <td>{{ optional($event->event_date)->format('d/m/Y H:i') ?: 'Sin fecha' }}</td>
                        <td><span class="badge text-bg-secondary">{{ $event->status->label() }}</span></td>
                        <td>{{ $event->image_path ?: 'Sin imagen' }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.events.edit', $event) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.events.publish', $event) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success">Publicar</button></form>
                                <form method="POST" action="{{ route('admin.events.archive', $event) }}">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-warning">Archivar</button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">No hay eventos con esos filtros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $events->links() }}</div>
</section>
@endsection
