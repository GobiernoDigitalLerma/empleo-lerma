<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Empleo Lerma</title>
  <link href="{{asset('assets/img/escudo-de-armas-lerma.png')}}" rel="shortcut icon">
  <meta name="robots" content="index,follow">
  <meta name="description" content="Empleo Lerma">
  <meta name="author" content="LERMA.GOB.MX">
  <meta name="keywords" content="lerma, empleo, municipio">
  <meta name="copyright" content="Copyright 2020 Ayuntamiento de Lerma">
  <link rel="canonical" href="https://empleo.lerma.gob.mx">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://empleo.lerma.gob.mx">
  <meta property="og:title" content="Empleo Lerma">
  <meta property="og:description" content="Empleo Lerma">
  <meta property="og:image" content="https://empleo.lerma.gob.mx/img/logos-lerma.png">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('assets/css/src/style.min.css')}}">
  @laravelPWA
</head>

<body>
  @laravelPWA
  <!--header-->
  <header>
  <div class="social-icons">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light p-0">
        <a href="{{url('/')}}" class="navbar-brand">
          <img src="{{asset('assets/img/logo_lerma.png')}}" alt="lerma" width="120" height="auto">
        </a>
          
        <button style="border-color:white;" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerAccount" aria-controls="navbarTogglerAccount" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-ellipsis-h"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerAccount" target="_blank">
    <ul class="navbar-nav ml-auto">
        @guest
            <li class="nav-item">
                <a href="{{ route('login') }}" class="btn" style="color:#545859"  > Iniciar Sesión </a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="btn" style="color:#545859"> Registrarse </a>
                </li>
            @endif
        @else
            <li class="nav-item ">
                <a class="btn" href="{{ route('micuenta') }}" style="color:#545859"> 
                    @auth {{ Auth::user()->nombre }} @endauth
                </a>
            </li>

            <li class="nav-item">
                <a class="btn " href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:#545859">
                    {{ __('Cerrar Sesión') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
</div>
            <li class="nav-item facebook">
              <a href="https://www.facebook.com/Ayuntamiento-de-Lerma-467953823268730" class="s-i" target="_blank">
              </a>
            </li>
            <li class="nav-item instagram">
              <a href="https://www.instagram.com/lermamex/" class="s-i" target="_blank">
              </a>
            </li>
            <li class="nav-item youtube">
              <a href="https://www.youtube.com/channel/UC8IK9ozLAiYcvIftlzb1NWw" class="s-i" target="_blank">
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  

 <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #00a9e0;">
    <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
        aria-controls="navbarToggler" aria-expanded="false" aria-label="Menu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="/">
              <i class="fas fa-home me-2"></i> Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/busco_empleo">
              <i class="fas fa-search me-2"></i> Busco Empleo
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/ofrezco_empleo">
              <i class="fas fa-briefcase me-2"></i> Ofrezco Empleo
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/eventos">
              <i class="fas fa-calendar-alt me-2"></i> Eventos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/materialapoyo">
              <i class="fa fa-info"></i> Recursos Complementarios
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

</header>
<style>
  @media (max-width: 768px) {
    .form-container {
      left: 50%;
      top: 55%;
      width: 90% !important;
      transform: translate(-50%, -50%);
      padding: 15px;
    }
  }

  .form-container {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
  }

  ::placeholder {
    color: #00a9e0;
    opacity: 0.8;
  }

  .btn:hover {
    background-color: #00a9e0 !important;
    color: white !important;
    transition: all 0.3s ease;
  }
  body {
    font-family: 'Poppins', sans-serif;
  }

  .custom-title {
    color: #333;
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 40px;
  }

  .card:hover {
    transform: scale(1.05);
    transition: all 0.3s ease;
    border-color: #0d6efd;
  }

  .card-title {
    font-size: 1.1rem;
    font-weight: 600;
  }

  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    background-color: #0d6efd;
    border-radius: 50%;
    padding: 10px;
  }

  .carousel-control-prev:hover,
  .carousel-control-next:hover {
    filter: brightness(1.2);
  }
</style>

<section style="position: relative; margin-top: 0;">
  <!-- Imagen de fondo con contenedor responsivo -->
  <div class="hero-image-container" style="height: 400px; overflow: hidden;">
    <img class="d-block w-100 h-100" src="{{ asset('assets/img/bg.jpg') }}" alt="Portal del Empleo Lerma" style="object-fit: cover;">
  </div>
  
  <!-- Formulario con diseño responsivo -->
  <div class="form-container text-center"
    style="position: absolute;
           top: calc(43% + 30px); /* Ajuste para considerar la barra de navegación */
           left: 50%; 
           transform: translate(-50%, -50%); 
           background: rgba(255, 255, 255, 0.9);
           border: 3px solid #00a9e0;
           border-radius: 10px;
           padding: 10px;
           width: 90%;
           max-width: 800px;
           text-align: center;
           box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);">
    
    <h1 class="text-center custom-title" style="font-size: clamp(24px, 5vw, 40px); margin-bottom: 15px; color: #333; font-weight: 600;">Portal del Empleo Lerma</h1>

    <form action="{{ route('buscar') }}" class="row data-form form-search" method="GET">
      <div class="col-12 col-md-6">
        <div class="form-group text-center">
          <label style="color:#545859" for="searchText">¿Qué trabajo buscas?</label>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fa fa-briefcase"></i></div>
            </div>
            <input style="border: 2px solid #00a9e0; background-color: transparent; color: #00a9e0; border-radius: 8px;"
              type="text" class="form-control" id="vacantes" name="titulo_puesto" placeholder="Puesto o Área Deseada">
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="form-group text-center">
          <label style="color:#545859" for="searchCity">¿Dónde?</label>
          <div class="input-group mb-2">
            <div class="input-group-prepend">
              <div class="input-group-text"><i class="fas fa-map-marker-alt"></i></div>
            </div>
            <select style="border: 2px solid #00a9e0; background-color: transparent; color: #00a9e0; border-radius: 8px;"
              class="form-control text-info" id="municipio" name="lugar_vacante">
              <option selected disabled>Municipio</option>
              @foreach ($municipios as $municipio)
                <option value="{{ $municipio->lugar_vacante }}">{{ $municipio->lugar_vacante }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="col-12 text-center mt-2">
        <button style="border: 2px solid #00a9e0; background-color: transparent; color: #00a9e0; border-radius: 15px !important; padding: 8px 15px;"
          type="submit" class="btn btn-lg hover-effect">
          <i class="fa fa-search"></i> Buscar
        </button>
      </div>
    </form>
  </div>
</section>

<style>
  /* Estilos generales */
  ::placeholder {
    color: #00a9e0;
    opacity: 0.8;
  }
  
  .hover-effect:hover {
    background-color: #00a9e0 !important;
    color: white !important;
    transition: all 0.3s ease;
  }
  
  /* Estilos responsivos */
  @media (max-width: 992px) {
    .hero-image-container {
      height: 450px !important;
    }
  }
  
  @media (max-width: 768px) {
    .hero-image-container {
      height: 400px !important;
    }
    
    .form-container {
      top: calc(50% + 40px) !important;
      padding: 15px !important;
      width: 95% !important;
    }
    
    .custom-title {
      font-size: 28px !important;
      margin-bottom: 10px !important;
    }
  }
  
  @media (max-width: 576px) {
    .hero-image-container {
      height: 350px !important;
    }
    
    .form-container {
      top: calc(50% + 50px) !important;
      padding: 10px !important;
    }
    
    .custom-title {
      font-size: 24px !important;
    }
    
    .input-group-text {
      padding: 0.375rem 0.5rem !important;
    }
    
    .btn-lg {
      padding: 6px 12px !important;
      font-size: 14px;
    }
    
    /* Asegurar que el menú desplegable no afecte el espacio */
    .navbar-collapse {
      background-color: #00a9e0;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
    }
  }
</style>
<!--Companies-->
<section>
  
<div class="container my-5">
  <div class="row">
    <div class="col-12 text-center">
      <h1 class="display-5 fw-bold custom-title">Empresas que confían en nuestro talento</h1>
      <p class="text-muted">Conoce algunas de las organizaciones que actualmente cuentan con vacantes disponibles para ti.</p>
    </div>
  </div>

  <div id="companyCarousel" class="carousel slide mt-4" data-bs-ride="carousel" data-bs-interval="4000" data-bs-pause="hover">
    <div class="carousel-inner">
      @php $chunkedEmpresas = $empresas->chunk(4); @endphp
      @foreach ($chunkedEmpresas as $key => $chunk)
      <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
        <div class="row row-cols-1 row-cols-md-4 g-4">
          @foreach ($chunk as $empresa)
          <div class="col">
            <a href="{{ route('register') }}" class="text-decoration-none">
              <div class="card h-100 border-0 shadow-sm rounded-4 text-center">
                <img src="{{ asset('archivo/'.$empresa->foto_perfil) }}" 
                     class="card-img-top mx-auto mt-4"
                     style="height: 120px; width: 120px; object-fit: cover; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.1);" 
                     alt="{{ $empresa->nombre_RS }}" 
                     title="{{ $empresa->nombre_RS }}">
                <div class="card-body bg-light">
  {{-- Nombre de la empresa --}}
  <h6 class="card-title text-dark fw-semibold">{{ $empresa->nombre_RS }}</h6>

  {{-- Página electrónica (si existe) --}}
  @if (!empty($empresa->pagina_electronica))
    <p class="card-text small mb-1">
      <a href="{{ Str::startsWith($empresa->pagina_electronica, ['http://', 'https://']) ? $empresa->pagina_electronica : 'https://' . $empresa->pagina_electronica }}" 
         class="text-decoration-underline text-primary" target="_blank" rel="noopener noreferrer">
        {{ $empresa->pagina_electronica }}
      </a>
    </p>
  @endif

  {{-- Número de vacantes activas --}}
  <p class="card-text text-success fw-semibold mb-1">
    {{ $empresa->vacantes->count() }} vacante{{ $empresa->vacantes->count() === 1 ? '' : 's' }} disponible{{ $empresa->vacantes->count() === 1 ? '' : 's' }}
  </p>

  {{-- Dirección --}}
  <p class="card-text text-muted small">
    {{ $empresa->calle ?? '' }} {{ $empresa->numero ?? '' }}, {{ $empresa->colonia ?? '' }}<br>
    C.P. {{ $empresa->CP ?? '' }}, {{ $empresa->municipio ?? '' }}, {{ $empresa->estado ?? '' }}
  </p>
</div>

              </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
</section>

<!-- Vacantes Recientes -->
<section class="events my-5">
<div class="container">
    <div class="row justify-content-center">
      <div class="col-12 text-center mb-4">
        <h1 class="display-5 fw-bold custom-title">Oportunidades Laborales Recientes</h1>
        <p class="text-muted">Consulta las vacantes más recientes publicadas por empresas aliadas.</p>
      </div>

      <!-- Filtros -->
      @if($recientes)
      <div class="col-12 col-md-4">
        <div class="list-group">
          <li class="list-group-item text-center text-white" style="background-color: #00a9e0; border-radius: 5px !important; ">
            <h5>Búsquedas Recientes</h5>
          </li>
          @foreach ($recientes as $reciente)
          <a href="{{ route('vacante', $reciente->slug) }}" class="list-group-item list-group-item-action bg-light text-center">
            {{ $reciente->nombre_reciente }}
          </a>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Vacantes -->
      <div class="col-12 col-md-8">
        <ul class="list-unstyled">
          @foreach($vacantes as $vacante)
          <a href="{{ route('vacante', $vacante->slug) }}" 
               class="d-flex align-items-center p-4 rounded shadow-sm bg-white text-decoration-none" 
               style="border-left: 10px solid #00a9e0; transition: 0.3s;">
              
              <img src="{{ asset('archivo/'.$vacante->foto_perfil) }}" 
                   class="rounded-circle shadow-sm mr-3" 
                   style="height: 90px; width: 90px; object-fit: cover;" 
                   alt="{{ $vacante->titulo_puesto }}" 
                   title="{{ $vacante->titulo_puesto }}">
            <div class="media-body">
              <h5 class="mb-2 d-flex justify-content-between">
                <span>{{ $vacante->titulo_puesto }}</span>
                <small class="txt-info">$ {{ $vacante->salario_mensual }}</small>
              </h5>
              <p class="text-muted mb-1">{{ $vacante->descripcion_breve }}</p>
              <small class="text-muted">
                <span>{{ $vacante->lugar_vacante }}</span> / 
                <span>{{ date('d-m-Y h:i a', strtotime($vacante->fecha)) }}</span>
              </small>
            </div>
          </a>
          <hr>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>

</section>
@yield('content')
  <!--footer-->
  <footer>
    <div class="container-fluid bg-dark text-light">
      <div class="container">
        <div class="row py-5 justify-content-center">
          <div class="col-4 col-md-1">
            <img src="{{asset('assets/img/lerma-footer.png')}}" alt="" class="img-fluid">
          </div>
          <div class="col-10 col-md-4">
            <h5 class="text-uppercase pb-1">Contáctanos</h5>
            <i class="fas fa-phone fa-xs fa-footer pr-3"></i><a href="tel: 722 706 3143" class="text-light">722 706 3143</a><br>
            <i class="far fa-envelope fa-xs fa-footer pr-3"></i><a href="mailto:empleolerma@gmail.com" class="text-light">empleo.lerma@gmail.com</a><br>
            <i class="fas fa-map-marker-alt fa-xs fa-footer pr-3"></i><a href="#" class="text-light">Palacio Municipal s/n Col. Centro, Lerma, Estado de México</a>
          </div>
          <div class="col-10 col-md-3">
            <h5 class="text-uppercase pb-1">Síguenos</h5>
            <i class="fab fa-facebook fa-xs fa-footer pr-3"></i><a href="https://www.facebook.com/Ayuntamiento-de-Lerma-467953823268730" class="text-light">Facebook</a><br>
            <i class="fab fa-instagram-square fa-xs fa-footer pr-3"></i><a href="https://www.instagram.com/lermamex/" class="text-light">Instagram</a><br>
            <i class="fab fa-youtube fa-xs fa-footer pr-3"></i><a href="https://www.youtube.com/channel/UC8IK9ozLAiYcvIftlzb1NWw" class="text-light">YouTube</a><br>
          </div>
          <div class="col-10 col-md-4">
            <h5 class="text-uppercase pb-1">Enlaces de interes</h5>
            <a href="https://www.lerma.gob.mx/" class="text-light">Ayuntamiento de Lerma</a><br>
            <a href="https://strabajo.edomex.gob.mx" class="text-light">Secretaría del Trabajo del Estado de México</a><br>
            <a href="https://www.gob.mx/stps" class="text-light">Secretaría del Trabajo y Previsión Social</a><br>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid bg-secondary">
      <div class="container">
        <div class="row py-3 justify-content-md-center text-center">
          <div class="col-12 col-md-8 copy">
            <a href="#" class="text-white small text-uppercase pr-4">Derechos reservados 2019</a>
            <a href="http://www.lerma.gob.mx/ayuntamiento/aviso-de-privacidad/" class="text-white small text-uppercase pr-4">Anuncio de privacidad</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/b2d5760d1d.js" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @yield('scripts')
</body>

</html>