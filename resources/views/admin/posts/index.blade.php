@extends('layouts.admin')
@section('title', 'Blog / News')
@section('heading', 'Blog / News')
@section('content')
<div class="mb-4 flex justify-end">
    <a class="rounded-lg bg-teal-600 px-4 py-2 font-black text-white hover:bg-teal-700" href="{{ route('admin.posts.create') }}">Tambah Artikel</a>
</div>
<div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
    <table class="w-full min-w-[760px] text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
            <tr><th class="p-3">Article</th><th class="p-3">Category</th><th class="p-3">Status</th><th class="p-3">SEO</th><th class="p-3">Action</th></tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr class="border-t border-slate-100">
                    <td class="p-3">
                        <div class="flex gap-3">
                            <img class="h-14 w-20 rounded object-cover" src="{{ $post->cover_image_url }}" alt="">
                            <div>
                                <strong>{{ $post->title }}</strong>
                                <div class="text-xs text-slate-500">/{{ $post->slug }}</div>
                                <p class="mt-1 text-xs text-slate-500">{{ Illuminate\Support\Str::limit($post->excerpt, 80) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-3">{{ $post->category }}</td>
                    <td class="p-3"><span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-black text-teal-800">{{ $post->status }}</span></td>
                    <td class="p-3 text-slate-600">{{ $post->meta_title ?: '-' }}</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <a class="rounded-lg border border-slate-200 px-3 py-2 font-bold" href="{{ route('admin.posts.edit', $post) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}">@csrf @method('DELETE')<button class="rounded-lg bg-red-50 px-3 py-2 font-bold text-red-700">Hapus</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td class="p-3" colspan="5">Belum ada artikel.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $posts->links() }}</div>
@endsection
