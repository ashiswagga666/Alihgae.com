<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\User;
use App\Models\JobListing;
use App\Models\Company;
use App\Models\Lamaran;
use App\Models\Berita;
use App\Models\BeritaRequest;

class AdminSiteController extends Controller
{
    public function dashboard()
    {
        try { $totalUsers      = User::where('role', 'pelamar')->count(); } catch(\Exception $e) { $totalUsers = 0; }
        try { $totalPerusahaan = Company::count(); }                       catch(\Exception $e) { $totalPerusahaan = 0; }
        try { $totalLowongan   = JobListing::count(); }                    catch(\Exception $e) { $totalLowongan = 0; }
        try { $totalLamaran    = Lamaran::count(); }                       catch(\Exception $e) { $totalLamaran = 0; }
        try { $totalBerita     = Berita::count(); }                        catch(\Exception $e) { $totalBerita = 0; }
        try { $lowonganAktif   = JobListing::where('is_active', true)->count(); } catch(\Exception $e) { $lowonganAktif = 0; }
        try { $pendingBerita   = BeritaRequest::where('status', 'pending')->count(); } catch(\Exception $e) { $pendingBerita = 0; }
        try { $beritaTerbaru   = Berita::latest()->take(5)->get(); }       catch(\Exception $e) { $beritaTerbaru = collect(); }
        try { $lowonganTerbaru = JobListing::with('company')->latest()->take(5)->get(); } catch(\Exception $e) { $lowonganTerbaru = collect(); }

        return view('admin.dashboard-custom', compact(
            'totalUsers','totalPerusahaan','totalLowongan','totalLamaran',
            'totalBerita','lowonganAktif','pendingBerita','beritaTerbaru','lowonganTerbaru'
        ));
    }

    public function settings()
    {
        try {
            $settings = SiteSetting::all()->pluck('value', 'key');
        } catch(\Exception $e) {
            $settings = collect();
        }
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->except(['_token', '_method', 'logo']) as $key => $value) {
            SiteSetting::set($key, $value);
        }
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('site', 'public');
            SiteSetting::set('logo_path', 'storage/'.$path);
        }
        return back()->with('success', 'Pengaturan situs berhasil disimpan!');
    }
}
