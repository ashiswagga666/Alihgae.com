<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JobSeekerProfile extends Model
{
    protected $fillable = [
        'user_id', 'phone', 'domicile', 'education_level',
        'cv_path', 'portfolio_url', 'skills', 'work_experience',
        'birth_date', 'gender', 'photo', 'about', 'desired_position',
        'surat_pengantar_path'
    ];

    public function user() { return $this->belongsTo(User::class); }
}
