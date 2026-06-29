<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bloquea operaciones de empresas no aprobadas o inactivas.
 */
class EnsureCompanyActive
{
    /**
     * Verifica que la empresa asociada al usuario esté activa.
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->company?->isActive(), 403, 'La empresa no está activa.');
        return $next($request);
    }
}
