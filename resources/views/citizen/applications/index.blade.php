@extends('layouts.dashboard')

@section('title', 'Mis postulaciones | Ciudadano')
@section('heading', 'Mis postulaciones')

@section('content')
{{-- Historial ciudadano: sólo muestra postulaciones del perfil autenticado. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('citizen.applications.index') }}">
            <div class="col-md-4">
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
                <a class="btn btn-outline-secondary" href="{{ route('citizen.applications.index') }}">Limpiar</a>
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
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    <tr>
                        <td>
                            <strong>{{ $application->vacancy?->title ?? 'Vacante no disponible' }}</strong>
                            <div class="text-muted">{{ $application->cover_message ?: 'Sin mensaje de presentación' }}</div>
                        </td>
                        <td>{{ $application->company?->business_name ?? $application->vacancy?->company?->business_name ?? 'Empresa no disponible' }}</td>
                        <td><span class="badge text-bg-secondary">{{ $application->status->label() }}</span></td>
                        <td>{{ optional($application->submitted_at ?? $application->created_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">Aún no tienes postulaciones.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $applications->links() }}</div>
</section>
@endsection
