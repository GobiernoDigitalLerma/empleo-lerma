<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Perfil operativo del ciudadano postulante.
 *
 * Se separa de User para mantener autenticación limpia y concentrar datos
 * personales, domicilio, documentos y postulaciones en este modelo.
 */
class CitizenProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'full_name', 'birth_date', 'gender', 'marital_status', 'birth_state', 'curp',
        'phone', 'street', 'external_number', 'internal_number', 'neighborhood', 'postal_code',
        'municipality', 'state', 'has_disability', 'disability_description', 'profile_photo_path',
        'how_did_you_hear', 'completed_at',
    ];

    protected function casts(): array
    {
        return ['birth_date' => 'date', 'has_disability' => 'boolean', 'completed_at' => 'datetime'];
    }

    /**
     * Usuario autenticable dueño del perfil.
     */
    public function user() { return $this->belongsTo(User::class); }

    /**
     * Escolaridad y habilidades capturadas para el CV.
     */
    public function education() { return $this->hasOne(CitizenEducation::class); }

    /**
     * Experiencia profesional capturada para el CV.
     */
    public function experience() { return $this->hasOne(CitizenExperience::class); }

    /**
     * Preferencias usadas para búsqueda y recomendación de vacantes.
     */
    public function preference() { return $this->hasOne(CitizenPreference::class); }

    /**
     * Documentos privados cargados por el ciudadano.
     */
    public function documents() { return $this->hasMany(CitizenDocument::class); }

    /**
     * Postulaciones realizadas por el ciudadano.
     */
    public function applications() { return $this->hasMany(Application::class); }

    /**
     * Define el mínimo requerido para permitir postulación.
     */
    public function hasMinimumProfile(): bool
    {
        return filled($this->full_name) && filled($this->curp) && filled($this->phone) && ! is_null($this->completed_at);
    }
}
