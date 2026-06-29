<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Autoriza publicación de vacantes sólo a empresas activas y vigentes.
 */
class EnsureCompanyCanPublish
{
    /**
     * Combina vigencia de usuario y estado activo de empresa.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        abort_unless($user?->hasActiveAccess() && $user->company?->isActive(), 403, 'La empresa no puede publicar.');
        return $next($request);
    }
}
