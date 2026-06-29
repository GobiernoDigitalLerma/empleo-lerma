@extends('layouts.auth')

@section('title', 'Entrar | Empleo Lerma')

@section('auth-content')
{{-- Formulario de acceso por correo y contraseña para todos los roles. --}}
<h1 class="section-title h3 mb-4">Entrar</h1>

<form method="POST" action="{{ route('login') }}" class="d-grid gap-3">
    @csrf

    <div>
        <label class="form-label">Correo</label>
        <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label class="form-label">Contraseña</label>
        <input class="form-control" type="password" name="password" required>
        @error('password')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <label class="form-check">
        <input class="form-check-input" type="checkbox" name="remember">
        <span class="form-check-label">Recordarme</span>
    </label>

    <button class="btn btn-primary">Entrar</button>
</form>
@endsection
