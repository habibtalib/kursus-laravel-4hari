# Rujukan Kaedah HTTP

## Kaedah HTTP dalam Laravel

| Kaedah | Tujuan | Route | Contoh |
|--------|--------|-------|--------|
| **GET** | Dapatkan/papar data | `Route::get()` | Papar halaman, senarai data |
| **POST** | Hantar data baharu | `Route::post()` | Hantar borang, cipta data |
| **PUT/PATCH** | Kemas kini data | `Route::put()` | Kemas kini profil, edit catatan |
| **DELETE** | Padam data | `Route::delete()` | Padam catatan, buang akaun |

## Resource Routes (7 Laluan Automatik)

Apabila anda menggunakan `Route::resource('posts', PostController::class)`:

| Kaedah | URI | Action | Nama Laluan |
|--------|-----|--------|-------------|
| GET | `/posts` | index | posts.index |
| GET | `/posts/create` | create | posts.create |
| POST | `/posts` | store | posts.store |
| GET | `/posts/{post}` | show | posts.show |
| GET | `/posts/{post}/edit` | edit | posts.edit |
| PUT/PATCH | `/posts/{post}` | update | posts.update |
| DELETE | `/posts/{post}` | destroy | posts.destroy |

## Arahan Berguna

```bash
# Lihat semua laluan berdaftar
php artisan route:list

# Lihat laluan untuk satu pengawal sahaja
php artisan route:list --name=posts

# Bersihkan cache laluan
php artisan route:clear
```
