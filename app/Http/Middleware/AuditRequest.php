<?php

namespace App\Http\Middleware;

use App\Services\AuditService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Registra acciones de escritura para trazabilidad administrativa.
 */
class AuditRequest
{
    public function __construct(private AuditService $audit) {}

    /**
     * Audita peticiones que modifican datos después de procesarlas.
     */
    public function handle(Request $request, Closure $next, ?string $action = null): Response
    {
        $response = $next($request);

        if ($request->user() && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            $this->audit->log($action ?: 'request.'.$request->route()?->getName(), null, [], [], [
                'method' => $request->method(),
                'path' => $request->path(),
            ], $request);
        }

        return $response;
    }
}
