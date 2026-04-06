# Hari 4: Ciri Lanjutan dan Projek Akhir

Selamat datang ke hari terakhir kursus Laravel 4 Hari! Hari ini kita akan mempelajari pengesahan pengguna, membina API RESTful, hubungan model, amalan terbaik, dan menyelesaikan projek blog lengkap.

---

## Modul 4.1: Pengesahan Pengguna (Authentication)

### Apa itu Pengesahan dalam Laravel?

Pengesahan (authentication) adalah proses mengesahkan identiti pengguna. Laravel menyediakan beberapa cara untuk menangani pengesahan dengan mudah:

- **Sessions**: Cara tradisional untuk web applications (menyimpan data pengguna dalam session)
- **Tokens**: Untuk API authentication (setiap request memakai token)
- **Two-Factor Authentication**: Keselamatan tambahan

### Perbandingan: Laravel Breeze vs Sanctum vs Passport

#### **Laravel Breeze**
- Kaedah pengesahan yang paling mudah dan ringkas
- Sesuai untuk aplikasi web tradisional dengan sessions
- Sudah disediakan dengan register, login, logout
- Menggunakan views Blade dan session authentication
- **Terbaik untuk**: Web applications, beginner-friendly

```
Pros:
- Simple, cepat setup
- Bagus untuk web applications
- Sudah ada boilerplate untuk forms

Cons:
- Tidak sesuai untuk mobile apps
- Tidak ada API token support
```

#### **Laravel Sanctum**
- Untuk aplikasi yang perlu web dan API authentication
- Menggunakan tokens untuk API, sessions untuk web
- Lightweight dan fleksibel
- **Terbaik untuk**: SPA (Single Page Applications) + API

```
Pros:
- Mendukung both web dan API
- Token-based untuk API
- CSRF protection built-in

Cons:
- Lebih kompleks dari Breeze
```

#### **Laravel Passport**
- OAuth 2.0 authentication server
- Untuk aplikasi dengan banyak third-party clients
- Lebih powerful dan kompleks
- **Terbaik untuk**: Enterprise applications dengan multiple clients

```
Pros:
- Full OAuth 2.0 support
- Multiple authentication scopes

Cons:
- Lebih berat
- Learning curve yang curam
```

**Untuk kursus ini**: Kita akan gunakan **Laravel Breeze** kerana ia paling mudah dan sesuai untuk pemula.

---

## Lab 4.1: Pasang Laravel Breeze

Mari kita pasang Laravel Breeze pada projek blog kita.

### Langkah 1: Pastikan Anda dalam direktori projek

```bash
cd C:\laragon\www\blog
```

**Output yang diharapkan**:
```
C:\laragon\www\blog>
```

### Langkah 2: Pasang Laravel Breeze via Composer

Jalankan command berikut:

```bash
composer require laravel/breeze --dev
```

**Output yang diharapkan**:
```
Using version ^1.29 for laravel/breeze
./composer.json has been updated
Loading composer repositories with package information
...
Installing laravel/breeze (v1.29.0)
...
Generating optimized autoload files
```

### Langkah 3: Publish Breeze Scaffolding dengan Blade

Jalankan:

```bash
php artisan breeze:install blade
```

**Output yang diharapkan**:
```
Publishing Breeze's assets and stubs...

   ____                          __  _____
  / __ )_________ ___ ___ ___  / /_/ __  /
 / __  / ___/ __ `__ `__ \/ _ \/ __/ /_/ /
/ /_/ / /  / / / / / / / /  __/ /__\__, /
/_____/_/  /_/ /_/ /_/ /_/\___/\___/____/

Breeze scaffolding published successfully.
```

Jika anda diminta untuk overwrite file, tekan `Y` dan Enter.

### Langkah 4: Pasang NPM Dependencies

```bash
npm install
```

**Output yang diharapkan**:
```
up to date, audited 48 packages in 2s
5 packages are looking for funding
```

### Langkah 5: Compile CSS dan JavaScript

```bash
npm run build
```

**Output yang diharapkan**:
```
> build
> vite build

vite v4.x.x building for production...
✓ 123 modules transformed.
dist/assets/app-abc123.js    250.00 kB │ gzip: 75.00 kB
dist/assets/app-abc123.css    45.00 kB │ gzip: 10.00 kB
```

### Langkah 6: Jalankan Database Migration

Breeze sudah menginclude User migration. Mari kita jalankan:

```bash
php artisan migrate
```

**Output yang diharapkan**:
```
  Illuminate\Database\Migrations\2014_10_12_000000_create_users_table ........... 3ms PASSED
  Illuminate\Database\Migrations\2014_10_12_100000_create_password_resets_table . 1ms PASSED
  Illuminate\Database\Migrations\2019_08_19_000000_create_failed_jobs_table ..... 1ms PASSED
  Illuminate\Database\Migrations\2019_12_14_000001_create_personal_access_tokens_table . 2ms PASSED

  Database migrations completed successfully.
```

### Langkah 7: Jalankan Development Server

```bash
php artisan serve
```

**Output yang diharapkan**:
```
   _______
  |  _    |
  | | |   |
  | |_|   |
  |_|___| v11.x

  Server running on [http://127.0.0.1:8000]
```

Pada terminal lain, jalankan:

```bash
npm run dev
```

### Langkah 8: Test Functionality

Buka browser ke `http://localhost:8000`

**Anda sepatutnya akan lihat**:
- Navigation bar dengan tombol "Login" dan "Register"
- Homepage Laravel

#### Test Register

1. Klik "Register"
2. Isi form:
   - Name: `Mohd Ali`
   - Email: `ali@example.com`
   - Password: `password123`
   - Confirm Password: `password123`
3. Klik "Register"

**Output yang diharapkan**:
- Anda akan di-redirect ke dashboard
- Di navigation bar akan muncul nama pengguna "Mohd Ali"

**File yang dibuat**:
- `app/Models/User.php` (sudah ada)
- `resources/views/auth/register.blade.php`
- `resources/views/auth/login.blade.php`
- `routes/auth.php` (routes untuk auth)
- `app/Http/Controllers/Auth/RegisteredUserController.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

#### Test Login

1. Klik nama pengguna di top-right
2. Klik "Logout"
3. Klik "Login"
4. Masukkan:
   - Email: `ali@example.com`
   - Password: `password123`
5. Klik "Log in"

**Output yang diharapkan**:
- Anda akan login dan redirect ke dashboard
- Anda akan lihat dashboard dengan "You are logged in!"

#### Test Logout

1. Klik nama pengguna di top-right
2. Klik "Log Out"

**Output yang diharapkan**:
- Anda akan logout dan redirect ke homepage
- Navigation bar akan balik menunjukkan "Login" dan "Register"

### Troubleshooting - Lab 4.1

**Masalah 1: "npm not found"**
```
Solusi: Pastikan Node.js sudah dipasang. Download dari https://nodejs.org
```

**Masalah 2: "Class not found" error selepas breeze:install**
```
Solusi: Jalankan:
php artisan cache:clear
composer dump-autoload
php artisan serve
```

**Masalah 3: Halaman login tidak stylesheet yang indah**
```
Solusi: Pastikan `npm run build` sudah selesai, kemudian refresh browser (Ctrl+Shift+R)
```

**Masalah 4: Cannot migrate, table already exists**
```
Solusi:
php artisan migrate:refresh
atau jika ingin semua data hilang:
php artisan migrate:fresh
```

---

## Modul 4.2: Membina API RESTful

### Apa itu REST API?

REST (Representational State Transfer) adalah seni cara membina web services yang fleksibel dan scalable.

#### Prinsip REST:

1. **Stateless**: Setiap request mempunyai semua informasi yang diperlukan
2. **Resource-Oriented**: Gunakan nouns, bukan verbs
3. **Standard HTTP Methods**:
   - `GET` - Ambil data
   - `POST` - Cipta data baru
   - `PUT` - Update data
   - `DELETE` - Padam data

#### HTTP Status Codes:

```
200 OK               - Request successful
201 Created          - Resource created successfully
400 Bad Request      - Invalid request
401 Unauthorized     - Authentication failed
403 Forbidden        - Authentication OK, tapi tidak ada permission
404 Not Found        - Resource tidak dijumpai
500 Server Error     - Server error
```

#### Contoh REST API Design:

```
GET    /api/posts           - Get semua posts
GET    /api/posts/{id}      - Get satu post
POST   /api/posts           - Cipta post baru
PUT    /api/posts/{id}      - Update post
DELETE /api/posts/{id}      - Padam post
```

### routes/api.php dan API Routes

File `routes/api.php` adalah tempat kita define semua API routes.

Perbezaan dengan `routes/web.php`:
- API routes mendapat prefix `/api` secara automatic
- API routes menggunakan token authentication (bukan sessions)
- API routes me-return JSON (bukan HTML)

```php
// Dalam routes/api.php
Route::get('/posts', [PostController::class, 'index']);  // GET /api/posts

// Dalam routes/web.php
Route::get('/posts', [PostController::class, 'index']);  // GET /posts
```

### API Resource Routes

Laravel mempunyai cara shortcut untuk define RESTful routes:

```php
// Membuat 7 routes sekaligus:
Route::apiResource('posts', PostController::class);

// Equivalent dengan:
// GET    /api/posts              -> index()
// POST   /api/posts              -> store()
// GET    /api/posts/{post}       -> show()
// PUT    /api/posts/{post}       -> update()
// DELETE /api/posts/{post}       -> destroy()
```

### API Controllers

API controllers mirip dengan regular controllers, tapi:
- Me-return JSON instead of views
- Tidak ada methods untuk forms (create, edit)

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // GET /api/posts
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Posts retrieved successfully',
            'data' => Post::all()
        ]);
    }

    // POST /api/posts
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = Post::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'data' => $post
        ], 201);
    }

    // GET /api/posts/{id}
    public function show(Post $post)
    {
        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    // PUT /api/posts/{id}
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string'
        ]);

        $post->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }

    // DELETE /api/posts/{id}
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }
}
```

### Returning JSON

Dalam Laravel, kita boleh return JSON dengan cara:

```php
// Cara 1: response()->json()
return response()->json($data);

// Cara 2: Langsung return array (automatic JSON)
return ['status' => 'success', 'data' => $posts];

// Cara 3: Dengan status code
return response()->json($data, 201);

// Cara 4: Dengan headers
return response()->json($data, 200, [
    'X-Custom-Header' => 'value'
]);
```

### API Testing dengan Thunder Client

Thunder Client adalah extension untuk VS Code untuk test API (seperti Postman tapi lebih simple).

#### Install Thunder Client

1. Buka VS Code
2. Pergi ke Extensions (Ctrl+Shift+X)
3. Cari "Thunder Client"
4. Install oleh rangga (official)

#### Test API dengan Thunder Client

1. Buka Thunder Client (ikon kilat di sidebar)
2. Klik "New Request"
3. Pilih HTTP method (GET, POST, etc.)
4. Masukkan URL: `http://localhost:8000/api/posts`
5. Klik "Send"

---

## Lab 4.2: Cipta API CRUD untuk Post

Mari kita cipta API RESTful lengkap untuk Post.

### Langkah 1: Buat API Controller untuk Post

```bash
php artisan make:controller Api/PostController --api
```

**Output yang diharapkan**:
```
Controller created successfully.
```

### Langkah 2: Edit routes/api.php

Buka file `routes/api.php`:

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes untuk Post
Route::apiResource('posts', PostController::class);
```

### Langkah 3: Isi PostController dengan CRUD Methods

Edit `app/Http/Controllers/Api/PostController.php`:

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * GET /api/posts
     * Ambil semua posts
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'success' => true,
            'message' => 'Posts retrieved successfully',
            'data' => $posts
        ]);
    }

    /**
     * POST /api/posts
     * Cipta post baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        try {
            $post = Post::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $post
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/posts/{id}
     * Ambil satu post berdasarkan ID
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    /**
     * PUT /api/posts/{id}
     * Update post
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string'
        ]);

        try {
            $post->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/posts/{id}
     * Padam post
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        try {
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete post',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
```

### Langkah 4: Test API dengan Thunder Client

Mari kita test setiap endpoint.

#### Test 1: GET /api/posts (Ambil Semua Posts)

1. Buka Thunder Client
2. Pilih method: **GET**
3. URL: `http://localhost:8000/api/posts`
4. Klik **Send**

**Expected Output**:
```json
{
  "success": true,
  "message": "Posts retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": "Post Pertama",
      "content": "Ini adalah post pertama saya",
      "created_at": "2026-04-06T10:30:00.000000Z",
      "updated_at": "2026-04-06T10:30:00.000000Z"
    }
  ]
}
```

#### Test 2: POST /api/posts (Cipta Post Baru)

1. Pilih method: **POST**
2. URL: `http://localhost:8000/api/posts`
3. Buka tab **Body**
4. Pilih **JSON**
5. Paste code berikut:
```json
{
  "title": "Post API Baru",
  "content": "Ini adalah post yang dibuat melalui API"
}
```
6. Klik **Send**

**Expected Output** (Status 201):
```json
{
  "success": true,
  "message": "Post created successfully",
  "data": {
    "title": "Post API Baru",
    "content": "Ini adalah post yang dibuat melalui API",
    "id": 2,
    "created_at": "2026-04-06T11:00:00.000000Z",
    "updated_at": "2026-04-06T11:00:00.000000Z"
  }
}
```

#### Test 3: GET /api/posts/{id} (Ambil Satu Post)

1. Pilih method: **GET**
2. URL: `http://localhost:8000/api/posts/1`
3. Klik **Send**

**Expected Output**:
```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Post Pertama",
    "content": "Ini adalah post pertama saya",
    "created_at": "2026-04-06T10:30:00.000000Z",
    "updated_at": "2026-04-06T10:30:00.000000Z"
  }
}
```

#### Test 4: PUT /api/posts/{id} (Update Post)

1. Pilih method: **PUT**
2. URL: `http://localhost:8000/api/posts/1`
3. Body (JSON):
```json
{
  "title": "Post Pertama - Updated",
  "content": "Isi sudah di-update"
}
```
4. Klik **Send**

**Expected Output**:
```json
{
  "success": true,
  "message": "Post updated successfully",
  "data": {
    "id": 1,
    "title": "Post Pertama - Updated",
    "content": "Isi sudah di-update",
    "created_at": "2026-04-06T10:30:00.000000Z",
    "updated_at": "2026-04-06T11:15:00.000000Z"
  }
}
```

#### Test 5: DELETE /api/posts/{id} (Padam Post)

1. Pilih method: **DELETE**
2. URL: `http://localhost:8000/api/posts/2`
3. Klik **Send**

**Expected Output**:
```json
{
  "success": true,
  "message": "Post deleted successfully"
}
```

#### Test 6: GET /api/posts (Confirm Padam)

1. Pilih method: **GET**
2. URL: `http://localhost:8000/api/posts`
3. Klik **Send**

**Expected Output**: Post dengan ID 2 sudah hilang dari list.

### Test dengan cURL (Command Line)

Jika anda tidak mahu guna Thunder Client, boleh guna cURL:

```bash
# GET semua posts
curl http://localhost:8000/api/posts

# Cipta post baru
curl -X POST http://localhost:8000/api/posts \
  -H "Content-Type: application/json" \
  -d '{"title":"Post cURL","content":"Dibuat dengan cURL"}'

# Ambil post dengan ID 1
curl http://localhost:8000/api/posts/1

# Update post ID 1
curl -X PUT http://localhost:8000/api/posts/1 \
  -H "Content-Type: application/json" \
  -d '{"title":"Updated Title"}'

# Padam post ID 1
curl -X DELETE http://localhost:8000/api/posts/1
```

### Troubleshooting - Lab 4.2

**Masalah 1: "Target class [Api\PostController] does not exist"**
```
Solusi: Pastikan anda create controller dengan command yang betul
php artisan make:controller Api/PostController --api
```

**Masalah 2: "POST returns 404"**
```
Solusi: Pastikan route sudah di-define dalam routes/api.php
Jalankan: php artisan route:list untuk lihat semua routes
```

**Masalah 3: "Validation error" ketika POST**
```
Solusi: Pastikan JSON body sudah betul
Contoh yang betul:
{
  "title": "Post Title",
  "content": "Post content here"
}
```

**Masalah 4: Request timeout**
```
Solusi: Pastikan php artisan serve masih running
Jika tidak, jalankan:
php artisan serve
```

---

## Modul 4.3: Hubungan Model (Relationships)

### Apa itu Model Relationships?

Relationships membolehkan kita untuk "menghubungkan" data antara dua model.

Contoh dalam aplikasi blog:
- **User** boleh mempunyai banyak **Posts**
- Setiap **Post** belong kepada satu **User**

### Jenis Relationships

#### 1. One-to-Many (User hasMany Post)

```php
// User model
public function posts()
{
    return $this->hasMany(Post::class);
}

// Usage:
$user = User::find(1);
$user->posts; // Ambil semua posts untuk user ini
```

#### 2. Belongs-To (Post belongsTo User)

```php
// Post model
public function user()
{
    return $this->belongsTo(User::class);
}

// Usage:
$post = Post::find(1);
$post->user; // Ambil user yang punya post ini
```

#### 3. Many-to-Many (Contoh: Post mempunyai banyak Tags)

```php
// Post model
public function tags()
{
    return $this->belongsToMany(Tag::class);
}

// Usage:
$post = Post::find(1);
$post->tags; // Ambil semua tags untuk post ini
```

### Protecting Routes dengan Auth Middleware

Middleware adalah "filter" yang jalan sebelum request sampai ke controller.

#### Middleware Authentication

```php
// routes/web.php

// Route yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('posts', PostController::class);
});

// Alternative: Dalam controller
public function __construct()
{
    $this->middleware('auth')->except('index', 'show');
}
```

#### Auth Guard

Laravel punya beberapa "guards" (authentication mechanisms):
- `web` - Session-based (default)
- `api` - Token-based

```php
// Check jika user sudah login
auth()->check();      // return true/false
auth()->user();       // return User object atau null
auth()->id();         // return user ID atau null

// Check dalam route/controller
if (auth()->check()) {
    echo "User logged in: " . auth()->user()->name;
}
```

### Showing Only User's Posts

Dalam aplikasi blog, user hanya boleh lihat/edit posts mereka sendiri.

```php
// Controller
public function index()
{
    // Hanya posts milik user yang login
    $posts = auth()->user()->posts;

    return view('posts.index', compact('posts'));
}

public function edit(Post $post)
{
    // Authorization: check jika user adalah owner
    if ($post->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    return view('posts.edit', compact('post'));
}
```

---

## Lab 4.3: Hubungkan Post dengan User

Mari kita hubungkan Post model dengan User model.

### Langkah 1: Cipta Migration untuk Add user_id ke Posts

```bash
php artisan make:migration add_user_id_to_posts_table
```

**Output yang diharapkan**:
```
Migration created successfully at database/migrations/2026_04_06_xxxxx_add_user_id_to_posts_table.php
```

### Langkah 2: Edit Migration File

Buka file migration yang baru dibuat dan edit:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Tambah foreign key ke users table
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeignIdFor('User');
        });
    }
};
```

### Langkah 3: Jalankan Migration

```bash
php artisan migrate
```

**Output yang diharapkan**:
```
  database/migrations/2026_04_06_xxxxx_add_user_id_to_posts_table .. 2ms PASSED

  Database migrations completed successfully.
```

### Langkah 4: Update Post Model

Edit `app/Models/Post.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    /**
     * Post belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### Langkah 5: Update User Model

Edit `app/Models/User.php`:

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User has many Posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

### Langkah 6: Update PostController - Create Method

Edit `app/Http/Controllers/PostController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // Posts methods memerlukan authentication
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        // Semua orang boleh lihat semua posts
        $posts = Post::with('user')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        // Tambah user_id dari auth()->id()
        $validated['user_id'] = auth()->id();

        Post::create($validated);

        return redirect()->route('posts.index')
                        ->with('success', 'Post created successfully');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        // Check jika user adalah owner
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)
                        ->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', 'Post deleted successfully');
    }
}
```

### Langkah 7: Cipta Policy untuk Authorization

```bash
php artisan make:policy PostPolicy --model=Post
```

**Output yang diharapkan**:
```
Policy created successfully.
```

Edit `app/Policies/PostPolicy.php`:

```php
<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
```

### Langkah 8: Update Views untuk Papar Nama Author

Edit `resources/views/posts/index.blade.php`:

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('posts.create') }}" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
                        Create New Post
                    </a>

                    @forelse($posts as $post)
                        <div class="mb-4 border-b pb-4">
                            <h3 class="text-lg font-bold">{{ $post->title }}</h3>
                            <p class="text-sm text-gray-600">
                                By <strong>{{ $post->user->name }}</strong>
                                on {{ $post->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="mt-2">{{ Str::limit($post->content, 100) }}</p>

                            <div class="mt-2">
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-500">View</a>
                                @can('update', $post)
                                    <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 ml-2">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 ml-2">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p>No posts found</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

Edit `resources/views/posts/show.blade.php`:

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-sm text-gray-600 mb-4">
                        By <strong>{{ $post->user->name }}</strong>
                        on {{ $post->created_at->format('d/m/Y H:i') }}
                    </p>

                    <div class="mt-4">
                        {{ $post->content }}
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('posts.index') }}" class="text-blue-500">Back to Posts</a>
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 ml-4">Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

### Langkah 9: Test

1. Login sebagai user pertama
2. Create post baru
3. Logout dan login sebagai user lain
4. Coba edit post user pertama - sepatutnya dapat error 403

---

## Modul 4.4: Amalan Terbaik dan Deployment

### Security Best Practices

#### 1. Protect .env File

File `.env` mengandung sensitif data seperti database password, API keys, dll.

```bash
# Jangan pernah commit .env ke git
# Dalam .gitignore:
.env
.env.local
.env.*.php
```

#### 2. Environment Configurations

```php
// Jangan hardcode values
// JANGAN:
$password = 'root123';

// BETUL:
$password = env('DB_PASSWORD');
```

#### 3. Validate dan Sanitize Input

```php
// Validate input
$validated = $request->validate([
    'email' => 'required|email',
    'password' => 'required|min:8'
]);

// Sanitize data sebelum simpan
$data = $request->sanitize();
```

#### 4. CSRF Protection

Laravel automatically protect CSRF attacks. Pastikan token ada dalam forms:

```blade
<form method="POST">
    @csrf  <!-- Important! -->
    <!-- form fields -->
</form>
```

#### 5. Secure Passwords

```php
// Hash passwords
$password = Hash::make('plaintext');

// Check password
if (Hash::check('plaintext', $hashed)) {
    // Passwords match
}
```

### Naming Conventions

#### Table Names (plural, snake_case)
```
users
posts
comments
user_posts (pivot table)
```

#### Column Names (singular, snake_case)
```
user_id (foreign key)
created_at
updated_at
is_active
```

#### Model Names (singular, PascalCase)
```
User
Post
Comment
```

#### Controller Names (PascalCase)
```
PostController
UserController
CommentController
ApiPostController
```

#### Method Names (camelCase)
```
getActivePosts()
createNewUser()
updateUserEmail()
```

#### Route Names (kebab-case)
```
posts.index
posts.create
posts.show
posts.edit
posts.update
posts.destroy
```

### Form Request Classes

Alih-alih validate dalam controller, guna Form Requests untuk clean code:

```bash
php artisan make:request StorePostRequest
```

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'content.required' => 'Content is required'
        ];
    }
}
```

Guna dalam controller:

```php
public function store(StorePostRequest $request)
{
    // Data sudah validated
    $validated = $request->validated();

    Post::create($validated);

    return redirect()->route('posts.index');
}
```

### Caching

Caching mempercepat aplikasi dengan menyimpan data expensive operations.

```php
// Cache data selama 60 minit
$posts = cache()->remember('all_posts', 60 * 60, function () {
    return Post::all();
});

// Atau guna helper:
$posts = cache('all_posts') ?? Post::all();

// Clear cache
cache()->forget('all_posts');
cache()->flush(); // Clear semua cache
```

### Common Artisan Commands

```bash
# Database
php artisan migrate              # Run migrations
php artisan migrate:refresh      # Rollback dan run semula
php artisan migrate:fresh        # Fresh database (delete semua)
php artisan migrate:rollback     # Undo last migration
php artisan seed                 # Run seeders
php artisan tinker               # Interactive shell

# Cache
php artisan cache:clear          # Clear app cache
php artisan config:cache         # Cache configuration
php artisan route:cache          # Cache routes
php artisan view:cache           # Cache views

# Generate
php artisan make:model Post      # Create model
php artisan make:controller PostController  # Create controller
php artisan make:migration create_posts_table  # Create migration
php artisan make:request StorePostRequest  # Create form request

# Development
php artisan serve                # Run development server
php artisan optimize             # Optimize application
php artisan storage:link         # Link storage directory

# List
php artisan route:list           # List semua routes
php artisan command:list         # List semua commands
```

### Deployment Options

#### 1. Shared Hosting (Using cPanel)

**Pros**:
- Murah
- Mudah setup
- Shared resources

**Cons**:
- Limited control
- Shared server performance
- Tidak ideal untuk aplikasi besar

**Deployment Steps**:
1. Upload files ke `/public_html` folder
2. Copy `.env.example` jadi `.env`
3. Generate app key: `php artisan key:generate`
4. Setup database
5. Run migrations: `php artisan migrate`

#### 2. Laravel Forge

**Pros**:
- Managed hosting
- Auto deployment dari GitHub
- Auto SSL certificates
- Server management tools

**Cons**:
- Lebih mahal
- Overkill untuk project kecil

**Website**: https://forge.laravel.com

#### 3. Railway.app / Vercel / Heroku

**Pros**:
- Free tier available
- Easy deployment
- Auto scaling
- Modern infrastructure

**Cons**:
- Limited free resources
- Database limitations

**Railway Deployment** (recommended untuk beginners):
1. Push code ke GitHub
2. Signup di railway.app
3. Connect GitHub repository
4. Set environment variables
5. Deploy

---

## Lab 4.4: Setup Deployment (Railway)

Mari kita prepare aplikasi untuk deployment ke Railway.

### Langkah 1: Prepare untuk Production

```bash
# Generate app key (jika belum)
php artisan key:generate

# Clear cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Langkah 2: Create Production .env File

Buat file `.env.production`:

```bash
APP_NAME=Blog
APP_ENV=production
APP_KEY=base64:xxxxx (sama seperti .env)
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```

### Langkah 3: Commit ke GitHub

```bash
git add .
git commit -m "Prepare for deployment"
git push origin main
```

### Langkah 4: Deploy ke Railway

1. Pergi ke railway.app
2. Click "Start New Project"
3. Pilih "Deploy from GitHub repo"
4. Select your repository
5. Configure environment variables
6. Deploy!

---

## Projek Akhir: Aplikasi Blog Lengkap

Sekarang mari kita cipta aplikasi blog yang LENGKAP dengan semua features!

### Requirements Checklist

Aplikasi blog anda harus mempunyai:

#### Authentication & Authorization
- [x] User registration
- [x] User login/logout
- [x] Password hashing
- [x] User can only edit/delete own posts

#### Posts Management
- [x] Create post (authenticated users only)
- [x] Read/view all posts
- [x] Read/view single post with author info
- [x] Update post (only owner)
- [x] Delete post (only owner)
- [x] Posts displayed with author name dan creation date

#### API (Optional but recommended)
- [x] REST API untuk posts (GET, POST, PUT, DELETE)
- [x] JSON responses dengan proper status codes
- [x] API documentation

#### User Experience
- [x] Navigation bar dengan auth status
- [x] Dashboard untuk logged-in users
- [x] Flash messages untuk success/error
- [x] Form validation dengan error messages
- [x] Responsive design (Bootstrap or Tailwind)

#### Database
- [x] Users table dengan proper fields
- [x] Posts table dengan user_id foreign key
- [x] Timestamps (created_at, updated_at)

### Step-by-Step Implementation

#### Step 1: Verify All Migrations

```bash
php artisan migrate:fresh
```

Semua tables sepatutnya sudah ada.

#### Step 2: Create Sample Data (Seeders)

```bash
php artisan make:seeder UserSeeder
php artisan make:seeder PostSeeder
```

Edit `database/seeders/UserSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Mohd Ali',
            'email' => 'ali@example.com',
            'password' => Hash::make('password123')
        ]);

        User::create([
            'name' => 'Siti Zainab',
            'email' => 'siti@example.com',
            'password' => Hash::make('password123')
        ]);
    }
}
```

Edit `database/seeders/PostSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Post::create([
                'title' => 'Post pertama dari ' . $user->name,
                'content' => 'Ini adalah post pertama dari ' . $user->name,
                'user_id' => $user->id
            ]);
        }
    }
}
```

Edit `database/seeders/DatabaseSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
        ]);
    }
}
```

Run seeders:

```bash
php artisan db:seed
```

#### Step 3: Update Views

Pastikan semua views sudah proper:

- `resources/views/posts/index.blade.php` - List all posts dengan author info
- `resources/views/posts/create.blade.php` - Form untuk create post
- `resources/views/posts/edit.blade.php` - Form untuk edit post
- `resources/views/posts/show.blade.php` - Single post view dengan author

#### Step 4: Test Everything

```bash
# Run development server
php artisan serve

# Di terminal lain
npm run dev
```

Test semua functionality:
- Register new user
- Login
- Create post
- Edit own post
- Try edit other user's post (should fail)
- Delete post
- Logout

#### Step 5: Test API

Guna Thunder Client atau cURL untuk test semua API endpoints:

```bash
# GET all posts
curl http://localhost:8000/api/posts

# Create post
curl -X POST http://localhost:8000/api/posts \
  -H "Content-Type: application/json" \
  -d '{"title":"API Post","content":"Created via API"}'

# Update post
curl -X PUT http://localhost:8000/api/posts/1 \
  -H "Content-Type: application/json" \
  -d '{"title":"Updated Title"}'

# Delete post
curl -X DELETE http://localhost:8000/api/posts/1
```

### Bonus Challenges (Optional)

Jika anda ingin lebih challenge, coba features ini:

#### 1. Categories/Tags

```bash
# Create model dan migration
php artisan make:model Category -m
php artisan make:model Tag -m

# Create many-to-many relationship
php artisan make:migration create_post_tag_table
```

Cipta relationship:
```php
// Post model
public function tags()
{
    return $this->belongsToMany(Tag::class);
}

// Tag model
public function posts()
{
    return $this->belongsToMany(Post::class);
}
```

#### 2. Comments

```bash
php artisan make:model Comment -m
```

Migration:
```php
Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('post_id')->constrained()->onDelete('cascade');
    $table->text('content');
    $table->timestamps();
});
```

Relationships:
```php
// Post model
public function comments()
{
    return $this->hasMany(Comment::class);
}

// Comment model
public function post()
{
    return $this->belongsTo(Post::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
```

#### 3. Image Upload

```bash
php artisan storage:link
```

Migration:
```php
$table->string('image_path')->nullable();
```

Controller:
```php
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('posts', 'public');
    $validated['image_path'] = $path;
}
```

View:
```blade
@if($post->image_path)
    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}">
@endif
```

#### 4. Search/Filter

```php
public function index(Request $request)
{
    $query = Post::with('user');

    if ($request->has('search')) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('content', 'like', '%' . $request->search . '%');
    }

    $posts = $query->get();

    return view('posts.index', compact('posts'));
}
```

#### 5. Pagination

```php
public function index()
{
    $posts = Post::paginate(10);
    return view('posts.index', compact('posts'));
}
```

View:
```blade
{{ $posts->links() }}
```

---

## Rujukan Pantas Artisan

Semua command artisan yang kita pelajari dalam kursus ini:

| Command | Kegunaan |
|---------|----------|
| `php artisan serve` | Jalankan development server |
| `php artisan migrate` | Run database migrations |
| `php artisan migrate:fresh` | Refresh database (delete all) |
| `php artisan migrate:rollback` | Undo migrations |
| `php artisan make:model Post` | Create model |
| `php artisan make:model Post -m` | Create model with migration |
| `php artisan make:controller PostController` | Create controller |
| `php artisan make:controller Api/PostController --api` | Create API controller |
| `php artisan make:migration create_posts_table` | Create migration |
| `php artisan make:request StorePostRequest` | Create form request |
| `php artisan make:policy PostPolicy --model=Post` | Create authorization policy |
| `php artisan make:seeder UserSeeder` | Create seeder |
| `php artisan db:seed` | Run seeders |
| `php artisan breeze:install blade` | Install Laravel Breeze |
| `php artisan cache:clear` | Clear application cache |
| `php artisan config:cache` | Cache configuration |
| `php artisan route:cache` | Cache routes |
| `php artisan view:cache` | Cache views |
| `php artisan optimize` | Optimize application |
| `php artisan route:list` | List all routes |
| `php artisan tinker` | Interactive shell |
| `php artisan key:generate` | Generate application key |
| `php artisan storage:link` | Link storage directory |
| `composer require package/name` | Install composer package |
| `npm install` | Install npm packages |
| `npm run dev` | Run development mode |
| `npm run build` | Build for production |

---

## Ringkasan dan Langkah Seterusnya

Tahniah! Anda sudah menyelesaikan kursus Laravel 4 Hari!

### Apa yang anda sudah pelajari:

**Hari 1: Basics**
- Laravel structure dan MVC pattern
- Routing dan controllers
- Database setup dengan Eloquent ORM
- Models dan migrations

**Hari 2: Forms & Validation**
- Creating forms dengan Blade
- Form validation
- CRUD operations
- Displaying data dalam views

**Hari 3: Relationships & Advanced Features**
- Model relationships (hasMany, belongsTo)
- Eloquent query builders
- Advanced form handling
- File uploads

**Hari 4: Authentication & Deployment**
- Laravel Breeze authentication
- Building RESTful APIs
- User authorization dengan policies
- Deployment strategies

### Langkah Seterusnya untuk Lanjut Belajar:

#### 1. **Laravel Livewire**
Framework untuk membina reactive components dalam Blade tanpa JavaScript.

```bash
composer require livewire/livewire
```

Dengan Livewire, anda boleh membuat interactive features seperti real-time search, notifications, dll.

**Resource**: https://livewire.laravel.com

#### 2. **Inertia.js**
Kombinasi Laravel backend dengan Vue/React frontend.

Sesuai untuk membina Single Page Applications (SPAs) dengan power Laravel.

**Resource**: https://inertiajs.com

#### 3. **Filament**
Admin dashboard builder untuk Laravel.

Cipta admin panel dalam minit, bukan hari!

**Resource**: https://filamentphp.com

#### 4. **Laravel Pint**
Code style formatter untuk Laravel.

```bash
composer require laravel/pint --dev
./vendor/bin/pint
```

#### 5. **Testing dengan PHPUnit**

Tulis automated tests untuk code anda:

```bash
php artisan make:test PostControllerTest
php artisan test
```

#### 6. **Database Query Optimization**

Pelajari N+1 problem dan cara solve dengan eager loading:

```php
// Bad - N+1 problem
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name;  // Query ke database setiap iteration
}

// Good - Eager loading
$posts = Post::with('user')->get();
```

#### 7. **Laravel Community Malaysia**

Join komunitas Laravel Malaysia untuk networking dan learning:

- **GitHub**: Search "Laravel Malaysia"
- **Facebook**: Laravel Malaysia Developer Group
- **Discord**: Laravel Asia community
- **Twitter**: Follow @laravelmalaysia

#### 8. **Real-world Projects**

Cubalah membuat projects sendiri:

1. **Todo App** - Pelajari CRUD, user tasks
2. **E-commerce** - Products, cart, payments
3. **Forum** - Topics, posts, comments, user profiles
4. **Social Media** - Posts, likes, comments, followers
5. **CMS** - Content management system

### Recommended Learning Resources:

1. **Official Laravel Documentation**
   - https://laravel.com/docs
   - Lengkap dan always updated

2. **Laracasts**
   - https://laracasts.com
   - Video tutorials dari Jeffrey Way
   - Mulai dari basic hingga advanced

3. **Laravel News**
   - https://laravel-news.com
   - Artikel, tips, dan latest updates

4. **YouTube Channels**
   - "Traversy Media" - General web dev
   - "Codewithdary" - Laravel tutorials
   - "Web Dev Simplified" - JavaScript fundamentals

5. **Book: "Laravel Up and Running"**
   - Oleh Matt Stauffer
   - Comprehensive guide untuk Laravel

---

## Final Checklist - Pastikan Semua Siap:

Sebelum anda submit projek final atau deploy ke production:

- [ ] Semua CRUD operations berfungsi dengan baik
- [ ] Authentication dan authorization bekerja
- [ ] API endpoints tested dan working
- [ ] Database migrations berjalan tanpa error
- [ ] Views di-design dan responsive
- [ ] Validation bekerja untuk semua forms
- [ ] Flash messages di-display untuk success/error
- [ ] .env file sudah di-exclude dari git
- [ ] No hardcoded values dalam code
- [ ] Proper naming conventions digunakan
- [ ] Comments/documentation dalam code yang complex
- [ ] Testing dilakukan (manual atau automated)
- [ ] Database seeders ready untuk development

---

## Troubleshooting Guide - Common Issues

### Issue: "Class not found" Error

**Solution**:
```bash
composer dump-autoload
php artisan cache:clear
```

### Issue: Database Connection Error

**Solution**:
1. Pastikan MySQL running
2. Check .env file untuk correct database credentials
3. Pastikan database sudah dibuat
4. Run: `php artisan migrate`

### Issue: CSRF Token Mismatch

**Solution**:
Pastikan form punya `@csrf` token:
```blade
<form method="POST">
    @csrf
    <!-- fields -->
</form>
```

### Issue: 403 Forbidden pada Edit/Delete

**Solution**:
Ini adalah by design untuk authorization. Check:
1. User sudah login
2. User adalah owner post
3. Policy di-authorize dengan betul

### Issue: API Returns 404

**Solution**:
```bash
# Check routes
php artisan route:list

# Pastikan controller dan route define dengan betul
# Pastikan URL sama seperti dalam route
```

### Issue: npm run build tidak jalan

**Solution**:
```bash
# Clear dan reinstall
rm -rf node_modules package-lock.json
npm install
npm run build
```

---

## Terima Kasih!

Terima kasih sudah mengikuti kursus Laravel 4 Hari. Semoga kursus ini membantu anda untuk memahami Laravel dan membina aplikasi web yang powerful.

**Jangan lupa**:
- Practice membuat projects
- Read official documentation
- Join Laravel community
- Share your projects di GitHub
- Terus belajar dan improve skills

Selamat berjaya dalam journey Laravel anda!

---

**Dibuat**: 6 April 2026
**Version**: 1.0
**Language**: Bahasa Melayu
**Level**: Beginner to Intermediate
