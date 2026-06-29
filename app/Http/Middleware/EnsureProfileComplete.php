<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Exige perfil ciudadano mínimo antes de postularse.
 */
class EnsureProfileComplete
{
    /**
     * Bloquea el flujo si faltan datos requeridos del ciudadano.
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->citizenProfile?->hasMinimumProfile(), 403, 'El perfil ciudadano no está completo.');
        return $next($request);
    }
}
