@extends('layouts.master')
@section('title', $berita->judul)
@section('content')

<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-6">
        <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:underline mb-6">
            <i class="fas fa-arrow-left"></i> Kembali ke Berita
        </a>
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            @if($berita->thumbnail)
            <div class="h-72 overflow-hidden">
                <img src="{{ asset('storage/'.$berita->thumbnail) }}" class="w-full h-full object-cover">
            </div>
            @endif
            <div class="p-8">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">{{ ucfirst(str_replace('-', ' ', $berita->kategori)) }}</span>
                    @if($berita->is_sponsored)<span class="text-xs text-orange-600 bg-orange-50 px-3 py-1 rounded-full">Sponsor</span>@endif
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $berita->judul }}</h1>
                <p class="text-sm text-gray-500 mb-6 flex items-center gap-3">
                    <span><i class="fas fa-user mr-1"></i>{{ $berita->author?->name }}</span>
                    <span><i class="fas fa-calendar mr-1"></i>{{ $berita->published_at?->format('d M Y') }}</span>
                    <span><i class="fas fa-eye mr-1"></i>{{ $berita->views }} dibaca</span>
                </p>
                <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">{{ $berita->konten }}</div>
            </div>
        </div>

        @if($related->count())
        <div class="mt-10">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Baca Juga</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($related as $r)
                <a href="{{ route('berita.show', $r->slug) }}" class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition hover:-translate-y-1">
                    <h4 class="font-semibold text-sm text-gray-800 hover:text-blue-700">{{ $r->judul }}</h4>
                    <p class="text-xs text-gray-400 mt-1">{{ $r->published_at?->format('d M Y') }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
