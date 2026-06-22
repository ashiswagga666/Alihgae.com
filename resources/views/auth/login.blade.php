@extends('layouts.master')

@section('title', 'Masuk — Alihgae')

@section('content')

{{-- Halaman login: layout tengah layar --}}
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
<div class="w-full max-w-md">

    {{-- Logo & judul --}}
    <div class="text-center mb-8">
        <a href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo3.png') }}" alt="Alihgae" class="h-12 mx-auto mb-3">
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Masuk ke Akun</h1>
        <p class="text-gray-500 text-sm mt-1">Selamat datang kembali! 👋</p>
    </div>

    {{-- Card form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        {{-- Notif sukses (setelah register / redirect) --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-5 text-sm">
            ✅ {{ session('success') }}
        </div>
        @endif

        {{-- Tampilkan error validasi --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm">
            ❌ {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Input email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input name="email" type="email" value="{{ old('email') }}"
                    placeholder="email@contoh.com" required autofocus
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
            </div>

            {{-- Input password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input name="password" type="password" required
                    placeholder="Masukkan password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
            </div>

            {{-- Checkbox ingat saya --}}
            <div class="flex items-center gap-2">
                <input name="remember" type="checkbox" id="remember" class="rounded border-gray-300 text-blue-600">
                <label for="remember" class="text-sm text-gray-600 cursor-pointer">Ingat saya</label>
            </div>

            {{-- Tombol CTA oranye --}}
            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition">
                Masuk
            </button>
        </form>

        {{-- Divider --}}
        <div class="flex items-center gap-3 my-6">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-gray-400 text-xs">atau</span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        {{-- Link ke register --}}
        <p class="text-center text-sm text-gray-500">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">Daftar Sekarang</a>
        </p>

        {{-- Link khusus daftar perusahaan --}}
        <div class="border-t border-gray-100 mt-6 pt-5 text-center">
            <p class="text-xs text-gray-400 mb-2">Punya perusahaan?</p>
            <a href="{{ route('register') }}"
               class="text-sm text-blue-600 font-medium hover:underline">
               Daftar Akun Perusahaan →
            </a>
        </div>

    </div>

    {{-- Link kembali ke beranda --}}
    <p class="text-center mt-5 text-sm text-gray-400">
        <a href="{{ route('beranda') }}" class="hover:text-blue-600 transition">← Kembali ke Beranda</a>
    </p>

</div>
</div>

@endsection