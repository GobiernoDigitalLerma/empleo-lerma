<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Datos de contacto e entrevista asociados a una vacante.
 *
 * Esta información es sensible y no debe mostrarse completa en vistas públicas.
 */
class VacancyContact extends Model
{
    use HasFactory;

    protected $fillable = ['vacancy_id', 'contact_name', 'position', 'phone', 'email', 'preferred_contact_method', 'interview_days', 'interview_start_time', 'interview_end_time'];

    protected function casts(): array
    {
        return ['interview_start_time' => 'datetime:H:i', 'interview_end_time' => 'datetime:H:i'];
    }

    /**
     * Vacante propietaria de los datos de contacto.
     */
    public function vacancy() { return $this->belongsTo(Vacancy::class); }
}
