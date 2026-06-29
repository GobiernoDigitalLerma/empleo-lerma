<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Registro histórico de cambios de estado de una postulación.
 *
 * No usa updated_at porque cada fila representa un evento inmutable.
 */
class ApplicationStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'application_status_history';

    public $timestamps = false;

    protected $fillable = ['application_id', 'from_status', 'to_status', 'changed_by', 'notes', 'created_at'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    /**
     * Postulación a la que pertenece el cambio.
     */
    public function application() { return $this->belongsTo(Application::class); }

    /**
     * Usuario que realizó el cambio, cuando aplica.
     */
    public function changedBy() { return $this->belongsTo(User::class, 'changed_by'); }
}
