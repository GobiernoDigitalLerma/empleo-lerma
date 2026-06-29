<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Registra acciones administrativas sensibles desde controladores admin.
 *
 * Es un trait deliberadamente pequeño para dejar trazabilidad desde el primer
 * incremento del dashboard sin introducir todavía un servicio de auditoría más complejo.
 */
trait RecordsAdminAudit
{
    /**
     * Guarda un registro de auditoría con usuario, entidad y valores relevantes.
     */
    protected function audit(string $action, ?Model $auditable = null, array $oldValues = [], array $newValues = [], array $metadata = []): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'auditable_type' => $auditable?->getMorphClass(),
            'auditable_id' => $auditable?->getKey(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'old_values' => $oldValues ?: null,
            'new_values' => $newValues ?: null,
            'metadata' => $metadata ?: null,
        ]);
    }
}
