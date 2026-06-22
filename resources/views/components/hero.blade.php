{{-- Hero Section --}}
<section class="relative bg-gradient-to-br from-emerald-800 via-green-700 to-emerald-900 overflow-hidden py-20 px-4">

    <div class="absolute top-10 left-10 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-20 w-48 h-48 bg-white/5 rounded-full blur-2xl"></div>

    <div class="relative max-w-3xl mx-auto text-center">

        <p class="inline-block text-xs font-semibold text-emerald-200 tracking-widest uppercase mb-5">
            ✦ {{ $totalJobs ?? ($siteSettings['hero_badge_count'] ?? '13') }}+ Lowongan Aktif Sekarang
        </p>

        <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-3">
            {{ $siteSettings['hero_title'] ?? 'Temukan Karir Impianmu' }}
        </h1>
        <p class="text-3xl md:text-4xl font-extrabold text-emerald-300 mb-6">
            {{ $siteSettings['hero_subtitle'] ?? 'di Bali' }}
        </p>

        <p class="text-emerald-100 text-sm md:text-base mb-10 max-w-xl mx-auto">
            {{ $siteSettings['site_description'] ?? 'Ribuan lowongan kerja dari perusahaan terbaik menanti Anda. Bergabunglah dengan jutaan pencari kerja yang sudah menemukan pekerjaan impian mereka.' }}
        </p>

        <form action="{{ route('lowongan') }}" method="GET"
            class="flex flex-col sm:flex-row gap-2 bg-white rounded-2xl p-2 shadow-xl max-w-2xl mx-auto mb-6">

            <div class="flex items-center gap-2 flex-1 px-3">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Posisi, perusahaan, atau kata kunci..."
                    class="w-full py-2 text-sm text-gray-800 outline-none placeholder-gray-400">
            </div>

            <div class="hidden sm:block w-px bg-gray-200 my-2"></div>

            <div class="flex items-center gap-2 w-full sm:w-40 px-3">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                    <circle cx="12" cy="9" r="2.5" stroke-width="2"/>
                </svg>
                <input type="text" name="location" value="{{ request('location') }}"
                    placeholder="Kota..."
                    class="w-full py-2 text-sm text-gray-800 outline-none placeholder-gray-400">
            </div>

            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-bold px-6 py-3 rounded-xl transition-all text-sm whitespace-nowrap shadow-md">
                Cari Lowongan
            </button>

        </form>

        <div class="flex items-center justify-center gap-2 flex-wrap text-sm">
            <span class="text-emerald-200">🔥 Trending:</span>
            @php $trending = ['Software Engineer', 'Marketing', 'Finance', 'UI/UX Design']; @endphp
            @foreach($trending as $keyword)
                <a href="{{ route('lowongan', ['search' => $keyword]) }}"
                   class="text-white hover:text-orange-300 underline underline-offset-2 transition-colors">
                    {{ $keyword }}
                </a>
                @if(!$loop->last)<span class="text-emerald-600">·</span>@endif
            @endforeach
        </div>

    </div>
</section>

{{-- Stats Bar --}}
<section class="bg-white py-8 px-4 shadow-sm">
    <div class="max-w-4xl mx-auto grid grid-cols-3 gap-4 text-center">
        <div class="p-4">
            <p class="text-2xl font-extrabold text-gray-900">{{ $totalJobs ?? '13' }}+</p>
            <p class="text-xs text-gray-500 mt-1">🏢 Lowongan</p>
            <p class="text-xs text-emerald-600 font-medium">Aktif sekarang</p>
        </div>
        <div class="border-l border-r border-gray-100 p-4">
            <p class="text-2xl font-extrabold text-gray-900">{{ $totalCompanies ?? '8' }}+</p>
            <p class="text-xs text-gray-500 mt-1">🏗 Perusahaan</p>
            <p class="text-xs text-emerald-600 font-medium">Terverifikasi</p>
        </div>
        <div class="p-4">
            <p class="text-2xl font-extrabold text-gray-900">{{ $totalApplicants ?? '0' }}+</p>
            <p class="text-xs text-gray-500 mt-1">👥 Pencari</p>
            <p class="text-xs text-emerald-600 font-medium">Sudah daftar</p>
        </div>
    </div>
</section>