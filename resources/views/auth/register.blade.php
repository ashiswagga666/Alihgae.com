@extends('layouts.master')

@section('title', 'Daftar — Alihgae')

@section('content')

{{-- Halaman register: layout tengah layar --}}
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
<div class="w-full max-w-md">

    {{-- Logo & judul --}}
    <div class="text-center mb-8">
        <a href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo3.png') }}" alt="Alihgae" class="h-12 mx-auto mb-3">
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Bergabung dan temukan karir impianmu! 🚀</p>
    </div>

    {{-- Card form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

        {{-- Tampilkan semua error validasi --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-5 text-sm">
            @foreach($errors->all() as $error)
                <p>❌ {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Pilih role: Pencari Kerja atau Perusahaan --}}
            {{-- Ini penting! Tanpa ini register akan error "role is required" --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Daftar sebagai</label>
                <div class="grid grid-cols-2 gap-3">

                    {{-- Opsi: Pencari Kerja --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="pelamar"
                            {{ old('role', 'pelamar') === 'pelamar' ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700
                                    border-2 border-gray-200 rounded-xl p-3 text-center transition hover:border-blue-300">
                            <div class="text-xl mb-1">🧑‍💼</div>
                            <div class="font-semibold text-xs">Pencari Kerja</div>
                            <div class="text-xs text-gray-400 mt-0.5">Saya ingin melamar</div>
                        </div>
                    </label>

                    {{-- Opsi: Perusahaan --}}
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="perusahaan"
                            {{ old('role') === 'perusahaan' ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700
                                    border-2 border-gray-200 rounded-xl p-3 text-center transition hover:border-blue-300">
                            <div class="text-xl mb-1">🏢</div>
                            <div class="font-semibold text-xs">Perusahaan</div>
                            <div class="text-xs text-gray-400 mt-0.5">Saya ingin merekrut</div>
                        </div>
                    </label>

                </div>
            </div>

            {{-- Input nama lengkap / nama perusahaan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap / Nama Perusahaan</label>
                <input name="name" type="text" value="{{ old('name') }}"
                    placeholder="Nama kamu atau perusahaan" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
            </div>

            {{-- Input email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input name="email" type="email" value="{{ old('email') }}"
                    placeholder="email@contoh.com" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
            </div>

            {{-- Input password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input name="password" type="password" required
                    placeholder="Min. 6 karakter"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
            </div>

            {{-- Konfirmasi password (harus sama dengan password di atas) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input name="password_confirmation" type="password" required
                    placeholder="Ulangi password"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                           focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
            </div>

            {{-- Tombol CTA oranye --}}
            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition">
                Daftar Sekarang
            </button>
        </form>

        {{-- Divider --}}
        <div class="flex items-center gap-3 my-6">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-gray-400 text-xs">atau</span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        {{-- Link ke login --}}
        <p class="text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Masuk Sekarang</a>
        </p>

    </div>

    {{-- Link kembali ke beranda --}}
    <p class="text-center mt-5 text-sm text-gray-400">
        <a href="{{ route('beranda') }}" class="hover:text-blue-600 transition">← Kembali ke Beranda</a>
    </p>

</div>
</div>

@endsection