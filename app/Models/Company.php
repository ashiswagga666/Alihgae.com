<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company_name', 'industry', 'description',
        'logo', 'website', 'is_verified', 'address', 'phone',
        'email', 'city', 'employee_count', 'founded_year'
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function jobListings() { return $this->hasMany(JobListing::class); }
    public function berita() { return $this->hasMany(Berita::class); }
    public function beritaRequests() { return $this->hasMany(BeritaRequest::class); }
}
