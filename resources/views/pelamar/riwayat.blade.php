@extends('layouts.dashboard')
@section('title', 'Riwayat Lamaran')
@section('page-title', 'Riwayat Lamaran')
@section('page-subtitle', 'Pantau status semua lamaranmu')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Semua Lamaran</h3>
        <a href="{{ route('lowongan') }}" class="bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-green-700 transition">
            <i class="fas fa-plus mr-1"></i> Lamar Lagi
        </a>
    </div>
    @forelse($lamarans as $lmr)
    <div class="p-5 border-b border-gray-50 hover:bg-gray-50 transition">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">
                    @if($lmr->lowongan?->company?->logo)
                        <img src="{{ asset('storage/'.$lmr->lowongan->company->logo) }}" class="w-10 h-10 rounded-lg object-cover">
                    @else 💼 @endif
                </div>
                <div>
                    <p class="font-bold text-gray-800">{{ $lmr->nama_lowongan ?? $lmr->lowongan?->title }}</p>
                    <p class="text-sm text-gray-500">{{ $lmr->nama_perusahaan ?? $lmr->lowongan?->company?->company_name }}</p>
                    <p class="text-xs text-gray-400 mt-1">Dilamar: {{ $lmr->created_at->format('d M Y') }}</p>
                    <div class="flex gap-2 mt-2">
                        @if($lmr->cv_path)
                            <a href="{{ asset('storage/'.$lmr->cv_path) }}" target="_blank" class="text-xs text-green-600 hover:underline"><i class="fas fa-file-pdf mr-1"></i>CV</a>
                        @endif
                        @if($lmr->surat_pengantar_path)
                            <a href="{{ asset('storage/'.$lmr->surat_pengantar_path) }}" target="_blank" class="text-xs text-purple-600 hover:underline"><i class="fas fa-file-alt mr-1"></i>Surat</a>
                        @endif
                    </div>
                </div>
            </div>
            @php
                $statusColor = match($lmr->status) { 'diterima' => 'bg-green-100 text-green-700 border-green-200', 'ditolak' => 'bg-red-100 text-red-700 border-red-200', default => 'bg-yellow-100 text-yellow-700 border-yellow-200' };
                $statusLabel = match($lmr->status) { 'diterima' => '✅ Diterima', 'ditolak' => '❌ Ditolak', default => '⏳ Menunggu' };
            @endphp
            <span class="text-sm font-semibold px-4 py-2 rounded-xl border {{ $statusColor }} whitespace-nowrap">{{ $statusLabel }}</span>
        </div>
    </div>
    @empty
    <div class="text-center py-16 text-gray-400">
        <i class="fas fa-inbox text-5xl mb-3"></i>
        <p class="text-lg font-medium">Belum ada lamaran</p>
        <a href="{{ route('lowongan') }}" class="mt-3 inline-block bg-green-600 text-white px-6 py-2 rounded-xl text-sm font-semibold hover:bg-green-700 transition">Mulai Lamar Sekarang</a>
    </div>
    @endforelse
</div>
@if($lamarans->hasPages())
<div class="mt-4">{{ $lamarans->links() }}</div>
@endif
@endsection
