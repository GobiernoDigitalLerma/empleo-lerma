@extends('layouts.public')

@section('title', 'Eventos | Empleo Lerma')

@section('content')
{{-- Listado público: sólo recibe eventos ya filtrados como publicados desde el controlador. --}}
<section class="py-5">
    <div class="container">
        <h1 class="section-title mb-4">Eventos</h1>

        <div class="row g-3">
            @forelse($events as $event)
                <div class="col-md-4">
                    <div class="card h-100">
                        @if($event->image_path)
                            <img src="{{ asset($event->image_path) }}" class="event-card-image" alt="Publicidad de {{ $event->title }}">
                        @else
                            <div class="event-card-placeholder" aria-hidden="true">{{ str($event->title)->substr(0, 1)->upper() }}</div>
                        @endif
                        <div class="card-body">
                            <h2 class="h5">{{ $event->title }}</h2>
                            <p class="text-muted">{{ optional($event->event_date)->format('d/m/Y H:i') }}</p>
                            <a href="{{ route('events.show', $event) }}">Detalle</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">No hay eventos publicados.</div>
                </div>
            @endforelse
        </div>

        {{-- Paginación nativa de Laravel para conservar filtros cuando existan. --}}
        <div class="mt-4">{{ $events->links() }}</div>
    </div>
</section>
@endsection
