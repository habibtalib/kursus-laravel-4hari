<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*
|--------------------------------------------------------------------------
| Model Post — Hari 3
|--------------------------------------------------------------------------
| Cipta model ini dengan arahan:
| php artisan make:model Post -mfs
|
| Salin fail ini ke app/Models/Post.php
|
*/

class Post extends Model
{
    use HasFactory;

    /**
     * Lajur yang boleh diisi secara massal (mass assignment).
     * PENTING: Sentiasa tentukan $fillable untuk keselamatan.
     */
    protected $fillable = [
        'title',
        'body',
        'slug',
        'is_published',
        'user_id',
    ];

    /**
     * Penukaran jenis data (casting).
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    // ============================================
    // HUBUNGAN (Relationships)
    // ============================================

    /**
     * Catatan ini dimiliki oleh seorang pengguna.
     * Post belongsTo User
     *
     * Contoh penggunaan:
     *   $post->user->name  // Dapatkan nama pengarang
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // SKOP (Scopes)
    // ============================================

    /**
     * Skop: Hanya catatan yang telah diterbitkan.
     *
     * Contoh penggunaan:
     *   Post::published()->get()
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Skop: Catatan terbaru dahulu.
     *
     * Contoh penggunaan:
     *   Post::latest()->get()
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
