@extends('layouts.master')
@section('title', 'Perusahaan Terpercaya di Bali — Alihgae.com')
@section('content')

<section class="bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 py-14 text-white">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">🏢 Perusahaan Terpercaya di Bali</h1>
        <p class="text-blue-200">{{ $perusahaans->count() }}+ perusahaan aktif merekrut talenta terbaik</p>
    </div>
</section>

<section class="bg-gray-50 py-10">
<div class="max-w-6xl mx-auto px-6">
    @if($perusahaans->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($perusahaans as $p)
        <a href="{{ route('perusahaan.detail', $p->id) }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-xl hover:-translate-y-1 transition-all border border-gray-100 group">
            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-3xl mb-4 overflow-hidden">
                @if($p->logo)
                    <img src="{{ asset('storage/'.$p->logo) }}" class="w-full h-full object-cover">
                @else 🏢 @endif
            </div>
            <h2 class="font-bold text-lg text-gray-800 group-hover:text-blue-700 transition">{{ $p->company_name }}</h2>
            <p class="text-gray-500 text-sm mt-1">{{ $p->industry ?? '-' }}</p>
            @if($p->city)<p class="text-xs text-gray-400 mt-1"><i class="fas fa-map-marker-alt mr-1"></i>{{ $p->city }}, Bali</p>@endif
            <div class="flex items-center justify-between mt-4">
                @if($p->is_verified)
                    <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full"><i class="fas fa-check-circle mr-1"></i>Terverifikasi</span>
                @else <span></span> @endif
                <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold">{{ $p->job_listings_count }} Lowongan</span>
            </div>
        </a>
        @endforeach
    </div>
    @else
        <div class="text-center py-20 bg-white rounded-2xl">
            <div class="text-5xl mb-3">🏢</div>
            <p class="text-gray-500">Belum ada perusahaan terdaftar.</p>
        </div>
    @endif
</div>
</section>
@endsection
