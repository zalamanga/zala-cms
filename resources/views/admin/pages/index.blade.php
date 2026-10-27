@extends('layouts.admin')
@section('title', 'Pages')
@section('heading', 'Pages')
@section('content')
<div class="mb-4 flex justify-end">
    <a class="rounded-lg bg-teal-600 px-4 py-2 font-black text-white hover:bg-teal-700" href="{{ route('admin.pages.create') }}">Tambah Page</a>
</div>
<div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
    <table class="w-full min-w-[760px] text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
            <tr><th class="p-3">Title</th><th class="p-3">Template</th><th class="p-3">Nav</th><th class="p-3">Status</th><th class="p-3">SEO</th><th class="p-3">Action</th></tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
                <tr class="border-t border-slate-100">
                    <td class="p-3">
                        <strong>{{ $page->title }}</strong>
                        <div class="text-xs text-slate-500">/{{ $page->slug }} · order {{ $page->sort_order }}</div>
                    </td>
                    <td class="p-3">{{ ucfirst($page->template) }}</td>
                    <td class="p-3">{{ $page->show_in_nav ? 'Shown' : 'Hidden' }}</td>
                    <td class="p-3"><span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-black text-teal-800">{{ $page->status }}</span></td>
                    <td class="p-3 text-slate-600">{{ $page->meta_title ?: '-' }}</td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <a class="rounded-lg border border-slate-200 px-3 py-2 font-bold" href="{{ route('admin.pages.edit', $page) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.pages.destroy', $page) }}">@csrf @method('DELETE')<button class="rounded-lg bg-red-50 px-3 py-2 font-bold text-red-700">Hapus</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td class="p-3" colspan="6">Belum ada page.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $pages->links() }}</div>
@endsection
