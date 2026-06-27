<footer class="bg-gray-900 text-white pt-6 pb-0">
    <div class="container mx-auto px-6">
        <div class="flex flex-wrap justify-between gap-6 pb-6">

            {{-- Brand --}}
            <div class="max-w-xs">
                <img src="{{ asset($siteSettings['logo_path'] ?? 'images/logo3.png') }}"
                     alt="{{ $siteSettings['site_name'] ?? 'Alihgae' }}"
                     class="h-10 w-auto brightness-0 invert mb-3">
                <p class="text-gray-400 text-xs leading-relaxed">
                    {{ $siteSettings['site_tagline'] ?? 'Platform karir terpercaya di Bali.' }}
                </p>
                <div class="mt-3 space-y-1">
                    @if($siteSettings['contact_phone'] ?? null)
                    <p class="text-gray-500 text-xs"><i class="fas fa-phone mr-2 text-green-500"></i>{{ $siteSettings['contact_phone'] }}</p>
                    @endif
                    @if($siteSettings['contact_email'] ?? null)
                    <p class="text-gray-500 text-xs"><i class="fas fa-envelope mr-2 text-green-500"></i>{{ $siteSettings['contact_email'] }}</p>
                    @endif
                    @if($siteSettings['contact_address'] ?? null)
                    <p class="text-gray-500 text-xs"><i class="fas fa-map-marker-alt mr-2 text-green-500"></i>{{ $siteSettings['contact_address'] }}</p>
                    @endif
                </div>
            </div>

            {{-- Menu --}}
            <div>
                <h4 class="font-semibold mb-3 text-xs uppercase tracking-widest text-gray-300">Menu</h4>
                <ul class="space-y-2 text-gray-400 text-xs">
                    <li><a href="{{ route('beranda') }}" class="hover:text-green-400 transition">Beranda</a></li>
                    <li><a href="{{ route('lowongan') }}" class="hover:text-green-400 transition">Lowongan Kerja</a></li>
                    <li><a href="{{ route('perusahaan') }}" class="hover:text-green-400 transition">Perusahaan</a></li>
                    <li><a href="{{ route('berita.index') }}" class="hover:text-green-400 transition">Berita & Tips Karir</a></li>
                </ul>
            </div>

            {{-- Akun --}}
            <div>
                <h4 class="font-semibold mb-3 text-xs uppercase tracking-widest text-gray-300">Akun</h4>
                <ul class="space-y-2 text-gray-400 text-xs">
                    <li><a href="{{ route('register') }}" class="hover:text-green-400 transition">Daftar Pencari Kerja</a></li>
                    <li><a href="{{ route('register') }}?role=perusahaan" class="hover:text-green-400 transition">Daftar sebagai Perusahaan</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-green-400 transition">Login</a></li>
                    @auth
                    @if(Auth::user()->role === 'perusahaan')
                    <li><a href="{{ route('perusahaan.lowongan.create') }}" class="hover:text-green-400 transition">Pasang Lowongan</a></li>
                    @endif
                    @endauth
                </ul>
            </div>

            {{-- Sosmed --}}
            <div>
                <h4 class="font-semibold mb-3 text-xs uppercase tracking-widest text-gray-300">Ikuti Kami</h4>
                <div class="flex space-x-3 text-gray-400 text-xl mb-4">
                    <a href="#" class="hover:text-green-400 transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-green-400 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-green-400 transition"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="hover:text-green-400 transition"><i class="fab fa-twitter"></i></a>
                </div>
                @if(Auth::check() && Auth::user()->role === 'perusahaan')
                <a href="{{ route('perusahaan.berita.request') }}"
                   class="text-xs bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition">
                    📰 Pasang Berita Sponsor
                </a>
                @endif
            </div>
        </div>

        <div class="border-t border-gray-800 py-4 text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Alihgae.com' }}. Hak cipta dilindungi.
        </div>
    </div>

    {{-- Running text --}}
    <style>
        .alihgae-marquee-wrap { overflow: hidden; }
        .alihgae-marquee-track {
            display: inline-flex !important;
            white-space: nowrap !important;
            animation-name: alihgae-marquee-anim !important;
            animation-duration: 20s !important;
            animation-timing-function: linear !important;
            animation-iteration-count: infinite !important;
            will-change: transform;
        }
        @keyframes alihgae-marquee-anim {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
    </style>
    <div class="bg-green-700 alihgae-marquee-wrap py-2">
        <div class="alihgae-marquee-track" id="runner">
            @php
                try {
                    $rb = \App\Models\Berita::where('status', 'published')
                        ->latest('published_at')->take(12)->get();
                } catch(\Exception $e) { $rb = collect(); }
            @endphp
            @if($rb->count())
                @foreach($rb as $b)
                    <span class="px-8 text-white text-xs">📰 {{ $b->judul }}</span>
                @endforeach
                @foreach($rb as $b)
                    <span class="px-8 text-white text-xs">📰 {{ $b->judul }}</span>
                @endforeach
            @else
                <span class="px-8 text-white text-xs">📰 Belum ada berita terbaru — pantau terus Alihgae.com!</span>
            @endif
        </div>
    </div>
</footer>