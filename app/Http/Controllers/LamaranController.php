<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lamaran;

class LamaranController extends Controller
{
    public function store(Request $request, $lowongan_id)
    {
        // Harus login dulu
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Login dulu untuk melamar!');
        }

        // Cek sudah melamar belum
        $sudah = Lamaran::where('user_id', Auth::id())
            ->where('lowongan_id', $lowongan_id)
            ->exists();

        if ($sudah) {
            return back()->with('error', 'Kamu sudah pernah melamar posisi ini!');
        }

        // Simpan lamaran dengan nama lowongan & perusahaan
        Lamaran::create([
            'user_id'         => Auth::id(),
            'lowongan_id'     => $lowongan_id,
            'nama_lowongan'   => $request->nama_lowongan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'pesan'           => $request->pesan,
            'status'          => 'menunggu',
        ]);

        return back()->with('success', 'Lamaran berhasil dikirim! Tunggu konfirmasi.');
    }

    public function riwayat()
    {
        $lamarans = Lamaran::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pelamar.riwayat', compact('lamarans'));
    }
}