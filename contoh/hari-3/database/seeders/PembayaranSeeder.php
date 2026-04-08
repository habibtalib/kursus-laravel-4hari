<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    /**
     * Masukkan data contoh pembayaran.
     */
    public function run(): void
    {
        $pembayarans = [
            ['pembayar_id' => 1, 'jenis_zakat_id' => 1, 'jumlah' => 7.00, 'tarikh_bayar' => '2024-03-15', 'cara_bayar' => 'tunai', 'no_resit' => 'ZK-2024-0001', 'status' => 'sah'],
            ['pembayar_id' => 1, 'jenis_zakat_id' => 2, 'jumlah' => 150.00, 'tarikh_bayar' => '2024-03-20', 'cara_bayar' => 'fpx', 'no_resit' => 'ZK-2024-0002', 'status' => 'sah'],
            ['pembayar_id' => 2, 'jenis_zakat_id' => 1, 'jumlah' => 7.00, 'tarikh_bayar' => '2024-03-16', 'cara_bayar' => 'tunai', 'no_resit' => 'ZK-2024-0003', 'status' => 'sah'],
            ['pembayar_id' => 2, 'jenis_zakat_id' => 2, 'jumlah' => 120.00, 'tarikh_bayar' => '2024-04-01', 'cara_bayar' => 'online', 'no_resit' => 'ZK-2024-0004', 'status' => 'pending'],
            ['pembayar_id' => 3, 'jenis_zakat_id' => 3, 'jumlah' => 2500.00, 'tarikh_bayar' => '2024-02-10', 'cara_bayar' => 'fpx', 'no_resit' => 'ZK-2024-0005', 'status' => 'sah'],
            ['pembayar_id' => 3, 'jenis_zakat_id' => 1, 'jumlah' => 7.00, 'tarikh_bayar' => '2024-03-18', 'cara_bayar' => 'tunai', 'no_resit' => 'ZK-2024-0006', 'status' => 'sah'],
            ['pembayar_id' => 4, 'jenis_zakat_id' => 2, 'jumlah' => 200.00, 'tarikh_bayar' => '2024-03-25', 'cara_bayar' => 'kad', 'no_resit' => 'ZK-2024-0007', 'status' => 'sah'],
            ['pembayar_id' => 4, 'jenis_zakat_id' => 4, 'jumlah' => 350.00, 'tarikh_bayar' => '2024-04-05', 'cara_bayar' => 'fpx', 'no_resit' => 'ZK-2024-0008', 'status' => 'pending'],
            ['pembayar_id' => 5, 'jenis_zakat_id' => 1, 'jumlah' => 7.00, 'tarikh_bayar' => '2024-03-14', 'cara_bayar' => 'tunai', 'no_resit' => 'ZK-2024-0009', 'status' => 'sah'],
            ['pembayar_id' => 5, 'jenis_zakat_id' => 2, 'jumlah' => 80.00, 'tarikh_bayar' => '2024-04-10', 'cara_bayar' => 'online', 'no_resit' => 'ZK-2024-0010', 'status' => 'batal'],
            ['pembayar_id' => 6, 'jenis_zakat_id' => 2, 'jumlah' => 250.00, 'tarikh_bayar' => '2024-03-28', 'cara_bayar' => 'fpx', 'no_resit' => 'ZK-2024-0011', 'status' => 'sah'],
            ['pembayar_id' => 6, 'jenis_zakat_id' => 5, 'jumlah' => 500.00, 'tarikh_bayar' => '2024-04-12', 'cara_bayar' => 'kad', 'no_resit' => 'ZK-2024-0012', 'status' => 'sah'],
            ['pembayar_id' => 7, 'jenis_zakat_id' => 2, 'jumlah' => 300.00, 'tarikh_bayar' => '2024-03-30', 'cara_bayar' => 'fpx', 'no_resit' => 'ZK-2024-0013', 'status' => 'sah'],
            ['pembayar_id' => 7, 'jenis_zakat_id' => 3, 'jumlah' => 1800.00, 'tarikh_bayar' => '2024-04-02', 'cara_bayar' => 'online', 'no_resit' => 'ZK-2024-0014', 'status' => 'pending'],
            ['pembayar_id' => 8, 'jenis_zakat_id' => 1, 'jumlah' => 7.00, 'tarikh_bayar' => '2024-03-17', 'cara_bayar' => 'tunai', 'no_resit' => 'ZK-2024-0015', 'status' => 'sah'],
            ['pembayar_id' => 9, 'jenis_zakat_id' => 2, 'jumlah' => 180.00, 'tarikh_bayar' => '2024-04-08', 'cara_bayar' => 'fpx', 'no_resit' => 'ZK-2024-0016', 'status' => 'sah'],
            ['pembayar_id' => 9, 'jenis_zakat_id' => 4, 'jumlah' => 600.00, 'tarikh_bayar' => '2024-04-15', 'cara_bayar' => 'kad', 'no_resit' => 'ZK-2024-0017', 'status' => 'pending'],
            ['pembayar_id' => 10, 'jenis_zakat_id' => 2, 'jumlah' => 400.00, 'tarikh_bayar' => '2024-03-22', 'cara_bayar' => 'fpx', 'no_resit' => 'ZK-2024-0018', 'status' => 'sah'],
            ['pembayar_id' => 10, 'jenis_zakat_id' => 4, 'jumlah' => 800.00, 'tarikh_bayar' => '2024-04-18', 'cara_bayar' => 'online', 'no_resit' => 'ZK-2024-0019', 'status' => 'sah'],
            ['pembayar_id' => 3, 'jenis_zakat_id' => 2, 'jumlah' => 280.00, 'tarikh_bayar' => '2024-04-20', 'cara_bayar' => 'fpx', 'no_resit' => 'ZK-2024-0020', 'status' => 'batal'],
        ];

        foreach ($pembayarans as $pembayaran) {
            Pembayaran::create($pembayaran);
        }
    }
}
