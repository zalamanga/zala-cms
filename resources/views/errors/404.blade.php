@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan - ZalaCMS')
@section('meta_description', 'Halaman yang kamu cari tidak ditemukan di ZalaCMS.')

@section('content')
<main class="bg-slate-50">
    <section class="mx-auto grid min-h-[72vh] max-w-7xl items-center gap-10 px-5 py-16 lg:grid-cols-[0.9fr_1.1fr]">
        <div>
            <p class="text-xs font-black uppercase text-amber-600">404 Not Found</p>
            <h1 class="mt-3 text-5xl font-black leading-tight md:text-7xl">Halaman ini belum tersedia.</h1>
            <p class="mt-5 max-w-xl text-lg text-slate-600">
                URL yang kamu buka tidak cocok dengan page, news, atau admin route yang aktif.
                Coba kembali ke halaman utama atau pilih salah satu halaman company profile.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a class="rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700" href="{{ route('home') }}">Kembali ke Home</a>
                <a class="rounded-lg border border-slate-200 bg-white px-5 py-3 font-black hover:bg-slate-50" href="{{ route('posts.index') }}">Lihat News</a>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-black uppercase text-slate-500">Available pages</p>
            <div class="mt-5 grid gap-3">
                @forelse(($navigationPages ?? collect()) as $page)
                    <a class="rounded-lg border border-slate-200 p-4 hover:border-teal-300 hover:bg-teal-50" href="{{ route('pages.pretty', $page) }}">
                        <strong class="block">{{ $page->title }}</strong>
                        <span class="text-sm text-slate-500">/{{ $page->slug }}</span>
                    </a>
                @empty
                    <p class="text-slate-600">Belum ada halaman published.</p>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection
