<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@zala.test'],
            ['name' => 'Admin Zala', 'role' => 'admin', 'password' => Hash::make('admin12345')]
        );

        SiteSetting::current()->update([
            'site_name' => 'ZalaCMS',
            'tagline' => 'Custom CMS Company Profile Builder',
            'description' => 'Laravel CMS untuk company profile, blog/news, contact inbox, SEO, media upload, role admin/editor, dan audit log.',
            'contact_email' => 'hello@zala.test',
            'contact_phone' => '+62 812 0000 0000',
            'address' => 'Jakarta, Indonesia',
            'linkedin_url' => 'https://www.linkedin.com/company/zalacms',
            'default_meta_title' => 'ZalaCMS - Custom CMS Company Profile',
            'default_meta_description' => 'Custom CMS company profile berbasis Laravel, Blade, MySQL, dan Tailwind.',
        ]);

        User::updateOrCreate(
            ['email' => 'editor@zala.test'],
            ['name' => 'Editor Zala', 'role' => 'editor', 'password' => Hash::make('editor12345')]
        );

        Page::updateOrCreate(
            ['slug' => 'tentang-kami'],
            [
                'title' => 'Tentang Kami',
                'eyebrow' => 'Company Profile',
                'hero_title' => 'Tim kecil, sistem rapi, dan konten yang mudah dikelola.',
                'hero_subtitle' => 'ZalaCMS dibuat untuk bisnis yang membutuhkan website company profile profesional tanpa membuat tim internal bergantung penuh pada developer untuk setiap update kecil.',
                'excerpt' => 'Kami membangun CMS yang fokus pada kebutuhan client nyata: halaman profil, layanan, berita, gambar, pesan kontak, dan kontrol admin.',
                'content' => "ZalaCMS membantu bisnis membuat company profile yang rapi, mudah dikelola, dan siap dikembangkan menjadi website client-ready.\n\nDi banyak project client, masalahnya bukan hanya tampilan website. Tim marketing butuh mengganti copy, admin butuh menambah berita, owner butuh melihat pesan masuk, dan developer tetap perlu menjaga security. Karena itu ZalaCMS dirancang sebagai fondasi CMS yang praktis: cukup ringan untuk dipahami, tapi cukup lengkap untuk ditunjukkan sebagai project Laravel yang serius.\n\nFokus utamanya adalah workflow harian: admin login, memilih halaman, menulis konten, mengatur SEO, upload gambar, publish, lalu semua perubahan tampil di website publik.",
                'template' => 'about',
                'featured_image' => 'images/zala-hero.png',
                'cta_label' => 'Lihat Layanan',
                'cta_url' => '/layanan',
                'show_in_nav' => true,
                'sort_order' => 1,
                'status' => 'published',
                'meta_title' => 'Tentang ZalaCMS',
                'meta_description' => 'Profil singkat ZalaCMS sebagai custom CMS company profile.',
                'published_at' => now(),
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'layanan'],
            [
                'title' => 'Layanan',
                'eyebrow' => 'CMS Services',
                'hero_title' => 'Modul CMS yang dibutuhkan website company profile modern.',
                'hero_subtitle' => 'Mulai dari page management sampai audit log, semua modul disiapkan agar project terasa siap dipakai client.',
                'excerpt' => 'Layanan inti mencakup custom CMS, admin dashboard, content publishing, media upload, SEO metadata, dan inbox pesan kontak.',
                'content' => "Kami menyiapkan modul halaman, blog/news, upload gambar, inbox kontak, SEO metadata, role admin, dan audit log.\n\nCRUD Pages dipakai untuk halaman seperti Tentang Kami, Layanan, Portfolio, FAQ, dan Kebijakan. Setiap page punya slug, status publish, template, hero section, CTA, featured image, dan metadata SEO.\n\nBlog atau News dipakai untuk artikel perusahaan, pengumuman, insight, dan update produk. Admin bisa menulis excerpt, content, kategori, cover image, serta menentukan draft atau published.\n\nContact inbox membuat pesan pengunjung tidak hilang di email pribadi. Semua pesan tercatat di dashboard, bisa ditandai read, dan masuk audit log saat diproses.",
                'template' => 'services',
                'featured_image' => 'images/zala-hero.png',
                'cta_label' => 'Kirim Kebutuhan',
                'cta_url' => '/#contact',
                'show_in_nav' => true,
                'sort_order' => 2,
                'status' => 'published',
                'meta_title' => 'Layanan ZalaCMS',
                'meta_description' => 'Layanan pembuatan CMS company profile berbasis Laravel dan MySQL.',
                'published_at' => now(),
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'portfolio'],
            [
                'title' => 'Portfolio',
                'eyebrow' => 'Selected Work',
                'hero_title' => 'Contoh struktur project yang bisa dipresentasikan ke client.',
                'hero_subtitle' => 'Halaman ini menunjukkan bagaimana CMS dapat dipakai untuk menyusun studi kasus, daftar project, dan ringkasan hasil pekerjaan.',
                'excerpt' => 'Portfolio di ZalaCMS bukan hardcoded page. Admin bisa mengelola narasi, gambar, CTA, SEO, dan status publish dari dashboard.',
                'content' => "Contoh portfolio dapat berisi project company profile untuk konsultan, website layanan untuk UMKM, landing page produk, dan portal berita internal perusahaan.\n\nSetiap studi kasus idealnya menjelaskan masalah client, solusi yang dibuat, modul CMS yang dipakai, dan hasil yang bisa diukur. Struktur seperti ini membuat portfolio terasa lebih credible daripada hanya menampilkan screenshot.\n\nPada tahap berikutnya, halaman portfolio bisa dikembangkan menjadi modul tersendiri dengan tabel projects, client name, industry, year, gallery, dan testimonial.",
                'template' => 'landing',
                'featured_image' => 'images/zala-hero.png',
                'cta_label' => 'Diskusi Project',
                'cta_url' => '/#contact',
                'show_in_nav' => true,
                'sort_order' => 3,
                'status' => 'published',
                'meta_title' => 'Portfolio ZalaCMS',
                'meta_description' => 'Contoh halaman portfolio yang dikelola dari CMS Laravel.',
                'published_at' => now(),
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'process'],
            [
                'title' => 'Process',
                'eyebrow' => 'Workflow',
                'hero_title' => 'Dari kebutuhan client sampai CMS siap publish.',
                'hero_subtitle' => 'Workflow dibuat bertahap agar scope jelas, konten terkumpul, dan dashboard tidak menjadi fitur yang asal ada.',
                'excerpt' => 'Proses kerja dimulai dari mapping konten, desain struktur halaman, implementasi Laravel, validasi security, lalu deploy.',
                'content' => "Tahap pertama adalah discovery: mengumpulkan halaman yang dibutuhkan, role admin, jenis konten, kebutuhan upload, dan target SEO.\n\nTahap kedua adalah desain data: menentukan tabel pages, posts, messages, users, dan audit logs. Di tahap ini validasi, status publish, slug, dan metadata SEO sudah dipikirkan dari awal.\n\nTahap ketiga adalah implementasi: route, controller, Blade view, middleware role, upload storage, contact form, dan dashboard. Setelah itu baru masuk verifikasi lokal, seed data, dan persiapan deploy.",
                'template' => 'default',
                'featured_image' => 'images/zala-hero.png',
                'cta_label' => 'Mulai dari Kontak',
                'cta_url' => '/#contact',
                'show_in_nav' => false,
                'sort_order' => 4,
                'status' => 'published',
                'meta_title' => 'Workflow Pembuatan CMS',
                'meta_description' => 'Tahapan membangun CMS company profile dari kebutuhan sampai deploy.',
                'published_at' => now(),
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'kenapa-company-profile-butuh-cms'],
            [
                'title' => 'Kenapa Company Profile Butuh CMS',
                'category' => 'Insight',
                'excerpt' => 'CMS membuat tim internal bisa memperbarui konten tanpa selalu meminta developer.',
                'content' => 'Dengan CMS, halaman profil perusahaan, berita, dan informasi layanan bisa diperbarui lebih cepat. Admin panel juga memberi kontrol role, validasi, dan jejak audit.',
                'cover_image' => 'images/zala-hero.png',
                'status' => 'published',
                'meta_title' => 'Kenapa Company Profile Butuh CMS',
                'meta_description' => 'Alasan company profile modern perlu CMS agar mudah dikelola.',
                'published_at' => now(),
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'checklist-security-admin-panel'],
            [
                'title' => 'Checklist Security untuk Admin Panel',
                'category' => 'Security',
                'excerpt' => 'Validasi input, role middleware, CSRF, rate limit, dan audit log adalah fondasi yang wajib ada.',
                'content' => 'Admin panel perlu CSRF protection, validasi request, pembatasan login, middleware role, validasi file upload, dan escaping output untuk mengurangi risiko umum.',
                'cover_image' => 'images/zala-hero.png',
                'status' => 'published',
                'meta_title' => 'Checklist Security Admin Panel',
                'meta_description' => 'Daftar security penting untuk CMS berbasis Laravel.',
                'published_at' => now(),
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'struktur-database-cms-laravel'],
            [
                'title' => 'Struktur Database CMS Laravel yang Rapi',
                'category' => 'Engineering',
                'excerpt' => 'Pages, posts, messages, users, settings, dan audit logs punya tanggung jawab yang jelas agar CMS mudah dikembangkan.',
                'content' => "Database CMS yang baik dimulai dari pemisahan modul. Pages menyimpan halaman company profile, posts menyimpan artikel, contact_messages menyimpan inbox, site_settings menyimpan konfigurasi brand, dan audit_logs menyimpan aktivitas penting.\n\nStruktur seperti ini membuat controller tetap fokus dan migration mudah dibaca. Saat fitur bertambah, misalnya portfolio, testimonials, atau services, tabel baru bisa ditambahkan tanpa mencampur semua konten ke satu tempat.\n\nDi ZalaCMS, setiap konten juga punya status draft atau published, slug unik, metadata SEO, dan timestamp publish. Ini pola yang umum dipakai pada CMS produksi.",
                'cover_image' => 'images/zala-hero.png',
                'status' => 'published',
                'meta_title' => 'Struktur Database CMS Laravel',
                'meta_description' => 'Cara menyusun database CMS Laravel yang rapi dan mudah dikembangkan.',
                'published_at' => now(),
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'workflow-upload-image-yang-aman'],
            [
                'title' => 'Workflow Upload Image yang Aman',
                'category' => 'Security',
                'excerpt' => 'Upload image perlu validasi mime, ukuran file, storage publik yang benar, dan penghapusan file lama saat konten diperbarui.',
                'content' => "Upload file adalah salah satu titik yang perlu diperhatikan pada CMS. Admin memang butuh upload gambar, tetapi sistem harus membatasi tipe file, ukuran, dan lokasi penyimpanan.\n\nZalaCMS menggunakan validasi image, mimes jpg/jpeg/png/webp, batas ukuran 2MB, serta storage disk public. Saat cover image diganti, file lama dihapus agar storage tidak penuh oleh aset yang tidak dipakai.\n\nPada production, langkah ini bisa ditingkatkan dengan scanning file, CDN, image optimization, dan private bucket untuk file sensitif.",
                'cover_image' => 'images/zala-hero.png',
                'status' => 'published',
                'meta_title' => 'Workflow Upload Image Aman',
                'meta_description' => 'Praktik aman upload image untuk CMS Laravel.',
                'published_at' => now(),
            ]
        );

        ContactMessage::firstOrCreate(
            ['email' => 'client@example.com'],
            ['name' => 'Demo Client', 'message' => 'Saya ingin website company profile dengan admin panel.', 'status' => 'unread']
        );

        AuditLog::firstOrCreate(
            ['action' => 'Demo data dibuat'],
            ['user_id' => $admin->id, 'ip_address' => '127.0.0.1']
        );
    }
}
