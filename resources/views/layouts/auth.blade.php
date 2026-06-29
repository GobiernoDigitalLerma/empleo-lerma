@extends('layouts.public')

@section('content')
{{-- Contenedor común para login, registro y verificación de correo. --}}
<section class="py-5">
    <div class="container" style="max-width: 760px;">
        <div class="card shadow-sm">
            <div class="card-body p-4 p-md-5">
                @yield('auth-content')
            </div>
        </div>
    </div>
</section>
@endsection
