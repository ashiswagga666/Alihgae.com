@extends('layouts.dashboard')
@section('title', 'Dashboard Saya')
@section('page-title', 'Dashboard Pelamar')
@section('page-subtitle', 'Selamat datang, ' . Auth::user()->name)

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Lamaran</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalLamaran }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-file-alt text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Diterima</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $diterima }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Profil Lengkap</p>
                <p class="text-3xl font-bold text-purple-600 mt-1">{{ $profile->photo ? '✓' : '—' }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-check text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

{{-- Profil cepat + lamaran terbaru --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Profil Card --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="text-center mb-4">
            @if($profile->photo)
                <img src="{{ asset('storage/'.$profile->photo) }}" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-blue-100">
            @else
                <div class="w-20 h-20 rounded-full mx-auto bg-blue-100 flex items-center justify-center text-3xl font-bold text-blue-600">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <h3 class="font-bold text-gray-800 mt-3">{{ $user->name }}</h3>
            <p class="text-sm text-gray-500">{{ $profile->desired_position ?? 'Pencari Kerja' }}</p>
            <p class="text-xs text-gray-400 mt-1"><i class="fas fa-map-marker-alt"></i> {{ $profile->domicile ?? 'Lokasi belum diisi' }}</p>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex items-center gap-2 text-gray-600">
                <i class="fas fa-graduation-cap w-4 text-blue-500"></i>
                {{ $profile->education_level ?? '-' }}
            </div>
            @if($profile->phone)
            <div class="flex items-center gap-2 text-gray-600">
                <i class="fas fa-phone w-4 text-blue-500"></i>
                {{ $profile->phone }}
            </div>
            @endif
            @if($profile->cv_path)
            <div class="flex items-center gap-2 text-green-600">
                <i class="fas fa-file-pdf w-4"></i>
                CV sudah diupload ✓
            </div>
            @endif
        </div>
        <a href="{{ route('pelamar.profil') }}" class="mt-4 block w-full text-center bg-blue-600 text-white py-2 rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
            <i class="fas fa-edit mr-1"></i> Edit Profil
        </a>
    </div>

    {{-- Lamaran Terbaru --}}
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-800">Lamaran Terbaru</h3>
            <a href="{{ route('pelamar.riwayat') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        @forelse($lamarans as $lmr)
        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-xl">💼</div>
                <div>
                    <p class="font-semibold text-sm text-gray-800">{{ $lmr->nama_lowongan ?? $lmr->lowongan?->title }}</p>
                    <p class="text-xs text-gray-500">{{ $lmr->nama_perusahaan ?? $lmr->lowongan?->company?->company_name }}</p>
                </div>
            </div>
            @php
                $statusColor = match($lmr->status) {
                    'diterima' => 'bg-green-100 text-green-700',
                    'ditolak'  => 'bg-red-100 text-red-700',
                    default    => 'bg-yellow-100 text-yellow-700',
                };
                $statusLabel = match($lmr->status) {
                    'diterima' => 'Diterima',
                    'ditolak'  => 'Ditolak',
                    default    => 'Menunggu',
                };
            @endphp
            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusColor }}">{{ $statusLabel }}</span>
        </div>
        @empty
        <div class="text-center py-8 text-gray-400">
            <i class="fas fa-inbox text-4xl mb-2"></i>
            <p class="text-sm">Belum ada lamaran</p>
            <a href="{{ route('lowongan') }}" class="mt-2 inline-block text-blue-600 text-sm hover:underline">Cari Lowongan Sekarang</a>
        </div>
        @endforelse
    </div>
</div>

{{-- Rekomendasi Lowongan --}}
<div class="mt-6 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-gray-800">💡 Lowongan Untukmu</h3>
        <a href="{{ route('lowongan') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($lowonganRekomendasi as $job)
        <a href="{{ route('lowongan.detail', $job->id) }}" class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                @if($job->company->logo)
                    <img src="{{ asset('storage/'.$job->company->logo) }}" class="w-10 h-10 rounded-lg object-cover">
                @else 🏢 @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm text-gray-800 truncate">{{ $job->title }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $job->company->company_name }}</p>
                <p class="text-xs text-gray-400"><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</p>
            </div>
            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full whitespace-nowrap">{{ $job->job_type_label }}</span>
        </a>
        @endforeach
    </div>
</div>
@endsection
