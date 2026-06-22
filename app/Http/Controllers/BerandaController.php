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
        $totalLowongan = JobListing::where('is_active', true)->where('deadline', '>=', date('Y-m-d'))->count();
        $totalPerusahaan = Company::count();
        $totalPencari = User::where('role', 'pelamar')->count();
        $lowonganTerbaru = JobListing::with('company')
            ->where('is_active', true)
            ->where('deadline', '>=', date('Y-m-d'))
            ->latest()
            ->take(6)
            ->get();
        $beritaTerbaru = Berita::where('status', 'published')->latest('published_at')->take(3)->get();

        return view('beranda', compact('totalLowongan', 'totalPerusahaan', 'totalPencari', 'lowonganTerbaru', 'beritaTerbaru'));
    }
}
