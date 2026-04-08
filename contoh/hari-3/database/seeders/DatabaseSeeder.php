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
        // Cipta pengguna admin
        User::create([
            'name' => 'Admin Zakat',
            'email' => 'admin@zakat.test',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            PembayarSeeder::class,
            JenisZakatSeeder::class,
            PembayaranSeeder::class,
        ]);
    }
}
