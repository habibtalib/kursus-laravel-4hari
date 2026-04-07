<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisZakat extends Model
{
    use HasFactory;

    /**
     * Medan yang boleh diisi secara mass-assignment.
     */
    protected $fillable = [
        'nama',
        'kadar',
        'penerangan',
        'is_aktif',
    ];

    /**
     * Penukaran jenis data automatik.
     */
    protected $casts = [
        'kadar'    => 'decimal:4',
        'is_aktif' => 'boolean',
    ];

    // ──────────────────────────────────────────────
    // Hubungan (Relationships)
    // ──────────────────────────────────────────────

    /**
     * Satu jenis zakat mempunyai banyak pembayaran.
     * (One-to-Many: JenisZakat hasMany Pembayaran)
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    // ──────────────────────────────────────────────
    // Skop (Scopes)
    // ──────────────────────────────────────────────

    /**
     * Skop: Hanya jenis zakat yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}
