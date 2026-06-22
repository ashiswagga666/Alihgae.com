<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    protected $fillable = [
        'user_id', 'lowongan_id', 'status', 'pesan',
        'cv_path', 'surat_pengantar_path', 'portofolio_path',
        'nama_lowongan', 'nama_perusahaan'
    ];

    public function pelamar() { return $this->belongsTo(User::class, 'user_id'); }
    public function lowongan() { return $this->belongsTo(JobListing::class, 'lowongan_id'); }
    public function user() { return $this->belongsTo(User::class); }
}
