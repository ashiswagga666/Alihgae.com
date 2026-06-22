@extends('layouts.master')
@section('title', 'Lowongan Kerja - Alihgae')
@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-center mb-4">Lowongan Kerja</h1>
    <p class="text-center text-gray-600 mb-8">Temukan pekerjaan impianmu di sini</p>

    <form method="GET" action="{{ route('lowongan') }}" class="mb-10">
        <div class="flex flex-col md:flex-row gap-3 max-w-4xl mx-auto">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="🔍 Cari posisi, perusahaan, atau lokasi..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <select name="tipe" class="border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="">Semua Tipe</option>
                <option value="full-time" {{ request('tipe') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                <option value="part-time" {{ request('tipe') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                <option value="freelance" {{ request('tipe') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                <option value="internship" {{ request('tipe') == 'internship' ? 'selected' : '' }}>Magang</option>
            </select>
            <input type="text" name="location" value="{{ request('location') }}"
                placeholder="📍 Lokasi..."
                class="border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition whitespace-nowrap">Cari</button>
            @if(request()->hasAny(['search', 'tipe', 'location']))
            <a href="{{ route('lowongan') }}" class="border border-gray-300 text-gray-500 hover:bg-gray-50 px-4 py-3 rounded-xl text-sm font-semibold transition whitespace-nowrap text-center">Reset</a>
            @endif
        </div>
    </form>

    @if(isset($lowongans) && $lowongans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lowongans as $lowongan)
            <div class="bg-white rounded-2xl shadow p-6 hover:shadow-lg transition">
                <div class="text-4xl mb-3">💼</div>
                <h3 class="font-bold text-xl mb-1">{{ $lowongan->title }}</h3>
                <p class="text-green-600 font-medium mb-2">{{ $lowongan->company->company_name ?? 'Perusahaan' }}</p>
                <p class="text-gray-600 text-sm mb-2">{{ $lowongan->location }} • {{ $lowongan->job_type }}</p>
                <p class="text-gray-600 text-sm mb-4">
                    @if($lowongan->salary_min && $lowongan->salary_max)
                        Rp {{ number_format($lowongan->salary_min) }} - {{ number_format($lowongan->salary_max) }}
                    @else
                        Negosiasi
                    @endif
                </p>
                <div class="flex justify-between items-center">
                    <span class="px-3 py-1 text-xs rounded-full {{ $lowongan->deadline >= date('Y-m-d') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $lowongan->deadline >= date('Y-m-d') ? 'Buka' : 'Tutup' }}
                    </span>
                    <a href="{{ route('lowongan.detail', $lowongan->id) }}" class="text-green-600 hover:underline">Detail →</a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500">Belum ada lowongan tersedia.</p>
        </div>
    @endif
</div>
@endsection
