@extends('layouts.dashboard')
@section('title', 'Profil Perusahaan')
@section('page-title', 'Profil Perusahaan')
@section('page-subtitle', 'Lengkapi profil agar pelamar lebih tertarik')

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ route('perusahaan.profil.update') }}" enctype="multipart/form-data">
@csrf
<div class="space-y-5">
    {{-- Logo --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-image text-blue-500 mr-2"></i>Logo Perusahaan</h3>
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden bg-gray-50">
                @if($company->logo)
                    <img src="{{ asset('storage/'.$company->logo) }}" class="w-full h-full object-cover">
                @else <i class="fas fa-building text-3xl text-gray-300"></i>
                @endif
            </div>
            <div>
                <input type="file" name="logo" accept="image/*" class="text-sm text-gray-500 file:mr-2 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700">
                <p class="text-xs text-gray-400 mt-1">JPG, PNG. Maks 2MB. Ukuran ideal: 200x200px</p>
            </div>
        </div>
    </div>

    {{-- Info Utama --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4"><i class="fas fa-building text-blue-500 mr-2"></i>Informasi Perusahaan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan <span class="text-red-500">*</span></label>
                <input type="text" name="company_name" value="{{ $company->company_name }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Industri <span class="text-red-500">*</span></label>
                <select name="industry" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach(['Teknologi Informasi','Pariwisata & Perhotelan','Retail & Oleh-oleh','Keuangan & Perbankan','Kesehatan','Properti & Real Estate','Startup Teknologi','Pendidikan','Manufaktur','Kuliner & F&B','Media & Kreatif','Lainnya'] as $ind)
                        <option value="{{ $ind }}" {{ $company->industry === $ind ? 'selected' : '' }}>{{ $ind }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                <select name="city" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach(['Denpasar','Badung','Gianyar','Tabanan','Buleleng','Klungkung','Karangasem','Jembrana','Bangli'] as $kota)
                        <option value="{{ $kota }}" {{ $company->city === $kota ? 'selected' : '' }}>{{ $kota }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Karyawan</label>
                <select name="employee_count" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    @foreach(['1-10','10-50','50-100','100-200','200-500','500-1000','1000+'] as $ec)
                        <option value="{{ $ec }}" {{ $company->employee_count === $ec ? 'selected' : '' }}>{{ $ec }} karyawan</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Berdiri</label>
                <input type="number" name="founded_year" value="{{ $company->founded_year }}" min="1900" max="{{ date('Y') }}" placeholder="2015" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <input type="text" name="address" value="{{ $company->address }}" placeholder="Jl. Contoh No. 1, Denpasar" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                <input type="text" name="phone" value="{{ $company->phone }}" placeholder="0361-xxx" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Perusahaan</label>
                <input type="email" name="email" value="{{ $company->email }}" placeholder="info@perusahaan.com" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                <input type="url" name="website" value="{{ $company->website }}" placeholder="https://perusahaan.com" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Perusahaan</label>
                <textarea name="description" rows="5" placeholder="Ceritakan tentang perusahaan, visi misi, budaya kerja..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ $company->description }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Simpan Profil
        </button>
    </div>
</div>
</form>
</div>
@endsection
