@extends('layouts.dashboard')

@section('title', 'Catálogos | Admin')
@section('heading', 'Catálogos')

@section('content')
{{-- Catálogos: alta rápida y activación/desactivación de valores. --}}
@include('admin.partials.status')

<section class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5">Nuevo valor</h2>
                <form method="POST" action="{{ route('admin.catalogs.store') }}" class="vstack gap-3">
                    @csrf
                    <div>
                        <label class="form-label" for="type">Tipo</label>
                        <input id="type" class="form-control" name="type" value="{{ old('type', request('type')) }}" placeholder="municipality" required>
                    </div>
                    <div>
                        <label class="form-label" for="name">Nombre</label>
                        <input id="name" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div>
                        <label class="form-label" for="sort_order">Orden</label>
                        <input id="sort_order" class="form-control" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">
                    </div>
                    <button class="btn btn-primary" type="submit">Crear</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.catalogs.index') }}">
                    <div class="col-md-8">
                        <label class="form-label" for="type_filter">Tipo</label>
                        <select id="type_filter" class="form-select" name="type">
                            <option value="">Todos</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                        <a class="btn btn-outline-secondary" href="{{ route('admin.catalogs.index') }}">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead><tr><th>Tipo</th><th>Nombre</th><th>Activo</th><th>Orden</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                        @forelse($catalogs as $catalog)
                            <tr>
                                <td>{{ $catalog->type }}</td>
                                <td>{{ $catalog->name }}</td>
                                <td><span class="badge text-bg-{{ $catalog->is_active ? 'success' : 'secondary' }}">{{ $catalog->is_active ? 'Sí' : 'No' }}</span></td>
                                <td>{{ $catalog->sort_order }}</td>
                                <td class="text-end">
                                    <div class="d-flex flex-wrap gap-2 justify-content-end">
                                        <form method="POST" action="{{ route('admin.catalogs.toggle', $catalog) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-primary" type="submit">Alternar</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.catalogs.destroy', $catalog) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-muted">No hay catálogos con esos filtros.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="catalog-pagination">
                <p>
                    Mostrando {{ $catalogs->firstItem() ?? 0 }}-{{ $catalogs->lastItem() ?? 0 }}
                    de {{ $catalogs->total() }} registros
                </p>

                <div class="catalog-pagination__controls">
                    @if($catalogs->onFirstPage())
                        <span class="btn btn-outline-secondary btn-sm disabled">Anterior</span>
                    @else
                        <a class="btn btn-outline-secondary btn-sm" href="{{ $catalogs->previousPageUrl() }}">Anterior</a>
                    @endif

                    <span class="catalog-pagination__current">
                        Página {{ $catalogs->currentPage() }} de {{ $catalogs->lastPage() }}
                    </span>

                    @if($catalogs->hasMorePages())
                        <a class="btn btn-outline-secondary btn-sm" href="{{ $catalogs->nextPageUrl() }}">Siguiente</a>
                    @else
                        <span class="btn btn-outline-secondary btn-sm disabled">Siguiente</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
