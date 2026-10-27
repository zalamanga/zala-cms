@extends('layouts.admin')
@section('title', $user->exists ? 'Edit User' : 'Tambah User')
@section('heading', $user->exists ? 'Edit User' : 'Tambah User')
@section('content')
<form class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm" method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
    @csrf
    @if($user->exists) @method('PUT') @endif
    <div class="grid gap-4 md:grid-cols-2">
        <label class="grid gap-2 text-sm font-bold text-slate-600">Nama <input class="rounded-lg border border-slate-300 px-3 py-2" name="name" value="{{ old('name', $user->name) }}" required></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600">Email <input class="rounded-lg border border-slate-300 px-3 py-2" type="email" name="email" value="{{ old('email', $user->email) }}" required></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600">Role <select class="rounded-lg border border-slate-300 px-3 py-2" name="role"><option value="editor" @selected(old('role', $user->role) === 'editor')>Editor</option><option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option></select></label>
        <div></div>
        <label class="grid gap-2 text-sm font-bold text-slate-600">Password <input class="rounded-lg border border-slate-300 px-3 py-2" type="password" name="password" @required(!$user->exists)></label>
        <label class="grid gap-2 text-sm font-bold text-slate-600">Konfirmasi Password <input class="rounded-lg border border-slate-300 px-3 py-2" type="password" name="password_confirmation" @required(!$user->exists)></label>
    </div>
    <div class="mt-5 flex gap-2">
        <button class="rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700">Simpan</button>
        <a class="rounded-lg border border-slate-200 px-5 py-3 font-black" href="{{ route('admin.users.index') }}">Batal</a>
    </div>
</form>
@endsection
