<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cipta jadual jenis_zakats.
     */
    public function up(): void
    {
        Schema::create('jenis_zakats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('kadar', 8, 4);
            $table->text('penerangan')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Padam jadual jenis_zakats.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_zakats');
    }
};
