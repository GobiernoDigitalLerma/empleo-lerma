@extends('layouts.dashboard')

@section('title', $heading.' | Empleo Lerma')
@section('heading', $heading)

@section('content')
{{-- Pantalla puente: mantiene la navegación funcional mientras se construye el CRUD real. --}}
<section class="dashboard-section-card">
    <div class="row g-4 align-items-start">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <span class="badge text-bg-warning mb-3">En preparación</span>
                    <h2 class="h4">Flujo pendiente de implementación</h2>
                    <p class="text-muted mb-4">{{ $description }}</p>

                    @if(! empty($items))
                        <h3 class="h6 text-uppercase text-muted">Alcance esperado</h3>
                        <ul class="dashboard-checklist">
                            @foreach($items as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-help-panel">
                <strong>Nota para desarrollo</strong>
                <p class="mb-0">Esta vista puede reemplazarse por el controlador definitivo sin cambiar el menú ni las rutas públicas del dashboard.</p>
            </div>
        </div>
    </div>
</section>
@endsection
