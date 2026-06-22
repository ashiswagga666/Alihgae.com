<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BeritaRequest extends Model
{
    protected $fillable = ['company_id', 'judul', 'konten', 'thumbnail', 'nominal', 'status', 'catatan_admin'];
    public function company() { return $this->belongsTo(Company::class); }
}
