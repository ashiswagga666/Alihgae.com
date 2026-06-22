<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pelamar.profil', compact('user'));
    }
}