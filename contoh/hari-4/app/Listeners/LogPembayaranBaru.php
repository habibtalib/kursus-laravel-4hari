<?php

namespace App\Listeners;

use App\Events\PembayaranDibuat;
use Illuminate\Support\Facades\Log;

class LogPembayaranBaru
{
    /**
     * Rekod pembayaran baru ke dalam log.
     */
    public function handle(PembayaranDibuat $event): void
    {
        $p = $event->pembayaran;
        $p->load(['pembayar', 'jenisZakat']);

        Log::channel('single')->info('Pembayaran Baru Diterima', [
            'no_resit' => $p->no_resit,
            'pembayar' => $p->pembayar->nama,
            'jenis_zakat' => $p->jenisZakat->nama,
            'jumlah' => 'RM ' . number_format($p->jumlah, 2),
            'tarikh' => $p->tarikh_bayar->format('d/m/Y'),
            'cara_bayar' => $p->cara_bayar,
        ]);
    }
}
