<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Requisitos laborales y condiciones de una vacante.
 */
class VacancyRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'vacancy_id', 'accepts_disability', 'disability_details', 'accepts_older_adults', 'vacancy_origin',
        'education_level', 'career_or_specialty', 'academic_status', 'minimum_experience', 'minimum_age',
        'maximum_age', 'language', 'computer_skills', 'gender_preference', 'available_to_travel',
        'available_to_relocate', 'benefits', 'observations',
    ];

    protected function casts(): array
    {
        return ['accepts_disability' => 'boolean', 'accepts_older_adults' => 'boolean', 'available_to_travel' => 'boolean', 'available_to_relocate' => 'boolean'];
    }

    /**
     * Vacante a la que pertenecen los requisitos.
     */
    public function vacancy() { return $this->belongsTo(Vacancy::class); }
}
