@extends('layouts.register')

@section('content')
<body style="background-color:#00a9e0;">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100 px-3">
      <!-- Card -->
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 bg-white shadow rounded-3 p-0">
        <!-- Logo -->
        <div class="brand text-center my-3">
          <a href="{{ url('/') }}">
            <img src="{{ asset('assets/img/logo_lerma.png') }}"
                 alt="lerma"
                 class="img-fluid"
                 style="max-width:55%;height:auto;">
          </a>
        </div>

        <div class="p-4 p-md-5">
          <h5 class="card-title">{{ __('Restablecer contraseña') }}</h5>
          <hr>

          @if (session('status'))
            <div class="alert alert-info" role="alert">
              {{ session('status') }}
            </div>
          @endif

          <p>{{ __('Para poder restablecer tu contraseña, ingresa la información necesaria que se te pide a continuación.') }}</p>

          <form method="POST" action="{{ route('password.email') }}" class="data-form">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label" style="color:#545859">
                {{ __('Correo Electrónico') }}
              </label>

              <input id="email"
                     type="email"
                     name="email"
                     value="{{ old('email') }}"
                     placeholder="Ingrese su correo electrónico."
                     autocomplete="email"
                     autofocus
                     required
                     class="form-control @error('email') is-invalid @enderror"
                     style="border-radius:10px !important;">

              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="d-grid">
              <button type="submit"
                      class="btn"
                      style="border:2px solid #00a9e0;background-color:transparent;color:#00a9e0;border-radius:20px !important;padding:10px 20px;transition:0.3s;">
                {{ __('Recuperar Contraseña') }}
              </button>
            </div>
          </form>
        </div>
      </div><!-- /Card -->
    </div>
  </div>
@endsection
