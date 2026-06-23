@extends('layouts.master')
@section('title', 'Berita Karir & Lowongan Kerja Bali')
@section('content')

<section class="bg-gradient-to-br from-green-700 to-green-900 py-16 text-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold mb-3">📰 Berita & Artikel</h1>
        <p class="text-green-200 text-lg">Tips karir, berita kerja, dan informasi terbaru seputar dunia kerja Bali</p>
        <form method="GET" action="{{ route('berita.index') }}" class="mt-6 max-w-md mx-auto flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..." class="flex-1 px-4 py-3 rounded-xl text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white">
            <button class="bg-white text-green-700 px-6 py-3 rounded-xl font-semibold text-sm hover:bg-green-50 transition">Cari</button>
        </form>
    </div>
</section>

<section class="py-12 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        {{-- Filter kategori --}}
        <div class="flex gap-2 flex-wrap mb-8">
            @foreach(['' => 'Semua', 'berita' => 'Berita', 'tips-karir' => 'Tips Karir', 'berita-perusahaan' => 'Berita Perusahaan'] as $k => $label)
                <a href="{{ route('berita.index', ['kategori' => $k]) }}" class="px-4 py-2 rounded-full text-sm font-medium transition {{ request('kategori') === $k ? 'bg-green-600 text-white' : 'bg-white text-gray-600 hover:bg-green-50 border border-gray-200' }}">{{ $label }}</a>
            @endforeach
        </div>

        @if($featured && !request('q') && !request('kategori'))
        {{-- Featured --}}
        <a href="{{ route('berita.show', $featured->slug) }}" class="block mb-8 bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-xl transition-all group">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="h-56 md:h-auto bg-gradient-to-br from-green-100 to-green-100 flex items-center justify-center overflow-hidden">
                    @if($featured->thumbnail)
                        <img src="{{ asset('storage/'.$featured->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="text-6xl">📰</div>
                    @endif
                </div>
                <div class="p-8 flex flex-col justify-center">
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full w-fit mb-3">{{ ucfirst(str_replace('-', ' ', $featured->kategori)) }}</span>
                    <h2 class="text-2xl font-bold text-gray-800 group-hover:text-green-700 transition mb-3">{{ $featured->judul }}</h2>
                    <p class="text-gray-500 text-sm">{{ Str::limit(strip_tags($featured->konten), 120) }}</p>
                    <p class="text-xs text-gray-400 mt-4">{{ $featured->published_at?->format('d M Y') }} • {{ $featured->views }} dibaca</p>
                </div>
            </div>
        </a>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($berita as $b)
            <a href="{{ route('berita.show', $b->slug) }}" class="bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all group overflow-hidden">
                <div class="h-44 bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center overflow-hidden">
                    @if($b->thumbnail)
                        <img src="{{ asset('storage/'.$b->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="text-5xl">
                            @if($b->kategori === 'tips-karir') 💡
                            @elseif($b->is_sponsored) 🏢
                            @else 📰 @endif
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">{{ ucfirst(str_replace('-', ' ', $b->kategori)) }}</span>
                        @if($b->is_sponsored)<span class="text-xs text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">Sponsor</span>@endif
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm leading-snug group-hover:text-green-700 transition mb-2">{{ $b->judul }}</h3>
                    <p class="text-xs text-gray-500">{{ Str::limit(strip_tags($b->konten), 80) }}</p>
                    <p class="text-xs text-gray-400 mt-3">{{ $b->published_at?->format('d M Y') }} • {{ $b->views }} dibaca</p>
                </div>
            </a>
            @empty
            <div class="col-span-3 text-center py-12 text-gray-400">
                <i class="fas fa-newspaper text-5xl mb-3"></i>
                <p>Belum ada berita</p>
            </div>
            @endforelse
        </div>

        @if($berita->hasPages())
        <div class="mt-8 flex justify-center">{{ $berita->links() }}</div>
        @endif
    </div>
</section>
@endsection
