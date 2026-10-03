# Tugas Rutin 10 — Blog CRUD Laravel

Mata kuliah **Pemrograman Web** · Hardiman G. Hutauruk · Ilmu Komputer, Universitas Negeri Medan

Aplikasi blog sederhana dengan CRUD lengkap (Create, Read, Update, Delete) memakai
Laravel, Blade, dan Eloquent. Repo: `TugasWeb-P10-BlogCRUD`.

## Pemenuhan requirement

| # | Requirement | Lokasi |
|---|-------------|--------|
| 1 | `Route::resource('posts')` + named routes | `routes/web.php` (`posts.index`, `posts.create`, `posts.store`, `posts.show`, `posts.edit`, `posts.update`, `posts.destroy`) |
| 2 | PostController resource (7 method) | `app/Http/Controllers/PostController.php` |
| 3 | Blade layout master + `@extends` / `@yield` | `resources/views/layouts/app.blade.php` |
| 4 | Minimal 2 komponen (Alert, Card) | `resources/views/components/alert.blade.php`, `card.blade.php` |
| 5 | Validasi + error per field + old input | `app/Http/Requests/PostRequest.php`, `posts/_form.blade.php` (`@error`, `old()`) |
| 6 | Flash message sukses / gagal | `with('success')` / `with('error')` di controller, ditampilkan `<x-alert>` di layout |
| 7 | `@csrf` semua form + `@method` PUT / DELETE | `posts/create`, `edit`, `show`, `index`, `trash` |
| 8 | Route Model Binding + pagination | `Post $post` di controller, `paginate(6)` + `$posts->links()` |
| Bonus | Pencarian | `?q=kata` — `Post::scopeSearch()` |
| Bonus | Soft delete | trait `SoftDeletes`, halaman `/posts/trash` (pulihkan / hapus permanen) |
| Bonus | Upload gambar | field `image`, disimpan di `storage/app/public/posts` |

## Cara instalasi

Folder ini hanya berisi **file kustom** (seperti TR 9). Langkahnya:

```bash
# 1. Buat project Laravel baru
composer create-project laravel/laravel TugasWeb-P10-BlogCRUD
```

2. **Salin isi folder ini** (`app`, `database`, `resources`, `routes`, `tests`, `.env.example`)
   ke dalam project tadi, pilih *Replace / timpa* jika ditanya.
3. Buat database kosong `tugas10_blogcrud` di phpMyAdmin (Laragon: HeidiSQL / phpMyAdmin).

```bash
cd TugasWeb-P10-BlogCRUD
copy .env.example .env          # Linux/Mac: cp .env.example .env
php artisan key:generate
php artisan migrate --seed      # membuat tabel + 15 post contoh
php artisan storage:link        # agar gambar upload bisa diakses
php artisan serve
```

Buka <http://127.0.0.1:8000> (otomatis diarahkan ke `/posts`).

> Setelah laptop dimatikan: nyalakan MySQL, buka terminal di folder project, jalankan `php artisan serve` lagi.

## Menjalankan test

```bash
php artisan test --filter=PostCrudTest
```

Test memakai SQLite in-memory (bawaan `phpunit.xml`), jadi tidak mengubah database MySQL.
Butuh ekstensi PHP `pdo_sqlite` dan `gd` (aktif secara default di Laragon / XAMPP).

## Struktur folder (bagian yang dibuat / diubah)

```
app/
├── Http/
│   ├── Controllers/PostController.php   ← logika CRUD (tipis)
│   └── Requests/PostRequest.php         ← aturan validasi + pesan Indonesia
└── Models/Post.php                      ← fillable, scopeSearch, SoftDeletes, accessor gambar
database/
├── migrations/..._create_posts_table.php
├── factories/PostFactory.php
└── seeders/DatabaseSeeder.php           ← 15 post contoh
resources/views/
├── layouts/app.blade.php                ← layout master
├── components/{alert,card}.blade.php    ← komponen Blade
└── posts/{index,create,edit,show,trash,_form}.blade.php
routes/web.php                           ← Route::resource + route trash/restore
tests/Feature/PostCrudTest.php
```

## Alur MVC singkat

`Route` → `PostController` → validasi di `PostRequest` → simpan lewat model `Post` → `redirect` dengan flash
message → `View` Blade. Route hanya memetakan URL, view hanya menampilkan data, dan semua logika berada
di controller dan model.

## Keamanan

- `@csrf` di semua form non-GET.
- Mass assignment dibatasi lewat `$fillable`; controller hanya memakai `safe()` dari data tervalidasi.
- Output Blade `{{ }}` di-escape otomatis (anti XSS). Isi post memakai `nl2br(e(...))`.
- Upload dibatasi: harus gambar, format jpg / jpeg / png / webp, maksimal 2 MB.

## Bukti (screenshot)

Letakkan di folder `docs/` lalu lampirkan saat pengumpulan: daftar post (pagination), form dengan error
validasi (old input terlihat), flash message sukses, hasil `php artisan route:list`, dan halaman tempat sampah.
