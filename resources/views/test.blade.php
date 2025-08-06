@extends('layouts.base')

@section('content')
<div class="container my-md-5 info-section">
    <div class="text-center">
        <h1 class="text-center" style="color:#545859; font-size: 40px;" >Evaluación</h1 >
    </div>
    <p class="text-center">
    Los test psicométricos se diseñan para evaluar características psicológicas, como aspectos de la personalidad, inteligencia, aptitudes y habilidades, incluyendo rasgos de carácter, capacidades cognitivas y habilidades específicas. Estos tests facilitan la toma de decisiones al proporcionar información objetiva que puede ser útil en la selección de personal, la orientación profesional y el desarrollo personal. Además, ayudan a identificar fortalezas y áreas de mejora, permitiendo a las personas entender sus habilidades y en qué aspectos pueden necesitar desarrollo.
    </p>
</div>
  
<div class="container ">
    <div class="row mb-4 ">
        <div class="col-md-6 mb-4 " style="border-left: 5px solid #fe5000;">
            <div class="card text-center">
                <div class="card-header ">
                    <h5 class="card-title ">Test de Aptitud</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('guardarTestAptitud') }}">
                        @csrf
                <div class="form-group">
                <label for="pregunta1">1. ¿Cuál es tu habilidad más destacada?</label>
                <input type="text" class="form-control" id="habilidad_mas_destacada" name="habilidad_mas_destacada" required>
              </div>
              <div class="form-group">
                <label for="pregunta2">2. ¿Qué te motiva a trabajar?</label>
                <input type="text" class="form-control" id="motivacion_trabajo" name="motivacion_trabajo" required>
              </div>
              <div class="form-group">
                <label for="pregunta3">3. ¿Cómo manejas el estrés en el trabajo?</label>
                <input type="text" class="form-control" id="manejo_estres" name="manejo_estres" required>
              </div>
              <div class="form-group">
                <label for="pregunta4">4. ¿Cuál es tu mayor logro profesional?</label>
                <input type="text" class="form-control" id="mayor_logro_profesional" name="mayor_logro_profesional" required>
              </div>
              <div class="form-group">
                <label for="pregunta5">5. ¿Cómo prefieres trabajar en equipo?</label>
                <input type="text" class="form-control" id="trabajo_equipo" name="trabajo_equipo" required>
              </div>
              <div class="form-group">
                <label for="pregunta6">6. ¿Qué habilidades te gustaría mejorar?
                Puedes mencionar aquellas que te ayuden a ser más efectivo en tu trabajo o en tu vida personal.
                </label>
                <input type="text" class="form-control" id="habilidades_mejorar" name="habilidades_mejorar" required>
              </div>
             
                        <button type="submit" class="btn " style="border: 2px solid #fe5000; background-color: transparent; color: #fe5000; border-radius: 15px !important; padding: 10px 20px; transition: 0.3s;"  >Guardar Test</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4 " style="border-left: 5px solid #e40046;">
            <div class="card text-center">
        <div class="card-header ">
                    <h5 class="card-title ">Test de Personalidad</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('guardarTestPersonalidad') }}">
                        @csrf
                        <div class="form-group">
                <label for="pregunta1">1. ¿Cómo te describirías en tres palabras?</label>
                <input type="text" class="form-control" id="pregunta1" name="pregunta1" required>
              </div>
              <div class="form-group">
                <label for="pregunta2">2. ¿Qué te hace sentir más satisfecho en tu vida?</label>
                <input type="text" class="form-control" id="pregunta2" name="pregunta2" required>
              </div>
              <div class="form-group">
                <label for="pregunta3">3. ¿Cómo sueles tomar decisiones importantes?</label>
                <input type="text" class="form-control" id="pregunta3" name="pregunta3" required>
              </div>
              <div class="form-group">
                <label for="pregunta4">4. ¿Cómo te relacionas con personas que tienen opiniones diferentes a las tuyas?</label>
                <input type="text" class="form-control" id="pregunta4" name="pregunta4" required>
              </div>
              <div class="form-group">
                <label for="pregunta5">5. ¿Qué valoras más en una amistad?</label>
                <input type="text" class="form-control" id="pregunta5" name="pregunta5" required>
              </div>
              <div class="form-group">
                <label for="pregunta6">6. ¿Cómo manejas los conflictos personales?</label>
                <input type="text" class="form-control" id="pregunta6" name="pregunta6" required>
              </div>
             
                        <button type="submit" class="btn"  style="border: 2px solid #e40046; background-color: transparent; color: #e40046; border-radius: 15px !important; padding: 10px 20px; transition: 0.3s;">Guardar Test</button>
                    </form>
                </div>
                </div>
                </div>
                <div class="col-md-6 mb-4 " style="border-left: 5px solid #00b140;">
            <div class="card text-center">
        <div class="card-header ">
                    <h5 class="card-title ">Test de Habilidades</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('guardarTestHabilidades') }}">
                        @csrf
                        <div class="form-group">
                <label for="pregunta1">1. Describe una habilidad que consideras tu punto fuerte.</label>
                <input type="text" class="form-control" id="pregunta1" name="pregunta1" required>
              </div>
              <div class="form-group">
                <label for="pregunta2">2. ¿Qué habilidad te gustaría desarrollar más y por qué?</label>
                <input type="text" class="form-control" id="pregunta2" name="pregunta2" required>
              </div>
              <div class="form-group">
                <label for="pregunta3">3. ¿Cómo has utilizado tus habilidades en tu trabajo o estudios?</label>
                <input type="text" class="form-control" id="pregunta3" name="pregunta3" required>
              </div>
              <div class="form-group">
                <label for="pregunta4">4. ¿Qué habilidades consideras necesarias para el rol que deseas ocupar?</label>
                <input type="text" class="form-control" id="pregunta4" name="pregunta4" required>
              </div>
              <div class="form-group">
                <label for="pregunta5">5. ¿Puedes dar un ejemplo de un desafío que has superado utilizando tus habilidades?</label>
                <input type="text" class="form-control" id="pregunta5" name="pregunta5" required>
              </div>
              <div class="form-group">
                <label for="pregunta6">6. ¿Qué estrategias sigues para mejorar tus habilidades?</label>
                <input type="text" class="form-control" id="pregunta6" name="pregunta6" required>
              </div>
             
                        <button type="submit" class="btn"  style="border: 2px solid #00b140; background-color: transparent; color: #00b140; border-radius: 15px !important; padding: 10px 20px; transition: 0.3s;">Guardar Test</button>
                    </form>
                </div>
                </div>
                </div>
                <div class="col-md-6 mb-4" style="border-left: 5px solid #00a9e0;">
            <div class="card text-center">
        <div class="card-header ">
                    <h5 class="card-title ">Test de Intereses</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('guardarTestIntereses') }}">
                        @csrf
                        <div class="form-group">
                <label for="pregunta1">1. ¿Qué tipo de tareas disfrutas más en tu trabajo o en proyectos personales?</label>
                <input type="text" class="form-control" id="pregunta1" name="pregunta1" required>
              </div>
              <div class="form-group">
                <label for="pregunta2">2. ¿En qué entorno te sientes más cómodo/a y productivo/a?</label>
                <input type="text" class="form-control" id="pregunta2" name="pregunta2" required>
              </div>
              <div class="form-group">
                <label for="pregunta3">3. ¿Qué tipo de actividades prefieres en tu tiempo libre?</label>
                <input type="text" class="form-control" id="pregunta3" name="pregunta3" required>
              </div>
              <div class="form-group">
                <label for="pregunta4">4.¿Cómo prefieres estructurar tu trabajo?</label>
                <input type="text" class="form-control" id="pregunta4" name="pregunta4" required>
              </div>
              <div class="form-group">
                <label for="pregunta5">5. ¿Qué aspecto de un trabajo te resulta más atractivo?</label>
                <input type="text" class="form-control" id="pregunta5" name="pregunta5" required>
              </div>
              <div class="form-group">
                <label for="pregunta6">6. ¿Qué tipo de logros en tu carrera te resultan más satisfactorios?</label>
                <input type="text" class="form-control" id="pregunta6" name="pregunta6" required>
              </div>
              
                        <button type="submit" class="btn" style="border: 2px solid #00a9e0; background-color: transparent; color: #00a9e0; border-radius: 15px !important; padding: 10px 20px; transition: 0.3s;" >Guardar Test</button>
                    </form>
                </div>
                </div>
                </div>  
                <div class="col text-center">
                <a href="{{ route('descargarPDF') }}" id="downloadButton" class="btn btn-primary" style="border: 2px solid #e40046; border-radius: 15px !important; padding: 10px 20px; transition: 0.3s;" disabled>Descargar PDF</a>
                 <a href="javascript:history.back()" class="back-button"
                    style="border: 2px solid #fe5000; background-color: transparent; color: #fe5000; 
                                          border-radius: 10px !important; padding: 10px 20px; transition: 0.3s; 
                                          text-transform: uppercase;"><i class="fas fa-arrow-left"></i> Regresar</a>

</div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('myForm');
        const downloadButton = document.getElementById('downloadButton');

        // Función para verificar si todos los campos están llenos
        function checkFormCompletion() {
            // Obtener todos los campos del formulario
            const inputs = form.querySelectorAll('input');
            let allFilled = true;

            // Verificar si cada campo está lleno
            inputs.forEach(input => {
                if (input.value.trim() === '') {
                    allFilled = false; // Si algún campo está vacío, el formulario no está completo
                }
            });

            // Si todos los campos están completos, habilitar el botón
            downloadButton.disabled = !allFilled;
        }

        // Añadir evento de entrada para verificar cuando el usuario escribe en cualquier campo
        form.addEventListener('input', checkFormCompletion);

        // Llamar a la función al cargar la página para asegurarse de que el botón se actualice correctamente
        checkFormCompletion();
    });
</script>

@endsection

