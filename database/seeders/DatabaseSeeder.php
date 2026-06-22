<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\JobSeekerProfile;
use App\Models\Berita;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN
        $admin = User::create([
            'name' => 'Admin Alihgae',
            'email' => 'admin@alihgae.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // ── SITE SETTINGS
        $settings = [
            'site_name' => 'Alihgae.com',
            'site_tagline' => 'Platform Karir Terbaik di Bali',
            'site_description' => 'Temukan ribuan lowongan kerja terbaik di Bali. Alihgae menghubungkan pencari kerja dengan perusahaan terpercaya di Denpasar, Badung, Gianyar, dan seluruh Bali.',
            'contact_email' => 'info@alihgae.com',
            'contact_phone' => '0361-123456',
            'contact_address' => 'Jl. Teuku Umar No. 100, Denpasar, Bali',
            'hero_title' => 'Temukan Karir Impianmu di Bali',
            'hero_subtitle' => 'Ribuan lowongan dari perusahaan terpercaya menanti kamu',
            'harga_sponsor_berita' => '500000',
            'logo_path' => 'images/logo3.png',
        ];
        foreach ($settings as $k => $v) SiteSetting::create(['key' => $k, 'value' => $v]);

        // ── PERUSAHAAN DATA
        $companies_data = [
            [
                'user' => ['name' => 'HRD Bali Digital', 'email' => 'hrd@balidigital.com'],
                'company' => [
                    'company_name' => 'PT Bali Digital Kreatif',
                    'industry' => 'Teknologi Informasi',
                    'description' => 'Perusahaan teknologi terdepan di Bali yang berfokus pada solusi digital untuk bisnis lokal dan internasional. Kami telah membantu 200+ klien bertransformasi digital.',
                    'city' => 'Denpasar',
                    'address' => 'Jl. Teuku Umar No. 15, Denpasar Barat',
                    'phone' => '0361-225566',
                    'email' => 'info@balidigital.com',
                    'website' => 'https://balidigital.com',
                    'employee_count' => '50-100',
                    'founded_year' => 2018,
                    'is_verified' => true,
                ],
                'jobs' => [
                    ['title' => 'Frontend Developer React', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 6000000, 'max' => 12000000, 'edu' => 'S1', 'exp' => 2, 'desc' => 'Kami mencari Frontend Developer berpengalaman dengan React.js untuk membangun aplikasi web modern yang interaktif.', 'req' => 'React.js, TypeScript, Tailwind CSS, Git, min 2 tahun pengalaman'],
                    ['title' => 'Backend Developer Laravel', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 7000000, 'max' => 14000000, 'edu' => 'S1', 'exp' => 2, 'desc' => 'Backend developer untuk membangun API dan sistem backend yang scalable menggunakan Laravel.', 'req' => 'PHP, Laravel, MySQL, Redis, REST API'],
                    ['title' => 'UI/UX Designer', 'location' => 'Remote', 'type' => 'full-time', 'min' => 5000000, 'max' => 9000000, 'edu' => 'D3', 'exp' => 1, 'desc' => 'Designer kreatif yang mampu merancang pengalaman pengguna yang intuitif dan menarik.', 'req' => 'Figma, Adobe XD, Prototyping, User Research'],
                    ['title' => 'Digital Marketing Specialist', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 4500000, 'max' => 8000000, 'edu' => 'S1', 'exp' => 1, 'desc' => 'Kelola strategi pemasaran digital untuk klien kami meliputi SEO, SEM, dan Social Media.', 'req' => 'SEO, Google Ads, Meta Ads, Content Marketing, Analytics'],
                    ['title' => 'Mobile Developer Flutter', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 7000000, 'max' => 13000000, 'edu' => 'S1', 'exp' => 2, 'desc' => 'Kembangkan aplikasi mobile cross-platform untuk klien kami menggunakan Flutter/Dart.', 'req' => 'Flutter, Dart, Firebase, REST API integration'],
                ],
            ],
            [
                'user' => ['name' => 'HRD Bali Resort', 'email' => 'hr@balipremiumresort.com'],
                'company' => [
                    'company_name' => 'Bali Premium Resort & Spa',
                    'industry' => 'Pariwisata & Perhotelan',
                    'description' => 'Resort bintang lima di jantung Ubud dengan 150 vila mewah. Kami berkomitmen memberikan pengalaman tak terlupakan kepada tamu dari seluruh dunia.',
                    'city' => 'Gianyar',
                    'address' => 'Jl. Raya Ubud No. 88, Gianyar, Bali',
                    'phone' => '0361-971234',
                    'email' => 'hr@balipremiumresort.com',
                    'website' => 'https://balipremiumresort.com',
                    'employee_count' => '200-500',
                    'founded_year' => 2010,
                    'is_verified' => true,
                ],
                'jobs' => [
                    ['title' => 'Front Office Manager', 'location' => 'Gianyar', 'type' => 'full-time', 'min' => 8000000, 'max' => 15000000, 'edu' => 'S1', 'exp' => 3, 'desc' => 'Mengelola operasional front office resort bintang lima dan memastikan kepuasan tamu tertinggi.', 'req' => 'Hospitality management, Bahasa Inggris fasih, Opera PMS, min 3 tahun'],
                    ['title' => 'Chef de Partie', 'location' => 'Gianyar', 'type' => 'full-time', 'min' => 6000000, 'max' => 10000000, 'edu' => 'D3', 'exp' => 2, 'desc' => 'Chef berpengalaman untuk mengelola seksi dapur dan mempersiapkan menu premium.', 'req' => 'Culinary arts, Fine dining experience, Team management'],
                    ['title' => 'Spa Therapist', 'location' => 'Gianyar', 'type' => 'full-time', 'min' => 4000000, 'max' => 7000000, 'edu' => 'SMA/SMK', 'exp' => 1, 'desc' => 'Terapis spa profesional untuk memberikan layanan perawatan tubuh dan relaksasi premium.', 'req' => 'Sertifikat spa, Bahasa Inggris dasar, Customer service'],
                    ['title' => 'Butler Service', 'location' => 'Gianyar', 'type' => 'full-time', 'min' => 4500000, 'max' => 7000000, 'edu' => 'D3', 'exp' => 1, 'desc' => 'Pelayan pribadi tamu villa untuk memberikan layanan personal yang eksklusif.', 'req' => 'Hospitality, Bahasa Inggris, Personal service skills'],
                ],
            ],
            [
                'user' => ['name' => 'HRD Krisna Group', 'email' => 'hr@krisnagroup.com'],
                'company' => [
                    'company_name' => 'Krisna Group Bali',
                    'industry' => 'Retail & Oleh-oleh',
                    'description' => 'Jaringan toko oleh-oleh terbesar di Bali dengan 12 cabang tersebar di seluruh Bali. Melayani jutaan wisatawan domestik dan mancanegara setiap tahunnya.',
                    'city' => 'Badung',
                    'address' => 'Jl. Nusa Kambangan No. 160, Denpasar',
                    'phone' => '0361-551111',
                    'email' => 'info@krisnagroup.com',
                    'website' => 'https://krisnagroup.com',
                    'employee_count' => '500-1000',
                    'founded_year' => 2005,
                    'is_verified' => true,
                ],
                'jobs' => [
                    ['title' => 'Store Manager', 'location' => 'Badung', 'type' => 'full-time', 'min' => 7000000, 'max' => 12000000, 'edu' => 'S1', 'exp' => 3, 'desc' => 'Kelola operasional toko oleh-oleh dengan omzet miliaran per bulan di lokasi strategis Bali.', 'req' => 'Retail management, Leadership, Inventory management, min 3 tahun'],
                    ['title' => 'Kasir & Customer Service', 'location' => 'Kuta, Badung', 'type' => 'full-time', 'min' => 3000000, 'max' => 4500000, 'edu' => 'SMA/SMK', 'exp' => 0, 'desc' => 'Melayani transaksi pembayaran dan memberikan informasi produk kepada pelanggan.', 'req' => 'Komunikatif, Ramah, Jujur, Bisa bahasa Inggris dasar'],
                    ['title' => 'Supervisor Produksi', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 5000000, 'max' => 8000000, 'edu' => 'D3', 'exp' => 2, 'desc' => 'Mengawasi proses produksi kerajinan dan oleh-oleh khas Bali sesuai standar kualitas.', 'req' => 'Production management, Quality control, Team leadership'],
                    ['title' => 'Marketing & Promosi', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 4000000, 'max' => 7000000, 'edu' => 'S1', 'exp' => 1, 'desc' => 'Kembangkan strategi marketing untuk meningkatkan penjualan produk Krisna Group.', 'req' => 'Marketing, Social Media, Event organizing, Kreatif'],
                ],
            ],
            [
                'user' => ['name' => 'HRD Bali Finance', 'email' => 'hr@balikoperasi.com'],
                'company' => [
                    'company_name' => 'Koperasi Simpan Pinjam Bali Sejahtera',
                    'industry' => 'Keuangan & Perbankan',
                    'description' => 'Koperasi terpercaya yang melayani anggota di seluruh Bali dengan produk simpan pinjam, kredit usaha mikro, dan layanan keuangan syariah.',
                    'city' => 'Denpasar',
                    'address' => 'Jl. Diponegoro No. 45, Denpasar',
                    'phone' => '0361-241234',
                    'email' => 'info@balikoperasi.com',
                    'website' => 'https://balikoperasi.com',
                    'employee_count' => '100-200',
                    'founded_year' => 2000,
                    'is_verified' => true,
                ],
                'jobs' => [
                    ['title' => 'Account Officer Kredit', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 4500000, 'max' => 8000000, 'edu' => 'S1', 'exp' => 1, 'desc' => 'Analisa kelayakan kredit dan melakukan kunjungan nasabah untuk produk pinjaman usaha mikro.', 'req' => 'Akuntansi/Ekonomi, Analisa kredit, Kendaraan pribadi'],
                    ['title' => 'Teller & Customer Service', 'location' => 'Badung', 'type' => 'full-time', 'min' => 3200000, 'max' => 4500000, 'edu' => 'D3', 'exp' => 0, 'desc' => 'Layani transaksi simpan pinjam anggota koperasi dengan ramah dan profesional.', 'req' => 'Teliti, Ramah, Komputer dasar, Jujur'],
                    ['title' => 'Kepala Cabang Gianyar', 'location' => 'Gianyar', 'type' => 'full-time', 'min' => 10000000, 'max' => 18000000, 'edu' => 'S1', 'exp' => 5, 'desc' => 'Memimpin operasional cabang Gianyar dan mengembangkan portofolio kredit di wilayah tersebut.', 'req' => 'Leadership, Perbankan/Keuangan, min 5 tahun pengalaman'],
                ],
            ],
            [
                'user' => ['name' => 'HRD Bali Health', 'email' => 'hr@rsubali.com'],
                'company' => [
                    'company_name' => 'RS Umum Bali Medika',
                    'industry' => 'Kesehatan',
                    'description' => 'Rumah sakit swasta tipe B dengan fasilitas lengkap dan dokter spesialis berpengalaman. Melayani pasien umum, BPJS, dan asuransi internasional.',
                    'city' => 'Denpasar',
                    'address' => 'Jl. Gatot Subroto No. 200, Denpasar',
                    'phone' => '0361-228800',
                    'email' => 'info@rsubali.com',
                    'website' => 'https://rsubali.com',
                    'employee_count' => '300-500',
                    'founded_year' => 2008,
                    'is_verified' => true,
                ],
                'jobs' => [
                    ['title' => 'Perawat IGD', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 4000000, 'max' => 6500000, 'edu' => 'D3', 'exp' => 1, 'desc' => 'Perawat IGD untuk penanganan gawat darurat 24 jam di RS Umum Bali Medika.', 'req' => 'STR Perawat aktif, BTCLS, min D3 Keperawatan'],
                    ['title' => 'Apoteker', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 5000000, 'max' => 8000000, 'edu' => 'S1', 'exp' => 1, 'desc' => 'Apoteker untuk mengelola apotek rumah sakit dan memastikan pelayanan farmasi optimal.', 'req' => 'Apoteker (S.Farm, Apt), STRA aktif, Teliti'],
                    ['title' => 'Rekam Medis', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 3500000, 'max' => 5000000, 'edu' => 'D3', 'exp' => 0, 'desc' => 'Mengelola rekam medis pasien secara digital dan memastikan keakuratan data klinis.', 'req' => 'D3 Rekam Medis, Komputer, Teliti'],
                ],
            ],
            [
                'user' => ['name' => 'HRD Bali Property', 'email' => 'hr@balirealestate.com'],
                'company' => [
                    'company_name' => 'Bali Real Estate Investama',
                    'industry' => 'Properti & Real Estate',
                    'description' => 'Developer properti premium di Bali yang fokus pada villa, townhouse, dan komersial. Proyek kami tersebar di Seminyak, Canggu, Ubud, dan Sanur.',
                    'city' => 'Badung',
                    'address' => 'Jl. Sunset Road No. 88, Kuta, Badung',
                    'phone' => '0361-762888',
                    'email' => 'info@balirealestate.com',
                    'website' => 'https://balirealestate.com',
                    'employee_count' => '50-100',
                    'founded_year' => 2015,
                    'is_verified' => true,
                ],
                'jobs' => [
                    ['title' => 'Sales Property Agent', 'location' => 'Kuta, Badung', 'type' => 'full-time', 'min' => 5000000, 'max' => 20000000, 'edu' => 'S1', 'exp' => 1, 'desc' => 'Jual properti premium di Bali kepada investor lokal dan internasional dengan komisi kompetitif.', 'req' => 'Sales experience, Bahasa Inggris, Networking, Kendaraan pribadi'],
                    ['title' => 'Arsitek', 'location' => 'Badung', 'type' => 'full-time', 'min' => 8000000, 'max' => 15000000, 'edu' => 'S1', 'exp' => 3, 'desc' => 'Rancang villa dan residensial premium dengan konsep arsitektur Bali modern.', 'req' => 'S1 Arsitektur, AutoCAD, SketchUp, Portfolio kuat'],
                    ['title' => 'Interior Designer', 'location' => 'Badung', 'type' => 'full-time', 'min' => 6000000, 'max' => 11000000, 'edu' => 'S1', 'exp' => 2, 'desc' => 'Desain interior villa mewah dengan konsep tropical Balinese yang modern.', 'req' => 'Interior Design, 3D Rendering, Material knowledge'],
                ],
            ],
            [
                'user' => ['name' => 'HRD Startup Bali', 'email' => 'hr@nyalabali.com'],
                'company' => [
                    'company_name' => 'Nyala Bali Tech Startup',
                    'industry' => 'Startup Teknologi',
                    'description' => 'Startup teknologi dari Bali yang sedang berkembang pesat. Kami membangun platform marketplace untuk UMKM lokal Bali agar bisa berjualan online.',
                    'city' => 'Denpasar',
                    'address' => 'Jl. Hayam Wuruk No. 33, Denpasar',
                    'phone' => '0361-775588',
                    'email' => 'hello@nyalabali.com',
                    'website' => 'https://nyalabali.com',
                    'employee_count' => '10-50',
                    'founded_year' => 2022,
                    'is_verified' => true,
                ],
                'jobs' => [
                    ['title' => 'Full Stack Developer', 'location' => 'Remote', 'type' => 'full-time', 'min' => 8000000, 'max' => 16000000, 'edu' => 'S1', 'exp' => 2, 'desc' => 'Bangun produk digital kami dari frontend hingga backend. Bekerja dengan tim kecil yang dinamis.', 'req' => 'React/Vue, Node.js/Laravel, PostgreSQL, Docker'],
                    ['title' => 'Product Manager', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 10000000, 'max' => 20000000, 'edu' => 'S1', 'exp' => 3, 'desc' => 'Pimpin pengembangan produk marketplace UMKM Bali dari discovery hingga launch.', 'req' => 'Product management, Agile/Scrum, Data analysis, Leadership'],
                    ['title' => 'Content Creator & Copywriter', 'location' => 'Denpasar', 'type' => 'part-time', 'min' => 2500000, 'max' => 5000000, 'edu' => 'D3', 'exp' => 1, 'desc' => 'Buat konten kreatif untuk media sosial dan blog startup kami tentang UMKM Bali.', 'req' => 'Writing, Social media, Photography dasar, Kreatif'],
                    ['title' => 'Community Manager', 'location' => 'Denpasar', 'type' => 'full-time', 'min' => 4000000, 'max' => 7000000, 'edu' => 'S1', 'exp' => 1, 'desc' => 'Kelola komunitas UMKM pengguna platform kami dan tingkatkan engagement.', 'req' => 'Community building, Event organizing, Communication'],
                    ['title' => 'Magang Data Analyst', 'location' => 'Remote', 'type' => 'internship', 'min' => 1000000, 'max' => 2000000, 'edu' => 'SMA/SMK', 'exp' => 0, 'desc' => 'Magang 3 bulan untuk belajar analisa data bisnis dan machine learning dasar.', 'req' => 'Python/R dasar, Excel, Mahasiswa aktif D3/S1'],
                ],
            ],
        ];

        foreach ($companies_data as $data) {
            $user = User::create([
                'name' => $data['user']['name'],
                'email' => $data['user']['email'],
                'password' => Hash::make('password'),
                'role' => 'perusahaan',
            ]);

            $company = Company::create(array_merge($data['company'], ['user_id' => $user->id]));

            foreach ($data['jobs'] as $i => $job) {
                JobListing::create([
                    'company_id' => $company->id,
                    'title' => $job['title'],
                    'description' => $job['desc'],
                    'requirements' => $job['req'],
                    'location' => $job['location'],
                    'job_type' => $job['type'],
                    'salary_min' => $job['min'],
                    'salary_max' => $job['max'],
                    'min_education' => $job['edu'],
                    'min_experience' => $job['exp'],
                    'deadline' => Carbon::now()->addDays(rand(15, 60)),
                    'is_active' => true,
                ]);
            }
        }

        // ── PELAMAR SAMPLE
        $pelamar = User::create([
            'name' => 'Made Wirawan',
            'email' => 'made@email.com',
            'password' => Hash::make('password'),
            'role' => 'pelamar',
        ]);
        JobSeekerProfile::create([
            'user_id' => $pelamar->id,
            'phone' => '081234567890',
            'domicile' => 'Denpasar',
            'education_level' => 'S1',
            'skills' => 'PHP, Laravel, JavaScript, MySQL',
            'about' => 'Fresh graduate S1 Teknik Informatika Universitas Udayana. Passionate di bidang web development.',
            'desired_position' => 'Backend Developer',
            'gender' => 'male',
        ]);

        // ── BERITA SAMPLE
        $berita_data = [
            ['judul' => 'Tips Sukses Melamar Kerja di Era Digital 2024', 'kategori' => 'tips-karir', 'konten' => 'Dunia kerja terus berkembang dengan pesat. Di era digital ini, para pencari kerja perlu memiliki strategi yang tepat untuk bersaing. Pertama, pastikan profil LinkedIn Anda selalu diperbarui dengan pengalaman dan keahlian terkini. Kedua, kuasai minimal satu bahasa pemrograman atau skill digital yang relevan dengan bidang Anda. Ketiga, bangun portofolio online yang menampilkan karya terbaik Anda. Keempat, jangan lupa persiapkan CV yang ATS-friendly agar lolos seleksi otomatis perusahaan besar.'],
            ['judul' => 'Bali Jadi Destinasi Digital Nomad Terbaik Asia 2024', 'kategori' => 'berita', 'konten' => 'Bali kembali dinobatkan sebagai destinasi digital nomad terbaik di Asia versi majalah Forbes 2024. Dengan ekosistem startup yang berkembang pesat, infrastruktur internet yang semakin baik, dan biaya hidup yang relatif terjangkau dibanding kota-kota Asia lainnya, Bali menjadi pilihan utama bagi ribuan pekerja remote dari seluruh dunia.'],
            ['judul' => 'Gaji UMP Bali 2025 Naik 6.5 Persen', 'kategori' => 'berita', 'konten' => 'Pemerintah Provinsi Bali resmi menetapkan Upah Minimum Provinsi (UMP) Bali tahun 2025 sebesar Rp 2.996.561, naik 6.5 persen dari tahun sebelumnya. Kenaikan ini merupakan respons pemerintah terhadap inflasi dan peningkatan biaya hidup di Bali, terutama pasca-pandemi yang mendorong pemulihan ekonomi.'],
            ['judul' => 'Panduan Lengkap Buat CV yang Menarik HRD', 'kategori' => 'tips-karir', 'konten' => 'CV adalah kesan pertama Anda di mata rekruter. Berikut panduan lengkap membuat CV yang akan membuat HRD langsung tertarik: 1) Gunakan format yang bersih dan mudah dibaca. 2) Cantumkan foto profesional dengan latar belakang polos. 3) Tulis ringkasan profil yang kuat di bagian atas. 4) Urutkan pengalaman kerja dari yang terbaru. 5) Sesuaikan CV dengan deskripsi pekerjaan yang dilamar.'],
            ['judul' => '10 Skill Teknologi Paling Dicari Perusahaan Bali 2024', 'kategori' => 'tips-karir', 'konten' => 'Berdasarkan data Alihgae.com, berikut 10 skill teknologi yang paling banyak dicari perusahaan di Bali: 1) React.js & Vue.js untuk frontend, 2) Laravel & Node.js untuk backend, 3) Flutter untuk mobile, 4) Data Analysis & Python, 5) DevOps & Cloud, 6) UI/UX Design dengan Figma, 7) Digital Marketing & SEO, 8) AI & Machine Learning dasar, 9) Cybersecurity, 10) Blockchain development.'],
            ['judul' => 'Bali Digital Kreatif Buka 50 Posisi Baru untuk Talenta Lokal', 'kategori' => 'berita-perusahaan', 'konten' => 'PT Bali Digital Kreatif mengumumkan ekspansi besar-besaran dengan membuka 50 posisi baru untuk tenaga IT lokal Bali. Perusahaan yang telah berdiri sejak 2018 ini berkomitmen untuk memprioritaskan putra-putri daerah yang memiliki kompetensi di bidang teknologi.', 'is_sponsored' => true, 'harga_sponsor' => 500000],
        ];

        foreach ($berita_data as $b) {
            Berita::create([
                'judul' => $b['judul'],
                'slug' => Berita::generateSlug($b['judul']),
                'konten' => $b['konten'],
                'kategori' => $b['kategori'],
                'status' => 'published',
                'author_id' => $admin->id,
                'is_sponsored' => $b['is_sponsored'] ?? false,
                'harga_sponsor' => $b['harga_sponsor'] ?? null,
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
                'views' => rand(50, 500),
            ]);
        }
    }
}
