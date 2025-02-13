<?php

namespace App\Policies;

use App\Models\Skill;

class SkillPolicy
{
    private function isAdmin(): bool
    {
        $token = request()->bearerToken();
        return $token && cache('admin_token') === $token;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true; // Herkes görebilir
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return true; // Herkes görebilir
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return $this->isAdmin();
    }
}
