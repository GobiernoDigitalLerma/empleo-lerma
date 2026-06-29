@extends('layouts.dashboard')

@section('title', 'Notificaciones | Admin')
@section('heading', 'Notificaciones')

@section('content')
{{-- Notificaciones propias del administrador autenticado. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.notifications.index') }}">
            <div class="col-md-4">
                <label class="form-label" for="read">Lectura</label>
                <select id="read" class="form-select" name="read">
                    <option value="">Todas</option>
                    <option value="0" @selected(request('read') === '0')>No leídas</option>
                    <option value="1" @selected(request('read') === '1')>Leídas</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.notifications.index') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<x-notification-list
    :notifications="$notifications"
    :read-route="fn ($notification) => route('admin.notifications.read', $notification)"
    :read-all-route="route('admin.notifications.read-all')"
/>
@endsection
