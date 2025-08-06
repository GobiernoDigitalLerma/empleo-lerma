@extends('layouts.base')

@section('content')
<!--Dashboard-->
<section class="events py-5">
  <div class="container">
    <div class="row justify-content-between">
      <!--username-->
      <div class="col-12">
        <h4 class="ml-4 lerma">Empresa: {{Auth::user()->nombre}}</h4>
      </div>
      <!--menu-->
      <div class="col-12 col-md-4">
        <div class="nav flex-column nav-pills shadow m-4 bg-white" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Cuenta</a>
          <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Datos Empresariales</a>
          <a class="nav-link" id="v-pills-applications-tab" data-toggle="pill" href="#v-pills-applications" role="tab" aria-controls="v-pills-applications" aria-selected="false">Postulados</a>
          <a class="nav-link" id="v-pills-vacancies-tab" data-toggle="pill" href="#v-pills-vacancies" role="tab" aria-controls="v-pills-vacancies" aria-selected="false">Vacantes</a>
        </div>
      </div>
      <div class="col-12 col-md-8">
        <div class="tab-content m-4" id="v-pills-tabContent">
          <!--home-->
          <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
            <div class="row">
              <div class="col-12 col-md-6">
                <div class="card">
                  <div class="card-header bg-white">
                    <h4 class="text-center font-weight-bold">Datos de Contacto</h4>
                  </div>
                  <div class="card-body">
                    <ul class="list-group">
                      <li class="list-group-item"><small>Telefono:</small> <span>{{Auth::user()->telefono}}</span></li>
                      <li class="list-group-item"><small>Email:</small> <span>{{Auth::user()->email}}</span></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="card">
                  <div class="card-header bg-white">
                    <h4 class="text-center font-weight-bold">Resumen</h4>
                  </div>
                  <div class="card-body">
                    <ul class="list-group">
                      <li class="list-group-item"><small>Vacantes Publicadas:</small> <span>@if($empresa) {{$contadorp}} @else 0 @endif</span></li>
                      <li class="list-group-item"><small>Postulaciones Recibidas:</small> <span>@if($empresa) {{$contadorc}} @else 0 @endif</span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header bg-white">
                <h4 class="text-center font-weight-bold">Postulaciones Recientes</h4>
              </div>
              <div class="card-body">
                <div class="card-content">
                  <ul class="list-unstyled">
                    @empty($postulantes)
                    <h4 class="text-center">Nadie se ha postulado aún.</h4>
                    @else
                    @foreach($postulantes as $postulacion)
                    <div class="media mb-4">
                      <div style="height: 100px; width: 100px; 
                            background: url('archivo/{{$postulacion->foto_perfil}}') no-repeat center center; 
                            -webkit-background-size: contain;
                            -moz-background-size: contain;
                            -o-background-size: contain;
                            background-size: contain;" class="mr-3 shadow" alt="{{$postulacion->foto_perfil}}" title="{{$postulacion->foto_perfil}}"></div>
                      <div class="media-body">
                        <dl class="row">
                          <dd class="col-sm-3">Nombre</dd>
                          <dt class="col-sm-9">{{$postulacion->nombre_completo}}
                            @if(isset($postulacion->was_contacted) && $postulacion->was_contacted == 1)
                            <small class="float-right bg-info text-white px-2">contactado</small>
                          </dt>
                          @endif
                          <dd class="col-sm-3">Vacante</dd>
                          <dt class="col-sm-9"><u>
                              <a href="{{ route('vacante', $postulacion->slug) }}">
                                {{$postulacion->titulo_puesto}}
                              </a></u>
                          </dt>
                          <dd class="col-sm-3">Salario</dd>
                          <dt class="col-sm-9">$ {{$postulacion->salario_mensual}}</dt>
                          <dd class="col-sm-3">Lugar</dd>
                          <dt class="col-sm-9">{{$postulacion->lugar_vacante}}</dt>
                        </dl>
                        <div class="form-row">
                          <a class="btn btn-secondary btn-sm mr-2 ml-4" href="{{ route('cvuserpdf', $postulacion->nombre_completo) }}" target="_blank">Descargar CV</a>
                          <form method="POST" action="{{route('contacto')}}" class="postulate-form">
                            @csrf
                            <input type="hidden" name="email" value="{{$postulacion->email}}">
                            <input type="hidden" name="nomemp" value="{{Auth::user()->nombre}}">
                            <input type="hidden" name="postulacion" value="{{$postulacion->id_postulacion}}">
                            <button type="submit" class="btn btn-primary btn-sm">Contactar Postulante</button>
                          </form>
                        </div>
                      </div>
                    </div>
                    <hr>
                    @endforeach
                    @endempty
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!--profile-->
          <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
            <div class="card">
              <div class="card-header bg-white">
                <h3 class="text-center font-weight-bold">Datos Empresariales</h3>
              </div>
              @if($empresa)
              <div class="card-body pt-0">
                <div class="container">
                  <!-- Nav tabs -->
                  <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#verdatos">Ver Datos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#modificardatos">Editar Datos</a>
                    </li>
                  </ul>
                  <hr class="mt-0">
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div id="verdatos" class="container tab-pane active"><br>
                      <!-- form profile -->
                      <div class="form-row data-form">
                        <div class="col-md-12 tex-center">
                          <label for="photoUser">Foto de Perfil*</label><br>
                          <div style="height: 130px; width: 130px; border-radius:50%; margin:auto; 
                                      background: url('{{asset('archivo/'.$empresa->foto_perfil)}}') no-repeat center center; 
                                      -webkit-background-size: contain;
                                      -moz-background-size: contain;
                                      -o-background-size: contain;
                                      background-size: contain;" alt="{{$empresa->foto_perfil}}"></div>
                        </div>
                        <hr class="mt-0" />
                        <div class="form-group col-md-8">
                          <label for="userName">Nombre o Razón Social*</label>
                          <input type="text" readonly class="form-control" name="companyName" placeholder="Nombre o Razón Social" value="{{$empresa->nombre_RS}}" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="userName">RFC*</label>
                          <input type="text" readonly class="form-control" name="CompanyRFC" placeholder="RFC" value="{{$empresa->RFC}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="stateUser">Estado*</label>
                          <input type="text" readonly class="form-control" name="stateCompany" placeholder="Estado" value="{{$empresa->estado}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="cityUser">Municipio*</label>
                          <input type="text" readonly class="form-control" name="cityCompany" placeholder="Municipio" value="{{$empresa->municipio}}" required>
                        </div>
                        <div class="form-group col-md-8">
                          <label for="villageUser">Colonia*</label>
                          <input type="text" readonly class="form-control" name="coloniaCompany" placeholder="Colonia" value="{{$empresa->colonia}}" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="cpUser">Código Postal*</label>
                          <input type="number" readonly class="form-control" name="cpCompany" placeholder="Código Postal" value="{{$empresa->CP}}" required>
                        </div>
                        <div class="form-group col-md-8">
                          <label for="villageUser">Calle*</label>
                          <input type="text" readonly class="form-control" name="calleCompany" placeholder="Calle" value="{{$empresa->calle}}" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="villageUser">Número*</label>
                          <input type="text" readonly class="form-control" name="numeroCompany" placeholder="Número" value="{{$empresa->numero}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="phoneUser">Teléfono 1*</label>
                          <input type="number" readonly class="form-control" name="phoneUser1" placeholder="Teléfono 1" value="{{$empresa->tel1}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="phoneUser">Teléfono 2</label>
                          <input type="number" readonly class="form-control" name="phoneUser2" placeholder="Teléfono 2" value="{{$empresa->tel2}}">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="email">Correo Electrónico*</label>
                          <input type="text" readonly class="form-control" name="emailCompany" placeholder="Correo Electrónico" value="{{$empresa->email}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="pagElectronica">Página Electrónica*</label>
                          <input type="text" readonly class="form-control" name="pagElectronica" placeholder="Página Electrónica" value="{{$empresa->pagina_electronica}}" required>
                        </div>
                        <div class="form-group col-md-8">
                          <label for="acteco">Actividad Económica*</label>
                          <input type="text" readonly class="form-control" name="acteco" placeholder="Actividad Económica" value="{{$empresa->actividad_economica}}" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="numemple">Número de Empleados*</label>
                          <input type="text" readonly class="form-control" name="numemple" placeholder="Número de Empleados" value="{{$empresa->numero_empleados}}" required>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="ComoSeEnt">¿Cómo Se Entero De La "Bolsa de Trabajo Para el Municipio de Lerma"?*</label>
                          <input type="text" readonly class="form-control" name="ComoSeEnt" placeholder="¿Cómo Se Entero De La Bolsa de Trabajo Para el Municipio de Lerma?" value="{{$empresa->ComoSeEnt}}" required>
                        </div>
                      </div>
                    </div>
                    <div id="modificardatos" class="container tab-pane fade"><br>
                      <!-- form profile -->
                      {{Form::open(['route' => 'modificardatosemp','files' => true, 'class' => 'data-form'])}}
                      @csrf
                      <input type="hidden" name='actual' value="{{$empresa->foto_perfil}}">
                      <div class="form-row">
                        <div class="form-row" align="center">
                          <div class="form-group col-md-6">
                            <label for="photoUser" class="font-weight-bold">Foto Actual</label><br>
                            <div style="height: 130px; width: 130px; border-radius:50%; 
                                          background: url('{{asset('archivo/'.$empresa->foto_perfil)}}') no-repeat center center; 
                                          -webkit-background-size: contain;
                                          -moz-background-size: contain;
                                          -o-background-size: contain;
                                          background-size: contain;" alt="{{$empresa->foto_perfil}}"></div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="photoUser" class="font-weight-bold">Foto Nueva</label><br>
                            <input type="file" name="photoCompany" id="photoCompany" accept=".jpg,.jpeg,.png" title="Solo imagenes con extensión: jpg, jpeg, png">
                          </div>
                        </div>
                        <hr />
                        <div class="form-group col-md-8">
                          <label for="userName">Nombre o Razón Social*</label>
                          <input type="text" class="form-control" id="companyName" name="companyName" placeholder="Nombre o Razón Social" value="{{$empresa->nombre_RS}}" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="userName">RFC*</label>
                          <input type="text" class="form-control" id="CompanyRFC" name="CompanyRFC" placeholder="RFC" pattern="([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))((-)?([A-Z\d]{3}))" title="Ingrese un RFC valido." value="{{$empresa->RFC}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="stateUser">Estado*</label>
                          <select name="entfed" id="entfed" class="form-control" required>
                            @foreach ($ents as $ent)
                            @if($ent->EntFed == $empresa->estado)
                            <option value='{{ $ent->EntFed }}' selected> {{ $ent->EntFed }}</option>
                            @else
                            <option value='{{ $ent->EntFed }}'> {{ $ent->EntFed }}</option>
                            @endif
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="cityUser">Municipio*</label>
                          <select name="municipio" id="municipio" class="form-control" required>
                            @foreach ($municipios as $municipio)
                            @if($municipio->Municipio == $empresa->municipio)
                            <option value='{{ $municipio->Municipio }}' selected> {{ $municipio->Municipio }}</option>
                            @else
                            <option value='{{ $municipio->Municipio }}'> {{ $municipio->Municipio }}</option>
                            @endif
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-8">
                          <label for="villageUser">Colonia*</label>
                          <input type="text" class="form-control" id="coloniaCompany" name="coloniaCompany" placeholder="Colonia" value="{{$empresa->colonia}}" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="cpUser">Código Postal*</label>
                          <input type="text" class="form-control" id="cpCompany" name="cpCompany" placeholder="Código Postal" value="{{$empresa->CP}}" pattern="[0-9]{5}" title="Ingrese Código Postal a 5 digitos" required>
                        </div>
                        <div class="form-group col-md-8">
                          <label for="villageUser">Calle*</label>
                          <input type="text" class="form-control" id="calleCompany" name="calleCompany" placeholder="Calle" value="{{$empresa->calle}}" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="villageUser">Número*</label>
                          <input type="text" class="form-control" id="numeroCompany" name="numeroCompany" placeholder="Número" value="{{$empresa->numero}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="phoneUser">Teléfono 1*</label>
                          <input type="tel" class="form-control" id="phoneUser1" name="phoneUser1" placeholder="Teléfono 1" value="{{$empresa->tel1}}" pattern="[a-z0-9]{10,18}" title="Ingrese número a 10 dígitos" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="phoneUser">Teléfono 2</label>
                          <input type="tel" class="form-control" id="phoneUser2" name="phoneUser2" placeholder="Teléfono 2" value="{{$empresa->tel2}}" pattern="[a-z0-9]{10,18}" title="Ingrese número a 10 dígitos" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="email">Correo Electrónico*</label>
                          <input type="email" class="form-control" id="emailCompany" name="emailCompany" placeholder="Correo Electrónico" value="{{$empresa->email}}" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="pagElectronica">Página Electrónica*</label>
                          <input type="text" class="form-control" id="pagElectronica" name="pagElectronica" placeholder="Página Electrónica" value="{{$empresa->pagina_electronica}}" required>
                        </div>
                        <div class="form-group col-md-8">
                          <label for="acteco">Actividad Económica*</label>
                          <input type="text" class="form-control" id="acteco" name="acteco" placeholder="Actividad Económica" value="{{$empresa->actividad_economica}}" required>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="numemple">Número de Empleados*</label>
                          <input type="number" class="form-control" id="numemple" name="numemple" placeholder="Número de Empleados" value="{{$empresa->numero_empleados}}" required>
                        </div>
                        <div class="form-group col-md-12">
                          <label for="ComoSeEnt">¿Cómo Se Entero De La "Bolsa de Trabajo Para el Municipio de Lerma"?*</label>
                          <input type="text" class="form-control" id="ComoSeEnt" name="ComoSeEnt" placeholder="¿Cómo Se Entero De La Bolsa de Trabajo Para el Municipio de Lerma?" value="{{$empresa->ComoSeEnt}}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              @else
              <div class="card-body">
                <!-- form profile -->
                {{Form::open(['route' => 'guardardatosemp','files' => true, 'class' => 'data-form'])}}
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="photoUser">Foto de Perfil*</label><br>
                    <input type="file" name="photoCompany" id="photoCompany" accept=".jpg,.jpeg,.png" title="Solo imagenes con extensión: jpg, jpeg, png" required>
                  </div>
                  <hr />
                  <div class="form-group col-md-8">
                    <label for="userName">Nombre o Razón Social*</label>
                    <input type="text" class="form-control" id="companyName" name="companyName" value="{{old('companyName',Auth::user()->nombre)}}" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="userName">RFC*</label>
                    <input type="text" class="form-control" id="CompanyRFC" name="CompanyRFC" pattern="([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1]))((-)?([A-Z\d]{3}))" title="Ingrese un RFC valido." required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="entfed">Estado*</label>
                    <select name="entfed" id="entfed" class="form-control" required>
                      <option disabled>Selecciona</option>
                      @foreach ($ents as $ent)
                      <option value='{{ $ent->EntFed }}'> {{ $ent->EntFed }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="cityUser">Municipio*</label>
                    <select name="municipio" id="municipio" class="form-control" required>
                      @foreach ($municipios as $municipio)
                      <option value='{{ $municipio->Municipio }}'> {{ $municipio->Municipio }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="villageUser">Colonia*</label>
                    <input type="text" class="form-control" id="coloniaCompany" name="coloniaCompany" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="cpUser">Código Postal*</label>
                    <input type="text" class="form-control" id="cpCompany" name="cpCompany" pattern="[0-9]{5}" title="Ingrese Código Postal a 5 digitos" required>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="villageUser">Calle*</label>
                    <input type="text" class="form-control" id="calleCompany" name="calleCompany" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="villageUser">Número*</label>
                    <input type="text" class="form-control" id="numeroCompany" name="numeroCompany" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="phoneUser">Teléfono 1*</label>
                    <input type="tel" class="form-control" id="phoneUser1" name="phoneUser1" pattern="[0-9]{10}" title="Ingrese número a 10 dígitos" value="{{old('phoneUser1',Auth::user()->telefono)}}" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="phoneUser">Teléfono 2</label>
                    <input type="tel" class="form-control" id="phoneUser2" name="phoneUser2" pattern="[0-9]{10}" title="Ingrese número a 10 dígitos">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email">Correo Electrónico*</label>
                    <input type="email" class="form-control" id="emailCompany" name="emailCompany" value="{{old('emailCompany',Auth::user()->email)}}" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="pagElectronica">Página Electrónica*</label>
                    <input type="text" class="form-control" id="pagElectronica" name="pagElectronica" required>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="acteco">Actividad Económica*</label>
                    <input type="text" class="form-control" id="acteco" name="acteco" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="numemple">Número de Empleados*</label>
                    <input type="number" class="form-control" id="numemple" name="numemple" required>
                  </div>
                  <div class="form-group col-md-12">
                    <label for="ComoSeEnt">¿Cómo Se Entero De La "Bolsa de Trabajo Para el Municipio de Lerma"?*</label>
                    <input type="text" class="form-control" id="ComoSeEnt" name="ComoSeEnt" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
              </div>
              @endif
            </div>
          </div>
          <!--applications-->
          <div class="tab-pane fade" id="v-pills-applications" role="tabpanel" aria-labelledby="v-pills-applications-tab">
            <div class="card">
              <div class="card-header bg-white">
                <h3 class="text-center font-weight-bold">Postulaciones</h3>
              </div>
              <div class="card-body">
                <div class="card-content">
                  <ul class="list-unstyled">
                    @empty($postulantes)
                    <h4 class="text-center">Nadie se ha postulado aún.</h4>
                    @else
                    @foreach($postulants as $postulacion)
                    <div class="media mb-4">
                      <div style="height: 100px; width: 100px; 
                            background: url('archivo/{{$postulacion->foto_perfil}}') no-repeat center center; 
                            -webkit-background-size: contain;
                            -moz-background-size: contain;
                            -o-background-size: contain;
                            background-size: contain;" class="mr-3 shadow" alt="{{$postulacion->foto_perfil}}" title="{{$postulacion->foto_perfil}}"></div>
                      <div class="media-body">
                        <dl class="row">
                          <dd class="col-sm-3">Nombre</dd>
                          <dt class="col-sm-9">{{$postulacion->nombre_completo}}
                            @if(isset($postulacion->was_contacted) && $postulacion->was_contacted == 1)
                            <small class="float-right bg-info text-white px-2">contactado</small>
                          </dt>
                          @endif
                          <dd class="col-sm-3">Vacante</dd>
                          <dt class="col-sm-9"><u>
                              <a href="{{ route('vacante', $postulacion->slug) }}">
                                {{$postulacion->titulo_puesto}}
                              </a></u>
                          </dt>
                          <dd class="col-sm-3">Salario</dd>
                          <dt class="col-sm-9">$ {{$postulacion->salario_mensual}}</dt>
                          <dd class="col-sm-3">Lugar</dd>
                          <dt class="col-sm-9">{{$postulacion->lugar_vacante}}</dt>
                        </dl>
                        <div class="form-row">
                          <a class="btn btn-secondary btn-sm mr-2 ml-4" href="{{ route('cvuserpdf', $postulacion->nombre_completo) }}" target="_blank">Descargar CV</a>
                          <form method="POST" action="{{route('contacto')}}" class="postulate-form">
                            @csrf
                            <input type="hidden" name="email" value="{{$postulacion->email}}">
                            <input type="hidden" name="nomemp" value="{{Auth::user()->nombre}}">
                            <input type="hidden" name="postulacion" value="{{$postulacion->id_postulacion}}">
                            <button type="submit" class="btn btn-primary btn-sm">Contactar Postulante</button>
                          </form>
                        </div>
                      </div>
                    </div>
                    <hr>
                    @endforeach
                    @endempty
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- Vacancies -->
          <div class="tab-pane fade" id="v-pills-vacancies" role="tabpanel" aria-labelledby="v-pills-vacancies-tab">
  <div class="card">
    <div class="card-header bg-white">
      <h3 class="text-center font-weight-bold">Vacantes</h3>
    </div>

    @if($empresa)
      @if($empresa->is_active)
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalVacancie">
          Nueva Vacante
        </button>
        
        <ul class="list-group mt-4 mx-3">
        @foreach($empresa->vacantes->where('is_covered', 0) as $vacante)
    <li class="list-group-item d-flex justify-content-between align-items-center">
      <div>
        <strong>{{ $vacante->titulo_puesto }}</strong><br>
        <small>Publicado el: {{ $vacante->created_at->format('d/m/Y') }}</small>
      </div>
      <div class="btn-group">
        <a href="{{ route('vacante', ['slug' => $vacante->slug]) }}" class="btn btn-sm btn-outline-primary">
          Ver
        </a>
        <form action="{{ route('vacante.cubrir', $vacante->id_vacante) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que esta vacante ya fue cubierta?')">
  @csrf
  @method('PATCH')
  <button type="submit" class="btn btn-sm btn-outline-danger ml-2">Vacante cubierta</button>
</form>
      </div>
    </li>
  @endforeach
</ul>
      @else
        <!-- Empresa inactiva -->
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalVacancie" disabled>
          Nueva Vacante
        </button>
        <p class="text-center font-weight-light text-secondary mt-3">
          Ya haz llenado tu perfil!<br>
          En breve <strong>Empleo Lerma</strong> se comunicará contigo para verificar los datos y puedas publicar vacantes.
        </p>
      @endif
    @else
      <!-- Empresa no tiene datos -->
      <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalVacancie" disabled>
        Nueva Vacante
      </button>
      <p class="text-center font-weight-light text-secondary mt-3">
        Aún no puedes publicar vacantes, para hacerlo necesitas completar los datos empresariales, <br />
        <strong>Empleo Lerma</strong> verificará la veracidad de los datos para que puedas publicar.
      </p>
    @endif

              <div class="card-body">
                <div class="card-content">
                  <ul class="list-unstyled">
                    @if($empresa)
                    @isset($vacantes)
                    @foreach ($vacantes as $vacante)
                    <div class="media mb-4">
                      <div class="media-body">
                        <h5><small class="float-right txt-info">${{$vacante->salario_mensual}}</small></h5>
                        <h5>{{$vacante->titulo_puesto}}</h5>
                        <p>{{$vacante->descripcion_breve}}</p>
                        <small class="txt-accent"><span>{{$vacante->lugar_vacante}}</span> / <span> {{date('d-m-o h:i a', strtotime($vacante->fecha))}}</span></small>
                      </div>
                      <div class="ml-2">
                        <a href="{{ route('vacante', $vacante->slug) }}" class="btn btn-light mt-4 btn-block btn-sm">ver</a>
                        <a href="{{ route('editarvacante', $vacante->id_vacante) }}" class="btn btn-light btn-block btn-sm">editar</a>
                        <button data-id="{{$vacante->id_vacante}}" class="btn btn-light btn-block btn-sm btn-covered">vacante cubierta</button>
                      </div>
                    </div>
                    <hr>
                    @endforeach
                    {{ $vacantes->appends(request()->query())->links() }}
                    @else
                    <h5 align="center">No hay vacantes para mostrar.</h5>
                    @endisset
                    @else
                    <h5 align="center">No hay vacantes para mostrar.</h5>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
            @if($empresa)
            @if($empresa->is_active)
            <!-- Modal con notificación para iniciar sesión -->
            <div class="modal fade" id="modalVacancie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header bg-info text-white rounded-top">
  <h5 class="modal-title font-weight-bold">Formulario de Nueva Vacante</h5>
  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

                  <div class="modal-body p-0">
                    {{Form::open(['route' => 'guardarvacante', 'class' => 'data-form'])}}
                    @csrf
                    <ul class="nav nav-pills justify-content-center siguiente bg-light" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#datosvacante">Datos de la Vacante</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#requisitos">Requisitos de la Vacante</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#infocontacto">Información de Contacto</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#fechayp">Publicación</a>
                      </li>
                    </ul>
                    <div class="tab-content px-5">
                      <div id="datosvacante" class="container tab-pane active"><br>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <h4 class="font-weight-bold">Datos de la Vacante</h4>
                            <hr />
                          </div>
                          <div class="form-group col-md-12">
                            <label for="title" class="font-weight-bold">Título del puesto: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="description" class="font-weight-bold">Breve Descripción: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="description" name="description" required>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="FuncionActividad" class="font-weight-bold">Funciones y actividades a realizar: <font color="red">*</font></label><br>
                            <input type="text" class="form-control" name="FuncionActividad" required>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="conocimientos" class="font-weight-bold">Conocimientos y habilidades requeridas: <font color="red">*</font></label><br>
                            <input type="text" class="form-control" name="conocimientos" required>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="direccion" class="font-weight-bold">Dirección donde se ubica la vacante: <font color="red">*</font></label><br>
                            <input type="text" class="form-control" name="direccioncompleta" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="tipoempleo" class="font-weight-bold">Tipo de empleo: <font color="red">*</font></label>
                            <select id="TipoEmpleo" name="tipoempleo" class="form-control" required>
                              @foreach ($tiposemp as $tipoemp)
                              <option value='{{ $tipoemp->TipoEmpleo }}'> {{ $tipoemp->TipoEmpleo }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="salario" class="font-weight-bold">Salario mensual ofrecido: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="salario" name="salario" Placeholder="$" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="ubicacion" class="font-weight-bold">Municipio donde de ubica la vacante: <font color="red">*</font></label>
                            <select name="ubicacion" id="ubicacion" class="form-control" required>
                              <option disabled>Selecciona</option>
                              @foreach ($munvacante as $mun)
                              <option value='{{ $mun->Municipio }}'> {{ $mun->Municipio }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="diaslaboral" class="font-weight-bold">Días a laborar: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="DiasLaboral" name="DiasLaboral" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="entrada" class="font-weight-bold">Hora de entrada:</label>
                            <input type="time" class="form-control" id="entrada" name="entrada">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="salida" class="font-weight-bold">Hora de salida:</label>
                            <input type="time" class="form-control" id="salida" name="salida">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="plazas" class="font-weight-bold">Número de plazas: <font color="red">*</font></label>
                            <input type="number" class="form-control" id="NumPlazas" name="NumPlazas" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="vigencia" class="font-weight-bold">Vigencia de la vacante: <font color="red">*</font></label>
                            <input type="date" class="form-control" id="VigenciaVacante" name="VigenciaVacante" required>
                          </div>
                          <hr />
                          <div class="form-group col-md-12">
                            <button type="button" class="btn btn-light btnNext">Siguiente >></button>
                          </div>
                        </div>
                      </div>
                      <div id="requisitos" class="container tab-pane"><br>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <h4 class="font-weight-bold">Requisitos de la Vacante</h4>
                            <hr />
                          </div>
                          <div class="form-group col-md-6">
                            <label for="discapacidad" class="font-weight-bold">¿Acepta personas con discapacidad? <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="discapacidad" value="Si" checked>
                              <label class="form-check-label" for="discapacidad">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="discapacidad" value="No">
                              <label class="form-check-label" for="discapacidad">No</label>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="MenDiscapacidad" class="font-weight-bold">Mencione que discapacidad <font color="red">*</font></label>
                            <input type="text" class="form-control" id="MenDiscapacidad" name="MenDiscapacidad" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="AdultoMayor" class="font-weight-bold">¿Acepta adultos mayores de 55 años? <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="AdultoMayor" required value="Si" checked>
                              <label class="form-check-label" for="AdultoMayor">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="AdultoMayor" value="No">
                              <label class="form-check-label" for="AdultoMayor">No</label>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="CausaVacante" class="font-weight-bold">Causa que origina la vacante <font color="red">*</font></label>
                            <input type="text" class="form-control" id="CausaVacante" name="CausaVacante" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="escolaridad" class="font-weight-bold">Escolaridad: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="escolaridad" name="escolaridad" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="CarreraEspe" class="font-weight-bold">Carrera o Especialidad: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="CarreraEspe" name="CarreraEspe" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="idioma" class="font-weight-bold">Situación Académica: <font color="red">*</font></label>
                            <select name="SituAcademica" class="form-control" required>
                              <option disabled>Seleccione una opción</option>
                              <option value="Estudiante">Estudiante</option>
                              <option value="Diploma o certificado">Diploma o certificado</option>
                              <option value="Trunca">Trunca</option>
                              <option value="Pasante">Pasante</option>
                              <option value="Titulado">Titulado</option>
                              <option value="Ninguna">Ninguna</option>
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="ExpeMin" class="font-weight-bold">Experiencia mínima requerida: <font color="red">*</font></label>
                            <select name="exppuesto" class="form-control" required>
                              @foreach ($exppuestos as $exppuesto)
                              <option value='{{ $exppuesto->ExpPuesto }}'> {{ $exppuesto->ExpPuesto }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="rango" class="font-weight-bold">Rango de edad: <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <p>De</p>
                            </div>
                            <div class="form-check form-check-inline col-md-3">
                              <input type="number" class="form-control" id="EdadMinima" name="EdadMinima" Placeholder="Min." required>
                            </div>
                            <div class="form-check form-check-inline">
                              <p>A</p>
                            </div>
                            <div class="form-check form-check-inline col-md-3">
                              <input type="number" class="form-control" id="EdadMaxima" name="EdadMaxima" Placeholder="Max." required>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="idioma" class="font-weight-bold">Idioma Requerido: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="idioma" name="idioma" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="computacion" class="font-weight-bold">¿Requiere conocimientos en computación? <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="computacion" required value="Si" checked>
                              <label class="form-check-label" for="computacion">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="computacion" value="No">
                              <label class="form-check-label" for="computacion">No</label>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="genero" class="font-weight-bold">Género <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="genero" value="Hombre" checked>
                              <label class="form-check-label" for="genero">Hombre</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="genero" value="Mujer">
                              <label class="form-check-label" for="genero">Mujer</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="genero" value="Indistinto">
                              <label class="form-check-label" for="genero">Indistinto</label>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="RadicarFuera" class="font-weight-bold">¿Requiere disponibilidad para radicar fuera? <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="RadicarFuera" value="Si" checked>
                              <label class="form-check-label" for="RadicarFuera">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="RadicarFuera" value="No">
                              <label class="form-check-label" for="RadicarFuera">No</label>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="DispoViajar" class="font-weight-bold">¿Requiere disponibilidad para viajar? <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="DispoViajar" value="Si" checked>
                              <label class="form-check-label" for="DsipoViajar">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="DispoViajar" value="No">
                              <label class="form-check-label" for="DispoViajar">No</label>
                            </div>
                          </div>
                          <div class="form-group col-md-12">
                            <label for="prestaciones" class="font-weight-bold">Otras prestaciones: </label><br>
                            <input type="text" class="form-control" name="prestaciones">
                          </div>
                          <div class="form-group col-md-12">
                            <label for="observaciones" class="font-weight-bold">Observaciones:</label><br>
                            <input type="text" class="form-control" name="observaciones">
                          </div>
                          <hr />
                          <div class="form-group col-md-12">
                            <button type="button" class="btn btn-light btnPrevious">
                              << Anterior</button>
                                <button type="button" class="btn btn-light btnNext">Siguiente >></button>
                          </div>
                        </div>
                      </div>
                      <div id="infocontacto" class="container tab-pane"><br>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <h4 class="font-weight-bold">Información de Contacto</h4>
                            <hr />
                          </div>
                          <div class="form-group col-md-6">
                            <label for="nameC" class="font-weight-bold">Nombre: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="nameC" name="nameC" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="Cargo" class="font-weight-bold">Cargo: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="Cargo" name="Cargo" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="tel" class="font-weight-bold">Teléfono: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="tel" name="tel" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="email" class="font-weight-bold">Correo Electrónico: <font color="red">*</font></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="contacto" class="font-weight-bold">Medio Preferente contacto: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="contacto" name="contacto" required>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="DiaEntrevista" class="font-weight-bold">Días de entrevista: <font color="red">*</font></label>
                            <input type="text" class="form-control" id="" name="DiaEntrevista">
                          </div>
                          <div class="form-group col-md-12">
                            <label for="rango" class="font-weight-bold">Horario de Entrevista: </label><br>
                            <div class="form-check form-check-inline">
                              <p>De</p>
                            </div>
                            <div class="form-check form-check-inline col-md-5">
                              <input type="time" class="form-control" id="horaentrevistaI" name="HorarioInicial">
                            </div>
                            <div class="form-check form-check-inline">
                              <p>A</p>
                            </div>
                            <div class="form-check form-check-inline col-md-5">
                              <input type="time" class="form-control" id="horaentrevistaF" name="HorarioFinal">
                            </div>
                          </div>
                          <hr />
                          <div class="form-group col-md-12">
                            <button type="button" class="btn btn-light btnPrevious">
                              << Anterior</button>
                                <button type="button" class="btn btn-light btnNext">Siguiente >></button>
                          </div>
                        </div>
                      </div>
                      <div id="fechayp" class="container tab-pane"><br>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <h4 class="font-weight-bold">Publicación</h4>
                            <hr />
                          </div>
                          <div class="form-group col-md-6">
                            <label for="periodico" class="font-weight-bold">Periodico de ofertas <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="periodico" value="Si" checked>
                              <label class="form-check-label" for="periodico">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="periodico" value="No">
                              <label class="form-check-label" for="periodico">No</label>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="PortalEmpleo" class="font-weight-bold">Portal de empleo <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="PortalEmpleo" value="Si" checked>
                              <label class="form-check-label" for="PortalEmpleo">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="PortalEmpleo" value="No">
                              <label class="form-check-label" for="PortalEmpleo">No</label>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="FeriaEmpleo" class="font-weight-bold">Feria del Empleo <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="FeriaEmpleo" value="Si" checked>
                              <label class="form-check-label" for="feria">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="FeriaEmpleo" value="No">
                              <label class="form-check-label" for="FeriaEmpleo">No</label>
                            </div>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="RadioMex" class="font-weight-bold">Radio Mexiquense <font color="red">*</font></label><br>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="RadioMex" value="Si" checked>
                              <label class="form-check-label" for="RadioMex">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="RadioMex" value="No">
                              <label class="form-check-label" for="RadioMex">No</label>
                            </div>
                          </div>
                          <hr />
                          <div class="form-group col-md-12">
                            <button type="button" class="btn btn-light btnPrevious">
                              << Anterior</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Crear Vacante</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Fin Modal -->
            @endif
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('.btnNext').click(function() {
      $('.siguiente .active').parent().next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function() {
      $('.siguiente .active').parent().prev('li').find('a').trigger('click');
    });

    $('#entfed').change(function() {
      var EntFed = $(this).val();
      $.ajax({
        url: 'getMpios',
        type: 'GET',
        data: {
          EntFed: EntFed
        },
        headers: {
          'X-CSRF-Token': '{{ csrf_token() }}',
        },
        success: function(response) {
          var datos = JSON.parse(response);
          var len = response.length;
          $("#municipio").empty();
          for (var i = 0; i < len; i++) {
            // var IdMunicipio = datos[i]['IdMunicipio'];
            var Municipio = datos[i]['Municipio'];
            $("#municipio").append("<option value='" + Municipio + "'>" + Municipio + "</option>");
          }
        }
      });
    });

    $('.postulate-form').submit(function(e) {
      e.preventDefault();
      $('.postulate-form button').text("Contactando...");
      let form = $(this);
      let url = form.attr('action');

      $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.name,
            text: data.success,
            showConfirmButton: false,
            timer: 1500
          });
          $(".postulate-form button").hide();
        }
      });
    });

    $('.btn-covered').click(function(e) {
      const vacancy_id = this.getAttribute("data-id");
      const button = this;
      Swal.fire({
        icon: 'question',
        title: '¿Cubriste la vacante desde Empleo Lerma?',
        showCloseButton: true,
        showDenyButton: true,
        confirmButtonText: 'Si',
        confirmButtonColor: '#e4032b',
        denyButtonText: 'No',
        denyButtonColor: '#6c757d',
        showLoaderOnConfirm: true,
        showLoaderOnDeny: true,
        preConfirm: (login) => {
          return covered_vacancy(login, vacancy_id)
        },
        preDeny:(login) => {
          return covered_vacancy(login, vacancy_id)
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        if (result.isConfirmed || result.isDenied) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: result.value.name,
            text: result.value.success,
            showConfirmButton: false,
            timer: 1500
          });
          //hide register
          button.parentNode.parentNode.remove();
        }
      });
    });
  });

  function covered_vacancy(login, vacancy_id){
    return fetch(`vacante/${vacancy_id}/cubierta/${login}`)
            .then(response => {
              if (!response.ok) {
                throw new Error(response.statusText)
              }
              return response.json()
            })
            .catch(error => {
              Swal.showValidationMessage(
                `Request failed: ${error}`
              )
            })
  }
</script>
@endsection