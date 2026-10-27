@extends('layouts.public')
@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description ?: Illuminate\Support\Str::limit(strip_tags($page->content), 150))
@section('content')
<main>
    <section class="relative overflow-hidden bg-slate-950">
        <img class="absolute inset-0 h-full w-full object-cover opacity-45" src="{{ $page->featured_image_url }}" alt="">
        <div class="relative mx-auto grid min-h-[460px] max-w-7xl items-end px-5 py-16 text-white">
            <div class="max-w-3xl">
                <p class="text-xs font-black uppercase text-amber-400">{{ $page->eyebrow ?: ucfirst($page->template) }}</p>
                <h1 class="mt-3 text-5xl font-black leading-tight md:text-7xl">{{ $page->hero_title ?: $page->title }}</h1>
                @if($page->hero_subtitle)
                    <p class="mt-5 text-lg text-slate-100 md:text-xl">{{ $page->hero_subtitle }}</p>
                @endif
                @if($page->cta_label && $page->cta_url)
                    <a class="mt-8 inline-flex rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700" href="{{ $page->cta_url }}">{{ $page->cta_label }}</a>
                @endif
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-10 px-5 py-16 lg:grid-cols-[1fr_320px]">
        <article class="rounded-lg border border-slate-200 bg-white p-6 text-slate-700 shadow-sm">
            @if($page->excerpt)
                <p class="mb-6 border-l-4 border-teal-600 pl-4 text-xl font-semibold text-slate-900">{{ $page->excerpt }}</p>
            @endif
            <div class="prose max-w-none leading-8">{!! nl2br(e($page->content)) !!}</div>
        </article>
        <aside class="grid content-start gap-4">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-black">Page Info</h2>
                <dl class="mt-4 grid gap-3 text-sm">
                    <div><dt class="font-bold text-slate-500">Template</dt><dd>{{ ucfirst($page->template) }}</dd></div>
                    <div><dt class="font-bold text-slate-500">Published</dt><dd>{{ optional($page->published_at)->format('d M Y') ?: '-' }}</dd></div>
                    <div><dt class="font-bold text-slate-500">SEO title</dt><dd>{{ $page->meta_title ?: '-' }}</dd></div>
                </dl>
            </div>
            <div class="rounded-lg bg-slate-950 p-5 text-white">
                <h2 class="text-lg font-black">Butuh CMS seperti ini?</h2>
                <p class="mt-2 text-sm text-slate-300">Kirim pesan lewat form kontak dan pesan masuk ke dashboard admin.</p>
                <a class="mt-4 inline-flex rounded-lg bg-white px-4 py-2 font-black text-slate-950" href="{{ route('home') }}#contact">Hubungi Kami</a>
            </div>
        </aside>
    </section>
</main>
@endsection
