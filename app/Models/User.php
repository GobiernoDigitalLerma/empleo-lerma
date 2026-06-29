<?php

namespace App\Models;

use App\Enums\AccessStatus;
use App\Enums\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Usuario autenticable del portal.
 *
 * Un usuario puede operar como administrador, empresa o ciudadano; las
 * relaciones y helpers de rol se usan en middleware, menús y redirecciones.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'email_verified_at', 'phone', 'password', 'role', 'status',
        'access_expires_at', 'revoked_at', 'last_login_at', 'force_password_reset',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'status' => AccessStatus::class,
            'access_expires_at' => 'datetime',
            'revoked_at' => 'datetime',
            'last_login_at' => 'datetime',
            'force_password_reset' => 'boolean',
        ];
    }

    /**
     * Perfil de empresa cuando el usuario tiene rol empresa.
     */
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    /**
     * Perfil ciudadano cuando el usuario tiene rol ciudadano.
     */
    public function citizenProfile()
    {
        return $this->hasOne(CitizenProfile::class);
    }

    /**
     * Indica si el usuario puede operar el dashboard administrador.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    /**
     * Indica si el usuario representa a una empresa.
     */
    public function isCompany(): bool
    {
        return $this->role === UserRole::Company;
    }

    /**
     * Indica si el usuario es ciudadano postulante.
     */
    public function isCitizen(): bool
    {
        return $this->role === UserRole::Citizen;
    }

    /**
     * Valida que el acceso esté activo, no revocado y no vencido.
     */
    public function hasActiveAccess(): bool
    {
        return $this->status === AccessStatus::Active
            && is_null($this->revoked_at)
            && (is_null($this->access_expires_at) || $this->access_expires_at->isFuture());
    }
}
