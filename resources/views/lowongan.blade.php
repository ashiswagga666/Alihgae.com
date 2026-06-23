@extends('layouts.master')
@section('title', 'Lowongan Kerja di Bali — ' . ($siteSettings['site_name'] ?? 'Alihgae.com'))

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-green-700 via-green-800 to-green-900 py-14 text-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Temukan Lowongan Kerja di Bali</h1>
        <p class="text-green-200 text-lg">Denpasar, Badung, Gianyar, dan seluruh wilayah Bali</p>
    </div>
</section>

{{-- Search Bar --}}
<section class="bg-white border-b border-gray-100 py-5 sticky top-16 z-20 shadow-sm">
    <div class="max-w-6xl mx-auto px-6">
        <form method="GET" action="{{ route('lowongan') }}">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search', request('q')) }}"
                        placeholder="Cari posisi, kata kunci, atau perusahaan..."
                        class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>
                <select name="lokasi" class="border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">📍 Semua Lokasi</option>
                    @foreach(['Denpasar','Badung','Kuta, Badung','Seminyak, Badung','Canggu, Badung','Gianyar','Ubud, Gianyar','Tabanan','Buleleng','Klungkung','Karangasem','Jembrana','Bangli','Remote'] as $kota)
                        <option value="{{ $kota }}" {{ request('lokasi') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                    @endforeach
                </select>
                <select name="tipe" class="border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">Semua Tipe</option>
                    <option value="full-time"  {{ request('tipe') == 'full-time'  ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time"  {{ request('tipe') == 'part-time'  ? 'selected' : '' }}>Part-time</option>
                    <option value="freelance"  {{ request('tipe') == 'freelance'  ? 'selected' : '' }}>Freelance</option>
                    <option value="internship" {{ request('tipe') == 'internship' ? 'selected' : '' }}>Magang</option>
                </select>
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition whitespace-nowrap">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
                @if(request()->hasAny(['search','q','tipe','lokasi','location']))
                    <a href="{{ route('lowongan') }}"
                        class="border border-gray-300 text-gray-500 hover:bg-gray-50 px-4 py-3 rounded-xl text-sm font-semibold transition whitespace-nowrap text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</section>

{{-- Hasil --}}
<section class="bg-gray-50 py-10 min-h-screen">
    <div class="max-w-6xl mx-auto px-6">

        <p class="text-sm text-gray-500 mb-6">
            Menampilkan <span class="font-semibold text-green-600">{{ $lowongans->total() }}</span> lowongan
            @if(request('search', request('q')))
                untuk "<span class="font-semibold">{{ request('search', request('q')) }}</span>"
            @endif
            @if(request('lokasi'))
                di <span class="font-semibold">{{ request('lokasi') }}</span>
            @endif
        </p>

        @if($lowongans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($lowongans as $lowongan)
            <a href="{{ route('lowongan.detail', $lowongan->id) }}"
               class="bg-white rounded-2xl shadow-sm p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 border border-gray-100 group flex flex-col">

                {{-- Header card --}}
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-2xl flex-shrink-0 overflow-hidden border border-green-100">
                        @if($lowongan->company->logo ?? null)
                            <img src="{{ asset('storage/'.$lowongan->company->logo) }}" class="w-full h-full object-cover">
                        @else
                            <span>🏢</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-800 group-hover:text-green-700 transition text-sm leading-snug line-clamp-2">
                            {{ $lowongan->title }}
                        </h3>
                        <p class="text-green-600 text-xs font-semibold truncate mt-0.5">
                            {{ $lowongan->company->company_name ?? 'Perusahaan' }}
                        </p>
                    </div>
                </div>

                {{-- Tags --}}
                <div class="flex flex-wrap gap-1.5 mb-3">
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-green-500"></i> {{ $lowongan->location }}
                    </span>
                    <span class="text-xs bg-green-50 text-green-700 px-2 py-1 rounded-full">
                        {{ $lowongan->job_type_label }}
                    </span>
                    @if($lowongan->min_education)
                    <span class="text-xs bg-gray-50 text-gray-500 px-2 py-1 rounded-full">
                        {{ $lowongan->min_education }}
                    </span>
                    @endif
                </div>

                {{-- Gaji --}}
                <p class="text-sm font-bold text-green-600 mb-3">{{ $lowongan->salary_range }}</p>

                {{-- Footer --}}
                <div class="flex justify-between items-center mt-auto pt-3 border-t border-gray-50">
                    <span class="px-2 py-1 text-xs rounded-full font-medium
                        {{ $lowongan->deadline >= date('Y-m-d') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        @if($lowongan->deadline >= date('Y-m-d'))
                            ✅ Buka s/d {{ $lowongan->deadline->format('d M') }}
                        @else
                            ❌ Ditutup
                        @endif
                    </span>
                    <span class="text-green-600 text-xs font-semibold group-hover:underline">Lihat →</span>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">{{ $lowongans->links() }}</div>

        @else
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm">
            @if(request()->hasAny(['search','q','tipe','lokasi']))
                <div class="text-6xl mb-4">😔</div>
                <p class="text-gray-500 text-lg font-medium mb-2">Tidak ada lowongan yang cocok</p>
                <p class="text-gray-400 text-sm mb-4">Coba kata kunci lain atau hapus filter</p>
                <a href="{{ route('lowongan') }}"
                   class="inline-block bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-green-700 transition">
                    Lihat Semua Lowongan
                </a>
            @else
                <div class="text-6xl mb-4">📭</div>
                <p class="text-gray-500 text-lg">Belum ada lowongan tersedia saat ini.</p>
            @endif
        </div>
        @endif
    </div>
</section>

@endsection
