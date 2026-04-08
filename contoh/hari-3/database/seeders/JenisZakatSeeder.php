<?php

namespace Database\Seeders;

use App\Models\JenisZakat;
use Illuminate\Database\Seeder;

class JenisZakatSeeder extends Seeder
{
    /**
     * Masukkan data contoh jenis zakat.
     */
    public function run(): void
    {
        $jenisZakats = [
            [
                'nama' => 'Zakat Fitrah',
                'kadar' => 7.0000,
                'penerangan' => 'Zakat yang wajib dibayar oleh setiap Muslim pada bulan Ramadan. Kadar ditetapkan berdasarkan harga beras tempatan.',
                'is_aktif' => true,
            ],
            [
                'nama' => 'Zakat Pendapatan',
                'kadar' => 2.5000,
                'penerangan' => 'Zakat ke atas pendapatan gaji, elaun, bonus dan sebarang hasil perkhidmatan yang melebihi nisab.',
                'is_aktif' => true,
            ],
            [
                'nama' => 'Zakat Perniagaan',
                'kadar' => 2.5000,
                'penerangan' => 'Zakat yang dikenakan ke atas harta perniagaan sama ada perniagaan persendirian, perkongsian atau syarikat.',
                'is_aktif' => true,
            ],
            [
                'nama' => 'Zakat Wang Simpanan',
                'kadar' => 2.5000,
                'penerangan' => 'Zakat yang dikenakan ke atas wang simpanan yang telah mencukupi nisab dan haul (setahun).',
                'is_aktif' => true,
            ],
            [
                'nama' => 'Zakat Emas',
                'kadar' => 2.5000,
                'penerangan' => 'Zakat yang dikenakan ke atas emas yang tidak dipakai (emas perhiasan yang melebihi uruf) dan emas pelaburan.',
                'is_aktif' => true,
            ],
        ];

        foreach ($jenisZakats as $jenis) {
            JenisZakat::create($jenis);
        }
    }
}
