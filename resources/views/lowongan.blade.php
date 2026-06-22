@extends('layouts.master')
@section('title', 'Lowongan Kerja di Bali — Alihgae.com')

@section('content')

<section class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 py-14 text-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Temukan Lowongan Kerja di Bali</h1>
        <p class="text-blue-200">Denpasar, Badung, Gianyar, dan seluruh wilayah Bali — update setiap hari</p>
    </div>
</section>

<section class="bg-white border-b border-gray-100 py-6 sticky top-16 z-20 shadow-sm">
    <div class="max-w-6xl mx-auto px-6">
        <form method="GET" action="{{ route('lowongan') }}">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search', request('q')) }}" placeholder="Cari posisi, kata kunci, atau perusahaan..." class="w-full border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <select name="lokasi" class="border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">📍 Semua Lokasi</option>
                    @foreach(['Denpasar','Badung','Gianyar','Tabanan','Buleleng','Klungkung','Karangasem','Jembrana','Bangli','Remote'] as $kota)
                        <option value="{{ $kota }}" {{ request('lokasi') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                    @endforeach
                </select>
                <select name="tipe" class="border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Semua Tipe</option>
                    <option value="full-time" {{ request('tipe') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ request('tipe') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="freelance" {{ request('tipe') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                    <option value="internship" {{ request('tipe') == 'internship' ? 'selected' : '' }}>Magang</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition whitespace-nowrap">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
                @if(request()->hasAny(['search', 'q', 'tipe', 'location', 'lokasi']))
                <a href="{{ route('lowongan') }}" class="border border-gray-300 text-gray-500 hover:bg-gray-50 px-4 py-3 rounded-xl text-sm font-semibold transition whitespace-nowrap text-center">Reset</a>
                @endif
            </div>
        </form>
    </div>
</section>

<section class="bg-gray-50 py-10">
<div class="max-w-6xl mx-auto px-6">

    <p class="text-sm text-gray-500 mb-6">
        Menampilkan <span class="font-semibold text-blue-600">{{ $lowongans->total() }}</span> lowongan
        @if(request('search', request('q'))) untuk "<span class="font-semibold">{{ request('search', request('q')) }}</span>" @endif
    </p>

    @if($lowongans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lowongans as $lowongan)
            <a href="{{ route('lowongan.detail', $lowongan->id) }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-xl hover:-translate-y-1 transition-all border border-gray-100 group">
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-2xl flex-shrink-0 overflow-hidden">
                        @if($lowongan->company->logo ?? null)
                            <img src="{{ asset('storage/'.$lowongan->company->logo) }}" class="w-full h-full object-cover">
                        @else 💼 @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-800 group-hover:text-blue-700 transition leading-snug">{{ $lowongan->title }}</h3>
                        <p class="text-blue-600 text-sm font-medium truncate">{{ $lowongan->company->company_name ?? 'Perusahaan' }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full"><i class="fas fa-map-marker-alt mr-1"></i>{{ $lowongan->location }}</span>
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $lowongan->job_type_label }}</span>
                </div>
                <p class="text-sm font-semibold text-green-600 mb-3">{{ $lowongan->salary_range }}</p>
                <div class="flex justify-between items-center pt-3 border-t border-gray-50">
                    <span class="px-3 py-1 text-xs rounded-full {{ $lowongan->deadline >= date('Y-m-d') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $lowongan->deadline >= date('Y-m-d') ? 'Dibuka' : 'Ditutup' }}
                    </span>
                    <span class="text-blue-600 text-sm font-semibold group-hover:underline">Lihat Detail →</span>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $lowongans->links() }}</div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl">
            @if(request()->hasAny(['search', 'q', 'tipe', 'location', 'lokasi']))
                <div class="text-5xl mb-3">😔</div>
                <p class="text-gray-500 text-lg mb-2">Tidak ada lowongan yang cocok.</p>
                <a href="{{ route('lowongan') }}" class="text-blue-600 hover:underline">Lihat semua lowongan →</a>
            @else
                <div class="text-5xl mb-3">📭</div>
                <p class="text-gray-500">Belum ada lowongan tersedia.</p>
            @endif
        </div>
    @endif
</div>
</section>
@endsection
