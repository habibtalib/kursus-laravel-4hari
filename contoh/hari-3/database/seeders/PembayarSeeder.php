<?php

namespace Database\Seeders;

use App\Models\Pembayar;
use Illuminate\Database\Seeder;

class PembayarSeeder extends Seeder
{
    /**
     * Masukkan data contoh pembayar.
     */
    public function run(): void
    {
        $pembayars = [
            [
                'nama' => 'Ahmad bin Ismail',
                'no_ic' => '850101145678',
                'alamat' => 'No. 12, Jalan Putra, Taman Putra, 05100 Alor Setar, Kedah',
                'no_tel' => '0124567890',
                'email' => 'ahmad.ismail@email.com',
                'pekerjaan' => 'Guru',
                'pendapatan_bulanan' => 4500.00,
            ],
            [
                'nama' => 'Siti Aminah binti Abdullah',
                'no_ic' => '900215085432',
                'alamat' => 'No. 5, Lorong Mawar 3, Taman Sejahtera, 05400 Alor Setar, Kedah',
                'no_tel' => '0137894561',
                'email' => 'siti.aminah@email.com',
                'pekerjaan' => 'Jururawat',
                'pendapatan_bulanan' => 3800.00,
            ],
            [
                'nama' => 'Mohd Razali bin Hassan',
                'no_ic' => '780520025678',
                'alamat' => 'Lot 234, Kampung Baru, 06000 Jitra, Kedah',
                'no_tel' => '0191234567',
                'email' => 'razali.hassan@email.com',
                'pekerjaan' => 'Peniaga',
                'pendapatan_bulanan' => 8500.00,
            ],
            [
                'nama' => 'Nur Faizah binti Othman',
                'no_ic' => '880730025890',
                'alamat' => 'No. 78, Jalan Langgar, 05460 Alor Setar, Kedah',
                'no_tel' => '0165432189',
                'email' => 'faizah.othman@email.com',
                'pekerjaan' => 'Akauntan',
                'pendapatan_bulanan' => 5200.00,
            ],
            [
                'nama' => 'Wan Azman bin Wan Ibrahim',
                'no_ic' => '750912025432',
                'alamat' => 'No. 3, Taman Aman, 08000 Sungai Petani, Kedah',
                'no_tel' => '0148765432',
                'email' => null,
                'pekerjaan' => 'Petani',
                'pendapatan_bulanan' => 2500.00,
            ],
            [
                'nama' => 'Zainab binti Yusof',
                'no_ic' => '920405025678',
                'alamat' => 'Blok C-2-5, Pangsapuri Harmoni, 08600 Kulim, Kedah',
                'no_tel' => '0171239876',
                'email' => 'zainab.yusof@email.com',
                'pekerjaan' => 'Jurutera',
                'pendapatan_bulanan' => 6800.00,
            ],
            [
                'nama' => 'Kamal bin Zakaria',
                'no_ic' => '830618025123',
                'alamat' => 'No. 45, Jalan Sultanah, 05000 Alor Setar, Kedah',
                'no_tel' => '0109876543',
                'email' => 'kamal.zakaria@email.com',
                'pekerjaan' => 'Peguam',
                'pendapatan_bulanan' => 9500.00,
            ],
            [
                'nama' => 'Halimah binti Mohamad',
                'no_ic' => '870225025987',
                'alamat' => 'Kampung Pisang, 06550 Changlun, Kedah',
                'no_tel' => '0132345678',
                'email' => null,
                'pekerjaan' => 'Suri Rumah',
                'pendapatan_bulanan' => null,
            ],
            [
                'nama' => 'Iskandar bin Nordin',
                'no_ic' => '800911025456',
                'alamat' => 'No. 67, Pekan Rabu, 05000 Alor Setar, Kedah',
                'no_tel' => '0183456789',
                'email' => 'iskandar.nordin@email.com',
                'pekerjaan' => 'Pegawai Kerajaan',
                'pendapatan_bulanan' => 5800.00,
            ],
            [
                'nama' => 'Norazlina binti Ramli',
                'no_ic' => '950103025234',
                'alamat' => 'No. 21, Taman Cahaya, 09000 Kulim, Kedah',
                'no_tel' => '0156789012',
                'email' => 'norazlina.ramli@email.com',
                'pekerjaan' => 'Doktor',
                'pendapatan_bulanan' => 12000.00,
            ],
        ];

        foreach ($pembayars as $pembayar) {
            Pembayar::create($pembayar);
        }
    }
}
