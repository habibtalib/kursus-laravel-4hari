<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| Laluan API — Hari 4
|--------------------------------------------------------------------------
| Fail ini mengandungi contoh laluan API.
| Salin kandungan ini ke dalam fail routes/api.php projek anda.
|
| Semua laluan API secara automatik mendapat prefix /api
| Contoh: /api/posts, /api/posts/1
|
*/

// Laluan API awam (tanpa pengesahan)
Route::apiResource('posts', PostController::class);

// Laluan API dengan pengesahan (Sanctum)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('posts', PostController::class);
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
// });
