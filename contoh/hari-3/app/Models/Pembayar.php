<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Pembayar extends Model
{
    /**
     * Medan yang boleh diisi secara massal.
     */
    protected $fillable = [
        'nama',
        'no_ic',
        'alamat',
        'no_tel',
        'email',
        'pekerjaan',
        'pendapatan_bulanan',
    ];

    /**
     * Penukaran jenis data.
     */
    protected $casts = [
        'pendapatan_bulanan' => 'decimal:2',
    ];

    /**
     * Hubungan: Pembayar mempunyai banyak Pembayaran.
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * Skop: Carian berdasarkan nama atau no IC.
     */
    public function scopeCarian(Builder $query, string $carian): Builder
    {
        return $query->where('nama', 'like', "%{$carian}%")
                     ->orWhere('no_ic', 'like', "%{$carian}%");
    }

    /**
     * Skop: Pendapatan melebihi jumlah tertentu.
     */
    public function scopePendapatanMelebihi(Builder $query, float $jumlah): Builder
    {
        return $query->where('pendapatan_bulanan', '>', $jumlah);
    }

    /**
     * Aksesor: Format No IC (850101-14-5678).
     */
    public function getIcFormatAttribute(): string
    {
        $ic = $this->no_ic;
        return substr($ic, 0, 6) . '-' . substr($ic, 6, 2) . '-' . substr($ic, 8);
    }

    /**
     * Aksesor: Format pendapatan bulanan (RM 3,500.00).
     */
    public function getPendapatanFormatAttribute(): string
    {
        return 'RM ' . number_format($this->pendapatan_bulanan ?? 0, 2);
    }

    /**
     * Aksesor: Jumlah keseluruhan bayaran yang sah.
     */
    public function getJumlahBayaranAttribute(): float
    {
        return (float) $this->pembayarans()->where('status', 'sah')->sum('jumlah');
    }
}
