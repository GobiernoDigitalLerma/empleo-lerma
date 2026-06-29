@extends('layouts.public')

@section('title', 'Busco empleo | Empleo Lerma')

@section('content')
{{-- Página heredada del legacy: explica el flujo ciudadano en tres acciones. --}}
<section class="public-flow-page">
    <div class="container">
        <header class="public-flow-header text-center">
            <h1>Encuentra el trabajo que quieres</h1>
            <p>Empleo Lerma te ayuda a crear tu perfil laboral, encontrar vacantes vigentes y postularte con empresas registradas.</p>
        </header>

        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-9">
                <article>
                <p>Para aprovechar la plataforma, sigue estos pasos:</p>
                </article>

                <article class="public-instruction-card">
                    <h4>Regístrate y crea tu CV con nosotros</h4>
                    <ul class="public-check-list">
                        <li>Selecciona la opción registrarse y elige el registro como ciudadano.</li>
                        <li>Captura tus datos personales y conserva tu correo y contraseña para ingresar después.</li>
                        <li>Confirma tu cuenta desde el correo de verificación que recibirás.</li>
                        <li>Ingresa a Mi cuenta y completa tu perfil ciudadano.</li>
                        <li>Agrega escolaridad, experiencia laboral, habilidades y preferencias de empleo.</li>
                        <li>Carga tu CV o genera uno desde la plataforma cuando la opción esté disponible.</li>
                    </ul>
                </article>

                <article class="public-instruction-card">
                    <h4>Descubre vacantes de acuerdo a tus intereses</h4>
                    <ul class="public-check-list">
                        <li>Consulta las vacantes disponibles desde la página principal o desde el menú Vacantes.</li>
                        <li>Usa los filtros de búsqueda por puesto, municipio o tipo de empleo.</li>
                        <li>Revisa el detalle de cada vacante para conocer descripción, ubicación, salario y vigencia.</li>
                        <li>Identifica las oportunidades que coincidan con tu experiencia, disponibilidad y preferencias.</li>
                        <li>Regresa con frecuencia para revisar nuevas publicaciones de empresas activas.</li>
                    </ul>
                </article>

                <article class="public-instruction-card">
                    <h4>Postúlate y conecta con reclutadores</h4>
                    <ul class="public-check-list">
                        <li>Antes de postularte, asegúrate de tener tu perfil completo y tu acceso vigente.</li>
                        <li>Abre la vacante que te interesa y selecciona la opción para postularte.</li>
                        <li>La empresa podrá revisar tu perfil y tu CV autorizado desde su panel.</li>
                        <li>Consulta Mis postulaciones para dar seguimiento al estado de tus aplicaciones.</li>
                        <li>Mantén actualizados tus datos de contacto para que los reclutadores puedan comunicarse contigo.</li>
                    </ul>
                </article>

                <div class="text-center">
                    <a href="{{ route('register', 'citizen') }}" class="public-tutorial-link">Empezar</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
