<?php

namespace App\Console\Commands;

use App\Models\Pembayaran;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BersihkanPembayaranBatal extends Command
{
    /**
     * Nama dan tandatangan arahan.
     */
    protected $signature = 'zakat:bersih-batal';

    /**
     * Penerangan arahan.
     */
    protected $description = 'Padamkan rekod pembayaran batal yang lebih 30 hari';

    /**
     * Jalankan arahan.
     */
    public function handle()
    {
        $jumlah = Pembayaran::where('status', 'batal')
            ->where('created_at', '<', now()->subDays(30))
            ->count();

        if ($jumlah === 0) {
            $this->info('Tiada rekod batal untuk dipadamkan.');
            return Command::SUCCESS;
        }

        Pembayaran::where('status', 'batal')
            ->where('created_at', '<', now()->subDays(30))
            ->delete();

        $this->info("{$jumlah} rekod pembayaran batal telah dipadamkan.");
        Log::info("Pembersihan: {$jumlah} rekod batal dipadamkan.");
        return Command::SUCCESS;
    }
}
