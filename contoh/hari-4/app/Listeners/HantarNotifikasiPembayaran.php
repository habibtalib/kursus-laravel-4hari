<?php

namespace App\Listeners;

use App\Events\PembayaranDibuat;
use Illuminate\Support\Facades\Log;

class HantarNotifikasiPembayaran
{
    /**
     * Hantar notifikasi (simulasi) kepada pentadbir.
     */
    public function handle(PembayaranDibuat $event): void
    {
        $p = $event->pembayaran;
        $p->load('pembayar');

        // Simulasi notifikasi — dalam pengeluaran, hantar e-mel/SMS
        Log::channel('single')->info('NOTIFIKASI: Pembayaran baru dari ' . $p->pembayar->nama . ' sebanyak RM ' . number_format($p->jumlah, 2));
    }
}
