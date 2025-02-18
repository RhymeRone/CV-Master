<?php

namespace App\Policies;

use App\Models\CVInformation;

class CVInformationPolicy
{
    private function isAdmin(): bool
    {
        $token = request()->bearerToken();
        return $token && cache('admin_token') === $token;
    }

    /**
     * Herkes CV'yi görüntüleyebilir
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Herkes CV detayını görüntüleyebilir
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * Sadece admin CV oluşturabilir
     */
    public function create(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Sadece admin CV'yi güncelleyebilir
     */
    public function update(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Sadece admin CV'yi silebilir
     */
    public function delete(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Sadece admin silinmiş CV'yi geri getirebilir
     */
    public function restore(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Sadece admin CV'yi kalıcı olarak silebilir
     */
    public function forceDelete(): bool
    {
        return $this->isAdmin();
    }
}
