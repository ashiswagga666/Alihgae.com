@extends('layouts.dashboard')
@section('title', 'Dashboard Perusahaan')
@section('page-title', $company->company_name)
@section('page-subtitle', 'Dashboard manajemen lowongan & pelamar')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach([['Total Lowongan', $stats['total_lowongan'], 'fas fa-briefcase', 'blue'], ['Lowongan Aktif', $stats['lowongan_aktif'], 'fas fa-check-circle', 'green'], ['Total Lamaran', $stats['total_lamaran'], 'fas fa-file-alt', 'purple'], ['Lamaran Baru', $stats['lamaran_baru'], 'fas fa-bell', 'orange']] as [$label, $val, $icon, $color])
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">{{ $label }}</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $val }}</p>
            </div>
            <div class="w-10 h-10 bg-{{ $color }}-100 rounded-xl flex items-center justify-center">
                <i class="{{ $icon }} text-{{ $color }}-600"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Quick Actions --}}
<div class="flex gap-3 mb-6">
    <a href="{{ route('perusahaan.lowongan.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-blue-700 transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Buat Lowongan
    </a>
    <a href="{{ route('perusahaan.profil.edit') }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-gray-50 transition flex items-center gap-2">
        <i class="fas fa-building"></i> Edit Profil
    </a>
    <a href="{{ route('perusahaan.berita.request') }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-gray-50 transition flex items-center gap-2">
        <i class="fas fa-newspaper"></i> Request Berita
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Daftar Lowongan --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Lowongan Saya</h3>
        </div>
        @forelse($lowongans as $lw)
        <div class="p-5 border-b border-gray-50 hover:bg-gray-50 transition">
            <div class="flex justify-between items-start gap-3">
                <div class="flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h4 class="font-semibold text-gray-800 text-sm">{{ $lw->title }}</h4>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $lw->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $lw->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i>{{ $lw->location }} • {{ $lw->job_type_label }}</p>
                    <p class="text-xs text-gray-400 mt-1">Deadline: {{ $lw->deadline?->format('d M Y') }} • <span class="text-blue-600 font-medium">{{ $lw->lamarans_count }} pelamar</span></p>
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    <a href="{{ route('perusahaan.lowongan.pelamar', $lw->id) }}" class="text-xs bg-blue-50 text-blue-600 px-2 py-1.5 rounded-lg hover:bg-blue-100 transition">Pelamar</a>
                    <a href="{{ route('perusahaan.lowongan.edit', $lw->id) }}" class="text-xs bg-gray-50 text-gray-600 px-2 py-1.5 rounded-lg hover:bg-gray-100 transition">Edit</a>
                    <form method="POST" action="{{ route('perusahaan.lowongan.destroy', $lw->id) }}" onsubmit="return confirm('Hapus lowongan ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs bg-red-50 text-red-600 px-2 py-1.5 rounded-lg hover:bg-red-100 transition">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">
            <i class="fas fa-briefcase text-4xl mb-2"></i>
            <p class="text-sm">Belum ada lowongan</p>
            <a href="{{ route('perusahaan.lowongan.create') }}" class="mt-2 inline-block text-blue-600 text-sm hover:underline">+ Buat Lowongan Pertama</a>
        </div>
        @endforelse
    </div>

    {{-- Lamaran Terbaru --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Lamaran Masuk</h3>
        </div>
        @forelse($lamaranTerbaru as $lmr)
        <div class="p-4 border-b border-gray-50">
            <p class="font-semibold text-sm text-gray-800">{{ $lmr->user?->name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ $lmr->lowongan?->title }}</p>
            <div class="flex items-center justify-between mt-2">
                <span class="text-xs text-gray-400">{{ $lmr->created_at->diffForHumans() }}</span>
                @php $sc = match($lmr->status) { 'diterima' => 'bg-green-100 text-green-700', 'ditolak' => 'bg-red-100 text-red-700', default => 'bg-yellow-100 text-yellow-700' } @endphp
                <span class="text-xs px-2 py-0.5 rounded-full {{ $sc }}">{{ ucfirst($lmr->status) }}</span>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-400 text-sm">Belum ada lamaran</div>
        @endforelse
    </div>
</div>
@endsection
