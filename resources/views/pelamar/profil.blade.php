@extends('layouts.dashboard')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Lengkapi profil untuk meningkatkan peluang diterima')

@section('content')

{{-- Warning CV belum diupload --}}
@if(!$profile->cv_path || !$profile->surat_pengantar_path)
<div class="mb-5 bg-amber-50 border border-amber-300 rounded-2xl p-4">
    <div class="flex items-start gap-3">
        <div class="text-2xl mt-0.5">⚠️</div>
        <div class="flex-1">
            <p class="font-bold text-amber-800 text-sm">Dokumen Wajib Belum Lengkap!</p>
            <p class="text-amber-700 text-xs mt-1">Kamu tidak bisa melamar pekerjaan sebelum mengupload dokumen berikut:</p>
            <div class="flex gap-4 mt-2">
                @if(!$profile->cv_path)
                <span class="flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 border border-red-200 px-3 py-1.5 rounded-full">
                    <i class="fas fa-times-circle"></i> CV / Resume belum diupload
                </span>
                @else
                <span class="flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 border border-green-200 px-3 py-1.5 rounded-full">
                    <i class="fas fa-check-circle"></i> CV sudah ada
                </span>
                @endif
                @if(!$profile->surat_pengantar_path)
                <span class="flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 border border-red-200 px-3 py-1.5 rounded-full">
                    <i class="fas fa-times-circle"></i> Surat Pengantar belum diupload
                </span>
                @else
                <span class="flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 border border-green-200 px-3 py-1.5 rounded-full">
                    <i class="fas fa-check-circle"></i> Surat Pengantar sudah ada
                </span>
                @endif
            </div>
            <p class="text-amber-600 text-xs mt-2">👇 Upload di bagian <strong>Upload Dokumen</strong> di bawah ini, lalu simpan.</p>
        </div>
    </div>
</div>
@else
<div class="mb-5 bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-3">
    <div class="text-2xl">✅</div>
    <div>
        <p class="font-bold text-green-800 text-sm">Dokumen lengkap! Kamu siap melamar pekerjaan.</p>
        <p class="text-green-600 text-xs mt-0.5">CV dan Surat Pengantar sudah tersimpan.</p>
    </div>
</div>
@endif

<form id="hapus-foto-form" method="POST" action="{{ route('pelamar.profil.foto.hapus') }}" class="hidden">
    @csrf
    @method('DELETE')
</form>

<form method="POST" action="{{ route('pelamar.profil.update') }}" enctype="multipart/form-data">
@csrf
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Kolom Kiri --}}
    <div class="space-y-5">

        {{-- Foto --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-camera text-green-500"></i> Foto Profil
            </h3>
            <div class="text-center mb-4">
                @if($profile->photo)
                    <img src="{{ asset('storage/'.$profile->photo) }}"
                         class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-green-100 mb-2">
                @else
                    <div class="w-20 h-20 rounded-full mx-auto bg-green-100 flex items-center justify-center text-3xl font-bold text-green-600 mb-2">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <input type="file" name="photo" accept="image/*"
                   class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            <p class="text-xs text-gray-400 mt-1">JPG, PNG. Maks 2MB</p>
            @if($profile->photo)
            <button type="submit" form="hapus-foto-form" onclick="return confirm('Hapus foto profil?')"
                class="mt-2 text-xs text-red-500 hover:text-red-700 font-semibold inline-flex items-center gap-1">
                <i class="fas fa-trash-alt"></i> Hapus Foto
            </button>
            @endif
        </div>

        {{-- Upload Dokumen --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-file-upload text-green-500"></i> Upload Dokumen
                <span class="text-red-500 text-xs font-bold">*Wajib</span>
            </h3>
            <div class="space-y-4">

                {{-- CV --}}
                <div class="p-3 rounded-xl border-2 {{ $profile->cv_path ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        CV / Resume <span class="text-red-500">*</span>
                    </label>
                    @if($profile->cv_path)
                        <a href="{{ asset('storage/'.$profile->cv_path) }}" target="_blank"
                           class="inline-flex items-center gap-1 text-xs text-green-600 font-semibold mb-2 hover:underline">
                            <i class="fas fa-check-circle"></i> CV tersimpan — Lihat file
                        </a>
                        <br>
                    @else
                        <p class="text-xs text-red-500 font-medium mb-2">⚠️ Belum ada CV — Upload sekarang!</p>
                    @endif
                    <input type="file" name="cv" accept=".pdf,.doc,.docx"
                           class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white file:text-green-700 hover:file:bg-green-50">
                    <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX. Maks 10MB</p>
                </div>

                {{-- Surat Pengantar --}}
                <div class="p-3 rounded-xl border-2 {{ $profile->surat_pengantar_path ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Surat Pengantar <span class="text-red-500">*</span>
                    </label>
                    @if($profile->surat_pengantar_path)
                        <a href="{{ asset('storage/'.$profile->surat_pengantar_path) }}" target="_blank"
                           class="inline-flex items-center gap-1 text-xs text-green-600 font-semibold mb-2 hover:underline">
                            <i class="fas fa-check-circle"></i> Surat tersimpan — Lihat file
                        </a>
                        <br>
                    @else
                        <p class="text-xs text-red-500 font-medium mb-2">⚠️ Belum ada surat pengantar — Upload sekarang!</p>
                    @endif
                    <input type="file" name="surat_pengantar" accept=".pdf,.doc,.docx"
                           class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-white file:text-green-700 hover:file:bg-green-50">
                    <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX. Maks 10MB</p>
                </div>
            </div>
        </div>

        {{-- Ganti Password --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-lock text-red-400"></i> Ganti Password
            </h3>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Password Baru</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ganti"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Data Diri --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-user text-green-500"></i> Data Diri
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Posisi yang Diinginkan</label>
                    <input type="text" name="desired_position" value="{{ $profile->desired_position }}"
                           placeholder="misal: Backend Developer"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP / WA</label>
                    <input type="text" name="phone" value="{{ $profile->phone }}" placeholder="08xx..."
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Domisili</label>
                    <select name="domicile" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                        <option value="">-- Pilih Kota --</option>
                        @foreach(['Denpasar','Badung','Gianyar','Tabanan','Buleleng','Klungkung','Karangasem','Jembrana','Bangli'] as $kota)
                            <option value="{{ $kota }}" {{ $profile->domicile === $kota ? 'selected' : '' }}>{{ $kota }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                    <select name="education_level" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                        @foreach(['SMA/SMK','D3','S1','S2','S3'] as $edu)
                            <option value="{{ $edu }}" {{ $profile->education_level === $edu ? 'selected' : '' }}>{{ $edu }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="gender" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                        <option value="">-- Pilih --</option>
                        <option value="male"   {{ $profile->gender === 'male'   ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ $profile->gender === 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ $profile->birth_date }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Portofolio</label>
                    <input type="url" name="portfolio_url" value="{{ $profile->portfolio_url }}"
                           placeholder="https://portfolio.com"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
            </div>
        </div>

        {{-- Tentang & Keahlian --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-star text-yellow-400"></i> Tentang & Keahlian
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tentang Saya</label>
                    <textarea name="about" rows="3"
                        placeholder="Ceritakan tentang dirimu, pengalaman, dan tujuan karir..."
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none resize-none">{{ $profile->about }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keahlian (pisahkan dengan koma)</label>
                    <input type="text" name="skills" value="{{ $profile->skills }}"
                           placeholder="PHP, Laravel, JavaScript, MySQL..."
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman Kerja</label>
                    <textarea name="work_experience" rows="4"
                        placeholder="Ceritakan pengalaman kerja kamu (perusahaan, posisi, durasi)..."
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none resize-none">{{ $profile->work_experience }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-green-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-green-700 transition flex items-center gap-2 shadow-sm">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>
</form>
@endsection
