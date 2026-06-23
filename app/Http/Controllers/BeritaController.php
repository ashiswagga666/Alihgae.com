<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Pagination\LengthAwarePaginator;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Berita::where('status', 'published')->with('author')->latest('published_at');
            if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
            if ($request->filled('q'))        $query->where('judul', 'like', '%'.$request->q.'%');
            $berita   = $query->paginate(9);
            $featured = Berita::where('status', 'published')->latest('published_at')->first();
        } catch (\Exception $e) {
            $berita   = new LengthAwarePaginator([], 0, 9);
            $featured = null;
        }
        return view('berita.index', compact('berita', 'featured'));
    }

    public function show($slug)
    {
        try {
            $berita  = Berita::where('slug', $slug)->where('status', 'published')->firstOrFail();
            $berita->increment('views');
            $related = Berita::where('status', 'published')
                ->where('kategori', $berita->kategori)
                ->where('id', '!=', $berita->id)->take(3)->get();
            return view('berita.show', compact('berita', 'related'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            abort(500);
        }
    }
}
