@extends('layouts.public')
@section('title', $post->meta_title ?: $post->title)
@section('meta_description', $post->meta_description ?: $post->excerpt)
@section('content')
<main class="mx-auto max-w-4xl px-5 py-16">
    <span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-black text-teal-800">{{ $post->category }}</span>
    <h1 class="mt-3 text-5xl font-black">{{ $post->title }}</h1>
    <p class="mt-4 text-lg text-slate-600">{{ $post->excerpt }}</p>
    <img class="mt-8 max-h-[460px] w-full rounded-lg object-cover" src="{{ $post->cover_image_url }}" alt="">
    <article class="prose mt-8 max-w-none text-slate-700">{!! nl2br(e($post->content)) !!}</article>
</main>
@endsection
