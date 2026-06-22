<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\BeritaRequest;
use Illuminate\Support\Facades\Auth;

class AdminBeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with('author')->latest()->paginate(15);
        $pendingRequests = BeritaRequest::where('status', 'pending')->count();
        return view('admin.berita.index', compact('berita', 'pendingRequests'));
    }

    public function create() { return view('admin.berita.form'); }

    public function store(Request $request)
    {
        $request->validate(['judul' => 'required|string', 'konten' => 'required|string', 'kategori' => 'required|string']);
        $data = $request->except(['_token']);
        $data['author_id'] = Auth::id();
        $data['slug'] = Berita::generateSlug($request->judul);
        if (isset($data['status']) && $data['status'] === 'published') $data['published_at'] = now();
        if ($request->hasFile('thumbnail')) $data['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    public function edit($id) { $berita = Berita::findOrFail($id); return view('admin.berita.form', compact('berita')); }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $data = $request->except(['_token', '_method']);
        if ($request->hasFile('thumbnail')) $data['thumbnail'] = $request->file('thumbnail')->store('berita', 'public');
        if (isset($data['status']) && $data['status'] === 'published' && !$berita->published_at) $data['published_at'] = now();
        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id) { Berita::findOrFail($id)->delete(); return back()->with('success', 'Berita dihapus!'); }

    public function requests()
    {
        $requests = BeritaRequest::with('company.user')->latest()->paginate(10);
        return view('admin.berita.requests', compact('requests'));
    }

    public function approveRequest(Request $request, $id)
    {
        $req = BeritaRequest::findOrFail($id);
        if ($request->action === 'approve') {
            Berita::create([
                'judul' => $req->judul,
                'slug' => Berita::generateSlug($req->judul),
                'konten' => $req->konten,
                'thumbnail' => $req->thumbnail,
                'kategori' => 'berita-perusahaan',
                'status' => 'published',
                'author_id' => Auth::id(),
                'company_id' => $req->company_id,
                'is_sponsored' => true,
                'harga_sponsor' => $req->nominal,
                'published_at' => now(),
            ]);
            $req->update(['status' => 'approved']);
            return back()->with('success', 'Request berita disetujui!');
        }
        $req->update(['status' => 'rejected', 'catatan_admin' => $request->catatan]);
        return back()->with('success', 'Request berita ditolak.');
    }
}
