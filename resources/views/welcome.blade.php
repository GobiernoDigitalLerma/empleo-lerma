@extends('layouts.base')

@section('content')
<!-- Search -->
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
                  <h6 class="card-title text-dark fw-semibold">{{ $empresa->nombre_RS }}</h6>
                  @if (!empty($empresa->pagina_electronica))
                    <p class="card-text small mb-1">
                      <a href="{{ Str::startsWith($empresa->pagina_electronica, ['http://', 'https://']) ? $empresa->pagina_electronica : 'https://' . $empresa->pagina_electronica }}" 
                         class="text-decoration-underline text-primary" target="_blank" rel="noopener noreferrer">
                        {{ $empresa->pagina_electronica }}
                      </a>
                    </p>
                  @endif
                  <p class="card-text text-muted small">
                    {{ $empresa->calle }} {{ $empresa->numero }}, {{ $empresa->colonia }}<br>
                    C.P. {{ $empresa->CP }}, {{ $empresa->municipio }}, {{ $empresa->estado }}
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



<section class="events my-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 text-center mb-4">
        <h1 class="display-5 fw-bold custom-title">Oportunidades Laborales Recientes</h1>
        <p class="text-muted">Consulta las vacantes más recientes publicadas por empresas aliadas.</p>
      </div>

      <div class="col-12 col-md-4">
                    <div class="mb-4">
                        <div class="list-group">
                            <li class="list-group-item text-white " style="background-color: #00a9e0; border-radius: 5px !important; ">
                                <h5 class="text-center">Búsquedas Recientes</h5>
                            </li>
                           
                        </div>
                    </div>
                </div>
      <div class="col-12 col-md-8">
        <ul class="list-unstyled">
          @foreach($vacantes as $vacante)
          <li class="mb-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
  <a href="{{ route('vacante', $vacante->slug) }}" 
     class="vacante-card d-flex align-items-center p-4 rounded shadow-lg bg-white text-decoration-none" 
     style="border-left: 10px solid #00a9e0;">
    
    <img src="{{ asset('archivo/'.$vacante->foto_perfil) }}" 
         class="rounded-circle shadow-sm mr-3" 
         style="height: 90px; width: 90px; object-fit: cover;" 
         alt="{{ $vacante->titulo_puesto }}" 
         title="{{ $vacante->titulo_puesto }}">

    <div class="media-body">
      <h5 class="mb-2 d-flex justify-content-between">
        <span class="text-dark font-weight-bold">{{ $vacante->titulo_puesto }}</span>
      </h5>
      <p class="text-muted mb-1">{{ $vacante->descripcion_breve }}</p>
      <small class="text-muted">
        <i class="fas fa-map-marker-alt"></i> {{ $vacante->lugar_vacante }} /
        <i class="far fa-calendar-alt"></i> {{ date('d-m-Y h:i a', strtotime($vacante->fecha)) }}
      </small>
    </div>
  </a>
</li>
 @endforeach
        </ul>
        
      </div>

    </div>
  </div>
</section>
@endsection