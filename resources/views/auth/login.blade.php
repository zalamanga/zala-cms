@extends('layouts.public')
@section('title', 'Login Admin')
@section('content')
<main class="mx-auto grid min-h-[70vh] max-w-md place-items-center px-5 py-16">
    <form class="w-full rounded-lg border border-slate-200 bg-white p-6 shadow-sm" method="POST" action="{{ route('login.store') }}">
        @csrf
        <p class="text-xs font-black uppercase text-amber-600">Login admin</p>
        <h1 class="mt-2 text-3xl font-black">Masuk ke ZalaCMS</h1>
        <p class="mt-2 text-sm text-slate-600">Admin: admin@zala.test / admin12345</p>
        @error('email')<p class="mt-4 rounded-lg bg-red-50 p-3 text-sm font-bold text-red-700">{{ $message }}</p>@enderror
        <div class="mt-5 grid gap-4">
            <label class="grid gap-2 text-sm font-bold text-slate-600">Email <input class="rounded-lg border border-slate-300 px-3 py-2" type="email" name="email" value="{{ old('email') }}" required autofocus></label>
            <label class="grid gap-2 text-sm font-bold text-slate-600">Password <input class="rounded-lg border border-slate-300 px-3 py-2" type="password" name="password" required></label>
            <button class="rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700">Login</button>
        </div>
    </form>
</main>
@endsection
