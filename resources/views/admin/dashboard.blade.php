@extends('layouts.dashboard')

@section('title', 'Admin | Empleo Lerma')
@section('heading', 'Panel administrador')

@section('content')
{{-- Métricas principales para lectura rápida del estado operativo. --}}
<section class="row g-3 mb-4">
    @foreach($metrics as $label => $value)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">{{ $label }}</p>
                    <strong class="fs-3">{{ $value }}</strong>
                </div>
            </div>
        </div>
    @endforeach
</section>

{{-- Acciones frecuentes que evitan depender sólo del menú lateral. --}}
<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h2 class="h5">Acciones rápidas</h2>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.users.index') }}">Revisar ciudadanos</a>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.companies.index') }}">Revisar empresas</a>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.vacancies.index') }}">Revisar vacantes</a>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.events.index') }}">Administrar eventos</a>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.audit.index') }}">Ver auditoría</a>
        </div>
    </div>
</section>

{{-- Auditoría reciente para detectar cambios sensibles sin salir del resumen. --}}
<section class="card border-0 shadow-sm">
    <div class="card-body">
        <h2 class="h5">Auditoría reciente</h2>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Acción</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($audits as $audit)
                        <tr>
                            <td>{{ $audit->action }}</td>
                            <td>{{ $audit->user?->name ?? 'Sistema' }}</td>
                            <td>{{ $audit->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Sin eventos de auditoría.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
