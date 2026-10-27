<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', $siteSettings->default_meta_description ?: 'ZalaCMS adalah custom CMS company profile berbasis Laravel, MySQL, Blade, dan Tailwind.')">
    <title>@yield('title', $siteSettings->default_meta_title ?: 'ZalaCMS - Company Profile Builder')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-950 antialiased">
    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/85 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 font-black">
                <span class="grid h-9 w-9 place-items-center rounded-lg bg-slate-950 text-white">Z</span>
                <span>{{ $siteSettings->site_name }}</span>
            </a>
            <nav class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                @foreach($navigationPages as $navPage)
                    <a class="rounded-lg px-3 py-2 hover:bg-teal-50 hover:text-slate-950" href="{{ route('pages.pretty', $navPage) }}">{{ $navPage->title }}</a>
                @endforeach
                <a class="rounded-lg px-3 py-2 hover:bg-teal-50 hover:text-slate-950" href="{{ route('posts.index') }}">News</a>
                <a class="rounded-lg px-3 py-2 hover:bg-teal-50 hover:text-slate-950" href="{{ route('home') }}#contact">Kontak</a>
                <a class="rounded-lg bg-slate-950 px-3 py-2 text-white" href="{{ route('admin.dashboard') }}">Admin</a>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="border-t border-slate-200 px-5 py-8 text-center text-sm text-slate-500">
        <strong class="text-slate-800">{{ $siteSettings->site_name }}</strong> - {{ $siteSettings->tagline ?: 'Laravel CMS company profile.' }}
        @if($siteSettings->contact_email)
            <span class="ml-2">{{ $siteSettings->contact_email }}</span>
        @endif
    </footer>
</body>
</html>
