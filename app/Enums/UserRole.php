<?php

namespace App\Enums;

/**
 * Roles principales del portal.
 *
 * Se usan para middleware, redirecciones, menús y autorización por dashboard.
 */
enum UserRole: string
{
    case Admin = 'admin';
    case Company = 'company';
    case Citizen = 'citizen';

    /**
     * Etiqueta legible para vistas y mensajes.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Company => 'Empresa',
            self::Citizen => 'Ciudadano',
        };
    }
}
