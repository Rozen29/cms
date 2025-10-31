# Website MIN 1 Pringsewu (PHP Native)

Aplikasi website dinamis untuk Madrasah Ibtidaiyah Negeri 1 Pringsewu menggunakan PHP native dan MySQL. Fokus pada keamanan (prepared statements, CSRF, hardening session) dan tema hijau-putih-abu-abu.

## Fitur
- Halaman publik: Beranda, Berita
- Admin: Login, CRUD Berita
- Keamanan: CSRF token, prepared statements, password hashing (bcrypt), sanitasi output, hardening session

## Kebutuhan
- PHP 8.1+
- MySQL/MariaDB 10+
- Apache/Nginx (contoh disertakan .htaccess untuk Apache)

## Instalasi
1. Buat database dan import schema:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
2. Sesuaikan kredensial DB di `app/config.php`.
3. Pastikan DocumentRoot mengarah ke `public/`.
4. Aktifkan mod_rewrite (Apache) dan AllowOverride untuk .htaccess.
5. Buat admin awal (opsional, via CLI):
   ```bash
   php database/seed_admin.php "admin@min1pringsewu.sch.id" "admin123"
   ```

## Login Admin (contoh)
- Email: admin@min1pringsewu.sch.id
- Password: admin123 (ganti setelah login!)

## Struktur Direktori
- `public/` entry point web, asset
- `app/` konfigurasi, router, controller, helper
- `views/` tampilan
- `database/` schema & seeder CLI

## Keamanan
- Gunakan `htmlspecialchars` saat menampilkan data
- Validasi input di server
- Gunakan CSRF token untuk semua aksi POST
- Sesi di-hardening (cookie flags, regenerasi id)

## Lisensi
Internal sekolah MIN 1 Pringsewu.
