@if($errors->any())
<div class="mb-4 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm">
    <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Posisi <span class="text-red-500">*</span></label>
        <input type="text" name="title" value="{{ old('title', $lowongan->title ?? '') }}" required placeholder="misal: Backend Developer Laravel" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
            <select name="location" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="">-- Pilih Kota --</option>
                @foreach(['Denpasar','Badung','Kuta, Badung','Seminyak, Badung','Canggu, Badung','Gianyar','Ubud, Gianyar','Tabanan','Buleleng','Singaraja, Buleleng','Klungkung','Karangasem','Jembrana','Bangli','Remote'] as $kota)
                    <option value="{{ $kota }}" {{ old('location', $lowongan->location ?? '') === $kota ? 'selected' : '' }}>{{ $kota }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Pekerjaan <span class="text-red-500">*</span></label>
            <select name="job_type" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                @foreach(['full-time' => 'Full-time','part-time' => 'Part-time','freelance' => 'Freelance','internship' => 'Magang'] as $val => $label)
                    <option value="{{ $val }}" {{ old('job_type', $lowongan->job_type ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gaji Minimum (Rp)</label>
            <input type="number" name="salary_min" value="{{ old('salary_min', $lowongan->salary_min ?? '') }}" placeholder="3000000" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gaji Maksimum (Rp)</label>
            <input type="number" name="salary_max" value="{{ old('salary_max', $lowongan->salary_max ?? '') }}" placeholder="8000000" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Minimum <span class="text-red-500">*</span></label>
            <select name="min_education" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                @foreach(['SMA/SMK','D3','S1','S2','S3'] as $edu)
                    <option value="{{ $edu }}" {{ old('min_education', $lowongan->min_education ?? '') === $edu ? 'selected' : '' }}>{{ $edu }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pengalaman Minimum (tahun) <span class="text-red-500">*</span></label>
            <input type="number" name="min_experience" value="{{ old('min_experience', $lowongan->min_experience ?? 0) }}" min="0" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deadline Lamaran <span class="text-red-500">*</span></label>
        <input type="date" name="deadline" value="{{ old('deadline', isset($lowongan) ? $lowongan->deadline?->format('Y-m-d') : '') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
        <textarea name="description" rows="5" required placeholder="Jelaskan tugas dan tanggung jawab posisi ini..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('description', $lowongan->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Persyaratan</label>
        <textarea name="requirements" rows="4" placeholder="Skill, pengalaman, dan kualifikasi yang dibutuhkan..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ old('requirements', $lowongan->requirements ?? '') }}</textarea>
    </div>
</div>
