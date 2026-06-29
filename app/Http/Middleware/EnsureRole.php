<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restringe rutas a uno o más roles permitidos.
 */
class EnsureRole
{
    /**
     * Compara el rol del usuario contra los roles declarados en la ruta.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $role = $request->user()?->role?->value;
        abort_unless($role && in_array($role, $roles, true), 403);
        return $next($request);
    }
}
