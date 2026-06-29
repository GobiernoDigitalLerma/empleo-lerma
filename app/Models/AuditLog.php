<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Bitácora de acciones sensibles del sistema.
 *
 * Guarda usuario, entidad afectada, valores anteriores/nuevos y metadatos de
 * la petición para que administración pueda auditar operación.
 */
class AuditLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'action', 'auditable_type', 'auditable_id', 'ip_address', 'user_agent', 'old_values', 'new_values', 'metadata'];

    protected function casts(): array
    {
        return ['old_values' => 'array', 'new_values' => 'array', 'metadata' => 'array'];
    }

    /**
     * Usuario que ejecutó la acción, si había sesión iniciada.
     */
    public function user() { return $this->belongsTo(User::class); }

    /**
     * Entidad afectada usando relación polimórfica.
     */
    public function auditable() { return $this->morphTo(); }
}
