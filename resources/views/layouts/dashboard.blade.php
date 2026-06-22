<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — {{ $siteSettings['site_name'] ?? 'Alihgae.com' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .sidebar-link { @apply flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200; }
        .sidebar-link:hover { @apply bg-white/10 text-white; }
        .sidebar-link.active { @apply bg-white text-blue-700 shadow-md; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex">

{{-- SIDEBAR --}}
<aside class="w-64 min-h-screen bg-gradient-to-b from-blue-700 to-blue-900 text-white flex flex-col fixed top-0 left-0 z-30 shadow-2xl">
    <div class="p-6 border-b border-white/10">
        <a href="{{ route('beranda') }}" class="flex items-center gap-3">
            <img src="/{{ $siteSettings['logo_path'] ?? 'images/logo3.png' }}" alt="Logo" class="h-9 w-auto filter brightness-0 invert">
            <div>
                <p class="font-bold text-lg leading-tight">{{ $siteSettings['site_name'] ?? 'Alihgae' }}</p>
                <p class="text-xs text-blue-200">
                    @if(Auth::user()->role === 'perusahaan') Dashboard Perusahaan
                    @elseif(Auth::user()->role === 'admin') Admin Panel
                    @else Dashboard Pelamar @endif
                </p>
            </div>
        </a>
    </div>

    <nav class="flex-1 p-4 space-y-1">
        @if(Auth::user()->role === 'pelamar')
            <a href="{{ route('pelamar.dashboard') }}" class="sidebar-link {{ request()->routeIs('pelamar.dashboard') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-home w-5"></i> Dashboard
            </a>
            <a href="{{ route('pelamar.profil') }}" class="sidebar-link {{ request()->routeIs('pelamar.profil') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-user w-5"></i> Profil Saya
            </a>
            <a href="{{ route('pelamar.riwayat') }}" class="sidebar-link {{ request()->routeIs('pelamar.riwayat') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-file-alt w-5"></i> Riwayat Lamaran
            </a>
            <a href="{{ route('lowongan') }}" class="sidebar-link text-blue-100">
                <i class="fas fa-briefcase w-5"></i> Cari Lowongan
            </a>
        @elseif(Auth::user()->role === 'perusahaan')
            <a href="{{ route('perusahaan.dashboard') }}" class="sidebar-link {{ request()->routeIs('perusahaan.dashboard') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-chart-line w-5"></i> Dashboard
            </a>
            <a href="{{ route('perusahaan.lowongan.create') }}" class="sidebar-link {{ request()->routeIs('perusahaan.lowongan.create') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-plus-circle w-5"></i> Buat Lowongan
            </a>
            <a href="{{ route('perusahaan.profil.edit') }}" class="sidebar-link {{ request()->routeIs('perusahaan.profil.edit') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-building w-5"></i> Profil Perusahaan
            </a>
            <a href="{{ route('perusahaan.berita.request') }}" class="sidebar-link {{ request()->routeIs('perusahaan.berita.*') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-newspaper w-5"></i> Request Berita
            </a>
        @elseif(Auth::user()->role === 'admin')
            <a href="{{ route('admin.custom.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.custom.dashboard') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-chart-pie w-5"></i> Dashboard
            </a>
            <a href="{{ route('admin.berita.index') }}" class="sidebar-link {{ request()->routeIs('admin.berita.*') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-newspaper w-5"></i> Kelola Berita
            </a>
            <a href="{{ route('admin.berita.requests') }}" class="sidebar-link {{ request()->routeIs('admin.berita.requests*') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-inbox w-5"></i> Request Sponsor
                @php $pending = \App\Models\BeritaRequest::where('status','pending')->count() @endphp
                @if($pending > 0)<span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $pending }}</span>@endif
            </a>
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : 'text-blue-100' }}">
                <i class="fas fa-cog w-5"></i> Pengaturan Situs
            </a>
            <a href="/admin" class="sidebar-link text-blue-100">
                <i class="fas fa-tools w-5"></i> Filament Admin
            </a>
        @endif
    </nav>

    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center font-bold text-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-semibold leading-tight">{{ Str::limit(Auth::user()->name, 20) }}</p>
                <p class="text-xs text-blue-200">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left sidebar-link text-blue-100 hover:bg-red-500/20 hover:text-red-200 text-sm">
                <i class="fas fa-sign-out-alt w-5"></i> Keluar
            </button>
        </form>
    </div>
</aside>

{{-- MAIN CONTENT --}}
<div class="ml-64 flex-1 flex flex-col min-h-screen">
    <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-20">
        <div>
            <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <p class="text-xs text-gray-400">@yield('page-subtitle', '')</p>
        </div>
        <div class="flex items-center gap-3 text-sm text-gray-600">
            <a href="{{ route('beranda') }}" class="hover:text-blue-600"><i class="fas fa-globe"></i> Lihat Website</a>
        </div>
    </header>

    <main class="flex-1 p-6">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
