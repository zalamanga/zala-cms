<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - ZalaCMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-950 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="bg-slate-950 p-5 text-white">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 font-black">
                <span class="grid h-9 w-9 place-items-center rounded-lg bg-white text-slate-950">Z</span>
                <span>ZalaCMS Admin</span>
            </a>
            <nav class="mt-8 grid gap-1 text-sm font-semibold text-slate-300">
                <a class="rounded-lg px-3 py-2 hover:bg-white/10 hover:text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="rounded-lg px-3 py-2 hover:bg-white/10 hover:text-white" href="{{ route('admin.pages.index') }}">Pages</a>
                <a class="rounded-lg px-3 py-2 hover:bg-white/10 hover:text-white" href="{{ route('admin.posts.index') }}">Blog / News</a>
                <a class="rounded-lg px-3 py-2 hover:bg-white/10 hover:text-white" href="{{ route('admin.messages.index') }}">Messages</a>
                @if(auth()->user()->isAdmin())
                    <a class="rounded-lg px-3 py-2 hover:bg-white/10 hover:text-white" href="{{ route('admin.users.index') }}">Users</a>
                @endif
                <a class="rounded-lg px-3 py-2 hover:bg-white/10 hover:text-white" href="{{ route('admin.audit.index') }}">Audit Log</a>
                @if(auth()->user()->isAdmin())
                    <a class="rounded-lg px-3 py-2 hover:bg-white/10 hover:text-white" href="{{ route('admin.settings.edit') }}">Settings</a>
                @endif
            </nav>
        </aside>

        <main class="p-5 lg:p-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-black uppercase text-amber-600">Admin Panel</p>
                    <h1 class="text-3xl font-black">@yield('heading', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white p-2 text-sm">
                    <span><strong>{{ auth()->user()->name }}</strong> <span class="rounded-full bg-teal-100 px-2 py-1 text-xs font-bold text-teal-800">{{ auth()->user()->role }}</span></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="rounded-lg border border-slate-200 px-3 py-2 font-bold hover:bg-slate-50">Logout</button>
                    </form>
                </div>
            </div>

            @if(session('status'))
                <div class="mb-5 rounded-lg border border-teal-200 bg-teal-50 px-4 py-3 text-sm font-semibold text-teal-800">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <strong>Periksa lagi:</strong>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
