<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Servicio centralizado para crear registros de auditoría.
 */
class AuditService
{
    /**
     * Guarda quién hizo qué, sobre qué entidad y desde qué petición.
     */
    public function log(string $action, ?Model $auditable = null, array $oldValues = [], array $newValues = [], array $metadata = [], ?Request $request = null): AuditLog
    {
        $request ??= request();

        return AuditLog::create([
            'user_id' => $request->user()?->id,
            'action' => $action,
            'auditable_type' => $auditable?->getMorphClass(),
            'auditable_id' => $auditable?->getKey(),
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 2000),
            'old_values' => $oldValues ?: null,
            'new_values' => $newValues ?: null,
            'metadata' => $metadata ?: null,
        ]);
    }
}
