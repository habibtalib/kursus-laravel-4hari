<?php

namespace App\Policies;

use App\Models\Pembayar;
use App\Models\User;

class PembayarPolicy
{
    /**
     * Semak sama ada pengguna boleh melihat senarai pembayar.
     * Semua peranan dibenarkan.
     */
    public function viewAny(User $user): bool
    {
        return true; // Semua peranan boleh lihat senarai
    }

    /**
     * Semak sama ada pengguna boleh melihat seorang pembayar.
     */
    public function view(User $user, Pembayar $pembayar): bool
    {
        return true; // Semua peranan boleh lihat butiran
    }

    /**
     * Semak sama ada pengguna boleh mendaftar pembayar baru.
     * Hanya admin dan pegawai dibenarkan.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin', 'pegawai');
    }

    /**
     * Semak sama ada pengguna boleh mengemaskini pembayar.
     * Hanya admin dan pegawai dibenarkan.
     */
    public function update(User $user, Pembayar $pembayar): bool
    {
        return $user->hasRole('admin', 'pegawai');
    }

    /**
     * Semak sama ada pengguna boleh memadamkan pembayar.
     * Hanya admin dibenarkan.
     */
    public function delete(User $user, Pembayar $pembayar): bool
    {
        return $user->isAdmin();
    }
}
