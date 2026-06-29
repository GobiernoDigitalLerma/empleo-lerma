@extends('layouts.public')

@section('title', $title.' | Empleo Lerma')

@section('content')
{{-- Página pública sencilla: conserva la navegación del portal y evita rediseños fuera del alcance. --}}
<section class="public-simple-hero py-5">
    <div class="container py-4">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <p class="public-eyebrow">{{ $eyebrow }}</p>
                <h1 class="display-6 fw-bold">{{ $heading }}</h1>
                <p class="lead text-muted">{{ $description }}</p>
                <a
                    href="{{ route($primaryAction['route'], $primaryAction['parameters'] ?? []) }}"
                    class="btn btn-primary"
                >
                    {{ $primaryAction['label'] }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
