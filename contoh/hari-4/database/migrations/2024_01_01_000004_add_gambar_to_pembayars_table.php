<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah lajur gambar pada jadual pembayars.
     */
    public function up(): void
    {
        Schema::table('pembayars', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('pendapatan_bulanan');
        });
    }

    /**
     * Buang lajur gambar.
     */
    public function down(): void
    {
        Schema::table('pembayars', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });
    }
};
