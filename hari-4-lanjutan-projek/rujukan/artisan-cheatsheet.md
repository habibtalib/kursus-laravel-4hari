# Rujukan Pantas Arahan Artisan

## Pelayan & Umum

| Arahan | Tujuan |
|--------|--------|
| `php artisan serve` | Mulakan pelayan pembangunan |
| `php artisan tinker` | REPL interaktif untuk uji kod PHP |
| `php artisan list` | Senarai semua arahan yang tersedia |
| `php artisan help migrate` | Bantuan untuk arahan tertentu |

## Cipta Fail (make:)

| Arahan | Cipta |
|--------|-------|
| `php artisan make:model Post -mfs` | Model + Migrasi + Factory + Seeder |
| `php artisan make:controller PostController --resource` | Pengawal dengan 7 method CRUD |
| `php artisan make:controller Api/PostController --api` | Pengawal API (tanpa create/edit) |
| `php artisan make:migration create_posts_table` | Fail migrasi baharu |
| `php artisan make:middleware CheckAge` | Middleware baharu |
| `php artisan make:request StorePostRequest` | Form Request untuk validasi |
| `php artisan make:seeder PostSeeder` | Seeder baharu |
| `php artisan make:factory PostFactory` | Factory baharu |

## Pangkalan Data

| Arahan | Tujuan |
|--------|--------|
| `php artisan migrate` | Jalankan semua migrasi |
| `php artisan migrate:rollback` | Batal migrasi terakhir |
| `php artisan migrate:refresh` | Batal semua & jalankan semula |
| `php artisan migrate:fresh` | Padam semua jadual & jalankan semula |
| `php artisan migrate:status` | Semak status migrasi |
| `php artisan db:seed` | Jalankan semua seeder |
| `php artisan db:seed --class=PostSeeder` | Jalankan seeder tertentu |
| `php artisan migrate:fresh --seed` | Reset DB & seed |

## Laluan

| Arahan | Tujuan |
|--------|--------|
| `php artisan route:list` | Senarai semua laluan |
| `php artisan route:list --name=posts` | Tapis mengikut nama |
| `php artisan route:cache` | Cache laluan (production) |
| `php artisan route:clear` | Bersihkan cache laluan |

## Cache & Optimasi

| Arahan | Tujuan |
|--------|--------|
| `php artisan config:cache` | Cache konfigurasi |
| `php artisan config:clear` | Bersihkan cache konfigurasi |
| `php artisan cache:clear` | Bersihkan cache aplikasi |
| `php artisan view:clear` | Bersihkan cache paparan |
| `php artisan optimize` | Optimumkan untuk production |
| `php artisan optimize:clear` | Bersihkan semua cache |

## Pengesahan (Breeze)

| Arahan | Tujuan |
|--------|--------|
| `composer require laravel/breeze --dev` | Pasang Breeze |
| `php artisan breeze:install blade` | Pasang dengan Blade |
| `npm install && npm run build` | Bina aset frontend |
