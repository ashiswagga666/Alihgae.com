<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'judul', 'slug', 'konten', 'thumbnail', 'kategori',
        'status', 'author_id', 'company_id', 'harga_sponsor',
        'is_sponsored', 'published_at', 'views'
    ];

    protected $casts = ['published_at' => 'datetime', 'is_sponsored' => 'boolean'];

    public static function generateSlug($judul) {
        $slug = Str::slug($judul);
        $count = static::where('slug', 'like', $slug.'%')->count();
        return $count ? $slug.'-'.$count : $slug;
    }

    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function company() { return $this->belongsTo(Company::class); }
}
