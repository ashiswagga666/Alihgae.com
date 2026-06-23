@extends('layouts.dashboard')
@section('title', 'Pengaturan Situs')
@section('page-title', 'Pengaturan Situs')
@section('page-subtitle', 'Edit konten dan tampilan website Alihgae.com')

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
@csrf
<div class="space-y-5">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-globe text-green-500 mr-2"></i>Identitas Situs</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Situs</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Situs</label>
                <textarea name="site_description" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none resize-none">{{ $settings['site_description'] ?? '' }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Logo Situs</label>
                @if(!empty($settings['logo_path']))
                    <img src="/{{ $settings['logo_path'] }}" class="h-12 mb-2 object-contain">
                @endif
                <input type="file" name="logo" accept="image/*" class="text-sm text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-home text-green-500 mr-2"></i>Konten Beranda</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Hero</label>
                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle Hero</label>
                <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-phone text-purple-500 mr-2"></i>Kontak</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Kontak</label>
                <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <input type="text" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-money-bill text-yellow-500 mr-2"></i>Tarif</h3>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Berita Sponsor (Rp)</label>
            <input type="number" name="harga_sponsor_berita" value="{{ $settings['harga_sponsor_berita'] ?? 500000 }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 outline-none">
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-green-700 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Simpan Pengaturan
        </button>
    </div>
</div>
</form>
</div>
@endsection
