@extends('layouts.auth')

@section('title', 'Registro | Empleo Lerma')

@section('auth-content')
{{-- Registro público: comparte campos base y agrega datos fiscales si el tipo es empresa. --}}
<h1 class="section-title h3 mb-4">Registro {{ $type === 'company' ? 'empresa' : 'ciudadano' }}</h1>

<form method="POST" action="{{ route('register') }}" class="row g-3">
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">

    {{-- Datos comunes para ciudadano y empresa. --}}
    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input class="form-control" name="name" value="{{ old('name') }}" required>
        @error('name')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Correo</label>
        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input class="form-control" name="phone" value="{{ old('phone') }}">
    </div>

    {{-- Datos extra para crear perfil inicial de empresa. --}}
    @if($type === 'company')
        <div class="col-md-6">
            <label class="form-label">Razón social</label>
            <input class="form-control" name="business_name" value="{{ old('business_name') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">RFC</label>
            <input class="form-control" name="rfc" value="{{ old('rfc') }}">
        </div>
    @endif

    {{-- Contraseña de sesión Laravel; la confirmación evita errores de captura. --}}
    <div class="col-md-6">
        <label class="form-label">Contraseña</label>
        <input class="form-control" type="password" name="password" required>
        @error('password')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirmar contraseña</label>
        <input class="form-control" type="password" name="password_confirmation" required>
    </div>

    <div class="col-12">
        <button class="btn btn-primary">Crear cuenta</button>
    </div>
</form>
@endsection
