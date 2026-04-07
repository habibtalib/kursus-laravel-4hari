<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    /**
     * Medan yang boleh diisi secara mass-assignment.
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
     * Penukaran jenis data automatik.
     */
    protected $casts = [
        'jumlah'       => 'decimal:2',
        'tarikh_bayar' => 'date',
    ];

    // ──────────────────────────────────────────────
    // Hubungan (Relationships)
    // ──────────────────────────────────────────────

    /**
     * Pembayaran ini milik seorang pembayar.
     * (Many-to-One: Pembayaran belongsTo Pembayar)
     */
    public function pembayar(): BelongsTo
    {
        return $this->belongsTo(Pembayar::class);
    }

    /**
     * Pembayaran ini milik satu jenis zakat.
     * (Many-to-One: Pembayaran belongsTo JenisZakat)
     */
    public function jenisZakat(): BelongsTo
    {
        return $this->belongsTo(JenisZakat::class);
    }

    // ──────────────────────────────────────────────
    // Aksesor (Accessors)
    // ──────────────────────────────────────────────

    /**
     * Aksesor: Format jumlah dengan RM (RM 150.00).
     */
    public function getJumlahFormatAttribute(): string
    {
        return 'RM ' . number_format($this->jumlah, 2);
    }

    // ──────────────────────────────────────────────
    // Skop (Scopes)
    // ──────────────────────────────────────────────

    /**
     * Skop: Hanya pembayaran yang sah.
     */
    public function scopeSah($query)
    {
        return $query->where('status', 'sah');
    }
}
