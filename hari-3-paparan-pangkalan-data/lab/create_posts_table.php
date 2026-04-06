<?php

/*
|--------------------------------------------------------------------------
| Contoh Migrasi — Hari 3
|--------------------------------------------------------------------------
| Cipta migrasi ini dengan arahan:
| php artisan make:migration create_posts_table
|
| Kemudian salin kandungan method up() dan down() ke dalam fail migrasi
| yang dijana di folder database/migrations/
|
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi — cipta jadual 'posts'.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();                              // Lajur ID auto-increment
            $table->foreignId('user_id')               // Kunci asing ke jadual users
                  ->constrained()                      // Rujuk users.id
                  ->onDelete('cascade');                // Padam catatan jika user dipadam
            $table->string('title');                    // Tajuk catatan (varchar 255)
            $table->text('body');                       // Isi kandungan (text panjang)
            $table->string('slug')->unique();           // URL mesra (unik)
            $table->boolean('is_published')             // Status terbit
                  ->default(false);
            $table->timestamps();                       // created_at & updated_at
        });
    }

    /**
     * Batal migrasi — padam jadual 'posts'.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
