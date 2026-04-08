<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Masukkan semua data contoh ke pangkalan data.
     */
    public function run(): void
    {
        // Cipta pengguna mengikut peranan
        User::create([
            'name' => 'Admin Zakat',
            'email' => 'admin@zakat.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pegawai Zakat',
            'email' => 'pegawai@zakat.test',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
        ]);

        User::create([
            'name' => 'Pemerhati',
            'email' => 'pemerhati@zakat.test',
            'password' => Hash::make('password'),
            'role' => 'pemerhati',
        ]);

        $this->call([
            PembayarSeeder::class,
            JenisZakatSeeder::class,
            PembayaranSeeder::class,
        ]);
    }
}
