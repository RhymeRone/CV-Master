<?php

namespace App\Policies;

use App\Models\Service;

class ServicePolicy
{
    private function isAdmin(): bool
    {
        $token = request()->bearerToken();
        return $token && cache('admin_token') === $token;
    }

    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(): bool
    {
        return $this->isAdmin();
    }

    public function update(): bool
    {
        return $this->isAdmin();
    }

    public function delete(): bool
    {
        return $this->isAdmin();
    }

    public function restore(): bool
    {
        return $this->isAdmin();
    }

    public function forceDelete(): bool
    {
        return $this->isAdmin();
    }
} 