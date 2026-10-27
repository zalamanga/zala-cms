@extends('layouts.admin')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('content')
<div class="grid gap-4 md:grid-cols-4">
    @foreach($stats as $label => $value)
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <strong class="block text-3xl font-black">{{ $value }}</strong>
            <span class="text-sm font-bold text-slate-500">{{ $label }}</span>
        </div>
    @endforeach
</div>

<div class="mt-6 grid gap-3 md:grid-cols-4">
    <a class="rounded-lg border border-slate-200 bg-white p-4 font-black shadow-sm hover:bg-slate-50" href="{{ route('admin.pages.create') }}">+ New Page</a>
    <a class="rounded-lg border border-slate-200 bg-white p-4 font-black shadow-sm hover:bg-slate-50" href="{{ route('admin.posts.create') }}">+ New Article</a>
    <a class="rounded-lg border border-slate-200 bg-white p-4 font-black shadow-sm hover:bg-slate-50" href="{{ route('admin.messages.index') }}">Open Inbox</a>
    @if(auth()->user()->isAdmin())
        <a class="rounded-lg border border-slate-200 bg-white p-4 font-black shadow-sm hover:bg-slate-50" href="{{ route('admin.settings.edit') }}">Site Settings</a>
    @endif
</div>

<div class="mt-6 grid gap-5 lg:grid-cols-[1.1fr_0.9fr]">
    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-xl font-black">Content Health</h2>
        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            @foreach($contentHealth as $label => $value)
                <div class="rounded-lg bg-slate-50 p-4">
                    <strong class="block text-2xl font-black">{{ $value }}</strong>
                    <span class="text-sm font-bold text-slate-500">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-xl font-black">Recent Messages</h2>
        <div class="mt-4 grid gap-3">
            @forelse($recentMessages as $message)
                <div class="border-t border-slate-100 pt-3">
                    <strong>{{ $message->name }}</strong>
                    <p class="text-sm text-slate-600">{{ $message->message }}</p>
                </div>
            @empty
                <p class="text-slate-500">Belum ada pesan.</p>
            @endforelse
        </div>
    </section>
</div>

<div class="mt-6 grid gap-5 lg:grid-cols-2">
    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-xl font-black">Recent Pages</h2>
        <div class="mt-4 grid gap-3">
            @foreach($recentPages as $page)
                <a class="rounded-lg border border-slate-100 p-3 hover:bg-slate-50" href="{{ route('admin.pages.edit', $page) }}">
                    <strong>{{ $page->title }}</strong>
                    <span class="block text-sm text-slate-500">{{ $page->status }} - /{{ $page->slug }}</span>
                </a>
            @endforeach
        </div>
    </section>
    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-xl font-black">Recent Articles</h2>
        <div class="mt-4 grid gap-3">
            @foreach($recentPosts as $post)
                <a class="rounded-lg border border-slate-100 p-3 hover:bg-slate-50" href="{{ route('admin.posts.edit', $post) }}">
                    <strong>{{ $post->title }}</strong>
                    <span class="block text-sm text-slate-500">{{ $post->category }} - {{ $post->status }}</span>
                </a>
            @endforeach
        </div>
    </section>
</div>

<div class="mt-6 grid gap-5 lg:grid-cols-2">
    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-xl font-black">Security Checklist</h2>
        <ul class="mt-4 grid gap-2 text-sm font-semibold text-slate-700">
            <li>CSRF protection aktif di semua form Laravel</li>
            <li>Input validation via request validation</li>
            <li>File upload validation JPG/PNG/WebP max 2MB</li>
            <li>Role middleware untuk admin-only settings dan users</li>
            <li>Throttle login dan contact form</li>
            <li>Blade escaping untuk mengurangi risiko XSS</li>
        </ul>
    </section>
    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="text-xl font-black">Latest Audit</h2>
        <div class="mt-4 grid gap-3">
            @foreach($auditLogs as $log)
                <div class="border-t border-slate-100 pt-3">
                    <strong>{{ $log->action }}</strong>
                    <p class="text-sm text-slate-500">{{ $log->user?->email ?: 'system' }} - {{ $log->created_at->format('d M Y H:i') }}</p>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
