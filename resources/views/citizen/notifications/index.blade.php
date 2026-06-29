@extends('layouts.dashboard')

@section('title', 'Notificaciones | Ciudadano')
@section('heading', 'Notificaciones')

@section('content')
{{-- Notificaciones propias del ciudadano autenticado. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('citizen.notifications.index') }}">
            <div class="col-md-4">
                <label class="form-label" for="read">Lectura</label>
                <select id="read" class="form-select" name="read">
                    <option value="">Todas</option>
                    <option value="0" @selected(request('read') === '0')>No leídas</option>
                    <option value="1" @selected(request('read') === '1')>Leídas</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100" type="submit">Filtrar</button>
                <a class="btn btn-outline-secondary" href="{{ route('citizen.notifications.index') }}">Limpiar</a>
            </div>
        </form>
    </div>
</section>

<x-notification-list
    :notifications="$notifications"
    :read-route="fn ($notification) => route('citizen.notifications.read', $notification)"
    :read-all-route="route('citizen.notifications.read-all')"
/>
@endsection
