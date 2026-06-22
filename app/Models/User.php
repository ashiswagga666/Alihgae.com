<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function company()  { return $this->hasOne(Company::class); }
    public function profile()  { return $this->hasOne(JobSeekerProfile::class); }
    public function lamarans() { return $this->hasMany(Lamaran::class); }
}
