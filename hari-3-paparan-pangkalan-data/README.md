# Kursus Laravel 4 Hari
## Hari 3: Paparan dan Pangkalan Data
**Tarikh:** 6 April 2026
**Tahap:** Pemula
**Alat:** Laragon (Windows)

---

## Gambaran Keseluruhan Hari 3

Pada hari ketiga ini, anda akan mempelajari cara memaparkan data kepada pengguna melalui **Blade Template Engine** dan cara menyimpan/mengakses data melalui **Eloquent ORM** dan **Database Migrations**. Anda akan:

- Membuat layout dan halaman menggunakan Blade
- Membuat model dan migrasi untuk jadual Posts
- Menjalankan operasi CRUD lengkap (Create, Read, Update, Delete)
- Mengesahkan data masukan dari pengguna
- Memaparkan ralat pengesahan

**Hasil akhir:** Blog yang berfungsi penuh dengan keupayaan untuk membuat, membaca, mengubah, dan memadamkan catatan blog.

---

## Modul 3.1: Enjin Templat Blade

### Pengenalan Blade

**Blade** adalah enjin templat yang menyertakan Laravel. Ia memudahkan anda untuk:
- Menulis HTML dengan logik PHP yang bersih
- Menggunakan struktur warisan (inheritance) untuk layout
- Menggunakan direktif khusus untuk gelung, syarat, dan lain-lain
- Melindungi dari serangan XSS secara automatik

**Perbezaan penting:**
- `{{ $variable }}` — Mencetak output yang telah dilindungi (diimbangi)
- `{!! $variable !!}` — Mencetak output tanpa perlindungan (HANYA untuk HTML yang dipercayai)

### Struktur Fail Blade

Semua fail Blade disimpan dalam folder `/resources/views/` dan mempunyai sambungan `.blade.php`.

Contoh struktur:
```
resources/
├── views/
│   ├── layouts/
│   │   └── app.blade.php      (Master layout)
│   ├── home.blade.php
│   ├── posts/
│   │   ├── index.blade.php    (Senarai semua post)
│   │   ├── show.blade.php     (Paparan satu post)
│   │   ├── create.blade.php   (Borang cipta post)
│   │   └── edit.blade.php     (Borang edit post)
```

### Direktif Blade Utama

#### 1. @extends dan @section — Warisan Layout

**Master Layout** (`layouts/app.blade.php`):
```blade
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Blog Saya</title>
</head>
<body>
    <nav><!-- Navigasi di sini --></nav>

    <main>
        @yield('content')
    </main>

    <footer>Hakcipta 2026</footer>
</body>
</html>
```

**Child View** (`home.blade.php`):
```blade
@extends('layouts.app')

@section('title', 'Halaman Utama')

@section('content')
    <h1>Selamat Datang di Blog Saya</h1>
    <p>Ini adalah halaman utama.</p>
@endsection
```

#### 2. @include — Sertakan Komponen Semula Guna

Untuk menyertakan satu bahagian kecil dalam pelbagai tempat:

```blade
@include('partials.navbar')
@include('partials.sidebar', ['data' => $data])
```

#### 3. @if, @elseif, @else, @endif — Syarat

```blade
@if ($posts->count() > 0)
    <p>Anda mempunyai {{ $posts->count() }} catatan.</p>
@elseif ($isGuest)
    <p>Sila daftar untuk membuat catatan.</p>
@else
    <p>Tiada catatan ditemui.</p>
@endif
```

#### 4. @foreach, @endforeach — Gelung

```blade
<ul>
    @foreach ($posts as $post)
        <li>{{ $post->title }}</li>
    @endforeach
</ul>
```

Dengan pembolehubah khusus `$loop`:
```blade
@foreach ($posts as $post)
    <li>
        {{ $loop->iteration }}: {{ $post->title }}
        @if ($loop->last)
            <strong>(Akhir senarai)</strong>
        @endif
    </li>
@endforeach
```

#### 5. @csrf — Token Keselamatan

Untuk borang POST, PUT, DELETE:
```blade
<form action="/posts" method="POST">
    @csrf
    <input type="text" name="title">
    <button type="submit">Hantar</button>
</form>
```

#### 6. @error — Papar Ralat Pengesahan

```blade
<input type="email" name="email" value="{{ old('email') }}">
@error('email')
    <span class="error">{{ $message }}</span>
@enderror
```

#### 7. old() — Simpan Nilai Borang

Selepas ralat pengesahan, papar nilai lama:
```blade
<input type="text" name="title" value="{{ old('title') }}">
```

### Melewati Data kepada View

**Di dalam Controller:**
```php
return view('posts.index', [
    'posts' => $posts,
    'userCount' => $userCount
]);
```

**Di dalam Blade:**
```blade
{{ $posts }}
{{ $userCount }}
```

---

## Lab 3.1: Cipta Layout dan Halaman Blade

### Langkah 1: Buat Struktur Folder

Buka terminal di dalam Laragon dan jalankan:
```bash
cd c:/laragon/www/blog
```

Cipta struktur folder untuk views:
```bash
# Jika belum wujud
mkdir resources\views\layouts
mkdir resources\views\posts
```

### Langkah 2: Buat Master Layout

**Fail:** `resources/views/layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Blog Saya</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        nav { background: #333; color: #fff; padding: 1rem; }
        nav a { color: #fff; text-decoration: none; margin-right: 1.5rem; }
        nav a:hover { text-decoration: underline; }
        main { max-width: 900px; margin: 2rem auto; padding: 0 1rem; min-height: 60vh; }
        footer { background: #f4f4f4; text-align: center; padding: 1rem; margin-top: 3rem; }
        .btn { display: inline-block; padding: 0.5rem 1rem; background: #007bff; color: #fff; text-decoration: none; border: none; cursor: pointer; border-radius: 4px; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-warning:hover { background: #ffb300; }
        table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        th, td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; }
        .error { color: #dc3545; font-size: 0.9rem; display: block; margin-top: 0.25rem; }
        .alert { padding: 1rem; margin: 1rem 0; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.25rem; font-weight: bold; }
        input[type="text"], input[type="email"], textarea { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; font-family: Arial; }
        textarea { resize: vertical; }
    </style>
</head>
<body>
    <!-- Navigasi -->
    <nav>
        <a href="/">Blog Saya</a>
        <a href="/posts">Semua Catatan</a>
        <a href="/posts/create">Cipta Catatan Baru</a>
        <a href="/about">Tentang Saya</a>
    </nav>

    <!-- Kandungan Utama -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Blog Saya. Semua hak terpelihara.</p>
    </footer>
</body>
</html>
```

### Langkah 3: Buat Halaman Utama (Home)

**Fail:** `resources/views/home.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Halaman Utama')

@section('content')
    <h1>Selamat Datang ke Blog Saya</h1>
    <p>Ini adalah blog peribadi saya di mana saya berkongsi pemikiran dan pengalaman.</p>

    <h2>Catatan Terbaru</h2>
    @if (isset($posts) && $posts->count() > 0)
        <ul>
            @foreach ($posts->take(5) as $post)
                <li>
                    <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                    <small>({{ $post->created_at->format('d M Y') }})</small>
                </li>
            @endforeach
        </ul>
        <p><a href="/posts" class="btn">Lihat Semua Catatan</a></p>
    @else
        <p>Tiada catatan ditemui. <a href="/posts/create">Mulakan dengan membuat satu!</a></p>
    @endif
@endsection
```

### Langkah 4: Buat Halaman About

**Fail:** `resources/views/about.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Tentang Saya')

@section('content')
    <h1>Tentang Saya</h1>
    <p>Nama saya Amin dan saya adalah seorang pembangun web yang bersemangat.</p>
    <p>Blog ini dibina menggunakan Laravel sebagai latihan pembelajaran saya.</p>

    <h2>Kemahiran</h2>
    <ul>
        <li>PHP dan Laravel</li>
        <li>MySQL dan Database Design</li>
        <li>HTML, CSS, dan JavaScript</li>
    </ul>
@endsection
```

### Langkah 5: Buat Halaman Senarai Catatan (Posts Index)

**Fail:** `resources/views/posts/index.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Semua Catatan')

@section('content')
    <h1>Semua Catatan Blog</h1>
    <p><a href="/posts/create" class="btn">+ Cipta Catatan Baru</a></p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($posts->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Tajuk</th>
                    <th>Pengarang</th>
                    <th>Tarikh</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->user ? $post->user->name : 'Tidak Diketahui' }}</td>
                        <td>{{ $post->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="/posts/{{ $post->id }}" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.9rem;">Lihat</a>
                            <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning" style="padding: 0.25rem 0.5rem; font-size: 0.9rem;">Edit</a>
                            <form action="/posts/{{ $post->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.9rem;" onclick="return confirm('Anda pasti?')">Padam</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tiada catatan ditemui. <a href="/posts/create">Cipta satu sekarang!</a></p>
    @endif
@endsection
```

### Langkah 6: Buat Halaman Paparan Catatan Tunggal (Posts Show)

**Fail:** `resources/views/posts/show.blade.php`

```blade
@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article>
        <h1>{{ $post->title }}</h1>
        <small>Oleh: {{ $post->user ? $post->user->name : 'Tidak Diketahui' }} | {{ $post->created_at->format('d M Y') }}</small>

        <hr style="margin: 1rem 0;">

        <div>
            {!! $post->body !!}
        </div>

        <hr style="margin: 1rem 0;">

        <div>
            <a href="/posts" class="btn">← Kembali ke Senarai</a>
            <a href="/posts/{{ $post->id }}/edit" class="btn btn-warning">Edit Catatan</a>
            <form action="/posts/{{ $post->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Anda pasti ingin memadamkan catatan ini?')">Padam Catatan</button>
            </form>
        </div>
    </article>
@endsection
```

### Langkah 7: Buat Borang Cipta Catatan

**Fail:** `resources/views/posts/create.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Cipta Catatan Baru')

@section('content')
    <h1>Cipta Catatan Blog Baru</h1>

    <form action="/posts" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Tajuk:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="body">Kandungan:</label>
            <textarea id="body" name="body" rows="10" required>{{ old('body') }}</textarea>
            @error('body')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">Simpan Catatan</button>
        <a href="/posts" class="btn" style="background: #6c757d;">Batal</a>
    </form>
@endsection
```

### Langkah 8: Buat Borang Edit Catatan

**Fail:** `resources/views/posts/edit.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Edit Catatan')

@section('content')
    <h1>Edit Catatan: {{ $post->title }}</h1>

    <form action="/posts/{{ $post->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Tajuk:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="body">Kandungan:</label>
            <textarea id="body" name="body" rows="10" required>{{ old('body', $post->body) }}</textarea>
            @error('body')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">Simpan Perubahan</button>
        <a href="/posts/{{ $post->id }}" class="btn" style="background: #6c757d;">Batal</a>
    </form>
@endsection
```

### Ujian Output Blade

Sekarang kami akan mencipta controller dan route untuk menguji blade ini. Lihat Modul 3.3 dan Lab 3.3 di bawah.

---

## Modul 3.2: Eloquent ORM

### Apakah ORM?

**ORM** (Object-Relational Mapping) membenarkan anda berinteraksi dengan pangkalan data menggunakan objek PHP daripada menulis SQL mentah.

**Tanpa ORM (SQL mentah):**
```php
$result = DB::select('SELECT * FROM posts WHERE id = ?', [1]);
```

**Dengan Eloquent ORM:**
```php
$post = Post::find(1);
```

### Membuat Model

Model mewakili jadual dalam pangkalan data. Untuk mencipta model `Post`:

```bash
php artisan make:model Post
```

Ini mencipta fail: `app/Models/Post.php`

### Konvensyen Model

- **Nama Model:** Singular, PascalCase (cth: `Post`, `User`, `Comment`)
- **Jadual Pangkalan Data:** Plural, snake_case (cth: `posts`, `users`, `comments`)
- Laravel secara automatik meneka nama jadual dari nama model

**Jika nama jadual berbeza, nyatakan dalam model:**
```php
class Post extends Model
{
    protected $table = 'blog_posts';  // Jadual sesuai
}
```

### Atribut Model Penting

#### Mass Assignment dengan $fillable

Untuk membenarkan medan diisi semasa mencipta/mengemas kini:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id'];
}
```

**Dengan $fillable:**
```php
Post::create([
    'title' => 'Tajuk Saya',
    'body' => 'Kandungan saya',
    'user_id' => 1
]);
```

**Tanpa $fillable (akan gagal):**
```php
Post::create([...]);  // Ralat: Mass assignment disabled
```

#### Timestamp Automatik

Secara default, Eloquent menambah kolom `created_at` dan `updated_at`:

```php
$post->created_at;  // Tarikh cipta
$post->updated_at;  // Tarikh ubah terakhir
```

Untuk melumpuhkannya:
```php
public $timestamps = false;
```

### Hubungan Dasar

#### hasMany — Satu kepada Banyak

Seorang pengguna mempunyai banyak catatan:

```php
// app/Models/User.php
public function posts()
{
    return $this->hasMany(Post::class);
}
```

Gunakan:
```php
$user = User::find(1);
$posts = $user->posts;  // Semua catatan pengguna
```

#### belongsTo — Banyak kepada Satu

Satu catatan dimiliki oleh seorang pengguna:

```php
// app/Models/Post.php
public function user()
{
    return $this->belongsTo(User::class);
}
```

Gunakan:
```php
$post = Post::find(1);
$author = $post->user;  // Pengarang catatan
```

---

## Lab 3.2: Model, Migrasi dan Seeder

### Langkah 1: Buat Model Post dengan Migrasi

```bash
php artisan make:model Post -m
```

Ini mencipta:
- `app/Models/Post.php`
- `database/migrations/XXXX_XX_XX_XXXXXX_create_posts_table.php`

### Langkah 2: Takrifkan Migrasi

**Fail:** `database/migrations/XXXX_XX_XX_XXXXXX_create_posts_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();  // id (primary key)
            $table->string('title');  // Tajuk (sehingga 255 aksara)
            $table->text('body');  // Kandungan (teks panjang)
            $table->unsignedBigInteger('user_id')->nullable();  // ID Pengguna
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');  // Padam catatan jika pengguna dipadamkan
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

**Penjelasan:**
- `$table->id()` — Kolom ID auto-increment (primary key)
- `$table->string('title')` — Kolom teks pendek (sehingga 255 aksara)
- `$table->text('body')` — Kolom teks panjang
- `$table->unsignedBigInteger('user_id')` — Kolom integer untuk ID pengguna
- `$table->foreign('user_id')` — Kunci terpencil ke jadual users
- `$table->timestamps()` — Menambah `created_at` dan `updated_at` automatik

### Langkah 3: Takrifkan Model Post

**Fail:** `app/Models/Post.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * Dapatkan pengguna yang memiliki catatan ini
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

Pastikan juga User model mempunyai hubungan:

**Fail:** `app/Models/User.php` (tambah bahagian ini jika belum ada):

```php
/**
 * Dapatkan semua catatan pengguna
 */
public function posts()
{
    return $this->hasMany(Post::class);
}
```

### Langkah 4: Jalankan Migrasi

```bash
php artisan migrate
```

**Output yang dijangka:**
```
Migrating: XXXX_XX_XX_XXXXXX_create_posts_table
Migrated:  XXXX_XX_XX_XXXXXX_create_posts_table (XXms)
```

Periksa pangkalan data menggunakan Laragon atau MySQL Workbench untuk mengesahkan jadual `posts` telah diwujudkan dengan kolom yang betul.

### Langkah 5: Buat Factory untuk Post (Untuk Data Ujian)

```bash
php artisan make:factory PostFactory
```

**Fail:** `database/factories/PostFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),  // Jengka ayat palsu
            'body' => fake()->paragraphs(3, true),  // Beberapa perenggan
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),  // ID pengguna rawak
        ];
    }
}
```

### Langkah 6: Buat Seeder untuk Post

```bash
php artisan make:seeder PostSeeder
```

**Fail:** `database/seeders/PostSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada sekurang-kurangnya seorang pengguna
        $user = User::first();

        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Amin',
                'email' => 'amin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Cipta 10 catatan dengan factory
        Post::factory(10)->create([
            'user_id' => $user->id,
        ]);
    }
}
```

### Langkah 7: Daftar Seeder

**Fail:** `database/seeders/DatabaseSeeder.php`

Pastikan PostSeeder dipanggil:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil seeder
        $this->call([
            PostSeeder::class,
        ]);
    }
}
```

### Langkah 8: Jalankan Seeder untuk Memasukkan Data

```bash
php artisan db:seed
```

**Output yang dijangka:**
```
Seeding: Database\Seeders\DatabaseSeeder
Seeding: Database\Seeders\PostSeeder
Seeded:  Database\Seeders\DatabaseSeeder (XXXms)
```

Periksa jadual `posts` untuk memastikan 10 catatan telah ditambah.

---

## Modul 3.3: Migrasi Pangkalan Data

### Perintah Migrasi Asas

#### Jalankan Semua Migrasi

```bash
php artisan migrate
```

Menjalankan semua migrasi yang belum dijalankan.

#### Batal (Rollback) Migrasi Terakhir

```bash
php artisan migrate:rollback
```

Menjalankan kaedah `down()` migrasi terbaharu.

#### Batal Semua Migrasi

```bash
php artisan migrate:rollback --step=999
```

Atau:

```bash
php artisan migrate:reset
```

#### Segarkan Pangkalan Data (Batal + Jalankan Semula)

```bash
php artisan migrate:refresh
```

Ini memadamkan semua jadual dan menjalankan semua migrasi dari awal.

Untuk menyemai semasa menyegarkan:

```bash
php artisan migrate:refresh --seed
```

### Menambah Kolom Baru kepada Jadual Sedia Ada

Buat migrasi baru:

```bash
php artisan make:migration add_description_to_posts_table
```

**Fail:** `database/migrations/XXXX_XX_XX_XXXXXX_add_description_to_posts_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('description')->nullable()->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
```

Kemudian jalankan:

```bash
php artisan migrate
```

### Meubah Kolom Sedia Ada

Pertama, pasang paket `doctrine/dbal`:

```bash
composer require doctrine/dbal
```

Kemudian buat migrasi:

```bash
php artisan make:migration change_body_column_in_posts_table
```

```php
public function up(): void
{
    Schema::table('posts', function (Blueprint $table) {
        $table->longText('body')->change();  // Ubah dari text kepada longText
    });
}

public function down(): void
{
    Schema::table('posts', function (Blueprint $table) {
        $table->text('body')->change();
    });
}
```

### Kunci Terpencil (Foreign Keys)

Untuk menjaga integriti data:

```php
$table->foreign('user_id')
      ->references('id')
      ->on('users')
      ->onDelete('cascade')  // Padam post jika user dipadamkan
      ->onUpdate('cascade');  // Ubah post jika user ID diubah
```

---

## Lab 3.3: Operasi CRUD dengan Eloquent

Sekarang kami akan membuat Controller untuk mengendalikan CRUD lengkap.

### Langkah 1: Buat PostController

```bash
php artisan make:controller PostController --resource
```

Ini mencipta `app/Http/Controllers/PostController.php` dengan kaedah template untuk CRUD.

### Langkah 2: Takrifkan PostController

**Fail:** `app/Http/Controllers/PostController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Paparkan senarai semua catatan
     */
    public function index()
    {
        $posts = Post::latest()->get();  // Ambil semua, urutkan terbaru dahulu
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Paparkan borang untuk mencipta catatan baru
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Simpan catatan baru ke pangkalan data
     */
    public function store(Request $request)
    {
        // Validasikan masukan
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:10',
        ]);

        // Cipta catatan
        $post = Post::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => auth()->id() ?? 1,  // Guna pengguna yang log masuk, atau ID 1
        ]);

        return redirect('/posts/' . $post->id)
                   ->with('success', 'Catatan telah dibuat!');
    }

    /**
     * Paparkan satu catatan
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Paparkan borang untuk mengubah catatan
     */
    public function edit(Post $post)
    {
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Simpan perubahan catatan
     */
    public function update(Request $request, Post $post)
    {
        // Validasikan masukan
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:10',
        ]);

        // Kemaskini catatan
        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return redirect('/posts/' . $post->id)
                   ->with('success', 'Catatan telah dikemaskini!');
    }

    /**
     * Padamkan catatan
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/posts')
                   ->with('success', 'Catatan telah dipadamkan!');
    }
}
```

### Langkah 3: Takrifkan Route Resource

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    $posts = \App\Models\Post::latest()->limit(5)->get();
    return view('home', ['posts' => $posts]);
});

Route::get('/about', function () {
    return view('about');
});

// Route Resource untuk CRUD Post
Route::resource('posts', PostController::class);
```

### Langkah 4: Ujian CRUD

Buka browser Laragon dan pergi ke:

**1. Senarai Catatan (Read):**
```
http://blog.test/posts
```

**Output yang dijangka:**
- Jadual dengan semua catatan
- Butang "Edit" dan "Padam" untuk setiap catatan
- Butang "+ Cipta Catatan Baru"

**2. Cipta Catatan (Create):**
```
http://blog.test/posts/create
```

**Output yang dijangka:**
- Borang dengan medan "Tajuk" dan "Kandungan"
- Butang "Simpan Catatan"

Isikan:
```
Tajuk: Catatan Pertama Saya
Kandungan: Ini adalah catatan pertama saya menggunakan Laravel. Saya sangat teruja untuk mempelajari framework yang berkuasa ini!
```

Klik "Simpan Catatan" → Anda akan diarahkan ke halaman catatan dengan mesej "Catatan telah dibuat!"

**3. Paparan Catatan Tunggal (Show):**
```
http://blog.test/posts/1
```

**Output yang dijangka:**
- Tajuk dan kandungan catatan
- Tarikh cipta
- Butang "Edit" dan "Padam"

**4. Edit Catatan (Update):**
Dari halaman catatan, klik "Edit Catatan".

Ubah tajuk menjadi "Catatan Pertama Saya - Dikemaskini" dan simpan.

**Output yang dijangka:**
- Halaman catatan menunjukkan tajuk yang baru
- Mesej "Catatan telah dikemaskini!"

**5. Padam Catatan (Delete):**
Dari halaman catatan, klik "Padam Catatan".

Dialog akan muncul meminta pengesahan.

**Output yang dijangka:**
- Anda akan diarahkan kembali ke senarai catatan
- Catatan tidak lagi ada dalam senarai
- Mesej "Catatan telah dipadamkan!"

### Ujian Cepat di Tinker

Anda juga boleh menguji model menggunakan Tinker:

```bash
php artisan tinker
```

Dalam Tinker:
```php
# Cipta catatan
$post = Post::create(['title' => 'Test', 'body' => 'Test body', 'user_id' => 1]);

# Baca semua catatan
Post::all();

# Cari catatan dengan ID 1
Post::find(1);

# Kemaskini
$post = Post::find(1);
$post->update(['title' => 'Updated']);

# Padam
Post::find(1)->delete();

# Keluar
exit
```

---

## Modul 3.4: Pengesahan Data (Validation)

### Mengapa Pengesahan Penting?

- Melindungi dari data tidak sah atau berbahaya
- Memastikan kualiti data dalam pangkalan data
- Memberikan maklum balas kepada pengguna tentang ralat

### Kaedah Pengesahan

#### Pengesahan dalam Controller

Guna `$request->validate()`:

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|min:3|max:255',
        'body' => 'required|string|min:10',
        'email' => 'required|email|unique:users',
    ]);

    // Jika sampai di sini, semua data sah
    Post::create($validated);
}
```

Jika pengesahan gagal:
- Laravel secara automatik mengubah semula ke halaman sebelumnya
- Ralat disimpan dalam `$errors`
- Nilai masukan lama disimpan (boleh diakses dengan `old()`)

### Peraturan Pengesahan Asas

| Peraturan | Penjelasan | Contoh |
|-----------|-----------|---------|
| `required` | Medan mesti ada | `'title' => 'required'` |
| `string` | Mesti teks | `'name' => 'string'` |
| `email` | Format e-mel sah | `'email' => 'email'` |
| `min:X` | Panjang minimum | `'password' => 'min:8'` |
| `max:X` | Panjang maksimum | `'title' => 'max:255'` |
| `unique:table` | Nilai unik dalam jadual | `'email' => 'unique:users'` |
| `unique:table,column` | Unik di kolom tertentu | `'username' => 'unique:users,username'` |
| `confirmed` | Medan pengesahan | `'password' => 'confirmed'` (perlu `password_confirmation`) |
| `numeric` | Mesti nombor | `'age' => 'numeric'` |
| `integer` | Mesti integer | `'count' => 'integer'` |
| `in:X,Y,Z` | Dalam senarai pilihan | `'status' => 'in:active,inactive'` |
| `regex:/pattern/` | Corak regex | `'phone' => 'regex:/^[0-9]{10}$/'` |

### Menggunakan Direktif @error dalam Blade

```blade
<div class="form-group">
    <label for="title">Tajuk:</label>
    <input type="text" name="title" value="{{ old('title') }}">
    @error('title')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
```

Jika pengesahan gagal pada medan `title`, mesej ralat akan dipaparkan.

### Pesan Ralat Khusus

```php
$request->validate([
    'title' => 'required|min:3',
], [
    'title.required' => 'Tajuk tidak boleh kosong.',
    'title.min' => 'Tajuk mesti mengandungi sekurang-kurangnya 3 aksara.',
]);
```

---

## Lab 3.4: Borang dengan Pengesahan

### Langkah 1: Kemas Kini PostController dengan Pengesahan

Kami telah mengubah PostController di Lab 3.3, tetapi marilah kami pastikan pengesahan lengkap:

**Fail:** `app/Http/Controllers/PostController.php` (Kaedah store dan update)

```php
/**
 * Simpan catatan baru ke pangkalan data
 */
public function store(Request $request)
{
    // Validasikan masukan dengan pesan khusus
    $validated = $request->validate(
        [
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:10|max:5000',
        ],
        [
            'title.required' => 'Tajuk tidak boleh kosong.',
            'title.min' => 'Tajuk mesti mengandungi sekurang-kurangnya 3 aksara.',
            'title.max' => 'Tajuk tidak boleh melebihi 255 aksara.',
            'body.required' => 'Kandungan tidak boleh kosong.',
            'body.min' => 'Kandungan mesti mengandungi sekurang-kurangnya 10 aksara.',
            'body.max' => 'Kandungan tidak boleh melebihi 5000 aksara.',
        ]
    );

    // Cipta catatan
    $post = Post::create([
        'title' => $validated['title'],
        'body' => $validated['body'],
        'user_id' => auth()->id() ?? 1,
    ]);

    return redirect('/posts/' . $post->id)
               ->with('success', 'Catatan telah dibuat!');
}

/**
 * Simpan perubahan catatan
 */
public function update(Request $request, Post $post)
{
    // Validasikan masukan
    $validated = $request->validate(
        [
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:10|max:5000',
        ],
        [
            'title.required' => 'Tajuk tidak boleh kosong.',
            'title.min' => 'Tajuk mesti mengandungi sekurang-kurangnya 3 aksara.',
            'title.max' => 'Tajuk tidak boleh melebihi 255 aksara.',
            'body.required' => 'Kandungan tidak boleh kosong.',
            'body.min' => 'Kandungan mesti mengandungi sekurang-kurangnya 10 aksara.',
            'body.max' => 'Kandungan tidak boleh melebihi 5000 aksara.',
        ]
    );

    // Kemaskini catatan
    $post->update([
        'title' => $validated['title'],
        'body' => $validated['body'],
    ]);

    return redirect('/posts/' . $post->id)
               ->with('success', 'Catatan telah dikemaskini!');
}
```

### Langkah 2: Kemaskini Borang Cipta dengan Paparan Ralat

**Fail:** `resources/views/posts/create.blade.php` (Versi Lengkap)

```blade
@extends('layouts.app')

@section('title', 'Cipta Catatan Baru')

@section('content')
    <h1>Cipta Catatan Blog Baru</h1>

    @if ($errors->any())
        <div class="alert" style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            <strong>Terdapat ralat dalam borang:</strong>
            <ul style="margin: 0.5rem 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/posts" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Tajuk:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="body">Kandungan (Min 10 aksara, Maks 5000 aksara):</label>
            <textarea id="body" name="body" rows="10" required>{{ old('body') }}</textarea>
            @error('body')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">Simpan Catatan</button>
        <a href="/posts" class="btn" style="background: #6c757d;">Batal</a>
    </form>
@endsection
```

### Langkah 3: Kemaskini Borang Edit

**Fail:** `resources/views/posts/edit.blade.php` (Versi Lengkap)

```blade
@extends('layouts.app')

@section('title', 'Edit Catatan')

@section('content')
    <h1>Edit Catatan: {{ $post->title }}</h1>

    @if ($errors->any())
        <div class="alert" style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            <strong>Terdapat ralat dalam borang:</strong>
            <ul style="margin: 0.5rem 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/posts/{{ $post->id }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Tajuk:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            @error('title')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="body">Kandungan (Min 10 aksara, Maks 5000 aksara):</label>
            <textarea id="body" name="body" rows="10" required>{{ old('body', $post->body) }}</textarea>
            @error('body')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn">Simpan Perubahan</button>
        <a href="/posts/{{ $post->id }}" class="btn" style="background: #6c757d;">Batal</a>
    </form>
@endsection
```

### Langkah 4: Ujian Pengesahan

Pergi ke halaman cipta: `http://blog.test/posts/create`

**Ujian 1: Tajuk Kosong**
- Biarkan medan "Tajuk" kosong
- Klik "Simpan Catatan"
- **Output yang dijangka:** Mesej ralat "Tajuk tidak boleh kosong." akan dipaparkan

**Ujian 2: Tajuk Terlalu Pendek**
- Masukkan tajuk "AB" (kurang dari 3 aksara)
- Kandungan "1234567890" (tepat 10 aksara)
- Klik "Simpan Catatan"
- **Output yang dijangka:** Mesej ralat "Tajuk mesti mengandungi sekurang-kurangnya 3 aksara." akan dipaparkan

**Ujian 3: Kandungan Terlalu Pendek**
- Masukkan tajuk "Tajuk Saya"
- Kandungan "Pendek" (kurang dari 10 aksara)
- Klik "Simpan Catatan"
- **Output yang dijangka:** Mesej ralat "Kandungan mesti mengandungi sekurang-kurangnya 10 aksara." akan dipaparkan

**Ujian 4: Semua Data Sah**
- Masukkan tajuk "Catatan Kedua Saya"
- Kandungan "Ini adalah catatan kedua saya yang mengikuti pengesahan yang betul."
- Klik "Simpan Catatan"
- **Output yang dijangka:**
  - Catatan berjaya disimpan
  - Anda akan dialihkan ke halaman paparan catatan
  - Mesej "Catatan telah dibuat!" akan dipaparkan

### Langkah 5: Ujian Edit dengan Pengesahan

Pergi ke senarai catatan: `http://blog.test/posts`

Klik "Edit" pada salah satu catatan.

**Ujian:** Kosongkan medan tajuk dan klik "Simpan Perubahan"

**Output yang dijangka:** Mesej ralat akan dipaparkan dan data lama akan diingat (gunakan `old()`).

---

## Penyelesaian Masalah (Troubleshooting)

### Masalah 1: "Blade Directive Unknown"

**Simptom:** Error mengatakan `@yield` tidak dikenali.

**Penyebab:** Fail tidak mempunyai sambungan `.blade.php`.

**Penyelesaian:**
```bash
# Nama fail mesti .blade.php
# ✓ Betul: home.blade.php
# ✗ Salah: home.php
```

### Masalah 2: "Mass Assignment Exception"

**Simptom:** Error ketika `Post::create([...])` mengatakan "Mass assignment disabled".

**Penyebab:** Model tidak mempunyai `$fillable` atau `$guarded`.

**Penyelesaian:**
```php
// Dalam app/Models/Post.php
protected $fillable = ['title', 'body', 'user_id'];
```

### Masalah 3: "SQLSTATE[23000]: Integrity Constraint Violation"

**Simptom:** Error semasa menyimpan catatan: "Cannot add or update a child row".

**Penyebab:** `user_id` yang dirujuk tidak wujud dalam jadual `users`.

**Penyelesaian:**
```bash
# Pastikan ada pengguna dengan ID 1
php artisan tinker
> User::first();  # Jika kosong, buat pengguna
> User::create(['name' => 'Amin', 'email' => 'amin@example.com', 'password' => bcrypt('password')])
```

Atau ubah Controller:
```php
'user_id' => User::first()?->id ?? 1,
```

### Masalah 4: "No query results found"

**Simptom:** Error ketika mengakses `/posts/99` (ID tidak wujud).

**Penyebab:** Model Route Binding tidak menemui catatan.

**Penyelesaian:** Periksa route:
```php
Route::resource('posts', PostController::class);
```

Laravel secara automatik menggunakan Route Model Binding untuk parameter `Post $post`.

Jika catatan tidak wujud, akan berpulang 404 (yang betul).

### Masalah 5: "View not found"

**Simptom:** Error "View [posts.create] not found".

**Penyebab:** Fail tidak disimpan di lokasi yang betul atau dengan nama yang betul.

**Penyelesaian:**
```bash
# Nama fail mesti betul:
# ✓ resources/views/posts/create.blade.php
# ✗ resources/views/posts/createPost.blade.php (nama berbeza)

# Atau dalam controller:
return view('posts.create');  # Cari posts/create.blade.php
```

### Masalah 6: Pengesahan tidak berfungsi

**Simptom:** Borang tidak menunjukkan ralat pengesahan.

**Penyebab:** Mungkin middleware tidak menjejak ralat, atau Blade tidak memaparkannya.

**Penyelesaian:**
```blade
<!-- Pastikan blade menggunakan @error dan old() -->
@error('title')
    <span class="error">{{ $message }}</span>
@enderror

<input value="{{ old('title') }}">
```

Dan controller:
```php
$validated = $request->validate([
    'title' => 'required|min:3',
]);
```

### Masalah 7: Migrasi gagal semasa running

**Simptom:** Error SQL semasa menjalankan `php artisan migrate`.

**Penyelesaian:**
```bash
# Semak ralat secara terperinci
php artisan migrate --verbose

# Batal migrasi
php artisan migrate:rollback

# Bersihkan dan jalankan semula
php artisan migrate:refresh
```

---

## Ringkasan Hari 3

| Topik | Pembelajaran Utama |
|-------|---------------------|
| **Blade Templat** | @extends, @section, @yield, @include, @if, @foreach, @error, {{ }} vs {!! !!} |
| **Model & ORM** | Membuat model, mass assignment ($fillable), hubungan (hasMany, belongsTo) |
| **Migrasi** | Membuat jadual, menambah kolom, kunci terpencil, rollback |
| **CRUD** | Create (form + store), Read (index + show), Update (edit + update), Delete (destroy) |
| **Pengesahan** | Peraturan asas, pesan ralat, paparang dalam Blade, maklum balas kepada pengguna |

---

## Persediaan untuk Hari 4

Pada Hari 4 (Autentikasi dan Kebolehan), kami akan mempelajari:

- **Autentikasi Pengguna** — Pendaftaran, log masuk, log keluar
- **Otorisasi** — Memastikan hanya pengarang boleh mengubah/memadamkan catatan mereka
- **Middleware** — Melindungi route dari akses tanpa kebenaran
- **Polisi** — Logik otorisasi yang kompleks

Persiapan:
1. Pastikan blog anda berfungsi penuh dengan CRUD
2. Buat beberapa catatan untuk pengujian Hari 4
3. Ketahui cara mengakses `auth()->user()` dalam Controller

---

## Rujukan Pantas

### Perintah Asas

```bash
# Model & Migrasi
php artisan make:model Post -m
php artisan make:model Post -mfc  # model, migration, factory, controller

# Controller
php artisan make:controller PostController --resource

# Migrasi
php artisan migrate
php artisan migrate:rollback
php artisan migrate:refresh
php artisan migrate:refresh --seed

# Factory & Seeder
php artisan make:factory PostFactory
php artisan make:seeder PostSeeder
php artisan db:seed

# Tinker
php artisan tinker
```

### Kaedah Eloquent Asas

```php
// Cipta
Post::create(['title' => '...', 'body' => '...']);

// Baca
Post::all();
Post::find(1);
Post::where('title', 'Tajuk')->first();

// Kemaskini
$post = Post::find(1);
$post->update(['title' => '...']);

// Padam
Post::find(1)->delete();
$post->delete();

// Hubungan
$post->user;
$user->posts;
```

### Validasi Asas

```php
$request->validate([
    'title' => 'required|string|min:3|max:255',
    'body' => 'required|string|min:10',
    'email' => 'required|email|unique:users',
]);
```

---

## Penutup

Selepas melengkapkan Hari 3, anda akan mempunyai:
- ✓ Pemahaman mendalam tentang Blade Template Engine
- ✓ Keupayaan untuk membuat model dan migrasi
- ✓ Operasi CRUD lengkap yang berfungsi
- ✓ Pengesahan data yang mantap

Blog anda kini siap untuk menambah autentikasi dan otorisasi pada Hari 4!

---

**Selamat belajar! Semoga anda mempunyai hari yang produktif pada Hari 3.** 🎉
