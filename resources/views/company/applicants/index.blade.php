@extends('layouts.dashboard')

@section('title', 'Postulados | Empresa')
@section('heading', 'Postulados')

@section('content')
{{-- Postulados recibidos: cada fila pertenece a una vacante de la empresa autenticada. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        {{-- Filtros para seguimiento rápido por vacante y etapa de postulación. --}}
        <form class="row g-3 align-items-end" method="GET" action="{{ route('company.applicants.index') }}">
            <div class="col-md-5">
                <label class="form-label" for="vacancy_id">Vacante</label>
                <select id="vacancy_id" class="form-select" name="vacancy_id">
                    <option value="">Todas</option>
                    @foreach($vacancies as $vacancy)
                        <option value="{{ $vacancy->id }}" @selected((string) request('vacancy_id') === (string) $vacancy->id)>{{ $vacancy->title }}</option>
                    @endforeach
                </select>
            </div>
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
                <a class="btn btn-outline-secondary" href="{{ route('company.applicants.index') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<section class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Postulante</th>
                    <th>Vacante</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th class="text-end">Seguimiento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                    @php
                        $currentCv = $application->citizenProfile?->documents
                            ->first(fn ($document) => $document->type->value === 'cv' && $document->is_current);
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $application->citizenProfile?->full_name ?? 'Perfil sin nombre' }}</strong>
                            <div class="text-muted">{{ $application->citizenProfile?->phone ?: 'Teléfono pendiente' }}</div>
                        </td>
                        <td>{{ $application->vacancy?->title ?? 'Vacante no disponible' }}</td>
                        <td><span class="badge text-bg-secondary">{{ $application->status->label() }}</span></td>
                        <td>{{ optional($application->submitted_at ?? $application->created_at)->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="d-grid gap-2 justify-content-end">
                                @if($currentCv)
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('company.applicants.cv', $application) }}">Descargar CV</a>
                                @else
                                    <span class="text-muted text-end">Sin CV vigente</span>
                                @endif

                                <form class="d-flex flex-wrap gap-2 justify-content-end" method="POST" action="{{ route('company.applicants.status', $application) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select class="form-select form-select-sm w-auto" name="status" aria-label="Cambiar estado de postulación">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->value }}" @selected($application->status === $status)>{{ $status->label() }}</option>
                                        @endforeach
                                    </select>
                                    <input class="form-control form-control-sm w-auto" name="notes" placeholder="Nota opcional">
                                    <button class="btn btn-sm btn-outline-success" type="submit">Actualizar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">No hay postulados con esos filtros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-body">{{ $applications->links() }}</div>
</section>
@endsection
