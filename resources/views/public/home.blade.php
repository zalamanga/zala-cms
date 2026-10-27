@extends('layouts.public')

@section('content')
<main>
    <section class="relative min-h-[680px] overflow-hidden">
        <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/zala-hero.png') }}" alt="Dashboard CMS modern">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/70 to-slate-950/10"></div>
        <div class="relative z-10 mx-auto max-w-7xl px-5 py-28 text-white">
            <p class="text-xs font-black uppercase text-amber-400">Laravel + Blade + MySQL + Tailwind</p>
            <h1 class="mt-3 max-w-3xl text-6xl font-black leading-none md:text-8xl">ZalaCMS</h1>
            <p class="mt-6 max-w-2xl text-lg text-slate-100 md:text-xl">Custom CMS company profile dengan dashboard admin, CRUD halaman, blog/news, upload gambar, pesan kontak, SEO meta, role, dan audit log.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a class="rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700" href="{{ route('login') }}">Coba Admin</a>
                <a class="rounded-lg border border-white/30 bg-white/10 px-5 py-3 font-black text-white hover:bg-white/20" href="#features">Lihat Fitur</a>
            </div>
        </div>
    </section>

    <section id="features" class="mx-auto grid max-w-7xl gap-5 px-5 py-20 md:grid-cols-4">
        @foreach(['CRUD Pages', 'Blog / News', 'Upload Image', 'Audit Log'] as $feature)
            <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="grid h-10 w-10 place-items-center rounded-lg bg-teal-50 font-black text-teal-800">{{ substr($feature, 0, 1) }}</div>
                <h2 class="mt-4 text-xl font-black">{{ $feature }}</h2>
                <p class="mt-2 text-sm text-slate-600">Modul utama CMS yang siap dikembangkan untuk kebutuhan client nyata.</p>
            </article>
        @endforeach
    </section>

    <section class="mx-auto max-w-7xl px-5 py-16">
        <p class="text-xs font-black uppercase text-amber-600">Company Pages</p>
        <h2 class="mt-2 max-w-3xl text-4xl font-black">Halaman company profile yang bisa dikelola dari admin.</h2>
        <div class="mt-8 grid gap-5 md:grid-cols-2">
            @foreach($pages as $page)
                <article class="grid overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm md:grid-cols-[220px_1fr]">
                    <img class="h-full min-h-56 w-full object-cover" src="{{ $page->featured_image_url }}" alt="">
                    <div class="p-5">
                        <p class="text-xs font-black uppercase text-amber-600">{{ $page->eyebrow ?: ucfirst($page->template) }}</p>
                        <h3 class="mt-2 text-2xl font-black">{{ $page->hero_title ?: $page->title }}</h3>
                        <p class="mt-3 text-sm text-slate-600">{{ $page->excerpt ?: Illuminate\Support\Str::limit($page->content, 150) }}</p>
                        <a class="mt-5 inline-flex rounded-lg border border-slate-200 px-4 py-2 font-black hover:bg-slate-50" href="{{ route('pages.pretty', $page) }}">Buka halaman</a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section id="news" class="mx-auto max-w-7xl px-5 py-16">
        <p class="text-xs font-black uppercase text-amber-600">Latest News</p>
        <h2 class="mt-2 text-4xl font-black">Konten dari dashboard.</h2>
        <div class="mt-8 grid gap-5 md:grid-cols-3">
            @forelse($posts as $post)
                <article class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                    <img class="h-48 w-full object-cover" src="{{ $post->cover_image_url }}" alt="">
                    <div class="p-5">
                        <span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-black text-teal-800">{{ $post->category }}</span>
                        <h3 class="mt-3 text-xl font-black">{{ $post->title }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $post->excerpt }}</p>
                        <a class="mt-4 inline-flex font-bold text-teal-700" href="{{ route('posts.show', $post) }}">Baca artikel</a>
                    </div>
                </article>
            @empty
                <p class="text-slate-600">Belum ada artikel published.</p>
            @endforelse
        </div>
    </section>

    <section id="contact" class="mx-auto grid max-w-7xl gap-8 px-5 py-20 md:grid-cols-[0.9fr_1.1fr]">
        <div>
            <p class="text-xs font-black uppercase text-amber-600">Contact Form</p>
            <h2 class="mt-2 text-4xl font-black">Pesan pengunjung masuk ke inbox admin.</h2>
            <p class="mt-4 text-slate-600">Form ini memakai CSRF, validasi Laravel, dan throttle route.</p>
            <div class="mt-6 grid gap-2 text-sm text-slate-600">
                @if($siteSettings->contact_email)<span><strong>Email:</strong> {{ $siteSettings->contact_email }}</span>@endif
                @if($siteSettings->contact_phone)<span><strong>Phone:</strong> {{ $siteSettings->contact_phone }}</span>@endif
                @if($siteSettings->address)<span><strong>Address:</strong> {{ $siteSettings->address }}</span>@endif
            </div>
        </div>
        <form class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm" method="POST" action="{{ route('contact.store') }}">
            @csrf
            <div class="grid gap-4">
                <label class="grid gap-2 text-sm font-bold text-slate-600">Nama <input class="rounded-lg border border-slate-300 px-3 py-2" name="name" required></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">Email <input class="rounded-lg border border-slate-300 px-3 py-2" type="email" name="email" required></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">Pesan <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="message" rows="5" required></textarea></label>
                <button class="rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700">Kirim Pesan</button>
                @if(session('status'))<p class="font-bold text-teal-700">{{ session('status') }}</p>@endif
            </div>
        </form>
    </section>
</main>
@endsection
