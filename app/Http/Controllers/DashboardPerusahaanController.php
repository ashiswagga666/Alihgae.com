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
    private function getCompany()
    {
        $c = Company::where('user_id', Auth::id())->first();
        if (!$c) $c = Company::create(['user_id' => Auth::id(), 'company_name' => Auth::user()->name . " Company", 'industry' => 'Lainnya']);
        return $c;
    }

    public function index()
    {
        $company = $this->getCompany();
        $lowongans = JobListing::where('company_id', $company->id)->withCount('lamarans')->latest()->get();
        $stats = [
            'total_lowongan' => $lowongans->count(),
            'lowongan_aktif' => $lowongans->where('is_active', true)->count(),
            'total_lamaran' => $lowongans->sum('lamarans_count'),
            'lamaran_baru' => Lamaran::whereIn('lowongan_id', $lowongans->pluck('id'))->where('status', 'menunggu')->count(),
        ];
        $lamaranTerbaru = Lamaran::whereIn('lowongan_id', $lowongans->pluck('id'))->with('user', 'lowongan')->latest()->take(5)->get();
        return view('dashboard.perusahaan.index', compact('company', 'lowongans', 'stats', 'lamaranTerbaru'));
    }

    public function editProfil()
    {
        $company = $this->getCompany();
        return view('dashboard.perusahaan.profil', compact('company'));
    }

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
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'logo']);
        if ($request->hasFile('logo')) {
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $company->update($data);
        return back()->with('success', 'Profil perusahaan berhasil diperbarui!');
    }

    public function hapusLogo()
    {
        $company = $this->getCompany();
        if ($company->logo && Storage::disk('public')->exists($company->logo)) {
            Storage::disk('public')->delete($company->logo);
        }
        $company->update(['logo' => null]);
        return back()->with('success', 'Logo perusahaan berhasil dihapus.');
    }

    public function create() { return view('dashboard.perusahaan.lowongan.create'); }

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
            'deadline' => 'required|date|after:today',
        ]);
        JobListing::create(array_merge($request->except(['_token']), ['company_id' => $company->id, 'is_active' => true]));
        return redirect()->route('perusahaan.dashboard')->with('success', 'Lowongan berhasil dipublikasikan!');
    }

    public function edit($id)
    {
        $company = $this->getCompany();
        $lowongan = JobListing::where('company_id', $company->id)->findOrFail($id);
        return view('dashboard.perusahaan.lowongan.edit', compact('lowongan'));
    }

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
        $lowongan->update(array_merge($request->except(['_token', '_method']), ['is_active' => $request->boolean('is_active')]));
        return redirect()->route('perusahaan.dashboard')->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $company = $this->getCompany();
        JobListing::where('company_id', $company->id)->findOrFail($id)->delete();
        return back()->with('success', 'Lowongan berhasil dihapus!');
    }

    public function pelamar($id)
    {
        $company = $this->getCompany();
        $lowongan = JobListing::where('company_id', $company->id)->findOrFail($id);
        $lamarans = Lamaran::where('lowongan_id', $id)->with('user.profile')->latest()->paginate(10);
        return view('dashboard.perusahaan.lowongan.pelamar', compact('lowongan', 'lamarans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:menunggu,diterima,ditolak']);
        Lamaran::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'Status lamaran diperbarui!');
    }

    public function requestBerita() {
        $company = $this->getCompany();
        $requests = BeritaRequest::where('company_id', $company->id)->latest()->get();
        return view('dashboard.perusahaan.berita-request', compact('company', 'requests'));
    }

    public function storeBeritaRequest(Request $request) {
        $company = $this->getCompany();
        $request->validate(['judul' => 'required|string', 'konten' => 'required|string']);
        $data = $request->only(['judul', 'konten']);
        $data['company_id'] = $company->id;
        $data['nominal'] = 500000;
        $data['status'] = 'pending';
        if ($request->hasFile('thumbnail')) $data['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        BeritaRequest::create($data);
        return back()->with('success', 'Request berita berhasil dikirim! Admin akan menghubungi Anda.');
    }
}
