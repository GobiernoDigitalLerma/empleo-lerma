<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vacancy;

/**
 * Autoriza acceso a vacantes según rol y propiedad de empresa.
 */
class VacancyPolicy
{
    /**
     * Admin ve todo; empresa sólo ve vacantes propias.
     */
    public function view(User $user, Vacancy $vacancy): bool
    {
        return $user->isAdmin() || $user->company?->id === $vacancy->company_id;
    }

    /**
     * Admin edita todo; empresa sólo edita vacantes propias.
     */
    public function update(User $user, Vacancy $vacancy): bool
    {
        return $user->isAdmin() || $user->company?->id === $vacancy->company_id;
    }
}
