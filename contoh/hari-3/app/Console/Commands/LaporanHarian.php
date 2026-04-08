<?php

namespace App\Console\Commands;

use App\Mail\LaporanHarianMail;
use App\Models\Pembayaran;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LaporanHarian extends Command
{
    /**
     * Nama dan tandatangan arahan.
     */
    protected $signature = 'zakat:laporan-harian';

    /**
     * Penerangan arahan.
     */
    protected $description = 'Hasilkan laporan harian kutipan zakat';

    /**
     * Jalankan arahan.
     */
    public function handle()
    {
        $tarikh = now()->format('d/m/Y');
        $jumlahHariIni = Pembayaran::whereDate('tarikh_bayar', today())->count();
        $kutipanHariIni = Pembayaran::whereDate('tarikh_bayar', today())
            ->where('status', 'sah')
            ->sum('jumlah');

        $jumlahKeseluruhan = Pembayaran::count();
        $kutipanKeseluruhan = Pembayaran::where('status', 'sah')->sum('jumlah');

        $this->info("====================================");
        $this->info("  LAPORAN HARIAN ZAKAT KEDAH");
        $this->info("  Tarikh: {$tarikh}");
        $this->info("====================================");
        $this->info("Transaksi hari ini : {$jumlahHariIni}");
        $this->info("Kutipan hari ini   : RM " . number_format($kutipanHariIni, 2));
        $this->info("------------------------------------");
        $this->info("Jumlah transaksi   : {$jumlahKeseluruhan}");
        $this->info("Jumlah kutipan     : RM " . number_format($kutipanKeseluruhan, 2));
        $this->info("====================================");

        // Log ke fail
        Log::info("Laporan Harian Zakat - {$tarikh}", [
            'transaksi_hari_ini' => $jumlahHariIni,
            'kutipan_hari_ini' => $kutipanHariIni,
            'jumlah_transaksi' => $jumlahKeseluruhan,
            'jumlah_kutipan' => $kutipanKeseluruhan,
        ]);

        $this->info('Laporan berjaya dilog ke storage/logs/laravel.log');

        // Hantar laporan melalui e-mel
        $laporan = [
            'tarikh' => $tarikh,
            'transaksi_hari_ini' => $jumlahHariIni,
            'kutipan_hari_ini' => $kutipanHariIni,
            'jumlah_transaksi' => $jumlahKeseluruhan,
            'jumlah_kutipan' => $kutipanKeseluruhan,
        ];

        Mail::to(config('mail.from.address'))->send(new LaporanHarianMail($laporan));
        $this->info('Laporan dihantar melalui e-mel.');

        return Command::SUCCESS;
    }
}
