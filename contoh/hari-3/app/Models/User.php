<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // === Peranan (Roles) ===

    /**
     * Semak sama ada pengguna ialah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Semak sama ada pengguna ialah pegawai.
     */
    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

    /**
     * Semak sama ada pengguna ialah pemerhati.
     */
    public function isPemerhati(): bool
    {
        return $this->role === 'pemerhati';
    }

    /**
     * Semak sama ada pengguna mempunyai salah satu peranan.
     */
    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles);
    }
}
