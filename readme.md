# ZalaCMS

CMS company profile dengan Laravel 10 dan Blade. Source menyediakan halaman publik, berita, form kontak, login, pengelolaan halaman dan posting, inbox pesan, pengaturan situs, pengguna, serta audit log. Proyek ini menggunakan MySQL dan aset frontend yang dibangun dengan Vite.

## Menjalankan lokal

Gunakan PHP 8.1+ beserta ekstensi Laravel/MySQL, Composer 2, MySQL, dan Node.js yang mendukung Vite 5. Buat database kosong `zala_cms_demo`, lalu dari folder proyek:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan serve --host=127.0.0.1 --port=8000
```

Atur `DB_*` dalam `.env` lokal sebelum migrasi. Jangan menyalin ulang contoh jika konfigurasi sudah diisi. Tidak ada database, sesi, log, atau APP_KEY asli dalam repo. Seeder berisi data demonstrasi source, bukan hasil ekspor database pengguna. Periksa `database/seeders/DatabaseSeeder.php` untuk akun demo; ganti kredensial bila memakainya di luar latihan.

Buka `http://127.0.0.1:8000`, kemudian `/login` untuk pengelolaan. `/admin` memerlukan login; modul pengguna dan pengaturan memiliki middleware admin tambahan.

## Peta kode

`routes/web.php` memetakan halaman publik dan admin. Controller berada di `app/Http/Controllers`, model di `app/Models`, view di `resources/views`, dan perubahan skema di `database/migrations`. `prototype-static` merupakan referensi tampilan awal, bukan aplikasi backend lain.

## Pemeriksaan dan batas

Pemeriksaan sintaks PHP dijalankan pada ekspor. Tes fitur tersedia dalam `tests/Feature`, tetapi hasil database/browser tidak diklaim lulus pada persiapan ini. Gunakan database khusus pengujian sebelum menjalankan `php artisan test`; tes sumber dapat membuat akun serta halaman.

Versi dependency mengikuti composer.lock sumber. Konfigurasi Composer sumber menonaktifkan pemblokiran advisory; lakukan pembaruan dan pemeriksaan dependency sebelum penggunaan produksi. Fitur upload dan penyajian konten perlu ditinjau sesuai kebutuhan deployment.

## Asal dan lisensi

Proyek berasal dari ZalaCMS lokal. composer.json menyatakan MIT; tidak ada berkas LICENSE proyek terpisah yang ditemukan pada sumber. Laravel dan library lain memiliki lisensinya sendiri. Lihat `NOTICE.md`; jangan menganggap data bisnis dan aset pihak ketiga otomatis termasuk lisensi kode.
