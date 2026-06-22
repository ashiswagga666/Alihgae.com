<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\BeritaRequest;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::where('status', 'published')->with('author')->latest('published_at');
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('q')) $query->where('judul', 'like', '%'.$request->q.'%');
        $berita = $query->paginate(9);
        $featured = Berita::where('status', 'published')->latest('published_at')->first();
        return view('berita.index', compact('berita', 'featured'));
    }

    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $berita->increment('views');
        $related = Berita::where('status', 'published')->where('kategori', $berita->kategori)->where('id', '!=', $berita->id)->take(3)->get();
        return view('berita.show', compact('berita', 'related'));
    }
}
