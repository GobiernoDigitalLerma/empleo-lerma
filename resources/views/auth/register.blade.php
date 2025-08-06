@extends('layouts.register')

@section('content')
<body style="background-color: #00a9e0;">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100 py-3">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5 bg-white shadow-lg rounded-3 p-4 p-md-5">
        
        <!-- Logo -->
        <div class="text-center mb-4">
          <a href="{{url('/')}}">
            <img src="{{asset('assets/img/logo_lerma.png')}}" alt="Lerma" class="img-fluid" style="max-width: 50%;">
          </a>
        </div>

        <!-- Título -->
        <h3 class="text-center mb-4" style="color:#545859">Registro</h3>

        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
          @csrf
          
          <!-- Tipo de Usuario -->
          <div class="mb-3">
            <label style="color:#545859; font-weight:500;">{{ __('Soy') }}</label>
            <select name="tipo_user" class="form-select" style="border-radius: 10px; padding: 10px 15px;" required>
              <option value="user">Ciudadano</option>
              <option value="company">Empresa</option>
            </select>
          </div>

          <!-- Nombre Completo -->
          <div class="mb-3">
            <label style="color:#545859; font-weight:500;">{{ __('Nombre Completo') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name') }}" 
                   placeholder="Escribe tu nombre completo" 
                   style="border-radius: 10px; padding: 10px 15px;"
                   required autocomplete="name">
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Correo Electrónico -->
          <div class="mb-3">
            <label style="color:#545859; font-weight:500;">{{ __('Correo Electrónico') }}</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" 
                   placeholder="Escribe tu correo electrónico" 
                   style="border-radius: 10px; padding: 10px 15px;"
                   required autocomplete="email">
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Teléfono -->
          <div class="mb-3">
            <label style="color:#545859; font-weight:500;">{{ __('Teléfono') }}</label>
            <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                   id="telefono" name="telefono" value="{{ old('telefono') }}" 
                   placeholder="Ingresa tu número de teléfono" 
                   pattern="[0-9]{10}" title="Ingrese número a 10 dígitos" 
                   style="border-radius: 10px; padding: 10px 15px;"
                   required autocomplete="tel">
            <small class="text-muted">Formato: 10 dígitos</small>
            @error('telefono')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Contraseña -->
          <div class="mb-3">
            <label style="color:#545859; font-weight:500;">{{ __('Contraseña') }}</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password" 
                   placeholder="Escribe tu contraseña" 
                   style="border-radius: 10px; padding: 10px 15px;"
                   required autocomplete="new-password">
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Confirmar Contraseña -->
          <div class="mb-4">
            <label style="color:#545859; font-weight:500;">{{ __('Confirma tu Contraseña') }}</label>
            <input type="password" class="form-control" 
                   id="password-confirm" name="password_confirmation" 
                   placeholder="Vuelve a escribir tu contraseña" 
                   style="border-radius: 10px; padding: 10px 15px;"
                   required autocomplete="new-password">
          </div>

          <!-- Aviso de Privacidad -->
          <div class="form-check mb-4">
            <input type="checkbox" class="form-check-input" id="keepConnected" required>
            <label class="form-check-label" style="color:#545859;">
              He leído y acepto la <a href="https://lerma.gob.mx/ayuntamiento/aviso-de-privacidad/" 
              target="_blank" style="color: #00a9e0; text-decoration: underline;">política de privacidad</a>.
            </label>
          </div>

          <!-- Botón de Registro -->
          <div class="d-grid mb-3">
            <button type="submit" class="btn py-2" 
                    style="border: 2px solid #00a9e0; 
                           background-color: transparent; 
                           color: #00a9e0; 
                           border-radius: 20px;
                           font-weight: 500;
                           transition: all 0.3s;">
              Registrarme
            </button>
          </div>

          <!-- Enlace a Login -->
          <div class="text-center">
            <p style="color:#545859;">¿Ya tienes una cuenta? 
              <a href="/login" style="color: #00a9e0; text-decoration: none;">Inicia sesión</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Validación del formulario
    (function() {
      'use strict';
      var forms = document.querySelectorAll('.needs-validation');
      
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
    })();
  </script>
</body>
@endsection