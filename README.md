# Website MIN 1 Pringsewu (PHP Native)

Aplikasi website dinamis untuk Madrasah Ibtidaiyah Negeri 1 Pringsewu menggunakan PHP native dan MySQL. Fokus pada keamanan (prepared statements, CSRF, hardening session) dan tema hijau-putih-abu-abu.

## Fitur
- Halaman publik: Beranda (dengan banner), Berita (thumbnail gambar)
- Admin: Login, Dashboard, CRUD Berita (tambah gambar), Edit Banner (gambar + caption)
- Keamanan: CSRF token, prepared statements, password hashing (bcrypt), sanitasi output, hardening session, proteksi folder uploads

## Kebutuhan
- PHP 8.1+
- MySQL/MariaDB 10+
- Apache/Nginx (contoh disertakan .htaccess untuk Apache)

## Instalasi
1. Buat database dan import schema awal:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
2. Jalankan migrasi fitur banner & gambar berita:
   ```bash
   mysql -u root -p min1pringsewu < database/migrations/20251031_add_settings_and_news_image.sql
   ```
3. Sesuaikan kredensial DB di `app/config.php`.
4. Pastikan DocumentRoot mengarah ke `public/` dan mod_rewrite aktif.
5. Buat admin awal (opsional, via CLI):
   ```bash
   php database/seed_admin.php "admin@min1pringsewu.sch.id" "admin123"
   ```

## Rute Penting
- Publik: `/`, `/news`
- Admin: `/admin`, `/admin/login`, `/admin/news/create`, `/admin/banner`

## Upload
- Direktori: `public/uploads/` (otomatis dibuat)
- Tipe diizinkan: JPG, PNG, GIF, WEBP
- Batas ukuran: 5MB

## Struktur
- `app/Helpers/upload.php` validasi dan pindah file gambar aman
- `app/Models/Setting.php` penyimpanan pengaturan (banner)
- `app/Controllers/BannerController.php` kelola banner

## Keamanan
- Folder `public/uploads` dibatasi eksekusi skrip via `.htaccess`
- Validasi MIME server-side (finfo) dan ukuran file

## Catatan
- Ganti password admin default setelah login.
