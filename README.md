# Kursus Laravel 4 Hari — Bahasa Melayu

Kursus latihan amali Laravel untuk pemula, sepenuhnya dalam Bahasa Melayu. Kursus ini menggunakan **Laragon** sebagai persekitaran pembangunan pada **Windows** dan merangkumi semua asas yang diperlukan untuk membina aplikasi web dengan Laravel.

## Ringkasan Kursus

| Hari | Topik | Fokus |
|------|-------|-------|
| [**Hari 1**](./hari-1-persediaan/) | Persediaan Persekitaran | Laragon, MySQL, VS Code, Composer, projek pertama |
| [**Hari 2**](./hari-2-penghalaan-pengawal/) | Penghalaan & Pengawal | Routes, Controllers, Middleware, Request/Response |
| [**Hari 3**](./hari-3-paparan-pangkalan-data/) | Paparan & Pangkalan Data | Blade templates, Eloquent ORM, Migrations, Validation |
| [**Hari 4**](./hari-4-lanjutan-projek/) | Ciri Lanjutan & Projek | Authentication, API, Deployment, Projek Blog |

## Keperluan Sistem

Sebelum memulakan kursus, pastikan anda mempunyai:

- Windows 10/11 (64-bit)
- Minimum 4GB RAM (8GB disyorkan)
- 2GB ruang cakera kosong
- Sambungan internet

## Perisian yang Diperlukan

| Perisian | Tujuan | Pautan Muat Turun |
|----------|--------|-------------------|
| Laragon | Apache + PHP + MySQL | [laragon.org](https://laragon.org/download/) |
| VS Code | Editor kod | [code.visualstudio.com](https://code.visualstudio.com/) |
| Node.js | Aset frontend (Vite) | [nodejs.org](https://nodejs.org/) |
| Chrome | Pelayar & DevTools | [google.com/chrome](https://www.google.com/chrome/) |

> **Nota:** Composer, Git, dan PHP sudah disertakan dalam Laragon. Tidak perlu pasang berasingan.

## Struktur Repositori

```
kursus-laravel-4hari/
├── README.md                          # Fail ini
├── hari-1-persediaan/
│   ├── README.md                      # Nota lengkap Hari 1
│   ├── lab/
│   │   └── env-contoh.txt             # Contoh fail .env
│   └── rujukan/
│       └── senarai-semak.md           # Senarai semak persediaan
├── hari-2-penghalaan-pengawal/
│   ├── README.md                      # Nota lengkap Hari 2
│   ├── lab/
│   │   ├── web.php                    # Contoh fail routes
│   │   └── PostController.php         # Contoh pengawal
│   └── rujukan/
│       └── arahan-http.md             # Rujukan kaedah HTTP
├── hari-3-paparan-pangkalan-data/
│   ├── README.md                      # Nota lengkap Hari 3
│   ├── lab/
│   │   ├── app.blade.php              # Contoh layout
│   │   ├── create_posts_table.php     # Contoh migrasi
│   │   └── Post.php                   # Contoh model
│   └── rujukan/
│       └── blade-cheatsheet.md        # Rujukan Blade
├── hari-4-lanjutan-projek/
│   ├── README.md                      # Nota lengkap Hari 4
│   ├── lab/
│   │   ├── api.php                    # Contoh laluan API
│   │   └── PostApiController.php      # Contoh pengawal API
│   └── rujukan/
│       └── artisan-cheatsheet.md      # Rujukan arahan Artisan
└── slaid/
    └── README.md                      # Pautan ke slaid pembentangan
```

## Cara Menggunakan Repositori Ini

1. **Clone** repositori ini:
   ```bash
   git clone https://github.com/habibtalib/kursus-laravel-4hari.git
   ```

2. Buka folder hari yang berkenaan (contoh: `hari-1-persediaan/`)

3. Baca `README.md` dalam setiap folder untuk nota lengkap

4. Ikut arahan dalam bahagian **Lab** untuk latihan amali

5. Rujuk folder `lab/` untuk contoh kod yang boleh disalin

6. Rujuk folder `rujukan/` untuk cheatsheet dan senarai semak

## Projek yang Dibina

Sepanjang 4 hari, anda akan membina sebuah **Aplikasi Blog** lengkap dengan ciri-ciri berikut:

- Pendaftaran dan log masuk pengguna (Laravel Breeze)
- CRUD catatan blog (Create, Read, Update, Delete)
- Paparan responsif dengan Blade templating
- Pengesahan data borang (Validation)
- Pangkalan data MySQL dengan Eloquent ORM
- API RESTful untuk akses data
- Hubungan Model (User hasMany Posts)

## Sambungan VS Code Disyorkan

| Sambungan | Tujuan |
|-----------|--------|
| PHP Intelephense | Autocomplete & diagnostik PHP |
| Laravel Blade Snippets | Penyerlahan sintaks Blade |
| Laravel Snippets | Snippet pantas Laravel |
| DotENV | Penyerlahan fail .env |
| Thunder Client | Ujian API dalam VS Code |

## Komuniti & Sumber Tambahan

- [Dokumentasi Rasmi Laravel](https://laravel.com/docs)
- [Laracasts](https://laracasts.com) — Video tutorial Laravel
- [Laravel News](https://laravel-news.com) — Berita & tutorial
- [Laravel Malaysia (Facebook)](https://www.facebook.com/groups/laravel.my/) — Komuniti tempatan

## Penyumbang

Disediakan oleh **Habib** — [bespokesb.com](https://bespokesb.com)

## Lesen

Repositori ini dilesenkan di bawah [MIT License](LICENSE).
