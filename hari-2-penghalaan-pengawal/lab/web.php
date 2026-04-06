<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Laluan Web (Web Routes) — Hari 2
|--------------------------------------------------------------------------
| Fail ini mengandungi contoh laluan yang dibina semasa Lab Hari 2.
| Salin laluan yang berkenaan ke dalam fail routes/web.php projek anda.
|
*/

// ============================================
// LALUAN ASAS (Lab 2.1)
// ============================================

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Halaman tentang kami
Route::get('/tentang', function () {
    return 'Halaman Tentang Kami - Blog Laravel';
});

// Halaman hubungi kami
Route::get('/hubungi', function () {
    return 'Halaman Hubungi Kami';
});

// Laluan dengan parameter
Route::get('/salam/{nama}', function ($nama) {
    return "Selamat datang, {$nama}!";
});

// Laluan dengan parameter pilihan
Route::get('/user/{id?}', function ($id = null) {
    if ($id) {
        return "Profil pengguna #{$id}";
    }
    return "Senarai semua pengguna";
});

// ============================================
// LALUAN DENGAN PENGAWAL (Lab 2.2)
// ============================================

// Resource route — mencipta 7 laluan CRUD secara automatik:
// GET    /posts          → PostController@index
// GET    /posts/create   → PostController@create
// POST   /posts          → PostController@store
// GET    /posts/{id}     → PostController@show
// GET    /posts/{id}/edit → PostController@edit
// PUT    /posts/{id}     → PostController@update
// DELETE /posts/{id}     → PostController@destroy
Route::resource('posts', PostController::class);

// ============================================
// LALUAN DENGAN MIDDLEWARE (Lab 2.3)
// ============================================

// Kumpulan laluan yang memerlukan pengesahan
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return 'Dashboard - Anda telah log masuk!';
    })->name('dashboard');
});

// Kumpulan laluan admin dengan prefix
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return 'Halaman Admin';
    });
    Route::get('/tetapan', function () {
        return 'Tetapan Admin';
    });
});

// ============================================
// LALUAN BERNAMA (Named Routes)
// ============================================

Route::get('/profil', function () {
    return 'Halaman Profil Saya';
})->name('profil');

// Gunakan: route('profil') untuk menjana URL ke laluan ini
