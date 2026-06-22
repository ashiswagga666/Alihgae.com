# 🚀 Alihgae.com — Panduan Instalasi

## Fitur Baru yang Ditambahkan

### 👤 Dashboard Pelamar
- Edit profil (nama, foto, domisili, pendidikan, keahlian, tentang saya)
- Upload CV, Surat Pengantar langsung dari profil
- Lamar lowongan dengan upload CV + Surat Pengantar + Portofolio per lamaran
- Riwayat lamaran dengan status realtime (Menunggu/Diterima/Ditolak)
- Rekomendasi lowongan terbaru

### 🏢 Dashboard Perusahaan
- CRUD Lowongan (buat, edit, hapus, aktif/nonaktif)
- Edit profil perusahaan lengkap (logo, industri, deskripsi, kota Bali, dll)
- Review pelamar per lowongan + download CV/surat/portofolio
- Update status lamaran (Diterima/Ditolak)
- Request berita sponsor (Rp 500.000/artikel)

### 📰 Sistem Berita
- Admin CRUD berita + kelola request sponsor dari perusahaan
- Perusahaan bisa request berita tentang perusahaan mereka
- Tampilan berita publik menarik dengan kategori & filter

### ⚙️ Admin Settings (non-Filament)
- Edit judul hero, tagline, deskripsi situs
- Upload logo situs
- Edit kontak (email, telepon, alamat)
- Kelola berita & approve request sponsor
- Dashboard statistik

### 🗄️ Data Seeder Bali
- 7 perusahaan nyata (IT, Hotel, Retail, Keuangan, Kesehatan, Properti, Startup)
- 25+ lowongan dari Denpasar, Badung, Gianyar, Remote
- 5 berita tips karir
- Admin + 2 contoh user

---

## Instalasi

### 1. Extract & Setup
```bash
cd laravel-fixed
cp .env.example .env
```

### 2. Edit .env (database)
```env
DB_DATABASE=alihgae
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://localhost:8000
```

### 3. Install & Migrate
```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
```

### 4. Jalankan
```bash
php artisan serve
```

---

## Akun Login

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@alihgae.com | password |
| Perusahaan 1 | hrd@balidigital.com | password |
| Perusahaan 2 | hr@balipremiumresort.com | password |
| Perusahaan 3 | hr@krisnagroup.com | password |
| Perusahaan 4 | hr@balikoperasi.com | password |
| Perusahaan 5 | hr@rsubali.com | password |
| Perusahaan 6 | hr@balirealestate.com | password |
| Perusahaan 7 | hr@nyalabali.com | password |
| Pelamar | made@email.com | password |

---

## URL Penting

| Halaman | URL |
|---------|-----|
| Beranda | / |
| Lowongan | /lowongan |
| Perusahaan | /perusahaan |
| Berita | /berita |
| Login | /login |
| Dashboard Pelamar | /pelamar/dashboard |
| Dashboard Perusahaan | /dashboard/perusahaan |
| Admin Non-Filament | /admin-panel/dashboard |
| Admin Filament | /admin |

---

## Catatan Penting

**Upload file** butuh `storage:link` agar bisa jalan:
```bash
php artisan storage:link
```

**Jika ada error permission:**
```bash
chmod -R 775 storage bootstrap/cache
```

**Reset ulang data:**
```bash
php artisan migrate:fresh --seed
```
