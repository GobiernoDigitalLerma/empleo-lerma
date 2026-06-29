<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Información académica y habilidades del ciudadano.
 */
class CitizenEducation extends Model
{
    use HasFactory;

    protected $table = 'citizen_education';

    protected $fillable = [
        'citizen_profile_id', 'education_level', 'career_or_specialty', 'academic_status',
        'language', 'language_level', 'computer_skills', 'special_knowledge', 'special_skills', 'courses',
    ];

    /**
     * Perfil ciudadano al que pertenece la escolaridad.
     */
    public function citizenProfile() { return $this->belongsTo(CitizenProfile::class); }
}
