<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    // Tabel yang digunakan (bukan 'lowongans')
    protected $table = 'job_listings';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'company_id', 'title', 'description', 'requirements',
        'location', 'job_type', 'salary_min', 'salary_max',
        'min_education', 'min_experience', 'deadline', 'is_active',
    ];

    // Cast tipe data otomatis
    protected $casts = [
        'is_active'  => 'boolean',
        'deadline'   => 'date',
        'salary_min' => 'integer',
        'salary_max' => 'integer',
    ];

    // Relasi ke perusahaan (company)
    public function perusahaan()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Relasi ke lamaran
    public function lamarans()
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id');
    }

    // Format gaji
    public function getGajiAttribute(): string
    {
        if ($this->salary_min && $this->salary_max) {
            return 'Rp ' . number_format($this->salary_min, 0, ',', '.') .
                   ' - Rp ' . number_format($this->salary_max, 0, ',', '.');
        }
        return 'Negosiasi';
    }
}