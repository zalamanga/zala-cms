@extends('layouts.admin')
@section('title', 'Messages')
@section('heading', 'Contact Messages')
@section('content')
<div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
    <table class="w-full min-w-[760px] text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
            <tr><th class="p-3">Name</th><th class="p-3">Email</th><th class="p-3">Message</th><th class="p-3">Status</th><th class="p-3">Action</th></tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
                <tr class="border-t border-slate-100">
                    <td class="p-3 font-bold">{{ $message->name }}</td>
                    <td class="p-3">{{ $message->email }}</td>
                    <td class="p-3 text-slate-600">{{ $message->message }}</td>
                    <td class="p-3"><span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-black text-teal-800">{{ $message->status }}</span></td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('admin.messages.read', $message) }}">@csrf @method('PATCH')<button class="rounded-lg border border-slate-200 px-3 py-2 font-bold">Read</button></form>
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}">@csrf @method('DELETE')<button class="rounded-lg bg-red-50 px-3 py-2 font-bold text-red-700">Hapus</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td class="p-3" colspan="5">Belum ada pesan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $messages->links() }}</div>
@endsection
