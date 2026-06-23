@extends('layouts.master')
@section('title', 'Beranda — Temukan Karir Impianmu di Bali')
@section('content')

{{-- Hero --}}
<x-hero :total-jobs="$totalJobs"></x-hero>

{{-- Stats --}}
<section class="bg-green-950 py-16">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="bg-black/30 border border-teal-900/50 p-8 rounded-3xl hover:border-teal-700/50 transition-all">
                <div class="text-6xl mb-4">💼</div>
                <p class="text-5xl font-bold text-teal-50">{{ $totalLowongan }}+</p>
                <p class="text-xl font-semibold text-teal-100 mt-2">Lowongan</p>
                <p class="text-sm text-teal-200 opacity-60">Aktif sekarang</p>
            </div>
            <div class="bg-black/30 border border-teal-900/50 p-8 rounded-3xl hover:border-teal-700/50 transition-all">
                <div class="text-6xl mb-4">🏢</div>
                <p class="text-5xl font-bold text-teal-50">{{ $totalPerusahaan }}+</p>
                <p class="text-xl font-semibold text-teal-100 mt-2">Perusahaan</p>
                <p class="text-sm text-teal-200 opacity-60">Terverifikasi</p>
            </div>
            <div class="bg-black/30 border border-teal-900/50 p-8 rounded-3xl hover:border-teal-700/50 transition-all">
                <div class="text-6xl mb-4">👥</div>
                <p class="text-5xl font-bold text-teal-50">{{ $totalPencari }}+</p>
                <p class="text-xl font-semibold text-teal-100 mt-2">Pencari</p>
                <p class="text-sm text-teal-200 opacity-60">Sudah daftar</p>
            </div>
        </div>
    </div>
</section>

{{-- Lowongan Terbaru --}}
<section class="bg-gray-50 py-20">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">💼 Lowongan Terbaru</h2>
                <p class="text-gray-500 mt-1">Pilih pekerjaan yang sesuai dengan keahlianmu</p>
            </div>
            <a href="{{ route('lowongan') }}" class="text-teal-600 hover:text-teal-700 text-sm font-bold">Lihat Semua →</a>
        </div>
        <div class="grid gap-5">
            @forelse($lowonganTerbaru as $job)
            <a href="{{ route('lowongan.detail', $job->id) }}"
               class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex justify-between items-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center text-3xl overflow-hidden">
                        @if($job->company->logo ?? null)
                            <img src="{{ asset('storage/'.$job->company->logo) }}" class="w-full h-full object-cover">
                        @else 💼 @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">{{ $job->title }}</h3>
                        <p class="text-gray-500">{{ $job->company->company_name ?? 'Perusahaan' }} • {{ $job->location }} • {{ $job->job_type_label }}</p>
                    </div>
                </div>
                <span class="bg-green-100 text-green-700 text-xs px-4 py-2 rounded-full font-bold uppercase whitespace-nowrap">
                    Buka
                </span>
            </a>
            @empty
            <div class="text-center py-12 text-gray-400">Belum ada lowongan tersedia.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- Berita Terbaru --}}
@if($beritaTerbaru->count())
<section class="bg-white py-20">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">📰 Berita & Tips Karir</h2>
                <p class="text-gray-500 mt-1">Informasi terbaru seputar dunia kerja di Bali</p>
            </div>
            <a href="{{ route('berita.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-bold">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($beritaTerbaru as $b)
            <a href="{{ route('berita.show', $b->slug) }}" class="bg-gray-50 rounded-2xl overflow-hidden hover:shadow-lg transition-all group">
                <div class="h-40 bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center overflow-hidden">
                    @if($b->thumbnail)
                        <img src="{{ asset('storage/'.$b->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else <div class="text-4xl">📰</div> @endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-800 text-sm group-hover:text-green-700 transition leading-snug">{{ $b->judul }}</h3>
                    <p class="text-xs text-gray-400 mt-2">{{ $b->published_at?->format('d M Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<x-cta></x-cta>

@endsection