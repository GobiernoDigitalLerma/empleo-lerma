<?php

namespace App\Models;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Documento privado asociado al perfil ciudadano.
 *
 * Guarda metadatos del archivo y la ruta en storage privado; el archivo no
 * debe exponerse directamente desde public/.
 */
class CitizenDocument extends Model
{
    use HasFactory;

    protected $fillable = ['citizen_profile_id', 'type', 'original_name', 'path', 'mime_type', 'size', 'is_current', 'uploaded_at'];

    protected function casts(): array
    {
        return ['type' => DocumentType::class, 'is_current' => 'boolean', 'uploaded_at' => 'datetime'];
    }

    /**
     * Perfil ciudadano propietario del documento.
     */
    public function citizenProfile() { return $this->belongsTo(CitizenProfile::class); }
}
