@extends('layouts.dashboard')
@section('title', 'Pelamar')
@section('page-title', 'Pelamar: ' . $lowongan->title)

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800">{{ $lowongan->title }}</h3>
            <p class="text-sm text-gray-500">{{ $lamarans->total() }} pelamar</p>
        </div>
        <a href="{{ route('perusahaan.dashboard') }}" class="text-sm text-green-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
    </div>
    @forelse($lamarans as $lmr)
    <div class="p-5 border-b border-gray-50 hover:bg-gray-50 transition">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center font-bold text-green-600">
                    {{ strtoupper(substr($lmr->user?->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-gray-800">{{ $lmr->user?->name }}</p>
                    <p class="text-sm text-gray-500">{{ $lmr->user?->email }}</p>
                    <p class="text-xs text-gray-400 mt-1">Dilamar: {{ $lmr->created_at->format('d M Y H:i') }}</p>
                    @if($lmr->pesan)
                    <p class="text-xs text-gray-600 mt-1 bg-gray-50 p-2 rounded-lg">{{ Str::limit($lmr->pesan, 100) }}</p>
                    @endif
                    <div class="flex gap-3 mt-2">
                        @if($lmr->cv_path)
                            <a href="{{ asset('storage/'.$lmr->cv_path) }}" target="_blank" class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded-lg hover:bg-green-100"><i class="fas fa-file-pdf mr-1"></i>Lihat CV</a>
                        @endif
                        @if($lmr->surat_pengantar_path)
                            <a href="{{ asset('storage/'.$lmr->surat_pengantar_path) }}" target="_blank" class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded-lg hover:bg-purple-100"><i class="fas fa-file-alt mr-1"></i>Surat Pengantar</a>
                        @endif
                        @if($lmr->portofolio_path)
                            <a href="{{ asset('storage/'.$lmr->portofolio_path) }}" target="_blank" class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded-lg hover:bg-green-100"><i class="fas fa-folder mr-1"></i>Portofolio</a>
                        @endif
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('perusahaan.lamaran.status', $lmr->id) }}" class="flex items-center gap-2 flex-shrink-0">
                @csrf
                <select name="status" class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                    <option value="menunggu" {{ $lmr->status === 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="diterima" {{ $lmr->status === 'diterima' ? 'selected' : '' }}>✅ Diterima</option>
                    <option value="ditolak" {{ $lmr->status === 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
                <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-xl text-sm hover:bg-green-700 transition">Update</button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-12 text-gray-400"><i class="fas fa-inbox text-4xl mb-2"></i><p>Belum ada pelamar</p></div>
    @endforelse
</div>
@if($lamarans->hasPages())<div class="mt-4">{{ $lamarans->links() }}</div>@endif
@endsection
