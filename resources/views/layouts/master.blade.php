<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteSettings['site_name'] ?? 'Alihgae.com')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo3.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#16a34a">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .nav-active { color: #16a34a; font-weight: 600; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

{{-- NAVBAR --}}
<nav class="bg-white shadow-sm px-4 md:px-6 py-3 flex justify-between items-center sticky top-0 z-50 border-b border-gray-100">

    {{-- Logo --}}
    <a href="{{ route('beranda') }}" class="flex items-center gap-2">
        <img src="{{ asset($siteSettings['logo_path'] ?? 'images/logo3.png') }}"
             alt="{{ $siteSettings['site_name'] ?? 'Alihgae' }}"
             class="h-10 w-auto">
    </a>

    {{-- Menu Tengah --}}
    <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
        <a href="{{ route('beranda') }}"
           class="{{ request()->routeIs('beranda') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">
            Beranda
        </a>
        <a href="{{ route('lowongan') }}"
           class="{{ request()->routeIs('lowongan*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">
            Lowongan
        </a>
        <a href="{{ route('perusahaan') }}"
           class="{{ request()->routeIs('perusahaan*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">
            Perusahaan
        </a>
        <a href="{{ route('berita.index') }}"
           class="{{ request()->routeIs('berita*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">
            Berita
        </a>

        @auth
            @if(Auth::user()->role === 'pelamar')
                <a href="{{ route('pelamar.dashboard') }}"
                   class="{{ request()->routeIs('pelamar.*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">
                    Dashboard
                </a>
            @elseif(Auth::user()->role === 'perusahaan')
                <a href="{{ route('perusahaan.dashboard') }}"
                   class="{{ request()->routeIs('perusahaan.dashboard') || request()->routeIs('perusahaan.lowongan*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">
                    Dashboard
                </a>
            @elseif(Auth::user()->role === 'admin')
                <a href="{{ route('admin.custom.dashboard') }}"
                   class="{{ request()->routeIs('admin.*') ? 'text-green-600 font-semibold' : 'hover:text-green-600' }} transition">
                    Admin Panel
                </a>
            @endif
        @endauth
    </div>

    {{-- Kanan: Auth --}}
    <div class="flex items-center gap-2 text-sm">
        @auth
            @php
                $role = Auth::user()->role;
                $avatarBg = match($role) {
                    'admin'      => 'bg-red-600',
                    'perusahaan' => 'bg-green-700',
                    default      => 'bg-green-500',
                };
                $roleLabel = match($role) {
                    'admin'      => 'Admin',
                    'perusahaan' => 'Perusahaan',
                    default      => 'Pencari Kerja',
                };
                $badgeBg = match($role) {
                    'admin'      => 'bg-red-100 text-red-700',
                    'perusahaan' => 'bg-green-100 text-green-800',
                    default      => 'bg-emerald-100 text-emerald-700',
                };
            @endphp

            {{-- Avatar + Nama --}}
            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-full px-3 py-1.5">
                <div class="w-7 h-7 rounded-full {{ $avatarBg }} text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="hidden sm:block leading-tight">
                    <p class="font-semibold text-gray-800 text-xs">{{ Str::limit(Auth::user()->name, 15) }}</p>
                    <span class="text-xs px-1.5 py-0.5 rounded-full font-medium {{ $badgeBg }}">{{ $roleLabel }}</span>
                </div>
            </div>

            {{-- Tombol Keluar --}}
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit"
                    class="text-gray-500 hover:text-red-500 border border-gray-200 hover:border-red-300 px-3 py-2 rounded-xl text-xs transition font-medium">
                    <i class="fas fa-sign-out-alt mr-1"></i>Keluar
                </button>
            </form>

        @else
            <a href="{{ route('login') }}"
               class="text-gray-600 hover:text-green-700 font-semibold px-4 py-2 rounded-xl hover:bg-green-50 transition text-sm">
                Masuk
            </a>
            <a href="{{ route('register') }}"
               class="bg-green-600 hover:bg-green-700 active:bg-green-800 text-white px-5 py-2 rounded-xl font-semibold transition text-sm shadow-sm">
                Daftar
            </a>
        @endauth
    </div>
</nav>

{{-- Flash Message --}}
@if(session('success'))
<div class="bg-green-50 border-b border-green-200 text-green-700 px-6 py-3 text-sm flex items-center gap-2">
    <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="bg-red-50 border-b border-red-200 text-red-700 px-6 py-3 text-sm flex items-center gap-2">
    <i class="fas fa-exclamation-circle text-red-500"></i> {{ session('error') }}
</div>
@endif

{{-- KONTEN --}}
<main class="flex-1">
    @yield('content')
</main>

{{-- Pop-up notifikasi aktivitas (muncul sekali, auto hilang) --}}
@guest
<div id="activity-toast"
     class="fixed bottom-5 left-5 z-50 bg-white border border-gray-100 shadow-xl rounded-2xl px-4 py-3 flex items-center gap-3 max-w-xs opacity-0 translate-y-4 transition-all duration-500"
     style="pointer-events:none">
    <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-lg flex-shrink-0">
        🎉
    </div>
    <div class="leading-tight">
        <p class="text-xs font-bold text-gray-800">Aktivitas baru!</p>
        <p class="text-xs text-gray-500" id="activity-toast-text">Seseorang baru saja melamar kerja di Bali</p>
    </div>
    <button onclick="document.getElementById('activity-toast').remove()"
            class="ml-1 text-gray-300 hover:text-gray-500 text-sm flex-shrink-0">
        <i class="fas fa-times"></i>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const messages = [
            'Seseorang baru saja melamar kerja di Bali',
            'PT Bali Digital Kreatif baru saja buka lowongan baru',
            '3 perusahaan baru bergabung minggu ini',
            'Lowongan Frontend Developer ramai dilamar hari ini'
        ];
        const toast = document.getElementById('activity-toast');
        if (!toast) return;

        toast.querySelector('#activity-toast-text').textContent =
            messages[Math.floor(Math.random() * messages.length)];

        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
            toast.style.pointerEvents = 'auto';
        }, 1500);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(1rem)';
            setTimeout(() => toast.remove(), 500);
        }, 8000);
    });
</script>
@endguest

{{-- FOOTER --}}
<x-footer></x-footer>

@stack('scripts')

<script>
    // Clear service worker cache yang mungkin nyimpen halaman lama
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            for(let registration of registrations) {
                registration.unregister();
            }
        });
    }
</script>
</body>
</html>
