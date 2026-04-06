# Hari 2: Penghalaan (Routing) dan Pengawal (Controllers)

**Kursus Laravel 4 Hari | Peringkat Pemula | Laragon pada Windows**

---

## Pengenalan

Pada Hari 2, kami akan mempelajari dua konsep asas dalam Laravel: **Penghalaan (Routing)** dan **Pengawal (Controllers)**. Penghalaan menentukan bagaimana permintaan pengguna dipetakan ke aplikasi, sementara Pengawal mengendalikan logik perniagaan untuk merespons permintaan tersebut.

**Tujuan Pembelajaran:**
- Memahami sistem penghalaan dalam Laravel
- Membuat pelbagai jenis laluan (routes)
- Membuat pengawal untuk mengendalikan permintaan
- Memahami middleware dan cara kerjanya
- Mengendalikan permintaan (request) dan respons (response)
- Melaksanakan operasi CRUD yang lengkap

**Prasyarat:**
- Projek `blog` telah dibuat pada Hari 1
- Laragon berjalan dengan sempurna
- Pemahaman asas tentang PHP dan Laravel

---

## Modul 2.1: Asas Penghalaan (Routing)

### Pengenalan Penghalaan

Penghalaan adalah proses mencocokkan URL permintaan dengan fungsi atau pengawal yang sepatutnya mengendalikan permintaan tersebut. Semua laluan dalam Laravel ditakrifkan dalam fail `routes/web.php`.

**Mengapa Penghalaan Penting?**
- Menentukan struktur URL aplikasi
- Memisahkan logik aplikasi dari URL
- Memudahkan pengurusan permintaan HTTP
- Membolehkan parameter dinamik dalam URL

### Fail Laluan Utama

```
blog/
├── routes/
│   ├── web.php          ← Laluan web (yang kami gunakan)
│   ├── api.php          ← Laluan API
│   └── console.php      ← Perintah console
└── ...
```

### Struktur Asas Laluan

Laluan dalam Laravel mengikuti format:

```php
Route::METHOD(path, callback_atau_controller);
```

**METHOD** boleh menjadi:
- `get` - Dapatkan data
- `post` - Hantar data
- `put` - Kemas kini keseluruhan data
- `patch` - Kemas kini sebahagian data
- `delete` - Hapus data
- `any` - Menerima semua jenis permintaan

### 1. Laluan Asas dengan Closure

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;

// Laluan GET asas yang mengembalikan string
Route::get('/', function () {
    return 'Selamat datang ke Blog!';
});

// Laluan POST untuk menerima data
Route::post('/submit', function () {
    return 'Data telah diterima!';
});

// Laluan DELETE
Route::delete('/item/{id}', function ($id) {
    return "Item dengan ID $id telah dihapus!";
});
```

**Ujian Dalam Terminal:**
```bash
# Buka CMD atau PowerShell dalam folder blog
cd C:\laragon\www\blog

# Jalankan pelayan penyelaras Laravel
php artisan serve

# Output dijangka:
# Laravel development server started: http://127.0.0.1:8000
```

**Ujian Dalam Pelayar:**
- Buka `http://127.0.0.1:8000` - Anda akan melihat "Selamat datang ke Blog!"

### 2. Laluan Dengan Parameter

Parameter membenarkan nilai dinamik dalam URL.

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;

// Parameter wajib
Route::get('/posts/{id}', function ($id) {
    return "Paparan jawatan dengan ID: $id";
});

// Parameter berbilang
Route::get('/users/{user}/posts/{post}', function ($user, $post) {
    return "Pengguna $user, Jawatan $post";
});

// Parameter pilihan dengan tanda soal
Route::get('/search/{query?}', function ($query = null) {
    if ($query) {
        return "Hasil carian untuk: $query";
    }
    return "Sila masukkan kata kunci carian";
});

// Kekangan parameter dengan regex
Route::get('/articles/{id}', function ($id) {
    return "Artikel $id";
})->where('id', '[0-9]+');  // Hanya nombor
```

**Ujian:**
```
http://127.0.0.1:8000/posts/5
→ Paparan jawatan dengan ID: 5

http://127.0.0.1:8000/users/ali/posts/10
→ Pengguna ali, Jawatan 10

http://127.0.0.1:8000/search/laravel
→ Hasil carian untuk: laravel

http://127.0.0.1:8000/articles/123
→ Artikel 123

http://127.0.0.1:8000/articles/abc
→ 404 Not Found (kerana tidak sepadan dengan [0-9]+)
```

### 3. Laluan Bernama (Named Routes)

Laluan bernama memudahkan anda merujuk laluan dalam kod tanpa menulis URL secara terus.

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;

// Laluan bernama
Route::get('/', function () {
    return 'Laman Utama';
})->name('home');

Route::get('/about', function () {
    return 'Tentang Kami';
})->name('about');

Route::get('/posts/{id}', function ($id) {
    return "Jawatan $id";
})->name('posts.show');

Route::get('/contact', function () {
    return 'Hubungi Kami';
})->name('contact');
```

**Menggunakan Laluan Bernama dalam Kod:**

```php
// Dalam controller atau view
url('home')                    // → /
route('about')                 // → /about
route('posts.show', ['id' => 5])  // → /posts/5

// Untuk membuat pautan dalam HTML
<a href="{{ route('home') }}">Laman Utama</a>
<a href="{{ route('posts.show', ['id' => 5]) }}">Baca Jawatan 5</a>
```

**Melihat Semua Laluan:**

```bash
# Dalam terminal
php artisan route:list

# Output dijangka:
# +-------+----------+------+-------------+
# | GET   | /        |      | home        |
# | GET   | /about   |      | about       |
# | GET   | /posts/{id}|   | posts.show  |
# | GET   | /contact |      | contact     |
# +-------+----------+------+-------------+
```

### 4. Kumpulan Laluan (Route Groups)

Kumpulan laluan memudahkan anda menggunakan awalan biasa, middleware, atau namespace untuk berbilang laluan.

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;

// Kumpulan dengan awalan
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return 'Papan Pemuka Admin';
    })->name('admin.dashboard');

    Route::get('/users', function () {
        return 'Senarai Pengguna';
    })->name('admin.users');

    Route::post('/users', function () {
        return 'Pengguna baru dibuat';
    })->name('admin.users.store');
});

// Kumpulan dengan middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return 'Profil Pengguna';
    });

    Route::get('/settings', function () {
        return 'Tetapan Pengguna';
    });
});

// Kumpulan gabungan
Route::prefix('api')
    ->middleware('api')
    ->group(function () {
        Route::get('/posts', function () {
            return json_encode(['posts' => []]);
        });
    });
```

**Laluan yang Dihasilkan:**

```
/admin/dashboard
/admin/users (GET)
/admin/users (POST)
/profile
/settings
/api/posts
```

### 5. Kaedah Laluan HTTP

Laravel menyokong semua kaedah HTTP utama:

```php
<?php

use Illuminate\Support\Facades\Route;

// GET - Dapatkan data
Route::get('/posts', function () {
    return 'Senarai semua jawatan';
});

// POST - Buat data baru
Route::post('/posts', function () {
    return 'Jawatan baru telah dibuat';
});

// PUT - Kemas kini seluruh sumber
Route::put('/posts/{id}', function ($id) {
    return "Jawatan $id telah dikemas kini sepenuhnya";
});

// PATCH - Kemas kini sebahagian sumber
Route::patch('/posts/{id}', function ($id) {
    return "Jawatan $id telah dikemas kini sebahagian";
});

// DELETE - Hapus sumber
Route::delete('/posts/{id}', function ($id) {
    return "Jawatan $id telah dihapus";
});

// Menerima berbilang kaedah
Route::match(['get', 'post'], '/search', function () {
    return 'Carian';
});

// Menerima semua kaedah
Route::any('/test', function () {
    return 'Mencapai dengan apa-apa kaedah HTTP';
});
```

**Pengujian Kaedah POST, PUT, DELETE dengan Alat:**

Gunakan alat seperti **Postman** atau **Thunder Client** (pelanjutan VS Code):

```
POST http://127.0.0.1:8000/posts
PUT  http://127.0.0.1:8000/posts/1
DELETE http://127.0.0.1:8000/posts/1
```

### Ringkasan Modul 2.1

| Konsep | Contoh | Kegunaan |
|--------|--------|----------|
| Laluan Asas | `Route::get('/', fn => 'Hello')` | Laluan mudah |
| Parameter | `Route::get('/posts/{id}', ...)` | Nilai dinamik dalam URL |
| Bernama | `Route::get(...)->name('posts.show')` | Merujuk laluan dalam kod |
| Kumpulan | `Route::prefix('admin')->group(...)` | Mengorganisir laluan |
| Kaedah HTTP | `Route::post/put/delete/patch` | Operasi yang berbeza |

---

## Lab 2.1: Cipta Pelbagai Laluan untuk Aplikasi Blog

### Objektif

Anda akan membuat sistem laluan lengkap untuk aplikasi blog dengan keupayaan:
- Laman utama
- Halaman tentang
- Senarai jawatan
- Paparan jawatan tunggal
- Borang hubungan
- Halaman admin

### Langkah-Langkah

**Langkah 1: Buka Fail `routes/web.php`**

```bash
# Buka folder projek dalam editor
cd C:\laragon\www\blog
code .
```

Atau buka fail secara manual:
```
C:\laragon\www\blog\routes\web.php
```

**Langkah 2: Hapus Kandungan Sedia Ada dan Tulis Laluan Baru**

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;

// ========== LALUAN AWAM ==========

// Laman Utama
Route::get('/', function () {
    return 'Selamat datang ke Blog Saya!';
})->name('home');

// Halaman Tentang
Route::get('/about', function () {
    return 'Halaman Tentang Kami - Blog Sederhana dengan Laravel';
})->name('about');

// Senarai Semua Jawatan
Route::get('/posts', function () {
    return 'Senarai Semua Jawatan di Blog';
})->name('posts.index');

// Paparan Jawatan Tunggal dengan Parameter
Route::get('/posts/{id}', function ($id) {
    return "Paparan Jawatan dengan ID: $id";
})->name('posts.show')->where('id', '[0-9]+');

// Borang Hubungan (Paparan)
Route::get('/contact', function () {
    return 'Borang Hubungan - Sila hantar mesej';
})->name('contact.show');

// Borang Hubungan (Hantar)
Route::post('/contact', function () {
    return 'Terima kasih! Mesej anda telah diterima.';
})->name('contact.store');

// Carian Jawatan
Route::get('/search', function () {
    $query = request('q'); // Ambil parameter query string
    if ($query) {
        return "Hasil carian untuk: '$query'";
    }
    return 'Sila masukkan kata kunci carian';
})->name('search');

// ========== LALUAN ADMIN (Kumpulan dengan Awalan) ==========

Route::prefix('admin')->group(function () {

    Route::get('/', function () {
        return 'Papan Pemuka Admin';
    })->name('admin.dashboard');

    Route::get('/posts', function () {
        return 'Senarai Jawatan untuk Pengurusan Admin';
    })->name('admin.posts.index');

    Route::get('/posts/create', function () {
        return 'Borang Cipta Jawatan Baru';
    })->name('admin.posts.create');

    Route::post('/posts', function () {
        return 'Jawatan baru telah dibuat!';
    })->name('admin.posts.store');

    Route::get('/posts/{id}/edit', function ($id) {
        return "Borang Edit Jawatan $id";
    })->name('admin.posts.edit')->where('id', '[0-9]+');

    Route::put('/posts/{id}', function ($id) {
        return "Jawatan $id telah dikemas kini";
    })->name('admin.posts.update')->where('id', '[0-9]+');

    Route::delete('/posts/{id}', function ($id) {
        return "Jawatan $id telah dihapus";
    })->name('admin.posts.destroy')->where('id', '[0-9]+');

});

// ========== LALUAN FALLBACK ==========
// Laluan untuk URL yang tidak wujud (mesti di akhir)
Route::fallback(function () {
    return response('Halaman Tidak Dijumpai', 404);
});
```

**Langkah 3: Uji Semua Laluan**

Buka terminal dan jalankan:

```bash
php artisan serve

# Output dijangka:
# Laravel development server started: http://127.0.0.1:8000
```

Keadaan server berjalan, uji dalam pelayar:

```
http://127.0.0.1:8000/              → Selamat datang ke Blog Saya!
http://127.0.0.1:8000/about         → Halaman Tentang Kami...
http://127.0.0.1:8000/posts         → Senarai Semua Jawatan...
http://127.0.0.1:8000/posts/5       → Paparan Jawatan dengan ID: 5
http://127.0.0.1:8000/contact       → Borang Hubungan...
http://127.0.0.1:8000/search?q=laravel → Hasil carian untuk: 'laravel'
http://127.0.0.1:8000/admin         → Papan Pemuka Admin
http://127.0.0.1:8000/admin/posts   → Senarai Jawatan untuk Pengurusan...
http://127.0.0.1:8000/tidak-wujud   → Halaman Tidak Dijumpai (404)
```

**Langkah 4: Lihat Senarai Semua Laluan**

```bash
php artisan route:list

# Output dijangka (contoh):
# +----------+------------------------+---------+-------+
# | Method   | URI                    | Name    | Auth  |
# +----------+------------------------+---------+-------+
# | GET|HEAD | /                      | home    |       |
# | GET|HEAD | /about                 | about   |       |
# | GET|HEAD | /posts                 | posts.index |   |
# | GET|HEAD | /posts/{id}            | posts.show  |   |
# | GET|HEAD | /contact               | contact.show |  |
# | POST     | /contact               | contact.store|  |
# | GET|HEAD | /search                | search  |       |
# | GET|HEAD | /admin                 | admin.dashboard |
# | GET|HEAD | /admin/posts           | admin.posts.index |
# ...
# +----------+------------------------+---------+-------+
```

### Penyelesaian Masalah Lab 2.1

**Masalah 1: "Halaman Tidak Dijumpai" untuk semua URL**
- **Punca:** Pelayan tidak berjalan
- **Penyelesaian:** Pastikan `php artisan serve` berjalan dalam terminal

**Masalah 2: Parameter tidak berfungsi (seperti `/posts/abc`)**
- **Punca:** Kekangan regex `where('id', '[0-9]+')` menolak nilai bukan-angka
- **Penyelesaian:** Ubah `[0-9]+` kepada `.+` untuk menerima sebarang nilai, atau pastikan anda menghantar ID yang sah

**Masalah 3: Kaedah POST/PUT/DELETE tidak berfungsi dalam pelayar**
- **Punca:** Pelayar hanya menyokong GET dan POST
- **Penyelesaian:** Gunakan alat seperti Postman untuk menguji PUT/DELETE

---

## Modul 2.2: Pengawal (Controllers)

### Pengenalan Pengawal

Pengawal adalah kelas PHP yang mengorganisir logik perniagaan aplikasi anda. Daripada menulis semua kod dalam laluan, anda pisahkan logik ke dalam pengawal yang boleh digunakan semula.

**Keuntungan Menggunakan Pengawal:**
- Kod lebih bersih dan mudah dibaca
- Logik dapat digunakan semula
- Lebih mudah untuk menguji
- Mengikuti prinsip MVC (Model-View-Controller)

### Struktur Folder Pengawal

```
blog/
├── app/
│   └── Http/
│       └── Controllers/
│           ├── Controller.php        ← Pengawal asas
│           ├── PostController.php    ← Pengawal kami akan buat di sini
│           └── ...
└── ...
```

### Jenis-Jenis Pengawal

#### 1. Pengawal Asas (Basic Controller)

**Membuat Pengawal dengan Artisan:**

```bash
cd C:\laragon\www\blog
php artisan make:controller PostController

# Output dijangka:
# Controller created successfully.
```

Fail yang dibuat:

**Fail:** `app/Http/Controllers/PostController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // Kaedah akan ditambah di sini
}
```

#### 2. Pengawal Sumber (Resource Controller)

Pengawal sumber secara automatik membuat kaedah CRUD (Create, Read, Update, Delete):

```bash
php artisan make:controller PostController --resource

# Output dijangka:
# Controller created successfully.
```

Ini akan membuat pengawal dengan kaedah:
- `index()` - Paparan senarai
- `create()` - Paparan borang cipta
- `store()` - Simpan data baru
- `show()` - Paparan item tunggal
- `edit()` - Paparan borang edit
- `update()` - Kemas kini data
- `destroy()` - Hapus data

#### 3. Pengawal Satu Tindakan (Single Action Controller)

Untuk kaedah tunggal:

```bash
php artisan make:controller WelcomeController --invokable

# Output dijangka:
# Controller created successfully.
```

**Fail:** `app/Http/Controllers/WelcomeController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        return 'Selamat datang!';
    }
}
```

### Membuat Pengawal POST yang Lengkap

**Buat pengawal sumber untuk Posts:**

```bash
php artisan make:controller PostController --resource

# Tunggu output:
# Controller created successfully.
```

**Fail:** `app/Http/Controllers/PostController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Paparan senarai semua jawatan
     */
    public function index()
    {
        // Data sampel
        $posts = [
            ['id' => 1, 'title' => 'Pengenalan Laravel', 'author' => 'Ali'],
            ['id' => 2, 'title' => 'Asas Penghalaan', 'author' => 'Siti'],
            ['id' => 3, 'title' => 'Bekerja dengan Database', 'author' => 'Ahmad'],
        ];

        return view('posts.index', compact('posts'));
        // Atau untuk ujian: return json_encode($posts);
    }

    /**
     * Paparan borang untuk cipta jawatan baru
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Simpan jawatan baru ke dalam database
     */
    public function store(Request $request)
    {
        // Validasi data (akan pelajari pada hari berikutnya)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
        ]);

        // Simpan ke database (akan implementasi dengan Model pada hari berikutnya)
        // Post::create($validated);

        return redirect()->route('posts.index')
                       ->with('success', 'Jawatan baru telah dibuat!');
    }

    /**
     * Paparan jawatan tunggal
     */
    public function show($id)
    {
        // Data sampel
        $post = [
            'id' => $id,
            'title' => 'Jawatan Contoh',
            'content' => 'Ini adalah kandungan jawatan sampel.',
            'author' => 'Ali'
        ];

        return view('posts.show', compact('post'));
        // Atau: return json_encode($post);
    }

    /**
     * Paparan borang untuk edit jawatan
     */
    public function edit($id)
    {
        // Data sampel
        $post = [
            'id' => $id,
            'title' => 'Jawatan untuk Diedit',
            'content' => 'Kandungan yang akan diedit',
            'author' => 'Ali'
        ];

        return view('posts.edit', compact('post'));
    }

    /**
     * Kemas kini jawatan dalam database
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
        ]);

        // Kemas kini database
        // Post::find($id)->update($validated);

        return redirect()->route('posts.show', $id)
                       ->with('success', 'Jawatan telah dikemas kini!');
    }

    /**
     * Hapus jawatan
     */
    public function destroy($id)
    {
        // Hapus dari database
        // Post::find($id)->delete();

        return redirect()->route('posts.index')
                       ->with('success', 'Jawatan telah dihapus!');
    }
}
```

### Menghubungkan Pengawal dengan Laluan

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// ========== Menggunakan Pengawal ==========

// Cara 1: Laluan individu
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

// Cara 2: Laluan sumber (lebih ringkas)
Route::resource('posts', PostController::class);

// ========== Laluan Lain ==========

Route::get('/', function () {
    return 'Selamat datang ke Blog!';
})->name('home');
```

**Perhatian:** Hanya gunakan SALAH SATU daripada Cara 1 atau Cara 2. Cara 2 lebih ringkas dan disyorkan.

**Uji Laluan Sumber:**

```bash
php artisan route:list

# Output dijangka:
# +----------+-------------------+----------+--------------------+
# | Method   | URI               | Name     | Controller         |
# +----------+-------------------+----------+--------------------+
# | GET|HEAD | /posts            | posts.index | PostController@index |
# | POST     | /posts            | posts.store | PostController@store |
# | GET|HEAD | /posts/create     | posts.create| PostController@create|
# | GET|HEAD | /posts/{id}       | posts.show  | PostController@show  |
# | GET|HEAD | /posts/{id}/edit  | posts.edit  | PostController@edit  |
# | PUT|PATCH| /posts/{id}       | posts.update| PostController@update|
# | DELETE   | /posts/{id}       | posts.destroy|PostController@destroy|
# +----------+-------------------+----------+--------------------+
```

---

## Lab 2.2: Cipta Pengawal CRUD Lengkap untuk Posts

### Objektif

Anda akan membuat pengawal `PostController` yang lengkap dengan kesemua kaedah CRUD dan menghubungkannya dengan laluan.

### Langkah-Langkah

**Langkah 1: Buat Pengawal dengan Artisan**

```bash
cd C:\laragon\www\blog

# Buat pengawal sumber
php artisan make:controller PostController --resource

# Output dijangka:
# Controller created successfully.
```

**Langkah 2: Kembali Edit Pengawal dengan Kod CRUD Lengkap**

Buka fail:
```
C:\laragon\www\blog\app\Http\Controllers\PostController.php
```

Gantikan dengan kod:

**Fail:** `app/Http/Controllers/PostController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // Simpan data dalam array (untuk ujian, belum database)
    private static $posts = [
        ['id' => 1, 'title' => 'Pengenalan Laravel', 'content' => 'Laravel adalah framework PHP yang kuat...', 'author' => 'Ali'],
        ['id' => 2, 'title' => 'Memahami Routing', 'content' => 'Routing adalah cara untuk mengarahkan permintaan...', 'author' => 'Siti'],
    ];

    /**
     * index() - Paparan senarai semua jawatan
     * GET /posts
     */
    public function index()
    {
        $posts = self::$posts;
        return response()->json([
            'status' => 'success',
            'message' => 'Senarai semua jawatan',
            'data' => $posts,
            'count' => count($posts)
        ]);
    }

    /**
     * create() - Paparan borang cipta jawatan
     * GET /posts/create
     */
    public function create()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Borang untuk membuat jawatan baru',
            'form_fields' => ['title', 'content', 'author']
        ]);
    }

    /**
     * store() - Simpan jawatan baru
     * POST /posts
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
        ]);

        // Buat ID baru
        $newId = count(self::$posts) + 1;

        // Tambah ke senarai
        $newPost = array_merge(['id' => $newId], $validated);
        self::$posts[] = $newPost;

        return response()->json([
            'status' => 'success',
            'message' => 'Jawatan baru telah disimpan!',
            'data' => $newPost
        ], 201);
    }

    /**
     * show() - Paparan jawatan tunggal
     * GET /posts/{id}
     */
    public function show($id)
    {
        // Cari jawatan dengan ID
        $post = collect(self::$posts)->firstWhere('id', $id);

        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => "Jawatan dengan ID $id tidak dijumpai"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Paparan jawatan',
            'data' => $post
        ]);
    }

    /**
     * edit() - Paparan borang edit jawatan
     * GET /posts/{id}/edit
     */
    public function edit($id)
    {
        // Cari jawatan
        $post = collect(self::$posts)->firstWhere('id', $id);

        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => "Jawatan dengan ID $id tidak dijumpai"
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Borang edit jawatan',
            'data' => $post,
            'form_fields' => ['title', 'content', 'author']
        ]);
    }

    /**
     * update() - Kemas kini jawatan
     * PUT /posts/{id}
     */
    public function update(Request $request, $id)
    {
        // Cari jawatan
        $post = collect(self::$posts)->firstWhere('id', $id);

        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => "Jawatan dengan ID $id tidak dijumpai"
            ], 404);
        }

        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
        ]);

        // Cari indeks dan kemas kini
        $key = array_search($id, array_column(self::$posts, 'id'));
        self::$posts[$key] = array_merge(['id' => $id], $validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Jawatan telah dikemas kini!',
            'data' => self::$posts[$key]
        ]);
    }

    /**
     * destroy() - Hapus jawatan
     * DELETE /posts/{id}
     */
    public function destroy($id)
    {
        // Cari jawatan
        $post = collect(self::$posts)->firstWhere('id', $id);

        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => "Jawatan dengan ID $id tidak dijumpai"
            ], 404);
        }

        // Hapus
        self::$posts = array_values(
            array_filter(self::$posts, fn($p) => $p['id'] != $id)
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Jawatan telah dihapus!'
        ]);
    }
}
```

**Langkah 3: Kemaskini Fail Laluan**

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Laman utama
Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Selamat datang ke API Blog!'
    ]);
})->name('home');

// Laluan sumber untuk Posts (menjana 7 laluan secara automatik)
Route::resource('posts', PostController::class);

// Laluan fallback
Route::fallback(function () {
    return response()->json([
        'status' => 'error',
        'message' => 'Halaman tidak dijumpai'
    ], 404);
});
```

**Langkah 4: Uji Semua Kaedah CRUD**

Buka terminal dan jalankan pelayan:

```bash
php artisan serve

# Output dijangka:
# Laravel development server started: http://127.0.0.1:8000
```

Buka Postman atau alat pengujian API lain, dan uji:

**1. GET /posts (Senarai Semua)**

```
Request: GET http://127.0.0.1:8000/posts

Response (Output Dijangka):
{
  "status": "success",
  "message": "Senarai semua jawatan",
  "data": [
    {
      "id": 1,
      "title": "Pengenalan Laravel",
      "content": "Laravel adalah framework PHP yang kuat...",
      "author": "Ali"
    },
    {
      "id": 2,
      "title": "Memahami Routing",
      "content": "Routing adalah cara untuk mengarahkan permintaan...",
      "author": "Siti"
    }
  ],
  "count": 2
}
```

**2. GET /posts/{id} (Paparan Tunggal)**

```
Request: GET http://127.0.0.1:8000/posts/1

Response (Output Dijangka):
{
  "status": "success",
  "message": "Paparan jawatan",
  "data": {
    "id": 1,
    "title": "Pengenalan Laravel",
    "content": "Laravel adalah framework PHP yang kuat...",
    "author": "Ali"
  }
}
```

**3. GET /posts/create (Borang Cipta)**

```
Request: GET http://127.0.0.1:8000/posts/create

Response (Output Dijangka):
{
  "status": "success",
  "message": "Borang untuk membuat jawatan baru",
  "form_fields": ["title", "content", "author"]
}
```

**4. POST /posts (Simpan Baru)**

```
Request: POST http://127.0.0.1:8000/posts

Body (JSON):
{
  "title": "Jawatan Baru",
  "content": "Ini adalah jawatan yang baru dibuat",
  "author": "Ahmad"
}

Response (Output Dijangka):
{
  "status": "success",
  "message": "Jawatan baru telah disimpan!",
  "data": {
    "id": 3,
    "title": "Jawatan Baru",
    "content": "Ini adalah jawatan yang baru dibuat",
    "author": "Ahmad"
  }
}
Status Code: 201 Created
```

**5. GET /posts/{id}/edit (Borang Edit)**

```
Request: GET http://127.0.0.1:8000/posts/1/edit

Response (Output Dijangka):
{
  "status": "success",
  "message": "Borang edit jawatan",
  "data": {
    "id": 1,
    "title": "Pengenalan Laravel",
    "content": "Laravel adalah framework PHP yang kuat...",
    "author": "Ali"
  },
  "form_fields": ["title", "content", "author"]
}
```

**6. PUT /posts/{id} (Kemas Kini)**

```
Request: PUT http://127.0.0.1:8000/posts/1

Body (JSON):
{
  "title": "Pengenalan Laravel - Dikemas Kini",
  "content": "Kandungan yang telah dikemas kini",
  "author": "Ali Updated"
}

Response (Output Dijangka):
{
  "status": "success",
  "message": "Jawatan telah dikemas kini!",
  "data": {
    "id": 1,
    "title": "Pengenalan Laravel - Dikemas Kini",
    "content": "Kandungan yang telah dikemas kini",
    "author": "Ali Updated"
  }
}
```

**7. DELETE /posts/{id} (Hapus)**

```
Request: DELETE http://127.0.0.1:8000/posts/1

Response (Output Dijangka):
{
  "status": "success",
  "message": "Jawatan telah dihapus!"
}
Status Code: 200 OK
```

**Periksa Semua Laluan:**

```bash
php artisan route:list

# Output dijangka:
# +---------+-----------------------+----------+--------------------+
# | Method  | URI                   | Name     | Controller         |
# +---------+-----------------------+----------+--------------------+
# | GET|HEAD| /                     | home     | Closure            |
# | GET|HEAD| /posts                | posts.index | PostController@index |
# | POST    | /posts                | posts.store | PostController@store |
# | GET|HEAD| /posts/create         | posts.create | PostController@create|
# | GET|HEAD| /posts/{id}           | posts.show | PostController@show  |
# | GET|HEAD| /posts/{id}/edit      | posts.edit | PostController@edit  |
# | PUT|PATCH| /posts/{id}          | posts.update | PostController@update|
# | DELETE  | /posts/{id}           | posts.destroy | PostController@destroy|
# +---------+-----------------------+----------+--------------------+
```

### Penyelesaian Masalah Lab 2.2

**Masalah 1: "Call to undefined method..."**
- **Punca:** Pengawal tidak diedit dengan betul
- **Penyelesaian:** Pastikan kod dalam `PostController.php` disalin sepenuhnya dan tanpa syntax error

**Masalah 2: "Target class [App\Http\Controllers\PostController] does not exist"**
- **Punca:** Laluan tidak menemui pengawal
- **Penyelesaian:** Pastikan namespace dan nama kelas betul. Jalankan `php artisan route:list` untuk memeriksa

**Masalah 3: Validasi gagal dengan pesan "validation.required"**
- **Punca:** Data yang dihantar tidak lengkap
- **Penyelesaian:** Pastikan semua medan yang diperlukan (`title`, `content`, `author`) dihantar dalam permintaan

**Masalah 4: DELETE tidak berfungsi dalam pelayar**
- **Punca:** Pelayar tidak menyokong kaedah DELETE
- **Penyelesaian:** Gunakan Postman atau alat serupa untuk menguji DELETE

---

## Modul 2.3: Middleware

### Pengenalan Middleware

Middleware adalah lapisan perantara antara permintaan (request) dan respons (response). Middleware dapat memeriksa, memodifikasi, atau menolak permintaan sebelum sampai ke pengawal.

**Analogi:** Seperti petugas keselamatan di pintu yang memeriksa pelawat sebelum membenarkan mereka masuk.

**Kegunaan Middleware:**
- Pengesahan pengguna (authentication)
- Kebenaran pengguna (authorization)
- Pengehadan kadar permintaan (rate limiting)
- Keamanan CORS
- Pencatatan permintaan
- Mampatan respons

### Struktur Folder Middleware

```
blog/
├── app/
│   └── Http/
│       ├── Middleware/
│       │   ├── Authenticate.php      ← Middleware asas
│       │   ├── LogRequests.php       ← Middleware tersuai kami akan buat
│       │   └── ...
│       └── ...
└── ...
```

### Middleware Terbina dalam Laravel

**1. Middleware Pengesahan (auth)**

```php
Route::get('/profile', function () {
    return 'Profil pengguna';
})->middleware('auth');
```

Memastikan hanya pengguna yang telah log masuk boleh akses.

**2. Middleware Tetamu (guest)**

```php
Route::get('/login', function () {
    return 'Halaman log masuk';
})->middleware('guest');
```

Memastikan hanya pengguna yang belum log masuk boleh akses.

**3. Middleware Pengehadan Kadar (throttle)**

```php
Route::post('/api/posts', function () {
    return 'Buat jawatan';
})->middleware('throttle:10,1');
```

Membenarkan maksimal 10 permintaan per 1 minit.

**4. Middleware Diperiksa Email (verified)**

```php
Route::get('/dashboard', function () {
    return 'Papan pemuka';
})->middleware('verified');
```

Memastikan email pengguna telah disahkan.

### Membuat Middleware Tersuai

**Buat middleware tersuai:**

```bash
cd C:\laragon\www\blog

php artisan make:middleware LogRequests

# Output dijangka:
# Middleware created successfully.
```

**Fail:** `app/Http/Middleware/LogRequests.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Proses permintaan
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sebelum permintaan sampai ke pengawal
        $method = $request->getMethod();
        $path = $request->getPathInfo();
        $ip = $request->ip();
        $timestamp = date('Y-m-d H:i:s');

        // Catat maklumat permintaan
        \Log::info("[$timestamp] $method $path dari IP: $ip");

        // Lanjutkan ke pengawal
        $response = $next($request);

        // Selepas pengawal memberikan respons
        $statusCode = $response->status();
        \Log::info("Response Status: $statusCode");

        return $response;
    }
}
```

### Menggunakan Middleware dalam Laluan

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Middleware\LogRequests;

// Laluan dengan middleware
Route::get('/', function () {
    return 'Laman Utama';
})->middleware(LogRequests::class);

// Laluan sumber dengan middleware
Route::resource('posts', PostController::class)
    ->middleware(LogRequests::class);

// Middleware pada kumpulan laluan
Route::prefix('admin')
    ->middleware(LogRequests::class)
    ->group(function () {
        Route::get('/', function () {
            return 'Admin Dashboard';
        });
    });
```

### Mendaftar Middleware Secara Global

Untuk memohon middleware pada semua laluan:

**Fail:** `app/Http/Kernel.php`

```php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Middleware untuk semua laluan HTTP
     */
    protected $middleware = [
        \App\Http\Middleware\LogRequests::class,
    ];

    /**
     * Kumpulan middleware yang boleh dipanggil dengan nama
     */
    protected $middlewareGroups = [
        'web' => [
            // Middleware untuk laluan web
        ],
        'api' => [
            // Middleware untuk laluan API
        ],
    ];
}
```

---

## Lab 2.3: Buat Middleware Pencatatan Tersuai

### Objektif

Anda akan membuat middleware yang mencatat setiap permintaan ke aplikasi dalam fail log.

### Langkah-Langkah

**Langkah 1: Buat Middleware**

```bash
cd C:\laragon\www\blog

php artisan make:middleware RequestLogger

# Output dijangka:
# Middleware created successfully.
```

**Langkah 2: Edit Middleware**

**Fail:** `app/Http/Middleware/RequestLogger.php`

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestLogger
{
    /**
     * Proses dan catatkan setiap permintaan
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Maklumat permintaan
        $method = $request->getMethod();
        $path = $request->getPathInfo();
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        $timestamp = date('Y-m-d H:i:s');

        // Format log
        $logMessage = "[$timestamp] $method $path | IP: $ip | User-Agent: $userAgent";

        // Tulis ke fail log
        \Log::channel('single')->info($logMessage);

        // Lanjutkan permintaan
        $response = $next($request);

        // Catat status respons
        $status = $response->status();
        \Log::channel('single')->info("Response Status: $status untuk $method $path");

        return $response;
    }
}
```

**Langkah 3: Daftar Middleware dalam Routing**

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Middleware\RequestLogger;

// Laman utama
Route::get('/', function () {
    return response()->json(['message' => 'Selamat datang']);
})->name('home')->middleware(RequestLogger::class);

// Laluan sumber dengan middleware pencatatan
Route::resource('posts', PostController::class)
    ->middleware(RequestLogger::class);

// Laluan lain untuk ujian
Route::get('/test', function () {
    return response()->json(['message' => 'Halaman ujian']);
})->middleware(RequestLogger::class);
```

**Langkah 4: Uji Middleware**

Buka terminal dan jalankan:

```bash
php artisan serve
```

Dalam pelayar atau Postman, buat beberapa permintaan:

```
GET http://127.0.0.1:8000/
GET http://127.0.0.1:8000/posts
POST http://127.0.0.1:8000/posts
GET http://127.0.0.1:8000/test
```

**Langkah 5: Lihat Fail Log**

Fail log disimpan di:

```
C:\laragon\www\blog\storage\logs\laravel.log
```

Buka dengan editor teks atau terminal:

```bash
# Lihat isi fail log (pada Windows PowerShell)
Get-Content C:\laragon\www\blog\storage\logs\laravel.log -Tail 20

# Output dijangka:
# [2026-04-06 10:15:30] local.INFO: [2026-04-06 10:15:30] GET / | IP: 127.0.0.1 | User-Agent: Mozilla/5.0...
# [2026-04-06 10:15:31] local.INFO: Response Status: 200 untuk GET /
# [2026-04-06 10:15:32] local.INFO: [2026-04-06 10:15:32] GET /posts | IP: 127.0.0.1 | User-Agent: Mozilla/5.0...
# [2026-04-06 10:15:32] local.INFO: Response Status: 200 untuk GET /posts
```

### Penyelesaian Masalah Lab 2.3

**Masalah 1: Fail log tidak dikemas kini**
- **Punca:** Middleware tidak didaftar atau sambungan fail log gagal
- **Penyelesaian:** Pastikan `RequestLogger::class` ditambah di laluan. Periksa kebenaran fail `storage/logs/`

**Masalah 2: "Undefined method...Log::channel()"**
- **Punca:** Kod menggunakan `Log` yang salah
- **Penyelesaian:** Guna `\Log::info()` atau `\Illuminate\Support\Facades\Log::info()`

**Masalah 3: Middleware berjalan untuk semua laluan**
- **Punca:** Middleware didaftar secara global
- **Penyelesaian:** Pastikan hanya laluan yang diperlukan memiliki `->middleware(RequestLogger::class)`

---

## Modul 2.4: Permintaan (Request) & Respons (Response)

### Pengenalan Request & Response

**Request (Permintaan):** Data yang dihantar oleh klien (pelayar) ke pelayan Laravel
**Response (Respons):** Data yang dikembalikan oleh pelayan Laravel ke klien

### Jenis-Jenis Request

```
GET     - Meminta data dari pelayan
POST    - Menghantar data baru ke pelayan
PUT     - Menghantar data untuk menggantikan keseluruhan sumber
PATCH   - Menghantar data untuk menggantikan sebahagian sumber
DELETE  - Meminta penghapusan sumber
HEAD    - Seperti GET tetapi tanpa badan respons
OPTIONS - Meminta maklumat tentang kaedah yang dibenarkan
```

### Objek Request

Dalam setiap pengawal atau laluan, anda boleh akses objek `Request`:

```php
public function store(Request $request)
{
    // Ambil semua input
    $all = $request->all();

    // Ambil input tertentu
    $name = $request->input('name');
    $email = $request->get('email');

    // Ambil dari query string
    $page = $request->query('page');

    // Ambil dari URL (parameter)
    $id = $request->route('id');

    // Periksa input tertentu
    if ($request->has('name')) {
        // Ada input 'name'
    }

    // Ambil nilai dengan default
    $role = $request->input('role', 'user');
}
```

### Ambil Input dari Request

**Fail:** `app/Http/Controllers/PostController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Simpan jawatan baru
     */
    public function store(Request $request)
    {
        // Cara 1: Ambil semua input
        $data = $request->all();

        // Cara 2: Ambil input tertentu
        $title = $request->input('title');
        $content = $request->input('content');
        $author = $request->get('author'); // Alias untuk input()

        // Cara 3: Ambil dengan nilai default
        $status = $request->input('status', 'published');

        // Cara 4: Ambil dari query string (?page=2)
        $page = $request->query('page', 1);

        // Cara 5: Periksa input tertentu
        if ($request->has('featured')) {
            // Ada 'featured' dalam input
        }

        if ($request->filled('title')) {
            // Ada 'title' dan nilainya tidak kosong
        }

        // Cara 6: Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'author' => 'required|string|max:100',
            'status' => 'in:draft,published,archived',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jawatan telah disimpan',
            'data' => $validated
        ], 201);
    }

    /**
     * Kemas kini jawatan
     */
    public function update(Request $request, $id)
    {
        // Validasi hanya medan yang dihantar
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'author' => 'sometimes|required|string|max:100',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jawatan $id telah dikemas kini',
            'data' => $validated
        ]);
    }
}
```

### Jenis-Jenis Response

#### 1. Response JSON

```php
// Cara 1: Ringkas
return response()->json(['message' => 'Berjaya']);

// Cara 2: Dengan status code
return response()->json(['message' => 'Dibuat'], 201);

// Cara 3: Dengan header tambahan
return response()->json(['data' => $data])
    ->header('X-Custom-Header', 'value');
```

#### 2. Response HTML/String

```php
// Kembalikan string
return 'Selamat datang ke Blog!';

// Kembalikan HTML
return '<h1>Selamat Datang</h1>';

// Kembalikan dengan status code
return response('<h1>Halaman Tidak Dijumpai</h1>', 404);
```

#### 3. Response View (Template)

```php
// Kembalikan view dengan data
return view('posts.show', ['post' => $post]);

// Dengan compact (lebih ringkas)
return view('posts.show', compact('post'));
```

#### 4. Response Redirect

```php
// Redirect ke URL
return redirect('/posts');

// Redirect ke nama laluan
return redirect()->route('posts.index');

// Dengan parameter
return redirect()->route('posts.show', ['id' => 1]);

// Dengan mesej flash
return redirect()->route('posts.index')
    ->with('success', 'Jawatan telah dibuat!');

// Redirect ke halaman sebelumnya
return redirect()->back();
```

#### 5. Response File Download

```php
// Download fail
return response()->download('/path/to/file.pdf');

// Dengan nama ubahan
return response()->download('/path/to/file.pdf', 'dokumen.pdf');
```

#### 6. Response File Tinjauan (View)

```php
// Tunjuk fail dalam pelayar
return response()->file('/path/to/file.pdf');
```

### Perlindungan CSRF

Laravel melindungi aplikasi daripada serangan CSRF (Cross-Site Request Forgery). Semua borang POST/PUT/DELETE mesti mengandungi token CSRF.

**Dalam Borang HTML:**

```html
<form method="POST" action="/posts">
    @csrf
    <input type="text" name="title" required>
    <button type="submit">Hantar</button>
</form>
```

**Atau Secara Manual:**

```html
<input type="hidden" name="_token" value="{{ csrf_token() }}">
```

---

## Lab 2.4: Tangani Request & Response

### Objektif

Anda akan membuat borang kontak dan memproses input dengan pengesahan yang betul, serta memberikan respons yang sesuai.

### Langkah-Langkah

**Langkah 1: Buat Pengawal Kontak**

```bash
cd C:\laragon\www\blog

php artisan make:controller ContactController

# Output dijangka:
# Controller created successfully.
```

**Langkah 2: Tulis Kod Pengawal**

**Fail:** `app/Http/Controllers/ContactController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Paparan borang kontak
     * GET /contact
     */
    public function show()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Borang hubungan siap untuk diisi',
            'form' => [
                'fields' => ['name', 'email', 'subject', 'message']
            ]
        ]);
    }

    /**
     * Proses borang kontak
     * POST /contact
     */
    public function store(Request $request)
    {
        // Ambil input dari permintaan
        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        // Periksa jika semua medan telah dihantar
        if (!$name || !$email || !$subject || !$message) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sila isi semua medan',
                'required_fields' => ['name', 'email', 'subject', 'message']
            ], 400);
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:5000',
        ]);

        // Simulasi penyimpanan ke database atau penghantar email
        $contactData = [
            'id' => uniqid(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        // Catat dalam fail log
        \Log::info('Borang kontak diterima:', $contactData);

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih! Mesej anda telah diterima. Kami akan menghubungi anda tidak lama lagi.',
            'data' => $contactData,
            'reference_id' => $contactData['id']
        ], 201);
    }

    /**
     * Senarai semua mesej kontak (Admin)
     * GET /contact/messages
     */
    public function index()
    {
        // Simulasi data dari database
        $messages = [
            [
                'id' => 1,
                'name' => 'Ali Ahmad',
                'email' => 'ali@example.com',
                'subject' => 'Pertanyaan tentang pricing',
                'message' => 'Berapa harga untuk paket premium?',
                'created_at' => '2026-04-05 10:30:00'
            ],
            [
                'id' => 2,
                'name' => 'Siti Nurul',
                'email' => 'siti@example.com',
                'subject' => 'Teknikal Support',
                'message' => 'Saya tidak dapat log masuk ke akaun saya.',
                'created_at' => '2026-04-05 14:15:00'
            ]
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Senarai mesej kontak',
            'data' => $messages,
            'total' => count($messages)
        ]);
    }
}
```

**Langkah 3: Daftar Laluan**

**Fail:** `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\RequestLogger;

// Laman utama
Route::get('/', function () {
    return response()->json(['message' => 'Selamat datang ke Blog']);
})->name('home');

// Laluan Posts (Sumber)
Route::resource('posts', PostController::class)
    ->middleware(RequestLogger::class);

// Laluan Kontak
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/messages', [ContactController::class, 'index'])->name('contact.messages');
```

**Langkah 4: Uji Request & Response**

Jalankan pelayan:

```bash
php artisan serve
```

**Ujian 1: GET /contact**

```
Request: GET http://127.0.0.1:8000/contact

Output Dijangka:
{
  "status": "success",
  "message": "Boform hubungan siap untuk diisi",
  "form": {
    "fields": ["name", "email", "subject", "message"]
  }
}
```

**Ujian 2: POST /contact dengan data lengkap**

```
Request: POST http://127.0.0.1:8000/contact

Body (JSON):
{
  "name": "Ali Ahmad",
  "email": "ali@example.com",
  "subject": "Pertanyaan Produk",
  "message": "Saya berminat untuk mengetahui lebih lanjut tentang produk anda yang baru"
}

Output Dijangka:
{
  "status": "success",
  "message": "Terima kasih! Mesej anda telah diterima. Kami akan menghubungi anda tidak lama lagi.",
  "data": {
    "id": "65a1b2c3d4e5f",
    "name": "Ali Ahmad",
    "email": "ali@example.com",
    "subject": "Pertanyaan Produk",
    "message": "Saya berminat untuk mengetahui lebih lanjut tentang produk anda yang baru",
    "created_at": "2026-04-06 10:45:30"
  },
  "reference_id": "65a1b2c3d4e5f"
}
Status Code: 201 Created
```

**Ujian 3: POST /contact tanpa data (Validasi Gagal)**

```
Request: POST http://127.0.0.1:8000/contact

Body (JSON):
{
  "name": "Ali"
}

Output Dijangka:
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "subject": ["The subject field is required."],
    "message": ["The message field is required."]
  }
}
Status Code: 422 Unprocessable Entity
```

**Ujian 4: POST /contact dengan email tidak sah**

```
Request: POST http://127.0.0.1:8000/contact

Body (JSON):
{
  "name": "Ali Ahmad",
  "email": "bukan-email",
  "subject": "Test",
  "message": "Mesej ujian untuk pengesahan email"
}

Output Dijangka:
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email must be a valid email address."]
  }
}
Status Code: 422 Unprocessable Entity
```

**Ujian 5: GET /contact/messages**

```
Request: GET http://127.0.0.1:8000/contact/messages

Output Dijangka:
{
  "status": "success",
  "message": "Senarai mesej kontak",
  "data": [
    {
      "id": 1,
      "name": "Ali Ahmad",
      "email": "ali@example.com",
      "subject": "Pertanyaan tentang pricing",
      "message": "Berapa harga untuk paket premium?",
      "created_at": "2026-04-05 10:30:00"
    },
    {
      "id": 2,
      "name": "Siti Nurul",
      "email": "siti@example.com",
      "subject": "Teknikal Support",
      "message": "Saya tidak dapat log masuk ke akaun saya.",
      "created_at": "2026-04-05 14:15:00"
    }
  ],
  "total": 2
}
```

### Penyelesaian Masalah Lab 2.4

**Masalah 1: "The given data was invalid" tetapi data nampak betul**
- **Punca:** Format JSON tidak betul atau medan tidak sepadan
- **Penyelesaian:** Pastikan `Content-Type: application/json` dalam header Postman, dan medan sepadan dengan nama dalam `validate()`

**Masalah 2: "Email validation failed"**
- **Punca:** Email tidak dalam format yang betul
- **Penyelesaian:** Gunakan email yang sah seperti `ali@example.com`

**Masalah 3: Response 500 Internal Server Error**
- **Punca:** Kesalahan dalam kod
- **Penyelesaian:** Periksa fail `storage/logs/laravel.log` untuk melihat ralat sebenar

---

## Ringkasan Hari 2

### Jadual Ringkasan

| Topik | Pembelajaran Utama | Praktik |
|-------|-------------------|---------|
| **Routing** | Laluan GET/POST/PUT/DELETE, parameter, laluan bernama, kumpulan | Lab 2.1: 7 laluan blog |
| **Controllers** | Membuat pengawal, kaedah CRUD, pengawal sumber | Lab 2.2: PostController CRUD lengkap |
| **Middleware** | Apa itu middleware, membuat middleware tersuai, menggunakan middleware | Lab 2.3: RequestLogger middleware |
| **Request & Response** | Ambil input, validasi, respons JSON/HTML/redirect | Lab 2.4: Borang kontak lengkap |

### Fail-Fail yang Dibuat/Diubah pada Hari 2

```
blog/
├── app/Http/
│   ├── Controllers/
│   │   ├── PostController.php         ← Baru
│   │   └── ContactController.php      ← Baru
│   └── Middleware/
│       ├── RequestLogger.php          ← Baru
│       └── LogRequests.php            ← Baru
├── routes/
│   └── web.php                        ← Diubah
└── storage/
    └── logs/
        └── laravel.log                ← Dicatat middleware
```

### Perintah Artisan Penting yang Dipelajari

```bash
php artisan serve                       # Jalankan pelayan development
php artisan route:list                  # Senarai semua laluan
php artisan make:controller NAME        # Buat pengawal
php artisan make:middleware NAME        # Buat middleware
php artisan tinker                      # Interaktif PHP shell
```

### Konsep Utama yang Dipelajari

1. **Routing:** Cara memetakan URL kepada logik aplikasi
2. **Controllers:** Cara mengorganisir logik dalam kelas yang boleh digunakan semula
3. **Middleware:** Cara mengesahkan/memproses permintaan sebelum sampai ke pengawal
4. **Request & Response:** Cara menangani input pengguna dan memberikan output yang betul
5. **CRUD:** Create (POST), Read (GET), Update (PUT), Delete (DELETE)

---

## Persediaan untuk Hari 3

Pada Hari 3, kami akan mempelajari:

1. **Database & Models** - Cara menyimpan data dalam database
2. **Migrasi** - Cara membuat dan mengurus struktur database
3. **Eloquent ORM** - Cara berinteraksi dengan database menggunakan Model
4. **Query Builder** - Cara menulis query database

**Sebelum Hari 3:**
- Pastikan Laravel dan semua komponennya berfungsi dengan baik
- Baca dokumentasi singkat tentang database MySQL
- Sediakan diri anda untuk belajar tentang database design

---

## Penyelesaian Masalah Umum

### Masalah: "laravel.log is not writable"
```bash
# Ubah kebenaran folder storage
icacls C:\laragon\www\blog\storage /grant Users:F /T
```

### Masalah: Port 8000 Sudah Digunakan
```bash
# Gunakan port lain
php artisan serve --port=8001
```

### Masalah: "Class not found"
```bash
# Buat semula autoloader
composer dump-autoload
```

### Masalah: Middleware tidak dijalankan
```bash
# Pastikan middleware didaftar dalam routes atau Kernel.php
# Periksa nama kelas middleware dalam import statement
```

---

## Bacaan Lanjutan & Sumber

- **Dokumentasi Routing:** https://laravel.com/docs/routing
- **Dokumentasi Controllers:** https://laravel.com/docs/controllers
- **Dokumentasi Middleware:** https://laravel.com/docs/middleware
- **Dokumentasi Request:** https://laravel.com/docs/requests
- **Dokumentasi Response:** https://laravel.com/docs/responses

---

**Tamatkan Lab dan Sedia untuk Hari 3!**

Selamat belajar! Jika anda menghadapi masalah, sila semak penyelesaian masalah di atas atau rujuk dokumentasi Laravel rasmi.
