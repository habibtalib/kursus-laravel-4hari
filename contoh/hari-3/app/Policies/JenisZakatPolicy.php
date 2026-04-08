<?php

namespace App\Policies;

use App\Models\JenisZakat;
use App\Models\User;

class JenisZakatPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, JenisZakat $jenisZakat): bool
    {
        return true;
    }

    /**
     * Hanya admin boleh mengurus jenis zakat.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, JenisZakat $jenisZakat): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, JenisZakat $jenisZakat): bool
    {
        return $user->isAdmin();
    }
}
