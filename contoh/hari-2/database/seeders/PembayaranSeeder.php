<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Masukkan 20 rekod pembayaran contoh.
     */
    public function run(): void
    {
        $pembayarans = [
            // Pembayar 1 — Ahmad bin Abdullah (3 pembayaran)
            [
                'pembayar_id'    => 1,
                'jenis_zakat_id' => 1,
                'jumlah'         => 7.00,
                'tarikh_bayar'   => '2024-03-28',
                'cara_bayar'     => 'tunai',
                'no_resit'       => 'ZK-2024-0001',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 1,
                'jenis_zakat_id' => 2,
                'jumlah'         => 1350.00,
                'tarikh_bayar'   => '2024-06-15',
                'cara_bayar'     => 'fpx',
                'no_resit'       => 'ZK-2024-0002',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 1,
                'jenis_zakat_id' => 4,
                'jumlah'         => 500.00,
                'tarikh_bayar'   => '2024-09-01',
                'cara_bayar'     => 'online',
                'no_resit'       => 'ZK-2024-0003',
                'status'         => 'pending',
            ],
            // Pembayar 2 — Siti Nurhaliza (2 pembayaran)
            [
                'pembayar_id'    => 2,
                'jenis_zakat_id' => 1,
                'jumlah'         => 7.00,
                'tarikh_bayar'   => '2024-03-29',
                'cara_bayar'     => 'tunai',
                'no_resit'       => 'ZK-2024-0004',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 2,
                'jenis_zakat_id' => 2,
                'jumlah'         => 1140.00,
                'tarikh_bayar'   => '2024-07-10',
                'cara_bayar'     => 'kad',
                'no_resit'       => 'ZK-2024-0005',
                'status'         => 'sah',
            ],
            // Pembayar 3 — Mohd Faizal (3 pembayaran)
            [
                'pembayar_id'    => 3,
                'jenis_zakat_id' => 1,
                'jumlah'         => 7.00,
                'tarikh_bayar'   => '2024-03-27',
                'cara_bayar'     => 'tunai',
                'no_resit'       => 'ZK-2024-0006',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 3,
                'jenis_zakat_id' => 2,
                'jumlah'         => 1950.00,
                'tarikh_bayar'   => '2024-05-20',
                'cara_bayar'     => 'fpx',
                'no_resit'       => 'ZK-2024-0007',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 3,
                'jenis_zakat_id' => 3,
                'jumlah'         => 3200.00,
                'tarikh_bayar'   => '2024-08-15',
                'cara_bayar'     => 'online',
                'no_resit'       => 'ZK-2024-0008',
                'status'         => 'sah',
            ],
            // Pembayar 5 — Ismail bin Yusof (3 pembayaran)
            [
                'pembayar_id'    => 5,
                'jenis_zakat_id' => 1,
                'jumlah'         => 7.00,
                'tarikh_bayar'   => '2024-03-30',
                'cara_bayar'     => 'tunai',
                'no_resit'       => 'ZK-2024-0009',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 5,
                'jenis_zakat_id' => 3,
                'jumlah'         => 4500.00,
                'tarikh_bayar'   => '2024-06-01',
                'cara_bayar'     => 'fpx',
                'no_resit'       => 'ZK-2024-0010',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 5,
                'jenis_zakat_id' => 2,
                'jumlah'         => 1560.00,
                'tarikh_bayar'   => '2024-10-05',
                'cara_bayar'     => 'online',
                'no_resit'       => 'ZK-2024-0011',
                'status'         => 'batal',
            ],
            // Pembayar 6 — Fatimah binti Omar (2 pembayaran)
            [
                'pembayar_id'    => 6,
                'jenis_zakat_id' => 1,
                'jumlah'         => 7.00,
                'tarikh_bayar'   => '2024-03-28',
                'cara_bayar'     => 'kad',
                'no_resit'       => 'ZK-2024-0012',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 6,
                'jenis_zakat_id' => 2,
                'jumlah'         => 1260.00,
                'tarikh_bayar'   => '2024-08-20',
                'cara_bayar'     => 'fpx',
                'no_resit'       => 'ZK-2024-0013',
                'status'         => 'pending',
            ],
            // Pembayar 8 — Nurul Huda (3 pembayaran)
            [
                'pembayar_id'    => 8,
                'jenis_zakat_id' => 1,
                'jumlah'         => 7.00,
                'tarikh_bayar'   => '2024-03-26',
                'cara_bayar'     => 'tunai',
                'no_resit'       => 'ZK-2024-0014',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 8,
                'jenis_zakat_id' => 2,
                'jumlah'         => 1740.00,
                'tarikh_bayar'   => '2024-04-15',
                'cara_bayar'     => 'fpx',
                'no_resit'       => 'ZK-2024-0015',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 8,
                'jenis_zakat_id' => 4,
                'jumlah'         => 800.00,
                'tarikh_bayar'   => '2024-07-01',
                'cara_bayar'     => 'online',
                'no_resit'       => 'ZK-2024-0016',
                'status'         => 'sah',
            ],
            // Pembayar 9 — Hassan bin Daud (1 pembayaran)
            [
                'pembayar_id'    => 9,
                'jenis_zakat_id' => 1,
                'jumlah'         => 7.00,
                'tarikh_bayar'   => '2024-03-31',
                'cara_bayar'     => 'tunai',
                'no_resit'       => 'ZK-2024-0017',
                'status'         => 'sah',
            ],
            // Pembayar 10 — Aminah binti Sulaiman (3 pembayaran)
            [
                'pembayar_id'    => 10,
                'jenis_zakat_id' => 1,
                'jumlah'         => 7.00,
                'tarikh_bayar'   => '2024-03-25',
                'cara_bayar'     => 'tunai',
                'no_resit'       => 'ZK-2024-0018',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 10,
                'jenis_zakat_id' => 2,
                'jumlah'         => 2160.00,
                'tarikh_bayar'   => '2024-05-10',
                'cara_bayar'     => 'fpx',
                'no_resit'       => 'ZK-2024-0019',
                'status'         => 'sah',
            ],
            [
                'pembayar_id'    => 10,
                'jenis_zakat_id' => 5,
                'jumlah'         => 1200.00,
                'tarikh_bayar'   => '2024-09-15',
                'cara_bayar'     => 'online',
                'no_resit'       => 'ZK-2024-0020',
                'status'         => 'pending',
            ],
        ];

        foreach ($pembayarans as $pembayaran) {
            Pembayaran::create($pembayaran);
        }
    }
}
