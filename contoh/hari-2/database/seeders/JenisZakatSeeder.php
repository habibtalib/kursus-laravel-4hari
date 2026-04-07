<?php

namespace Database\Seeders;

use App\Models\JenisZakat;
use Illuminate\Database\Seeder;

class JenisZakatSeeder extends Seeder
{
    /**
     * Masukkan 5 jenis zakat contoh.
     */
    public function run(): void
    {
        $jenisZakats = [
            [
                'nama'       => 'Zakat Fitrah',
                'kadar'      => 7.0000,
                'penerangan' => 'Zakat yang wajib dibayar oleh setiap individu Muslim pada bulan Ramadan. Kadar ditetapkan berdasarkan harga beras tempatan.',
                'is_aktif'   => true,
            ],
            [
                'nama'       => 'Zakat Pendapatan',
                'kadar'      => 2.5000,
                'penerangan' => 'Zakat yang dikenakan ke atas pendapatan penggajian dan pendapatan bebas yang telah mencapai nisab.',
                'is_aktif'   => true,
            ],
            [
                'nama'       => 'Zakat Perniagaan',
                'kadar'      => 2.5000,
                'penerangan' => 'Zakat yang dikenakan ke atas harta perniagaan yang telah cukup haul dan nisab.',
                'is_aktif'   => true,
            ],
            [
                'nama'       => 'Zakat Wang Simpanan',
                'kadar'      => 2.5000,
                'penerangan' => 'Zakat yang dikenakan ke atas wang simpanan yang telah cukup haul (setahun) dan mencapai nisab.',
                'is_aktif'   => true,
            ],
            [
                'nama'       => 'Zakat Emas',
                'kadar'      => 2.5000,
                'penerangan' => 'Zakat yang dikenakan ke atas emas yang disimpan (tidak dipakai) yang telah cukup haul dan nisab.',
                'is_aktif'   => true,
            ],
        ];

        foreach ($jenisZakats as $jenis) {
            JenisZakat::create($jenis);
        }
    }
}
