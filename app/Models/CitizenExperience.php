<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Experiencia laboral declarada por el ciudadano.
 */
class CitizenExperience extends Model
{
    use HasFactory;

    protected $table = 'citizen_experience';

    protected $fillable = [
        'citizen_profile_id', 'currently_working', 'company_name', 'job_title', 'functions',
        'monthly_salary', 'employment_type', 'started_at', 'ended_at', 'job_search_started_at',
        'separation_reason', 'availability',
    ];

    protected function casts(): array
    {
        return ['currently_working' => 'boolean', 'monthly_salary' => 'decimal:2', 'started_at' => 'date', 'ended_at' => 'date', 'job_search_started_at' => 'date'];
    }

    /**
     * Perfil ciudadano al que pertenece la experiencia.
     */
    public function citizenProfile() { return $this->belongsTo(CitizenProfile::class); }
}
