@extends('layouts.master')
@section('title', $perusahaan->company_name)
@section('content')

<section class="bg-gray-50 py-10">
<div class="max-w-5xl mx-auto px-6">

    <a href="{{ route('perusahaan') }}" class="inline-flex items-center gap-2 text-sm text-green-600 hover:underline mb-6">
        <i class="fas fa-arrow-left"></i> Kembali ke Perusahaan
    </a>

    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100">
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 bg-green-50 rounded-2xl flex items-center justify-center text-4xl overflow-hidden flex-shrink-0">
                @if($perusahaan->logo)
                    <img src="{{ asset('storage/'.$perusahaan->logo) }}" class="w-full h-full object-cover">
                @else 🏢 @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $perusahaan->company_name }}</h1>
                <p class="text-gray-500 text-sm">
                    {{ $perusahaan->industry ?? '-' }}
                    @if($perusahaan->city) • {{ $perusahaan->city }}, Bali @endif
                    @if($perusahaan->employee_count) • {{ $perusahaan->employee_count }} karyawan @endif
                </p>
                <div class="flex gap-2 mt-2 flex-wrap">
                    @if($perusahaan->is_verified)
                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full"><i class="fas fa-check-circle mr-1"></i>Terverifikasi</span>
                    @endif
                    <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">{{ $perusahaan->job_listings_count }} Lowongan Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Deskripsi & Lowongan --}}
        <div class="md:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h2 class="font-bold text-lg text-gray-800 mb-3">Tentang Perusahaan</h2>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $perusahaan->description ?? 'Belum ada deskripsi.' }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <h2 class="font-bold text-lg text-gray-800 mb-4">💼 Lowongan Tersedia</h2>
                @forelse($perusahaan->jobListings as $job)
                <a href="{{ route('lowongan.detail', $job->id) }}" class="block p-4 mb-3 rounded-xl border border-gray-100 hover:border-green-200 hover:bg-green-50 transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $job->title }}</p>
                            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }} • {{ $job->job_type_label }}</p>
                        </div>
                        <span class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded-full whitespace-nowrap">{{ $job->salary_range }}</span>
                    </div>
                </a>
                @empty
                <p class="text-gray-400 text-sm text-center py-6">Belum ada lowongan aktif saat ini.</p>
                @endforelse
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 h-fit border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4">Info Perusahaan</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Industri</span><span class="font-semibold text-right">{{ $perusahaan->industry ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Lokasi</span><span class="font-semibold text-right">{{ $perusahaan->city ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Karyawan</span><span class="font-semibold text-right">{{ $perusahaan->employee_count ?? '-' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Berdiri</span><span class="font-semibold text-right">{{ $perusahaan->founded_year ?? '-' }}</span></div>
                @if($perusahaan->phone)<div class="flex justify-between"><span class="text-gray-500">Telepon</span><span class="font-semibold text-right">{{ $perusahaan->phone }}</span></div>@endif
                @if($perusahaan->website)
                <div class="pt-2"><a href="{{ $perusahaan->website }}" target="_blank" class="text-green-600 hover:underline text-sm"><i class="fas fa-globe mr-1"></i>Kunjungi Website</a></div>
                @endif
            </div>
        </div>
    </div>
</div>
</section>
@endsection
