@extends('layouts.register')

@section('content')
<body style="background-color: #00a9e0;">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100 py-4">
      <div class="col-11 col-sm-8 col-md-6 col-lg-4 bg-white p-4 p-md-5 rounded-3 shadow-sm">
        
        <!-- Logo centrado -->
        <div class="text-center mb-4">
          <a href="{{url('/')}}">
            <img src="{{asset('assets/img/logo_lerma.png')}}" alt="Logo Lerma" class="img-fluid" style="max-width: 50%; height: auto;">
          </a>
        </div>

        <!-- Título del formulario -->
        <h3 class="text-center mb-4" style="color:#545859">Iniciar sesión</h3>

        <form method="POST" action="{{ route('login') }}">
          @csrf
          
          <!-- Campo Email -->
          <div class="form-group mb-3">
            <label style="color:#545859">{{ __('Correo Electrónico:') }}</label>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   name="email" 
                   placeholder="Ingresa tu email" 
                   value="{{ old('email') }}"
                   style="border-radius: 10px; padding: 10px 15px;"
                   required
                   autofocus>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Campo Contraseña -->
          <div class="form-group mb-3">
            <label style="color:#545859">{{ __('Contraseña:') }}</label>
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   name="password" 
                   placeholder="Ingresa tu contraseña"
                   style="border-radius: 10px; padding: 10px 15px;"
                   required>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="text-end mt-2">
              <a href="{{ route('password.request') }}" style="color: #00a9e0; text-decoration: none;">
                {{ __('¿Olvidaste tu Contraseña?') }}
              </a>
            </div>
          </div>

          <!-- Checkbox Recordar -->
          <div class="form-check mb-4">
            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember" style="color:#545859">{{ __('Mantenerme Conectado') }}</label>
          </div>

          <!-- Botón de Inicio -->
          <div class="d-grid mb-3">
            <button type="submit" 
                    class="btn py-2"
                    style="border: 2px solid #00a9e0; 
                           background-color: transparent; 
                           color: #00a9e0; 
                           border-radius: 20px;
                           font-weight: 500;">
              {{ __('Iniciar Sesión') }}
            </button>
          </div>

          <!-- Enlace de Registro -->
          <div class="text-center">
            <p style="color:#545859">{{ __('¿No tienes cuenta?') }} 
              <a href="/register" style="color: #00a9e0; text-decoration: none;">{{ __('Regístrate aquí') }}</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection