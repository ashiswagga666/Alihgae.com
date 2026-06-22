@extends('layouts.master')
@section('title', 'Blog')
@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📝 Blog & Artikel</h1>

    <div class="grid gap-6">

        <div class="bg-white rounded-xl shadow p-6 hover:shadow-md transition">
            <span class="bg-sky-100 text-sky-700 text-xs px-3 py-1 rounded-full font-semibold">Tips Karir</span>
            <h2 class="font-bold text-xl mt-3 mb-2">10 Tips Lolos Interview Kerja di 2026</h2>
            <p class="text-gray-500 text-sm leading-relaxed">Persiapkan dirimu dengan tips terbaik agar berhasil melewati proses seleksi...</p>
            <div class="flex items-center justify-between mt-4">
                <span class="text-gray-400 text-xs">6 April 2025</span>
                <a href="#" class="text-indigo-600 text-sm font-semibold hover:underline">Baca →</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 hover:shadow-md transition">
            <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-semibold">Hoax 2024</span>
            <h2 class="font-bold text-xl mt-3 mb-2">19 Juta Lapangan Kerja</h2>
            <p class="text-gray-500 text-sm leading-relaxed">Janji penciptaan 19 juta lapangan kerja adalah program strategis dari pasangan Presiden Prabowo Subianto dan Wakil Presiden Gibran...</p>
            <div class="flex items-center justify-between mt-4">
                <span class="text-gray-400 text-xs">Januari 2024</span>
                <a href="#" class="text-indigo-600 text-sm font-semibold hover:underline">Baca →</a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 hover:shadow-md transition">
            <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold">Lowongan Kerja MBG</span>
            <h2 class="font-bold text-xl mt-3 mb-2">Peluang Kerja MBG</h2>
            <p class="text-gray-500 text-sm leading-relaxed">Lowongan dan peluang kerja MBG sangat luas.</p>
            <div class="flex items-center justify-between mt-4">
                <span class="text-gray-400 text-xs">April 2026</span>
                <a href="#" class="text-indigo-600 text-sm font-semibold hover:underline">Baca →</a>
            </div>
        </div>

    </div>
</div>

@endsection