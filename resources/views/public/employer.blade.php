@extends('layouts.public')

@section('title', 'Ofrezco empleo | Empleo Lerma')

@section('content')
{{-- Página heredada del legacy: guía a empresas para registrarse y publicar. --}}
<section class="public-flow-page">
    <div class="container">
                <header class="public-flow-header text-center">
                    <h1>Ofrezco Empleo</h1>
                    <p>¡Muchas gracias por usar la aplicación!</p>
                    <p>Si necesitas personal para laborar contigo, puedes publicar y contactar a personas desde esta plataforma.</p>
        </header>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">
                <article>

                    <p>Es muy sencillo, solo necesitas seguir los siguientes pasos:</p>
                </article>

                <article class="public-instruction-card">
                    <h4>Regístrate</h4>
                    <ul class="public-check-list">
                        <li>Selecciona en la opción registrarse.</li>
                        <li>Se mostrará un formulario para tu registro. Selecciona la opción de empresa, posteriormente los datos solicitados y guarda tu contraseña.</li>
                        <li>Recibirás un correo de confirmación de cuenta. Da clic en Confirmar Cuenta o sigue el enlace que aparece en el correo.</li>
                        <li>Te regresará nuevamente a la página principal, posteriormente selecciona Mi cuenta.</li>
                        <li>Completa la información restante con tu perfil empresarial.</li>
                        <li>Empleo Lerma validará tu perfil empresarial.</li>
                        <li>Recibirás un correo de activación de perfil.</li>
                        <li>¡Ahora ya puedes registrar tus vacantes!</li>
                    </ul>
                </article>

                <article class="public-instruction-card">
                    <h4>Publica Vacantes</h4>
                    <ul class="public-check-list">
                        <li>Da clic en la opción de NUEVA VACANTE.</li>
                        <li>Llena todos los campos de la vacante.</li>
                        <li>Cubre los requisitos de la vacante.</li>
                        <li>Ingresa la información del contacto.</li>
                        <li>Selecciona la opción de publicación de periódico de ofertas y portal de Empleo.</li>
                        <li>Una vez finalizado el llenado COMPLETO de las vacantes, selecciona crear vacante.</li>
                        <li>Listo, se visualizará la vacante publicada.</li>
                    </ul>
                </article>

                <div class="text-center">
                    <a href="https://empleo.lerma.gob.mx/archivo/ofrezco_empleo_lerma.pdf" target="_blank" rel="noopener" class="public-tutorial-link">
                        Aquí tienes un tutorial más detallado
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
