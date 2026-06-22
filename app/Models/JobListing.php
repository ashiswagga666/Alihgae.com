<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id','title','description','requirements','location',
        'job_type','salary_min','salary_max','min_education',
        'min_experience','deadline','is_active'
    ];

    protected $casts = ['deadline' => 'date', 'is_active' => 'boolean'];

    public function company() { return $this->belongsTo(Company::class); }
    public function lamarans() { return $this->hasMany(Lamaran::class, 'lowongan_id'); }

    public function getSalaryRangeAttribute() {
        if ($this->salary_min && $this->salary_max)
            return 'Rp '.number_format($this->salary_min/1e6,1).'jt - Rp '.number_format($this->salary_max/1e6,1).'jt';
        if ($this->salary_min) return 'Rp '.number_format($this->salary_min/1e6,1).'jt+';
        return 'Negosiasi';
    }

    public function getJobTypeLabelAttribute() {
        return match($this->job_type) {
            'full-time'  => 'Full-time',
            'part-time'  => 'Part-time',
            'freelance'  => 'Freelance',
            'internship' => 'Magang',
            default      => $this->job_type,
        };
    }
}
