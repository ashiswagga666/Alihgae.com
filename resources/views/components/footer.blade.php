<footer class="bg-gray-900 text-white pt-6 pb-0">
    <div class="container mx-auto px-6">
        <div class="flex flex-wrap justify-between gap-4 pb-4">
            <div class="max-w-xs">
                <img src="{{ asset($siteSettings['logo_path'] ?? 'images/logo3.png') }}" alt="{{ $siteSettings['site_name'] ?? 'Alihgae' }}" class="h-10 w-auto brightness-0 invert mb-2">
                <p class="text-gray-400 text-xs">{{ $siteSettings['site_tagline'] ?? 'Platform karir terpercaya di Bali.' }}</p>
                <p class="text-gray-500 text-xs mt-1"><i class="fas fa-phone mr-1"></i>{{ $siteSettings['contact_phone'] ?? '0361-123456' }}</p>
                <p class="text-gray-500 text-xs mt-1"><i class="fas fa-envelope mr-1"></i>{{ $siteSettings['contact_email'] ?? 'info@alihgae.com' }}</p>
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-xs uppercase tracking-wide text-gray-300">Menu</h4>
                <ul class="space-y-1 text-gray-400 text-xs">
                    <li><a href="{{ route('beranda') }}" class="hover:text-teal-400 transition">Beranda</a></li>
                    <li><a href="{{ route('lowongan') }}" class="hover:text-teal-400 transition">Lowongan Kerja</a></li>
                    <li><a href="{{ route('perusahaan') }}" class="hover:text-teal-400 transition">Perusahaan</a></li>
                    <li><a href="{{ route('berita.index') }}" class="hover:text-teal-400 transition">Berita & Tips Karir</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-xs uppercase tracking-wide text-gray-300">Akun</h4>
                <ul class="space-y-1 text-gray-400 text-xs">
                    <li><a href="{{ route('register') }}" class="hover:text-teal-400 transition">Daftar Pencari Kerja</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-teal-400 transition">Login</a></li>
                    @auth
                    @if(Auth::user()->role === 'perusahaan')
                    <li><a href="{{ route('perusahaan.lowongan.create') }}" class="hover:text-teal-400 transition">Pasang Lowongan</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2 text-xs uppercase tracking-wide text-gray-300">Ikuti Kami</h4>
                <div class="flex space-x-3 text-gray-400 text-lg">
                    <a href="#" class="hover:text-teal-400 transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-teal-400 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-teal-400 transition"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="hover:text-teal-400 transition"><i class="fab fa-twitter"></i></a>
                </div>
                <p class="text-gray-500 text-xs mt-3"><i class="fas fa-map-marker-alt mr-1"></i>{{ $siteSettings['contact_address'] ?? 'Denpasar, Bali' }}</p>
            </div>
        </div>
        <div class="border-t border-gray-800 py-3 text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} {{ $siteSettings['site_name'] ?? 'Alihgae.com' }}. All rights reserved.
        </div>
    </div>
    {{-- Running text lowongan dari database --}}
    <div class="bg-teal-700 overflow-hidden py-1.5">
        <div class="running-text inline-flex whitespace-nowrap" id="runningText">
            <span class="flex" id="runnerContent">
                @php
                    try {
                        $runningJobs = \App\Models\JobListing::with('company')
                            ->where('is_active', true)
                            ->where('deadline', '>=', date('Y-m-d'))
                            ->latest()->take(10)->get();
                    } catch(\Exception $e) { $runningJobs = collect(); }
                @endphp
                @if($runningJobs->count())
                    @foreach($runningJobs as $rj)
                        <span class="px-8 text-white text-xs">💼 {{ $rj->title }} — {{ $rj->company->company_name ?? '' }} — {{ $rj->location }}</span>
                    @endforeach
                @else
                    <span class="px-8 text-white text-xs">💼 Banyak lowongan tersedia — Daftar sekarang!</span>
                @endif
            </span>
        </div>
    </div>
</footer>

@push('styles')
<style>
    .running-text { animation: marquee 30s linear infinite; }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
</style>
@endpush

@push('scripts')
<script>
    // Duplikasi konten agar marquee mulus
    const runner = document.getElementById('runnerContent');
    if (runner) {
        runner.parentNode.appendChild(runner.cloneNode(true));
    }
</script>
@endpush
