<?php

use Illuminate\Support\Facades\Schedule;

// Laporan harian — jalankan setiap hari pada jam 8 pagi
Schedule::command('zakat:laporan-harian')->dailyAt('08:00');

// Bersihkan pembayaran batal — jalankan setiap minggu pada hari Isnin
Schedule::command('zakat:bersih-batal')->weeklyOn(1, '02:00');
