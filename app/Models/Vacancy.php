<?php

namespace App\Models;

use App\Enums\CompanyStatus;
use App\Enums\VacancyStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Vacante publicada por una empresa.
 *
 * Concentra datos públicos de la oferta y relaciones con requisitos, contacto
 * y postulaciones. El scope publicable protege lo que se muestra al público.
 */
class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'title', 'slug', 'short_description', 'functions', 'required_knowledge',
        'full_address', 'municipality', 'state', 'employment_type', 'monthly_salary', 'work_days',
        'start_time', 'end_time', 'open_positions', 'expires_at', 'status', 'is_covered',
        'covered_on_platform', 'published_at', 'approved_at', 'approved_by', 'rejected_at', 'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'status' => VacancyStatus::class,
            'monthly_salary' => 'decimal:2',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'expires_at' => 'datetime',
            'is_covered' => 'boolean',
            'covered_on_platform' => 'boolean',
            'published_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function company() { return $this->belongsTo(Company::class); }
    public function requirement() { return $this->hasOne(VacancyRequirement::class); }
    public function contact() { return $this->hasOne(VacancyContact::class); }
    public function applications() { return $this->hasMany(Application::class); }
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }

    /**
     * Indica si esta vacante individual ya puede consultarse desde el sitio público.
     */
    public function isPubliclyVisible(): bool
    {
        return $this->status === VacancyStatus::Published
            && ! $this->is_covered
            && (is_null($this->expires_at) || $this->expires_at->endOfDay()->isFuture())
            && $this->company?->isActive();
    }

    /**
     * Limita vacantes visibles al público: publicadas, vigentes y no cubiertas.
     */
    public function scopePublicable(Builder $query): Builder
    {
        return $query->where('status', VacancyStatus::Published)
            ->where('is_covered', false)
            ->where(function (Builder $query) {
                $query->whereNull('expires_at')->orWhereDate('expires_at', '>=', today());
            })
            ->whereHas('company', fn (Builder $query) => $query->where('status', CompanyStatus::Active));
    }
}
