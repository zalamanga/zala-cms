@extends('layouts.public')
@section('title', 'News - ZalaCMS')
@section('meta_description', 'Artikel dan update terbaru dari ZalaCMS.')
@section('content')
<main class="mx-auto max-w-7xl px-5 py-16">
    <p class="text-xs font-black uppercase text-amber-600">News</p>
    <h1 class="mt-2 max-w-3xl text-5xl font-black">Artikel dan update perusahaan.</h1>
    <p class="mt-4 max-w-2xl text-slate-600">Semua artikel di halaman ini dikelola dari dashboard admin: status, kategori, cover image, excerpt, content, dan SEO.</p>

    <div class="mt-10 grid gap-5 md:grid-cols-3">
        @forelse($posts as $post)
            <article class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <img class="h-52 w-full object-cover" src="{{ $post->cover_image_url }}" alt="">
                <div class="p-5">
                    <span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-black text-teal-800">{{ $post->category }}</span>
                    <h2 class="mt-3 text-xl font-black">{{ $post->title }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $post->excerpt }}</p>
                    <a class="mt-5 inline-flex rounded-lg border border-slate-200 px-4 py-2 font-black hover:bg-slate-50" href="{{ route('posts.show', $post) }}">Baca artikel</a>
                </div>
            </article>
        @empty
            <p class="text-slate-600">Belum ada artikel published.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $posts->links() }}</div>
</main>
@endsection
