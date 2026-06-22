@extends('layouts.dashboard')
@section('title', 'Request Berita Sponsor')
@section('page-title', 'Request Berita Sponsor')
@section('page-subtitle', 'Review dan kelola permintaan berita dari perusahaan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @forelse($requests as $req)
    <div class="p-6 border-b border-gray-50">
        <div class="flex justify-between items-start gap-4 mb-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <p class="font-bold text-gray-800">{{ $req->judul }}</p>
                    @php $sc = match($req->status) { 'approved' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700', default => 'bg-yellow-100 text-yellow-700' } @endphp
                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold {{ $sc }}">{{ ucfirst($req->status) }}</span>
                </div>
                <p class="text-sm text-gray-600">Dari: <strong>{{ $req->company?->company_name }}</strong></p>
                <p class="text-xs text-gray-400">{{ $req->created_at->format('d M Y H:i') }} • Nominal: <strong class="text-green-600">Rp {{ number_format($req->nominal, 0, ',', '.') }}</strong></p>
            </div>
        </div>
        <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 mb-4 max-h-32 overflow-y-auto">{{ Str::limit($req->konten, 300) }}</div>
        @if($req->status === 'pending')
        <div class="flex gap-3">
            <form method="POST" action="{{ route('admin.berita.requests.action', $req->id) }}" class="flex gap-2">
                @csrf
                <input type="hidden" name="action" value="approve">
                <button class="bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-green-700 transition">✅ Setujui & Publikasikan</button>
            </form>
            <form method="POST" action="{{ route('admin.berita.requests.action', $req->id) }}" class="flex gap-2 items-center">
                @csrf
                <input type="hidden" name="action" value="reject">
                <input type="text" name="catatan" placeholder="Alasan penolakan..." class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-red-300 outline-none">
                <button class="bg-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-red-600 transition">❌ Tolak</button>
            </form>
        </div>
        @endif
    </div>
    @empty
    <div class="text-center py-12 text-gray-400"><i class="fas fa-inbox text-4xl mb-2"></i><p>Tidak ada request</p></div>
    @endforelse
</div>
@if($requests->hasPages())<div class="mt-4">{{ $requests->links() }}</div>@endif
@endsection
