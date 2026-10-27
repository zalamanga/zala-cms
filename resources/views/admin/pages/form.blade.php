@extends('layouts.admin')
@section('title', $page->exists ? 'Edit Page' : 'Tambah Page')
@section('heading', $page->exists ? 'Edit Page' : 'Tambah Page')
@section('content')
<form class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm" method="POST" enctype="multipart/form-data" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}">
    @csrf
    @if($page->exists) @method('PUT') @endif
    <div class="grid gap-5 lg:grid-cols-[1fr_340px]">
        <div class="grid gap-5">
            <section class="rounded-lg border border-slate-200 p-4">
                <h2 class="mb-4 text-lg font-black">Content</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Judul internal <input class="rounded-lg border border-slate-300 px-3 py-2" name="title" value="{{ old('title', $page->title) }}" required></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Slug publik <input class="rounded-lg border border-slate-300 px-3 py-2" name="slug" value="{{ old('slug', $page->slug) }}" placeholder="tentang-kami"></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600 md:col-span-2">Excerpt / ringkasan <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="excerpt" rows="3">{{ old('excerpt', $page->excerpt) }}</textarea></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600 md:col-span-2">Body content <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="content" rows="12" required>{{ old('content', $page->content) }}</textarea></label>
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 p-4">
                <h2 class="mb-4 text-lg font-black">Hero Section</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Eyebrow <input class="rounded-lg border border-slate-300 px-3 py-2" name="eyebrow" value="{{ old('eyebrow', $page->eyebrow) }}" placeholder="Company Profile"></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Hero title <input class="rounded-lg border border-slate-300 px-3 py-2" name="hero_title" value="{{ old('hero_title', $page->hero_title) }}"></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600 md:col-span-2">Hero subtitle <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="hero_subtitle" rows="3">{{ old('hero_subtitle', $page->hero_subtitle) }}</textarea></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600">CTA label <input class="rounded-lg border border-slate-300 px-3 py-2" name="cta_label" value="{{ old('cta_label', $page->cta_label) }}" placeholder="Hubungi Kami"></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600">CTA URL <input class="rounded-lg border border-slate-300 px-3 py-2" name="cta_url" value="{{ old('cta_url', $page->cta_url) }}" placeholder="/#contact"></label>
                </div>
            </section>
        </div>

        <aside class="grid content-start gap-5">
            <section class="rounded-lg border border-slate-200 p-4">
                <h2 class="mb-4 text-lg font-black">Publish</h2>
                <div class="grid gap-4">
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Status <select class="rounded-lg border border-slate-300 px-3 py-2" name="status"><option value="draft" @selected(old('status', $page->status ?: 'draft') === 'draft')>Draft</option><option value="published" @selected(old('status', $page->status) === 'published')>Published</option></select></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Template <select class="rounded-lg border border-slate-300 px-3 py-2" name="template">@foreach(['default','about','services','landing'] as $template)<option value="{{ $template }}" @selected(old('template', $page->template ?: 'default') === $template)>{{ ucfirst($template) }}</option>@endforeach</select></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Menu order <input class="rounded-lg border border-slate-300 px-3 py-2" type="number" min="0" name="sort_order" value="{{ old('sort_order', $page->sort_order ?? 0) }}"></label>
                    <label class="flex items-center gap-3 text-sm font-bold text-slate-600"><input class="h-4 w-4 rounded border-slate-300" type="checkbox" name="show_in_nav" value="1" @checked(old('show_in_nav', $page->show_in_nav ?? true))> Tampilkan di navigasi</label>
                </div>
            </section>

            <section class="rounded-lg border border-slate-200 p-4">
                <h2 class="mb-4 text-lg font-black">Featured Image</h2>
                @if($page->featured_image)
                    <img class="mb-3 h-36 w-full rounded-lg object-cover" src="{{ $page->featured_image_url }}" alt="">
                @endif
                <input class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" type="file" name="featured_image" accept="image/png,image/jpeg,image/webp">
                <p class="mt-2 text-xs text-slate-500">JPG, PNG, WebP. Maksimal 2MB.</p>
            </section>

            <section class="rounded-lg border border-slate-200 p-4">
                <h2 class="mb-4 text-lg font-black">SEO</h2>
                <div class="grid gap-4">
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Meta title <input class="rounded-lg border border-slate-300 px-3 py-2" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"></label>
                    <label class="grid gap-2 text-sm font-bold text-slate-600">Meta description <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="meta_description" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea></label>
                </div>
            </section>
        </aside>
    </div>
    <div class="mt-5 flex gap-2">
        <button class="rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700">Simpan</button>
        <a class="rounded-lg border border-slate-200 px-5 py-3 font-black" href="{{ route('admin.pages.index') }}">Batal</a>
    </div>
</form>
@endsection
