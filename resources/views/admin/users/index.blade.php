@extends('layouts.admin')
@section('title', 'Users')
@section('heading', 'Admin Users')
@section('content')
<div class="mb-4 flex justify-end">
    <a class="rounded-lg bg-teal-600 px-4 py-2 font-black text-white hover:bg-teal-700" href="{{ route('admin.users.create') }}">Tambah User</a>
</div>
<div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
    <table class="w-full min-w-[640px] text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
            <tr><th class="p-3">Name</th><th class="p-3">Email</th><th class="p-3">Role</th><th class="p-3">Action</th></tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t border-slate-100">
                    <td class="p-3 font-bold">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3"><span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-black text-teal-800">{{ $user->role }}</span></td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <a class="rounded-lg border border-slate-200 px-3 py-2 font-bold" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                            @if(!auth()->user()->is($user))
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}">@csrf @method('DELETE')<button class="rounded-lg bg-red-50 px-3 py-2 font-bold text-red-700">Hapus</button></form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
