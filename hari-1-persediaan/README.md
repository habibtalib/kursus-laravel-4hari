# Hari 1: Persediaan Persekitaran Pembangunan

## Objektif Pembelajaran

Pada akhir Hari 1, anda akan dapat:

- Memahami apa itu Laravel dan kelebihannya
- Memasang semua perisian yang diperlukan pada Windows
- Mengkonfigurasi Laragon, MySQL, dan VS Code
- Mencipta projek Laravel pertama anda
- Memahami struktur direktori Laravel

---

## Modul 1.1: Pengenalan kepada Laravel

### Apa itu Laravel?

Laravel ialah rangka kerja (framework) PHP sumber terbuka yang direka untuk memudahkan pembangunan aplikasi web. Ia mengikuti corak seni bina **Model-View-Controller (MVC)** yang memisahkan logik perniagaan, data, dan paparan.

### Kenapa Laravel?

- **Sintaks Elegan** — Kod yang bersih dan mudah dibaca
- **Ekosistem Lengkap** — Artisan CLI, Eloquent ORM, Blade templating
- **Keselamatan Terbina Dalam** — Perlindungan CSRF, SQL injection, XSS
- **Komuniti Aktif** — Dokumentasi yang sangat baik dan banyak pakej pihak ketiga
- **Pembangunan Pantas** — Banyak ciri "out-of-the-box" menjimatkan masa

### Corak MVC

```
Pengguna (Pelayar)
    │
    ▼
  Routes (Laluan) ──► Controller (Pengawal) ──► Model (Data/DB)
                            │
                            ▼
                      View (Paparan/Blade)
                            │
                            ▼
                    Respons ke Pengguna
```

- **Model** — Berinteraksi dengan pangkalan data (jadual, pertanyaan)
- **View** — Paparan HTML yang dilihat oleh pengguna (Blade templates)
- **Controller** — Logik yang menghubungkan Model dan View

---

## Modul 1.2: Keperluan Sistem & Perisian

### Senarai Perisian yang Diperlukan

| # | Perisian | Versi | Tujuan | Saiz |
|---|----------|-------|--------|------|
| 1 | **Laragon** | v6.0+ | Persekitaran pembangunan (Apache, PHP, MySQL) | ~80MB |
| 2 | **PHP** | 8.1+ | Bahasa pengaturcaraan (dipasang melalui Laragon) | — |
| 3 | **Composer** | v2.x | Pengurus kebergantungan PHP (dipasang melalui Laragon) | — |
| 4 | **MySQL** | 8.0+ | Pangkalan data hubungan (dipasang melalui Laragon) | — |
| 5 | **VS Code** | Terkini | Editor kod utama | ~90MB |
| 6 | **Node.js** | v18+ | Pengurus aset frontend (Vite) | ~30MB |
| 7 | **Git** | v2.x | Kawalan versi (dipasang melalui Laragon) | — |
| 8 | **Chrome** | Terkini | Pelayar web untuk ujian & DevTools | — |

### Kenapa Laragon dan Bukan XAMPP/WAMP?

| Ciri | Laragon | XAMPP | WAMP |
|------|---------|-------|------|
| Saiz | ~80MB | ~150MB | ~120MB |
| Masa mula | 3 saat | 10-15 saat | 10-15 saat |
| Auto Virtual Host | Ya (projek.test) | Tidak | Tidak |
| Tukar versi PHP | Satu klik | Manual | Manual |
| Terminal terbina dalam | Ya (dengan PATH) | Tidak | Tidak |
| Composer terbina dalam | Ya | Tidak | Tidak |
| Git terbina dalam | Ya | Tidak | Tidak |

---

## Modul 1.3: Pemasangan Perisian

> **PENTING:** Ikut langkah ini mengikut urutan. Jangan langkau mana-mana langkah.

### Langkah 1: Muat Turun dan Pasang Laragon

1. Buka pelayar dan pergi ke: **https://laragon.org/download/index.html**
2. Klik butang **"Download Laragon Full (64-bit)"**
3. Jalankan fail `.exe` yang dimuat turun
4. Dalam wizard pemasangan:
   - Pilih bahasa: **English**
   - Lokasi pemasangan: **`C:\laragon`** (biarkan lalai)
   - Pastikan kotak berikut ditanda:
     - ✅ Auto Virtual Hosts
     - ✅ Add Laragon to PATH
   - Klik **Install**
5. Tunggu sehingga pemasangan selesai
6. Klik **Finish**

**Pengesahan:**
```
Buka Laragon > Klik "Start All"
Buka pelayar > Pergi ke http://localhost
Anda sepatutnya nampak halaman Laragon
```

### Langkah 2: Muat Turun dan Pasang VS Code

1. Pergi ke: **https://code.visualstudio.com/download**
2. Klik **"Windows (User Installer)"**
3. Jalankan pemasang
4. Dalam wizard:
   - ✅ Tandakan "Add to PATH"
   - ✅ Tandakan "Register Code as an editor for supported file types"
   - Klik **Install**

### Langkah 3: Muat Turun dan Pasang Node.js

1. Pergi ke: **https://nodejs.org/**
2. Muat turun versi **LTS** (Long Term Support)
3. Jalankan pemasang dengan pilihan lalai
4. **Pengesahan** — Buka Command Prompt:
   ```
   node --version
   npm --version
   ```

### Langkah 4: Sahkan Semua Perisian

Buka **Terminal Laragon** (Klik kanan ikon Laragon > Terminal) dan jalankan:

```bash
# Sahkan PHP
php --version
# Jangkaan: PHP 8.x.x

# Sahkan Composer
composer --version
# Jangkaan: Composer version 2.x.x

# Sahkan Git
git --version
# Jangkaan: git version 2.x.x

# Sahkan Node.js
node --version
# Jangkaan: v18.x.x atau lebih tinggi

# Sahkan npm
npm --version
```

> **Penyelesaian Masalah:** Jika `composer` atau `git` tidak dikenali, tutup dan buka semula Terminal Laragon. Jika masih tidak berjaya, pastikan Laragon telah dimulakan ("Start All").

---

## Modul 1.4: Pasang Sambungan VS Code

Buka VS Code dan tekan `Ctrl+Shift+X` untuk membuka panel Extensions.

### Sambungan Wajib

Cari dan pasang sambungan berikut:

1. **PHP Intelephense** — Autocomplete, diagnostik, dan go-to-definition untuk PHP
2. **Laravel Blade Snippets** — Penyerlahan sintaks untuk fail `.blade.php`
3. **Laravel Snippets** — Snippet pantas untuk Route, Controller, Model
4. **DotENV** — Penyerlahan sintaks untuk fail `.env`

### Sambungan Disyorkan

5. **PHP DocBlocker** — Jana dokumentasi PHPDoc secara automatik
6. **Thunder Client** — Klien API terbina dalam (alternatif Postman)
7. **MySQL (by Weijan Chen)** — Sambung ke MySQL dari VS Code
8. **GitLens** — Lihat sejarah Git dan blame

### Konfigurasi VS Code

Buka Settings (`Ctrl+,`) dan tambah tetapan berikut dalam `settings.json`:

```json
{
    "editor.tabSize": 4,
    "editor.formatOnSave": true,
    "files.associations": {
        "*.blade.php": "blade"
    },
    "emmet.includeLanguages": {
        "blade": "html"
    }
}
```

---

## Lab 1.1: Konfigurasi Laragon & MySQL

### Langkah 1: Mulakan Laragon

1. Buka aplikasi Laragon
2. Klik butang **"Start All"**
3. Pastikan kedua-dua **Apache** dan **MySQL** berstatus hijau (running)

### Langkah 2: Buka phpMyAdmin

1. Klik kanan ikon Laragon di system tray
2. Pilih **MySQL > phpMyAdmin**
3. Atau buka pelayar dan pergi ke: **http://localhost/phpmyadmin**
4. Log masuk dengan:
   - Username: **root**
   - Password: *(kosongkan)*

### Langkah 3: Cipta Pangkalan Data

1. Di phpMyAdmin, klik **"New"** di panel kiri
2. Masukkan nama pangkalan data: **`laravel_blog`**
3. Pilih Collation: **`utf8mb4_unicode_ci`**
4. Klik **"Create"**

**Output yang dijangka:**
```
Pangkalan data "laravel_blog" telah dicipta.
Anda akan nampak "laravel_blog" dalam senarai di sebelah kiri.
```

---

## Lab 1.2: Cipta Projek Laravel Pertama

### Langkah 1: Buka Terminal Laragon

1. Klik kanan ikon Laragon > **Terminal**
2. Terminal akan dibuka di folder `C:\laragon\www`

### Langkah 2: Cipta Projek

```bash
composer create-project laravel/laravel blog
```

> **Nota:** Proses ini mengambil masa 2-5 minit bergantung pada kelajuan internet. Ia akan memuat turun semua kebergantungan Laravel.

**Output yang dijangka:**
```
Creating a "laravel/laravel" project at "./blog"
Installing laravel/laravel (v11.x.x)
  - Downloading laravel/laravel (v11.x.x)
...
Application key set successfully.
```

### Langkah 3: Konfigurasi Fail `.env`

1. Buka folder projek dalam VS Code:
   ```bash
   cd blog
   code .
   ```

2. Buka fail `.env` di root projek dan kemas kini tetapan pangkalan data:

```env
APP_NAME=Blog
APP_ENV=local
APP_KEY=base64:... (sudah dijana)
APP_DEBUG=true
APP_URL=http://blog.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_blog
DB_USERNAME=root
DB_PASSWORD=
```

> **PENTING:** Pastikan `DB_DATABASE` sepadan dengan nama pangkalan data yang anda cipta dalam phpMyAdmin tadi.

### Langkah 4: Jalankan Pelayan

**Pilihan A — Menggunakan Artisan:**
```bash
php artisan serve
```
Buka pelayar: **http://127.0.0.1:8000**

**Pilihan B — Menggunakan Laragon (disyorkan):**

Laragon secara automatik mencipta virtual host. Buka pelayar dan pergi ke:
**http://blog.test**

> **Penyelesaian Masalah:** Jika `blog.test` tidak berfungsi:
> 1. Pastikan Laragon sedang berjalan
> 2. Klik kanan Laragon > Apache > Reload
> 3. Cuba buka `http://blog.test` semula

**Output yang dijangka:**
```
Anda akan melihat halaman selamat datang Laravel
dengan teks "Laravel" dan butang navigasi.
```

### Langkah 5: Uji Sambungan Pangkalan Data

```bash
php artisan migrate
```

**Output yang dijangka:**
```
Migration table created successfully.
Running migrations...
2024_xx_xx_000000_create_users_table ........... DONE
2024_xx_xx_000001_create_password_reset_tokens_table ... DONE
2024_xx_xx_000002_create_sessions_table ........ DONE
2024_xx_xx_000003_create_cache_table ........... DONE
2024_xx_xx_000004_create_jobs_table ............ DONE
```

> Jika anda mendapat ralat sambungan, semak semula tetapan `DB_*` dalam fail `.env` dan pastikan MySQL sedang berjalan dalam Laragon.

---

## Modul 1.5: Struktur Direktori Laravel

Selepas mencipta projek, ini adalah struktur folder utama:

```
blog/
├── app/                    # Logik teras aplikasi
│   ├── Http/
│   │   ├── Controllers/    # Pengawal (Controllers)
│   │   └── Middleware/     # Middleware
│   ├── Models/             # Model Eloquent
│   └── Providers/          # Service Providers
├── bootstrap/              # Fail permulaan rangka kerja
├── config/                 # Fail konfigurasi
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── ...
├── database/
│   ├── factories/          # Factory untuk data ujian
│   ├── migrations/         # Fail migrasi pangkalan data
│   └── seeders/            # Seeder untuk data awal
├── public/                 # Titik masuk utama
│   └── index.php           # Front controller
├── resources/
│   ├── css/                # Fail CSS sumber
│   ├── js/                 # Fail JavaScript sumber
│   └── views/              # Paparan Blade (.blade.php)
├── routes/
│   ├── web.php             # Laluan untuk pelayar web
│   ├── api.php             # Laluan untuk API
│   └── console.php         # Arahan Artisan tersuai
├── storage/                # Log, cache, sesi, fail dimuat naik
├── tests/                  # Fail ujian
├── .env                    # Konfigurasi persekitaran (RAHSIA!)
├── .env.example            # Contoh fail .env
├── artisan                 # CLI Laravel
├── composer.json           # Kebergantungan PHP
├── package.json            # Kebergantungan Node.js
└── vite.config.js          # Konfigurasi Vite (aset frontend)
```

### Fail & Folder Paling Penting untuk Pemula

| Fail/Folder | Kekerapan Guna | Tujuan |
|-------------|----------------|--------|
| `routes/web.php` | Sangat kerap | Tentukan semua URL aplikasi |
| `app/Http/Controllers/` | Sangat kerap | Logik untuk setiap halaman |
| `app/Models/` | Kerap | Interaksi dengan pangkalan data |
| `resources/views/` | Sangat kerap | Fail HTML/Blade untuk paparan |
| `database/migrations/` | Kerap | Struktur jadual pangkalan data |
| `.env` | Kadang-kadang | Konfigurasi (DB, API keys) |
| `config/` | Jarang | Tetapan rangka kerja |

---

## Lab 1.3: Meneroka Projek dalam VS Code

### Tugasan

1. Buka fail `routes/web.php` — ini adalah fail pertama yang Laravel baca apabila menerima permintaan
2. Buka fail `resources/views/welcome.blade.php` — ini adalah halaman selamat datang
3. Buka fail `.env` — ini mengandungi konfigurasi aplikasi anda
4. Buka Terminal dalam VS Code (`Ctrl+``) dan jalankan:
   ```bash
   php artisan route:list
   ```
   Ini memaparkan semua laluan yang telah didaftarkan.

### Cuba Ubah Halaman Selamat Datang

1. Buka `resources/views/welcome.blade.php`
2. Cari teks "Laravel" dan tukar kepada "Selamat Datang ke Blog Saya"
3. Simpan fail (`Ctrl+S`)
4. Muat semula pelayar — anda akan nampak perubahan serta-merta!

---

## Ringkasan Hari 1

| Topik | Status |
|-------|--------|
| Memahami apa itu Laravel & MVC | ✅ |
| Memasang Laragon (Apache + PHP + MySQL) | ✅ |
| Memasang VS Code + sambungan | ✅ |
| Memasang Node.js | ✅ |
| Mengkonfigurasi MySQL & phpMyAdmin | ✅ |
| Mencipta projek Laravel pertama | ✅ |
| Menjalankan migrasi pertama | ✅ |
| Memahami struktur direktori | ✅ |

## Persediaan untuk Hari 2

Pastikan sebelum pulang:
1. ✅ Laragon boleh dimulakan tanpa ralat
2. ✅ `http://blog.test` memaparkan halaman Laravel
3. ✅ `php artisan migrate` berjaya tanpa ralat
4. ✅ VS Code boleh membuka folder projek `blog`
