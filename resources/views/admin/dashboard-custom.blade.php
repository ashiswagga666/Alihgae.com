@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Kelola seluruh konten Alihgae.com')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach([['Pengguna', $totalUsers, 'fas fa-users', 'blue'], ['Perusahaan', $totalPerusahaan, 'fas fa-building', 'green'], ['Lowongan Aktif', $lowonganAktif, 'fas fa-briefcase', 'purple'], ['Total Berita', $totalBerita, 'fas fa-newspaper', 'orange']] as [$label, $val, $icon, $color])
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div><p class="text-xs text-gray-500">{{ $label }}</p><p class="text-2xl font-bold text-gray-800 mt-1">{{ $val }}</p></div>
            <div class="w-10 h-10 bg-{{ $color }}-100 rounded-xl flex items-center justify-center">
                <i class="{{ $icon }} text-{{ $color }}-600"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($pendingBerita > 0)
<div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <i class="fas fa-bell text-orange-500 text-xl"></i>
        <div>
            <p class="font-semibold text-orange-800">{{ $pendingBerita }} Request Berita Sponsor Menunggu</p>
            <p class="text-sm text-orange-600">Perusahaan menunggu persetujuan berita sponsor mereka</p>
        </div>
    </div>
    <a href="{{ route('admin.berita.requests') }}" class="bg-orange-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">Review Sekarang</a>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800">Berita Terbaru</h3>
            <a href="{{ route('admin.berita.index') }}" class="text-sm text-green-600 hover:underline">Kelola Semua</a>
        </div>
        @foreach($beritaTerbaru as $b)
        <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ Str::limit($b->judul, 45) }}</p>
                <p class="text-xs text-gray-400">{{ $b->published_at?->format('d M Y') }}</p>
            </div>
            @php $sc = match($b->status) { 'published' => 'bg-green-100 text-green-700', 'draft' => 'bg-gray-100 text-gray-600', default => 'bg-yellow-100 text-yellow-700' } @endphp
            <span class="text-xs px-2 py-0.5 rounded-full {{ $sc }}">{{ ucfirst($b->status) }}</span>
        </div>
        @endforeach
        <a href="{{ route('admin.berita.create') }}" class="mt-4 block w-full text-center bg-green-600 text-white py-2 rounded-xl text-sm font-semibold hover:bg-green-700 transition">+ Tulis Berita Baru</a>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800">Lowongan Terbaru</h3>
        </div>
        @foreach($lowonganTerbaru as $lw)
        <div class="flex justify-between items-center py-3 border-b border-gray-50 last:border-0">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ Str::limit($lw->title, 35) }}</p>
                <p class="text-xs text-gray-400">{{ $lw->company?->company_name }}</p>
            </div>
            <span class="text-xs px-2 py-0.5 rounded-full {{ $lw->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $lw->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        @endforeach
        <a href="{{ route('admin.settings') }}" class="mt-4 block w-full text-center bg-gray-100 text-gray-700 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200 transition"><i class="fas fa-cog mr-1"></i>Pengaturan Situs</a>
    </div>
</div>
@endsection
