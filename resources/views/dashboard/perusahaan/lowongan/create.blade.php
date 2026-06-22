@extends('layouts.dashboard')
@section('title', 'Buat Lowongan')
@section('page-title', 'Buat Lowongan Baru')

@section('content')
<div class="max-w-3xl">
<form method="POST" action="{{ route('perusahaan.lowongan.store') }}">
@csrf
@include('dashboard.perusahaan.lowongan._form')
<div class="mt-5 flex gap-3">
    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition"><i class="fas fa-paper-plane mr-2"></i>Publikasikan Lowongan</button>
    <a href="{{ route('perusahaan.dashboard') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition">Batal</a>
</div>
</form>
</div>
@endsection
