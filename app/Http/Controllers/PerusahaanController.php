<?php

namespace App\Http\Controllers;

use App\Models\Company;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaans = Company::withCount(['jobListings' => function($q) {
            $q->where('is_active', true)->where('deadline', '>=', date('Y-m-d'));
        }])->get();

        return view('perusahaan', compact('perusahaans'));
    }

    public function detail($id)
    {
        $perusahaan = Company::withCount(['jobListings' => function($q) {
            $q->where('is_active', true)->where('deadline', '>=', date('Y-m-d'));
        }])->with(['jobListings' => function($q) {
            $q->where('is_active', true)->where('deadline', '>=', date('Y-m-d'));
        }])->findOrFail($id);

        return view('perusahaan-detail', compact('perusahaan'));
    }
}