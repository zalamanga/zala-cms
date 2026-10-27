@extends('layouts.admin')
@section('title', $post->exists ? 'Edit Artikel' : 'Tambah Artikel')
@section('heading', $post->exists ? 'Edit Artikel' : 'Tambah Artikel')
@section('content')
<form class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm" method="POST" enctype="multipart/form-data" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}">
    @csrf
    @if($post->exists) @method('PUT') @endif
    <div class="grid gap-4 md:grid-cols-3">
        <label class="grid gap-2 text-sm font-bold text-slate-600">Judul <input class="rounded-lg border border-slate-300 px-3 py-2" name="title" value="{{ old('title', $post->title) }}" required></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600">Slug <input class="rounded-lg border border-slate-300 px-3 py-2" name="slug" value="{{ old('slug', $post->slug) }}"></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600">Kategori <input class="rounded-lg border border-slate-300 px-3 py-2" name="category" value="{{ old('category', $post->category ?: 'News') }}" required></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600">Status <select class="rounded-lg border border-slate-300 px-3 py-2" name="status"><option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option><option value="published" @selected(old('status', $post->status) === 'published')>Published</option></select></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600 md:col-span-2">Cover image <input class="rounded-lg border border-slate-300 px-3 py-2" type="file" name="cover_image" accept="image/png,image/jpeg,image/webp"></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600 md:col-span-3">Excerpt <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="excerpt" rows="3" required>{{ old('excerpt', $post->excerpt) }}</textarea></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600 md:col-span-3">Content <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="content" rows="8" required>{{ old('content', $post->content) }}</textarea></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600">Meta title <input class="rounded-lg border border-slate-300 px-3 py-2" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600 md:col-span-2">Meta description <input class="rounded-lg border border-slate-300 px-3 py-2" name="meta_description" value="{{ old('meta_description', $post->meta_description) }}"></label>
    </div>
    <div class="mt-5 flex gap-2">
        <button class="rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700">Simpan</button>
        <a class="rounded-lg border border-slate-200 px-5 py-3 font-black" href="{{ route('admin.posts.index') }}">Batal</a>
    </div>
</form>
@endsection
