<?php

namespace App\Events;

use App\Models\Pembayaran;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PembayaranDibuat
{
    use Dispatchable, SerializesModels;

    /**
     * Peristiwa ini dicetuskan apabila pembayaran baru dibuat.
     */
    public function __construct(
        public Pembayaran $pembayaran
    ) {}
}
