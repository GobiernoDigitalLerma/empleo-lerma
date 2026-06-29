<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Bloquea usuarios sin credencial vigente.
 */
class EnsureActiveAccess
{
    /**
     * Permite continuar sólo si el usuario tiene acceso activo.
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless($request->user()?->hasActiveAccess(), 403, 'La credencial no está vigente.');
        return $next($request);
    }
}
