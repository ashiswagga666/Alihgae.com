@extends('layouts.dashboard')
@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')

@section('content')
<div class="flex justify-between items-center mb-5">
    <div class="flex gap-2">
        <a href="{{ route('admin.berita.requests') }}" class="relative bg-orange-50 border border-orange-200 text-orange-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-orange-100 transition">
            <i class="fas fa-inbox mr-1"></i>Request Sponsor
            @if($pendingRequests > 0)<span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $pendingRequests }}</span>@endif
        </a>
        <a href="{{ route('admin.berita.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-green-700 transition">+ Tulis Berita</a>
    </div>
</div>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @forelse($berita as $b)
    <div class="p-5 border-b border-gray-50 hover:bg-gray-50 flex justify-between items-center gap-4">
        <div class="flex items-center gap-4">
            @if($b->thumbnail)
                <img src="{{ asset('storage/'.$b->thumbnail) }}" class="w-14 h-14 object-cover rounded-xl flex-shrink-0">
            @else
                <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">📰</div>
            @endif
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $b->judul }}</p>
                <p class="text-xs text-gray-500">{{ $b->author?->name }} • {{ $b->published_at?->format('d M Y') ?? 'Draft' }} • {{ $b->views }} views</p>
                <div class="flex gap-2 mt-1">
                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ ucfirst(str_replace('-',' ',$b->kategori)) }}</span>
                    @if($b->is_sponsored)<span class="text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">Sponsor</span>@endif
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            @php $sc = match($b->status) { 'published' => 'bg-green-100 text-green-700', 'draft' => 'bg-gray-100 text-gray-500', default => 'bg-yellow-100 text-yellow-700' } @endphp
            <span class="text-xs px-2 py-1 rounded-full {{ $sc }}">{{ ucfirst($b->status) }}</span>
            <a href="{{ route('berita.show', $b->slug) }}" target="_blank" class="text-xs bg-gray-50 text-gray-600 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition">Lihat</a>
            <a href="{{ route('admin.berita.edit', $b->id) }}" class="text-xs bg-green-50 text-green-600 px-3 py-1.5 rounded-lg hover:bg-green-100 transition">Edit</a>
            <form method="POST" action="{{ route('admin.berita.destroy', $b->id) }}" onsubmit="return confirm('Hapus berita ini?')">
                @csrf @method('DELETE')
                <button class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-12 text-gray-400"><i class="fas fa-newspaper text-4xl mb-2"></i><p>Belum ada berita</p></div>
    @endforelse
</div>
@if($berita->hasPages())<div class="mt-4">{{ $berita->links() }}</div>@endif
@endsection
