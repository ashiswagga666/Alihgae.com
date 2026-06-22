<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\JobListing;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::with('company')
            ->where('is_active', true)
            ->where('deadline', '>=', date('Y-m-d'));

        $keyword = $request->filled('search') ? $request->search : $request->q;
        if ($keyword) {
            $query->where(function($sub) use ($keyword) {
                $sub->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('company', fn($c) => $c->where('company_name', 'like', "%{$keyword}%"));
            });
        }

        $lokasi = $request->filled('location') ? $request->location : $request->lokasi;
        if ($lokasi) {
            $query->where('location', 'like', "%{$lokasi}%");
        }

        if ($request->filled('tipe')) {
            $query->where('job_type', $request->tipe);
        }

        if ($request->filled('pendidikan')) {
            $query->where('min_education', $request->pendidikan);
        }

        $lowongans = $query->latest()->paginate(12)->withQueryString();

        return view('lowongan', compact('lowongans'));
    }

    public function detail($id)
    {
        $lowongan = JobListing::with('company')->findOrFail($id);
        return view('lowongan-detail', compact('lowongan'));
    }
}
