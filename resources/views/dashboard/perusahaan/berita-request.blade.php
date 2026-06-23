@extends('layouts.dashboard')
@section('title', 'Request Berita Sponsor')
@section('page-title', 'Request Berita Sponsor')
@section('page-subtitle', 'Pasang berita tentang perusahaan Anda di halaman berita')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Form --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-1">Ajukan Berita Baru</h3>
        <div class="bg-green-50 border border-green-100 rounded-xl p-3 mb-4 text-sm text-green-700">
            <i class="fas fa-info-circle mr-1"></i> Biaya pemasangan berita sponsor: <strong>Rp 500.000</strong> per artikel. Admin akan menghubungi Anda setelah disetujui.
        </div>
        <form method="POST" action="{{ route('perusahaan.berita.request.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required placeholder="misal: PT Kami Buka Rekrutmen Besar 2025" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konten Berita <span class="text-red-500">*</span></label>
                <textarea name="konten" rows="8" required placeholder="Tulis konten berita tentang perusahaan Anda..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail (opsional)</label>
                <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700">
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                <i class="fas fa-paper-plane mr-2"></i>Kirim Request (Rp 500.000)
            </button>
        </form>
    </div>

    {{-- History --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4">Riwayat Request</h3>
        @forelse($requests as $req)
        <div class="p-4 border border-gray-100 rounded-xl mb-3">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold text-sm text-gray-800">{{ $req->judul }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $req->created_at->format('d M Y') }} • Rp {{ number_format($req->nominal, 0, ',', '.') }}</p>
                    @if($req->catatan_admin)<p class="text-xs text-gray-600 mt-1 italic">Admin: {{ $req->catatan_admin }}</p>@endif
                </div>
                @php $sc = match($req->status) { 'approved' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700', default => 'bg-yellow-100 text-yellow-700' } @endphp
                <span class="text-xs px-3 py-1 rounded-full font-semibold {{ $sc }}">{{ ucfirst($req->status) }}</span>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-400 text-sm"><i class="fas fa-newspaper text-3xl mb-2"></i><p>Belum ada request</p></div>
        @endforelse
    </div>
</div>
@endsection
