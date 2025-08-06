@extends('layouts.base')

@section('content')
<div class="container mt-5">
    <h1 class="text-center" style="color:#545859; font-size: 40px;">Detalles del Evento</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="col-md-12 text-center">
                    {{-- Imagen del evento o imagen por defecto --}}
                    <div style="height: 300px; width: 100%; margin: auto; 
                                background: url('{{ asset($evento->foto ? 'archivo/'.$evento->foto : 'assets/img/default_event.png') }}') 
                                no-repeat center center; background-size: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    </div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">{{ $evento->titulo }}</h5>
                    <p class="card-text text-muted">{{ $evento->descripcion }}</p>
                    <p class="card-text"><strong>📍 Ubicación:</strong> {{ $evento->ubicacion }}</p>
                    <p class="card-text"><small class="text-muted">📅 {{ $evento->fecha }}</small></p>
                   <div class="mt-3">
                    <a href="javascript:history.back()" class="back-button"
                    style="border: 2px solid #fe5000; background-color: transparent; color: #fe5000; 
                                          border-radius: 10px !important; padding: 10px 20px; transition: 0.3s; 
                                          text-transform: uppercase;"><i class="fas fa-arrow-left"></i> Regresar</a>

                    </div>
                    {{-- Botón de registro si hay un enlace --}}
                    @if($evento->link)
                        <div class="mt-3">
                            <a href="{{ $evento->link }}" class="btn btn-lg" target="_blank" 
                               style="border: 2px solid #00b140; background-color: transparent; color: #00b140; 
                                      border-radius: 15px; padding: 10px 20px; transition: 0.3s;">
                                Registrarse
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
@endsection
