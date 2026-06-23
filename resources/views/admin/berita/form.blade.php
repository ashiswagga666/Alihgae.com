@extends('layouts.dashboard')
@section('title', isset($berita) ? 'Edit Berita' : 'Tulis Berita')
@section('page-title', isset($berita) ? 'Edit Berita' : 'Tulis Berita Baru')

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ isset($berita) ? route('admin.berita.update', $berita->id) : route('admin.berita.store') }}" enctype="multipart/form-data">
@csrf
@if(isset($berita)) @method('PUT') @endif
<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
        <input type="text" name="judul" value="{{ old('judul', $berita->judul ?? '') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
            <select name="kategori" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                @foreach(['berita' => 'Berita', 'tips-karir' => 'Tips Karir', 'berita-perusahaan' => 'Berita Perusahaan', 'umum' => 'Umum'] as $v => $l)
                    <option value="{{ $v }}" {{ old('kategori', $berita->kategori ?? '') === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
                @foreach(['draft' => 'Draft', 'published' => 'Publikasikan'] as $v => $l)
                    <option value="{{ $v }}" {{ old('status', $berita->status ?? 'draft') === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
        @if(isset($berita) && $berita->thumbnail)
            <img src="{{ asset('storage/'.$berita->thumbnail) }}" class="h-24 rounded-xl object-cover mb-2">
        @endif
        <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Konten <span class="text-red-500">*</span></label>
        <textarea name="konten" rows="12" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none resize-none">{{ old('konten', $berita->konten ?? '') }}</textarea>
    </div>
    <div class="flex gap-3 justify-end">
        <a href="{{ route('admin.berita.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-gray-200 transition">Batal</a>
        <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-green-700 transition"><i class="fas fa-save mr-2"></i>{{ isset($berita) ? 'Simpan Perubahan' : 'Publikasikan' }}</button>
    </div>
</div>
</form>
</div>
@endsection
