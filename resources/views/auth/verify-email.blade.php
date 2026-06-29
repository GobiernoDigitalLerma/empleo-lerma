@extends('layouts.auth')

@section('title', 'Verificar correo | Empleo Lerma')

@section('auth-content')
{{-- Bloque previo al dashboard: obliga a confirmar correo antes de operar. --}}
<h1 class="section-title h3">Verifica tu correo</h1>
<p class="text-muted">Antes de entrar al dashboard confirma tu correo electrónico.</p>

@if(session('status') === 'verification-link-sent')
    <div class="alert alert-success">Se envió un nuevo enlace de verificación.</div>
@endif

<form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button class="btn btn-primary">Reenviar verificación</button>
</form>
@endsection
