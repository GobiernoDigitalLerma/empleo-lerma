@extends('layouts.dashboard')

@section('title', 'Editar evento | Admin')
@section('heading', 'Editar evento')

@section('content')
{{-- Edición de evento existente; conserva acciones de publicación en el listado. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
            @include('admin.events._form', ['buttonLabel' => 'Guardar cambios', 'method' => 'PUT'])
        </form>
    </div>
</section>
@endsection
