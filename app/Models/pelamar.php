<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelamar extends User
{
    use HasFactory;

    // Scope untuk query user dengan role pelamar
    protected static function booted()
    {
        static::addGlobalScope('pelamar', function ($query) {
            $query->where('role', 'pelamar');
        });
    }

    // POLIMORFISME — override dashboard() dari parent
    public function dashboard(): string
    {
        return "Dashboard Pelamar: lihat lowongan & pantau status lamaran";
    }

    public function getRole(): string
    {
        return "pelamar";
    }

    // Method khusus pelamar — melamar pekerjaan
    public function lamarPekerjaan(int $lowongan_id): string
    {
        Lamaran::create([
            'user_id'     => $this->id,
            'lowongan_id' => $lowongan_id,
            'status'      => 'menunggu',
        ]);
        return "{$this->name} berhasil melamar ke lowongan ID: $lowongan_id";
    }

    // Ambil semua lamaran milik pelamar ini
    public function riwayatLamaran()
    {
        return $this->hasMany(Lamaran::class, 'user_id');
    }
}