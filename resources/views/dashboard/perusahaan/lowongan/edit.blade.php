@extends('layouts.dashboard')
@section('title', 'Edit Lowongan')
@section('page-title', 'Edit Lowongan')

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ route('perusahaan.lowongan.update', $lowongan->id) }}">
@csrf @method('PUT')
@include('dashboard.perusahaan.lowongan._form')
<div class="mt-5 flex items-center gap-3">
    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition"><i class="fas fa-save mr-2"></i>Simpan Perubahan</button>
    <a href="{{ route('perusahaan.dashboard') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">Batal</a>
    <label class="flex items-center gap-2 ml-auto">
        <input type="checkbox" name="is_active" value="1" {{ isset($lowongan) && $lowongan->is_active ? 'checked' : '' }} class="w-4 h-4 accent-green-600">
        <span class="text-sm text-gray-700 font-medium">Aktifkan Lowongan</span>
    </label>
</div>
</form>
</div>
@endsection
