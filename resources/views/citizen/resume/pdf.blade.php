<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>CV {{ $profile->full_name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; line-height: 1.5; }
        h1 { font-size: 24px; margin-bottom: 4px; }
        h2 { font-size: 16px; margin-top: 18px; border-bottom: 1px solid #ddd; padding-bottom: 4px; }
        p { margin: 3px 0; }
    </style>
</head>
<body>
{{-- PDF sencillo generado desde datos capturados por el ciudadano. --}}
<h1>{{ $profile->full_name }}</h1>
<p>{{ $profile->phone }} · {{ $profile->municipality }}, {{ $profile->state }}</p>

<h2>Escolaridad</h2>
<p>{{ $profile->education?->education_level }} {{ $profile->education?->career_or_specialty ? '· '.$profile->education?->career_or_specialty : '' }}</p>
<p>{{ $profile->education?->academic_status }}</p>

<h2>Experiencia</h2>
<p><strong>{{ $profile->experience?->job_title }}</strong> {{ $profile->experience?->company_name ? '· '.$profile->experience?->company_name : '' }}</p>
<p>{{ $profile->experience?->functions }}</p>

<h2>Preferencias</h2>
<p>Puesto deseado: {{ $profile->preference?->desired_position }}</p>
<p>Tipo de empleo: {{ $profile->preference?->desired_employment_type }}</p>
<p>Sueldo esperado: {{ $profile->preference?->expected_salary ? '$'.number_format((float) $profile->preference->expected_salary, 2) : 'No definido' }}</p>
</body>
</html>
