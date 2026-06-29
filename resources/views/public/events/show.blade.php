@extends('layouts.public')

@section('title', $event->title.' | Empleo Lerma')

@section('content')
{{-- Detalle público de evento; no muestra controles administrativos. --}}
<section class="py-5">
    <div class="container" style="max-width: 860px;">
        <a href="{{ route('events.index') }}">Volver a eventos</a>

        <div class="card mt-3">
            @if($event->image_path)
                <img src="{{ asset($event->image_path) }}" class="event-detail-image" alt="Publicidad de {{ $event->title }}">
            @endif
            <div class="card-body p-4">
                <h1 class="section-title h3">{{ $event->title }}</h1>
                <p class="text-muted">{{ optional($event->event_date)->format('d/m/Y H:i') }} · {{ $event->location }}</p>
                <p>{{ $event->description }}</p>

                @if($event->link)
                    <a class="btn btn-primary" href="{{ $event->link }}" target="_blank" rel="noopener">Abrir enlace</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
