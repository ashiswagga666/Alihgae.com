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
        return view('admin.dashboard-custom', [
            'totalUsers'     => User::where('role', 'pelamar')->count(),
            'totalPerusahaan'=> Company::count(),
            'totalLowongan'  => JobListing::count(),
            'totalLamaran'   => Lamaran::count(),
            'totalBerita'    => Berita::count(),
            'lowonganAktif'  => JobListing::where('is_active', true)->count(),
            'pendingBerita'  => BeritaRequest::where('status', 'pending')->count(),
            'beritaTerbaru'  => Berita::latest()->take(5)->get(),
            'lowonganTerbaru'=> JobListing::with('company')->latest()->take(5)->get(),
        ]);
    }

    public function settings()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
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
