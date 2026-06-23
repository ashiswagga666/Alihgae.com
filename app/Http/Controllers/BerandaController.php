<?php
namespace App\Http\Controllers;
use App\Models\JobListing;
use App\Models\Company;
use App\Models\User;
use App\Models\Berita;

class BerandaController extends Controller
{
    public function index()
    {
        try {
            $totalJobs       = JobListing::where('is_active', true)->where('deadline', '>=', date('Y-m-d'))->count();
            $totalCompanies  = Company::count();
            $totalApplicants = User::where('role', 'pelamar')->count();
            $lowonganTerbaru = JobListing::with('company')
                ->where('is_active', true)->where('deadline', '>=', date('Y-m-d'))
                ->latest()->take(6)->get();
        } catch (\Exception $e) {
            $totalJobs = $totalCompanies = $totalApplicants = 0;
            $lowonganTerbaru = collect();
        }

        // Berita pakai try-catch terpisah karena tabel mungkin belum ada
        try {
            $beritaTerbaru = Berita::where('status', 'published')
                ->latest('published_at')->take(3)->get();
        } catch (\Exception $e) {
            $beritaTerbaru = collect();
        }

        $totalLowongan   = $totalJobs;
        $totalPerusahaan = $totalCompanies;
        $totalPencari    = $totalApplicants;

        return view('beranda', compact(
            'totalJobs','totalCompanies','totalApplicants',
            'totalLowongan','totalPerusahaan','totalPencari',
            'lowonganTerbaru','beritaTerbaru'
        ));
    }
}
