<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Postulación de un ciudadano a una vacante.
 *
 * Une ciudadano, empresa y vacante; su estado se audita en
 * ApplicationStatusHistory para conservar trazabilidad del proceso.
 */
class Application extends Model
{
    use HasFactory;

    protected $fillable = ['vacancy_id', 'company_id', 'citizen_profile_id', 'status', 'cover_message', 'was_contacted', 'contacted_at', 'submitted_at'];

    protected function casts(): array
    {
        return ['status' => ApplicationStatus::class, 'was_contacted' => 'boolean', 'contacted_at' => 'datetime', 'submitted_at' => 'datetime'];
    }

    /**
     * Vacante a la que se postuló el ciudadano.
     */
    public function vacancy() { return $this->belongsTo(Vacancy::class); }

    /**
     * Empresa dueña de la vacante; se guarda para consultas rápidas.
     */
    public function company() { return $this->belongsTo(Company::class); }

    /**
     * Perfil ciudadano que realizó la postulación.
     */
    public function citizenProfile() { return $this->belongsTo(CitizenProfile::class); }

    /**
     * Historial de cambios de estado de la postulación.
     */
    public function statusHistory() { return $this->hasMany(ApplicationStatusHistory::class); }
}
