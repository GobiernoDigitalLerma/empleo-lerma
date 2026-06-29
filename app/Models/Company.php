<?php

namespace App\Models;

use App\Enums\CompanyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Perfil operativo de una empresa registrada.
 *
 * Contiene datos fiscales/contacto y controla si la empresa puede publicar
 * vacantes mediante su estado de aprobación.
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'business_name', 'rfc', 'economic_activity', 'employee_count', 'website',
        'primary_email', 'primary_phone', 'secondary_phone', 'street', 'external_number',
        'internal_number', 'neighborhood', 'postal_code', 'municipality', 'state', 'logo_path',
        'status', 'approved_at', 'approved_by', 'rejection_reason', 'how_did_you_hear',
    ];

    protected function casts(): array
    {
        return [
            'status' => CompanyStatus::class,
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Usuario autenticable asociado a la empresa.
     */
    public function user() { return $this->belongsTo(User::class); }

    /**
     * Administrador que aprobó la empresa.
     */
    public function approver() { return $this->belongsTo(User::class, 'approved_by'); }

    /**
     * Vacantes creadas por la empresa.
     */
    public function vacancies() { return $this->hasMany(Vacancy::class); }

    /**
     * Postulaciones recibidas por vacantes de la empresa.
     */
    public function applications() { return $this->hasMany(Application::class); }

    /**
     * Indica si la empresa ya puede operar y publicar.
     */
    public function isActive(): bool
    {
        return $this->status === CompanyStatus::Active;
    }

    /**
     * Resuelve la URL pública del logo sin acoplar las vistas al origen del archivo.
     *
     * Actualmente los logos cargados por empresa viven en public/images/companies,
     * pero este método también soporta URLs absolutas y rutas guardadas en storage
     * para evitar imágenes rotas si cambia la estrategia de archivos.
     */
    public function logoUrl(): ?string
    {
        if (blank($this->logo_path)) {
            return null;
        }

        if (Str::startsWith($this->logo_path, ['http://', 'https://'])) {
            return $this->logo_path;
        }

        if (Str::startsWith($this->logo_path, ['storage/', '/storage/'])) {
            return asset(ltrim($this->logo_path, '/'));
        }

        if (Storage::disk('public')->exists($this->logo_path)) {
            return Storage::disk('public')->url($this->logo_path);
        }

        return asset(ltrim($this->logo_path, '/'));
    }
}
