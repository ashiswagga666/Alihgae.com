<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Alihgae.com')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo3.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo3.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#16a34a">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Alihgae">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm px-6 py-3 flex justify-between items-center sticky top-0 z-50">

        {{-- Logo --}}
        <a href="{{ route('beranda') }}" class="flex items-center">
            <img src="{{ asset($siteSettings['logo_path'] ?? 'images/logo3.png') }}" alt="{{ $siteSettings['site_name'] ?? 'Alihgae' }}" class="h-12 w-auto">
        </a>

        {{-- Menu tengah --}}
        <div class="flex items-center gap-6 text-sm font-medium text-gray-600">
            <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">Beranda</a>
            <a href="{{ route('lowongan') }}" class="{{ request()->routeIs('lowongan*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">Lowongan</a>
            <a href="{{ route('perusahaan') }}" class="{{ request()->routeIs('perusahaan*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">Perusahaan</a>
            <a href="{{ route('berita.index') }}" class="{{ request()->routeIs('berita*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">Berita</a>

            {{-- Menu tambahan kalau sudah login --}}
            @auth
                @if(Auth::user()->role === 'pelamar')
                    <a href="{{ route('pelamar.dashboard') }}" class="{{ request()->routeIs('pelamar.*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">Dashboard</a>
                @endif
                @if(Auth::user()->role === 'perusahaan')
                    <a href="{{ route('perusahaan.dashboard') }}" class="{{ request()->routeIs('perusahaan.*') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }} transition">Dashboard</a>
                @endif
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.custom.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'text-red-600 font-semibold' : 'hover:text-red-600' }} transition">Admin</a>
                @endif
            @endauth
        </div>

        {{-- Kanan: auth --}}
        <div class="flex items-center gap-3 text-sm">
            @auth
                @php
                    $role = Auth::user()->role;
                    $avatarColor = match($role) {
                        'admin'      => 'bg-red-600',
                        'perusahaan' => 'bg-blue-600',
                        default      => 'bg-green-600',
                    };
                    $roleLabel = match($role) {
                        'admin'      => 'Admin',
                        'perusahaan' => 'Perusahaan',
                        default      => 'Pencari Kerja',
                    };
                    $badgeColor = match($role) {
                        'admin'      => 'bg-red-100 text-red-700',
                        'perusahaan' => 'bg-blue-100 text-blue-700',
                        default      => 'bg-green-100 text-green-700',
                    };
                @endphp

                @if($role === 'admin')
                    <a href="/admin" target="_blank"
                       class="text-xs bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-100 transition font-medium">
                        ⚙️ Admin Panel
                    </a>
                @endif

                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full {{ $avatarColor }} text-white flex items-center justify-center font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="leading-tight">
                        <p class="font-semibold text-gray-800 text-sm">{{ Auth::user()->name }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $badgeColor }}">
                            {{ $roleLabel }}
                        </span>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-gray-400 hover:text-red-500 border border-gray-200 hover:border-red-300 px-3 py-1.5 rounded-lg text-xs transition">
                        Keluar
                    </button>
                </form>

            @else
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-green-600 font-semibold px-3 py-2 transition">Masuk</a>
                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl font-semibold transition">Daftar</a>
            @endauth
        </div>
    </nav>

    {{-- KONTEN --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <x-footer></x-footer>

    @stack('scripts')

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(() => console.log('SW registered'))
                    .catch(err => console.log('SW error:', err));
            });
        }
    </script>
</body>
</html>