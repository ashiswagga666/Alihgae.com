<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perusahaan extends User
{
    use HasFactory;

    // Scope untuk query user dengan role perusahaan
    protected static function booted()
    {
        static::addGlobalScope('perusahaan', function ($query) {
            $query->where('role', 'perusahaan');
        });
    }

    // POLIMORFISME — override dashboard() dari parent
    public function dashboard(): string
    {
        return "Dashboard Perusahaan: kelola lowongan & review pelamar masuk";
    }

    public function getRole(): string
    {
        return "perusahaan";
    }

    // Method khusus perusahaan — ambil lamaran yang masuk
    public function lamaranMasuk()
    {
        return Lamaran::whereHas('lowongan', function ($q) {
            $q->where('user_id', $this->id);
        })->with(['pelamar'])->latest()->get();
    }

    // Method khusus perusahaan — update status lamaran
    public function updateStatusLamaran(int $lamaran_id, string $status): string
    {
        $allowed = ['menunggu', 'diterima', 'ditolak'];
        if (!in_array($status, $allowed)) {
            return "Status tidak valid!";
        }
        Lamaran::where('id', $lamaran_id)->update(['status' => $status]);
        return "Status lamaran ID $lamaran_id diubah menjadi: $status";
    }
}