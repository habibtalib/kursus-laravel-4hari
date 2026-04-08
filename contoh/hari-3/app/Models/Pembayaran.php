<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Pembayaran extends Model
{
    /**
     * Medan yang boleh diisi secara massal.
     */
    protected $fillable = [
        'pembayar_id',
        'jenis_zakat_id',
        'jumlah',
        'tarikh_bayar',
        'cara_bayar',
        'no_resit',
        'status',
    ];

    /**
     * Penukaran jenis data.
     */
    protected $casts = [
        'jumlah' => 'decimal:2',
        'tarikh_bayar' => 'date',
        'cara_bayar' => 'string',
        'status' => 'string',
    ];

    /**
     * Hubungan: Pembayaran milik seorang Pembayar.
     */
    public function pembayar(): BelongsTo
    {
        return $this->belongsTo(Pembayar::class);
    }

    /**
     * Hubungan: Pembayaran milik satu Jenis Zakat.
     */
    public function jenisZakat(): BelongsTo
    {
        return $this->belongsTo(JenisZakat::class);
    }

    /**
     * Aksesor: Format jumlah (RM 150.00).
     */
    public function getJumlahFormatAttribute(): string
    {
        return 'RM ' . number_format($this->jumlah, 2);
    }

    /**
     * Skop: Hanya pembayaran yang sah.
     */
    public function scopeSah(Builder $query): Builder
    {
        return $query->where('status', 'sah');
    }
}
