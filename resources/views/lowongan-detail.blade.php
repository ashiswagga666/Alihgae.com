@extends('layouts.master')
@section('title', $lowongan->title . ' — ' . ($lowongan->company->company_name ?? ''))
@section('content')

<section class="bg-gray-50 py-10">
<div class="max-w-5xl mx-auto px-6">
    <a href="{{ route('lowongan') }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:underline mb-6">
        <i class="fas fa-arrow-left"></i> Kembali ke Lowongan
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-start gap-5">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if($lowongan->company->logo ?? null)
                            <img src="{{ asset('storage/'.$lowongan->company->logo) }}" class="w-full h-full object-cover">
                        @else <span class="text-3xl">🏢</span> @endif
                    </div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $lowongan->title }}</h1>
                        <a href="{{ route('perusahaan.detail', $lowongan->company_id) }}" class="text-blue-600 font-semibold hover:underline">
                            {{ $lowongan->company->company_name ?? 'Perusahaan' }}
                        </a>
                        @if($lowongan->company->is_verified ?? false)
                            <span class="ml-2 text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full"><i class="fas fa-check-circle mr-1"></i>Terverifikasi</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-5 pt-5 border-t border-gray-100">
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <i class="fas fa-map-marker-alt text-blue-500 text-lg mb-1"></i>
                        <p class="text-xs text-gray-500">Lokasi</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $lowongan->location }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <i class="fas fa-briefcase text-green-500 text-lg mb-1"></i>
                        <p class="text-xs text-gray-500">Tipe</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $lowongan->job_type_label }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <i class="fas fa-graduation-cap text-purple-500 text-lg mb-1"></i>
                        <p class="text-xs text-gray-500">Pendidikan</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $lowongan->min_education }}</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-xl">
                        <i class="fas fa-clock text-orange-500 text-lg mb-1"></i>
                        <p class="text-xs text-gray-500">Deadline</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $lowongan->deadline?->format('d M Y') }}</p>
                    </div>
                </div>

                @if($lowongan->salary_min || $lowongan->salary_max)
                <div class="mt-4 bg-green-50 border border-green-100 rounded-xl p-3 flex items-center gap-2">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                    <span class="font-semibold text-green-700">{{ $lowongan->salary_range }}</span>
                    <span class="text-green-600 text-sm">/ bulan</span>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-3">Deskripsi Pekerjaan</h2>
                <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $lowongan->description }}</div>
            </div>

            @if($lowongan->requirements)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-3">Persyaratan</h2>
                <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $lowongan->requirements }}</div>
            </div>
            @endif
        </div>

        {{-- Sidebar: Form Lamar --}}
        <div class="space-y-5">
            @auth
                @if(Auth::user()->role === 'pelamar')
                    @php $sudahLamar = \App\Models\Lamaran::where('user_id', Auth::id())->where('lowongan_id', $lowongan->id)->exists() @endphp
                    @if($sudahLamar)
                        <div class="bg-green-50 border border-green-200 rounded-2xl p-5 text-center">
                            <i class="fas fa-check-circle text-green-500 text-4xl mb-2"></i>
                            <p class="font-semibold text-green-700">Sudah Melamar</p>
                            <p class="text-sm text-green-600 mt-1">Pantau status di riwayat lamaran</p>
                            <a href="{{ route('pelamar.riwayat') }}" class="mt-3 block bg-green-600 text-white py-2 rounded-xl text-sm font-semibold hover:bg-green-700 transition">Lihat Riwayat</a>
                        </div>
                    @else
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-4">📨 Lamar Sekarang</h3>
                            <form method="POST" action="{{ route('lamaran.store', $lowongan->id) }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CV / Resume</label>
                                    <input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700">
                                    @php $profile = Auth::user()->profile @endphp
                                    @if($profile?->cv_path)
                                        <p class="text-xs text-green-600 mt-1"><i class="fas fa-check-circle mr-1"></i>CV profil akan digunakan jika tidak upload baru</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Surat Pengantar</label>
                                    <input type="file" name="surat_pengantar" accept=".pdf,.doc,.docx" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Portofolio (opsional)</label>
                                    <input type="file" name="portofolio" accept=".pdf,.zip,.doc,.docx" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan ke HRD</label>
                                    <textarea name="pesan" rows="3" placeholder="Perkenalkan dirimu secara singkat..." class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition text-sm">
                                    <i class="fas fa-paper-plane mr-2"></i>Kirim Lamaran
                                </button>
                            </form>
                        </div>
                    @endif
                @elseif(Auth::user()->role === 'perusahaan')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-5 text-center text-sm text-yellow-700">
                        <i class="fas fa-info-circle text-xl mb-2"></i>
                        <p>Anda login sebagai perusahaan</p>
                    </div>
                @endif
            @else
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="text-4xl mb-3">🔐</div>
                    <p class="font-semibold text-gray-800 mb-1">Login untuk Melamar</p>
                    <p class="text-sm text-gray-500 mb-4">Buat akun gratis dan lamar ribuan lowongan di Bali</p>
                    <a href="{{ route('login') }}" class="block bg-blue-600 text-white py-2.5 rounded-xl font-semibold hover:bg-blue-700 transition text-sm mb-2">Login</a>
                    <a href="{{ route('register') }}" class="block bg-gray-100 text-gray-700 py-2.5 rounded-xl font-semibold hover:bg-gray-200 transition text-sm">Daftar Gratis</a>
                </div>
            @endauth

            {{-- Info Perusahaan --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-800 mb-3">🏢 Tentang Perusahaan</h3>
                <p class="font-semibold text-gray-800">{{ $lowongan->company->company_name }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $lowongan->company->industry }}</p>
                @if($lowongan->company->city)
                <p class="text-xs text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i>{{ $lowongan->company->city }}, Bali</p>
                @endif
                @if($lowongan->company->employee_count)
                <p class="text-xs text-gray-500"><i class="fas fa-users mr-1"></i>{{ $lowongan->company->employee_count }} karyawan</p>
                @endif
                @if($lowongan->company->website)
                <a href="{{ $lowongan->company->website }}" target="_blank" class="text-xs text-blue-600 hover:underline"><i class="fas fa-globe mr-1"></i>Website</a>
                @endif
            </div>
        </div>
    </div>
</div>
</section>
@endsection
