<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class JenisZakat extends Model
{
    /**
     * Nama jadual dalam pangkalan data.
     */
    protected $table = 'jenis_zakats';

    /**
     * Medan yang boleh diisi secara massal.
     */
    protected $fillable = [
        'nama',
        'kadar',
        'penerangan',
        'is_aktif',
    ];

    /**
     * Penukaran jenis data.
     */
    protected $casts = [
        'kadar' => 'decimal:4',
        'is_aktif' => 'boolean',
    ];

    /**
     * Hubungan: Jenis Zakat mempunyai banyak Pembayaran.
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * Skop: Hanya jenis zakat yang aktif.
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true);
    }
}
