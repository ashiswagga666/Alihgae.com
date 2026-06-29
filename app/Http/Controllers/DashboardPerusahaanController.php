<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\JobListing;
use App\Models\Lamaran;
use App\Models\Company;
use App\Models\BeritaRequest;

class DashboardPerusahaanController extends Controller
{
    /**
     * getCompany() — Fungsi PRIVAT (helper), hanya bisa dipanggil
     * dari dalam class ini sendiri, TIDAK bisa diakses lewat URL.
     *
     * Konsep "Get or Create": ambil data Company milik user yang
     * login; jika belum ada (user baru daftar sebagai perusahaan),
     * BUAT otomatis data Company kosong dengan nama default.
     *
     * Fungsi ini dipanggil di HAMPIR SETIAP method controller ini,
     * supaya tidak terjadi error "data tidak ditemukan" saat
     * perusahaan baru pertama kali mengakses dashboard.
     */
    private function getCompany()
    {
        $c = Company::where('user_id', Auth::id())->first();
        if (!$c) $c = Company::create(['user_id' => Auth::id(), 'company_name' => Auth::user()->name . " Company", 'industry' => 'Lainnya']);
        return $c;
    }

    /**
     * index() — READ: Dashboard utama perusahaan.
     * Menampilkan statistik lowongan & lamaran masuk.
     */
    public function index()
    {
        $company = $this->getCompany();

        // withCount('lamarans') menambahkan kolom 'lamarans_count' otomatis
        // ke setiap baris lowongan, berisi jumlah lamaran yang masuk —
        // tanpa perlu mengambil semua data lamaran satu per satu.
        $lowongans = JobListing::where('company_id', $company->id)->withCount('lamarans')->latest()->get();

        $stats = [
            'total_lowongan' => $lowongans->count(),
            'lowongan_aktif' => $lowongans->where('is_active', true)->count(),
            'total_lamaran' => $lowongans->sum('lamarans_count'), // sum() menjumlahkan kolom lamarans_count semua baris
            'lamaran_baru' => Lamaran::whereIn('lowongan_id', $lowongans->pluck('id'))->where('status', 'menunggu')->count(),
            // whereIn(..., $lowongans->pluck('id')) -> pluck('id') mengambil HANYA
            // kolom id dari koleksi $lowongans menjadi array sederhana [1,2,3,...],
            // lalu whereIn mencari lamaran yang lowongan_id-nya ada di daftar itu.
        ];

        $lamaranTerbaru = Lamaran::whereIn('lowongan_id', $lowongans->pluck('id'))->with('user', 'lowongan')->latest()->take(5)->get();
        return view('dashboard.perusahaan.index', compact('company', 'lowongans', 'stats', 'lamaranTerbaru'));
    }

    // ===================== PROFIL PERUSAHAAN =====================

    // READ: form edit profil perusahaan (GET .../profil)
    public function editProfil()
    {
        $company = $this->getCompany();
        return view('dashboard.perusahaan.profil', compact('company'));
    }

    /**
     * updateProfil() — UPDATE data profil & logo perusahaan (POST .../profil)
     */
    public function updateProfil(Request $request)
    {
        $company = $this->getCompany();
        $request->validate([
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string',
            'description' => 'nullable|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'employee_count' => 'nullable|string',
            'founded_year' => 'nullable|integer',
            'logo' => 'nullable|image|max:2048', // maks 2MB
        ]);

        // except(['_token','_method','logo']) -> ambil SEMUA field form
        // KECUALI token keamanan, method override (_method), dan field logo
        // (logo butuh proses upload khusus, jadi ditangani terpisah di bawah).
        $data = $request->except(['_token', '_method', 'logo']);

        if ($request->hasFile('logo')) {
            // Hapus logo lama dulu (jika ada) agar file tidak menumpuk.
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($data); // UPDATE: simpan semua perubahan sekaligus
        return back()->with('success', 'Profil perusahaan berhasil diperbarui!');
    }

    // DELETE: menghapus logo perusahaan (file fisik + kolom database)
    public function hapusLogo()
    {
        $company = $this->getCompany();
        if ($company->logo && Storage::disk('public')->exists($company->logo)) {
            Storage::disk('public')->delete($company->logo);
        }
        $company->update(['logo' => null]);
        return back()->with('success', 'Logo perusahaan berhasil dihapus.');
    }

    // ===================== CRUD LOWONGAN KERJA =====================

    // READ: form tambah lowongan baru (GET .../lowongan/buat)
    public function create() { return view('dashboard.perusahaan.lowongan.create'); }

    /**
     * store() — CREATE lowongan baru (POST .../lowongan)
     */
    public function store(Request $request)
    {
        $company = $this->getCompany();
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'job_type' => 'required|in:full-time,part-time,freelance,internship',
            'min_education' => 'required|in:SMA/SMK,D3,S1,S2,S3',
            'min_experience' => 'required|integer|min:0',
            'deadline' => 'required|date|after:today', // deadline wajib tanggal setelah hari ini
        ]);

        // array_merge menggabungkan SEMUA data form (kecuali _token)
        // dengan 2 data tambahan: company_id (pemilik lowongan ini)
        // dan is_active = true (status default saat baru dibuat).
        JobListing::create(array_merge($request->except(['_token']), ['company_id' => $company->id, 'is_active' => true]));
        return redirect()->route('perusahaan.dashboard')->with('success', 'Lowongan berhasil dipublikasikan!');
    }

    // READ: form edit lowongan (GET .../lowongan/{id}/edit)
    public function edit($id)
    {
        $company = $this->getCompany();
        // where('company_id', $company->id) PENTING untuk keamanan:
        // memastikan perusahaan A tidak bisa edit lowongan milik perusahaan B,
        // walaupun tahu ID lowongannya.
        $lowongan = JobListing::where('company_id', $company->id)->findOrFail($id);
        return view('dashboard.perusahaan.lowongan.edit', compact('lowongan'));
    }

    /**
     * update() — UPDATE data lowongan (PUT .../lowongan/{id})
     */
    public function update(Request $request, $id)
    {
        $company = $this->getCompany();
        $lowongan = JobListing::where('company_id', $company->id)->findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'job_type' => 'required|in:full-time,part-time,freelance,internship',
            'min_education' => 'required|in:SMA/SMK,D3,S1,S2,S3',
            'min_experience' => 'required|integer|min:0',
            'deadline' => 'required|date',
        ]);
        // boolean('is_active') mengubah nilai checkbox aktif/nonaktif jadi true/false yang valid.
        $lowongan->update(array_merge($request->except(['_token', '_method']), ['is_active' => $request->boolean('is_active')]));
        return redirect()->route('perusahaan.dashboard')->with('success', 'Lowongan berhasil diperbarui!');
    }

    // DELETE: menghapus lowongan (DELETE .../lowongan/{id})
    public function destroy($id)
    {
        $company = $this->getCompany();
        JobListing::where('company_id', $company->id)->findOrFail($id)->delete();
        return back()->with('success', 'Lowongan berhasil dihapus!');
    }

    // ===================== LAMARAN MASUK =====================

    // READ: daftar pelamar pada satu lowongan tertentu, dengan pagination.
    public function pelamar($id)
    {
        $company = $this->getCompany();
        $lowongan = JobListing::where('company_id', $company->id)->findOrFail($id);
        // with('user.profile') -> ambil data User + profil pelamarnya sekaligus.
        $lamarans = Lamaran::where('lowongan_id', $id)->with('user.profile')->latest()->paginate(10);
        return view('dashboard.perusahaan.lowongan.pelamar', compact('lowongan', 'lamarans'));
    }

    // UPDATE: mengubah status satu lamaran (menunggu/diterima/ditolak)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:menunggu,diterima,ditolak']);
        Lamaran::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'Status lamaran diperbarui!');
    }

    // ===================== REQUEST BERITA SPONSOR =====================

    // READ: daftar permintaan berita sponsor yang pernah diajukan perusahaan ini.
    public function requestBerita() {
        $company = $this->getCompany();
        $requests = BeritaRequest::where('company_id', $company->id)->latest()->get();
        return view('dashboard.perusahaan.berita-request', compact('company', 'requests'));
    }

    /**
     * storeBeritaRequest() — CREATE permintaan berita sponsor baru.
     * Ini BUKAN langsung membuat berita; ini hanya membuat PERMINTAAN
     * yang nanti harus disetujui admin (lihat AdminBeritaController::approveRequest()).
     */
    public function storeBeritaRequest(Request $request) {
        $company = $this->getCompany();
        $request->validate(['judul' => 'required|string', 'konten' => 'required|string']);
        $data = $request->only(['judul', 'konten']);
        $data['company_id'] = $company->id;
        $data['nominal'] = 500000;   // biaya sponsor tetap (hardcoded)
        $data['status'] = 'pending'; // status awal, menunggu admin
        if ($request->hasFile('thumbnail')) $data['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        BeritaRequest::create($data);
        return back()->with('success', 'Request berita berhasil dikirim! Admin akan menghubungi Anda.');
    }
}