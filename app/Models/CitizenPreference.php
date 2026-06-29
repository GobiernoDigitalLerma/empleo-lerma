<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Preferencias laborales usadas para recomendaciones y filtros.
 */
class CitizenPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'citizen_profile_id', 'desired_position', 'occupation', 'desired_employment_type',
        'expected_salary', 'experience_level', 'available_to_travel', 'available_to_relocate',
        'preferred_municipality', 'preferred_state',
    ];

    protected function casts(): array
    {
        return ['expected_salary' => 'decimal:2', 'available_to_travel' => 'boolean', 'available_to_relocate' => 'boolean'];
    }

    /**
     * Perfil ciudadano al que pertenecen las preferencias.
     */
    public function citizenProfile() { return $this->belongsTo(CitizenProfile::class); }
}
