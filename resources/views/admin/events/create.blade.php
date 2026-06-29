@extends('layouts.dashboard')

@section('title', 'Nuevo evento | Admin')
@section('heading', 'Nuevo evento')

@section('content')
{{-- Alta de evento público administrado por el municipio. --}}
@include('admin.partials.status')

<section class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
            @include('admin.events._form', ['buttonLabel' => 'Crear evento'])
        </form>
    </div>
</section>
@endsection
