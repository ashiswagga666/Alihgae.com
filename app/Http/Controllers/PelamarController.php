<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\JobSeekerProfile;
use App\Models\Lamaran;
use App\Models\JobListing;

class PelamarController extends Controller
{
    public function dashboard()
    {
        $user    = Auth::user();
        $profile = JobSeekerProfile::firstOrCreate(['user_id' => $user->id], ['education_level' => 'S1']);
        $lamarans = Lamaran::where('user_id', $user->id)->with('lowongan.company')->latest()->take(5)->get();
        $totalLamaran = Lamaran::where('user_id', $user->id)->count();
        $diterima     = Lamaran::where('user_id', $user->id)->where('status', 'diterima')->count();
        $lowonganRekomendasi = JobListing::where('is_active', true)
            ->where('deadline', '>=', now())
            ->latest()->take(4)->with('company')->get();
        return view('pelamar.dashboard', compact('user','profile','lamarans','totalLamaran','diterima','lowonganRekomendasi'));
    }

    public function profil()
    {
        $user    = Auth::user();
        $profile = JobSeekerProfile::firstOrCreate(['user_id' => $user->id], ['education_level' => 'S1']);
        return view('pelamar.profil', compact('user', 'profile'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'            => 'required|string|max:255',
            'phone'           => 'nullable|string|max:20',
            'domicile'        => 'nullable|string|max:255',
            'education_level' => 'required|in:SMA/SMK,D3,S1,S2,S3',
            'skills'          => 'nullable|string',
            'about'           => 'nullable|string',
            'desired_position'=> 'nullable|string',
            'birth_date'      => 'nullable|date',
            'gender'          => 'nullable|in:male,female',
            'photo'           => 'nullable|image|max:5120',
            'cv'              => 'nullable|mimes:pdf,doc,docx|max:10240',
            'surat_pengantar' => 'nullable|mimes:pdf,doc,docx|max:10240',
        ]);

        $user->update(['name' => $request->name]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        $profileData = $request->only([
            'phone','domicile','education_level','skills','about',
            'desired_position','birth_date','gender','portfolio_url','work_experience'
        ]);

        if ($request->hasFile('photo')) {
            $profileData['photo'] = $request->file('photo')->store('photos', 'public');
        }
        if ($request->hasFile('cv')) {
            $profileData['cv_path'] = $request->file('cv')->store('cv', 'public');
        }
        if ($request->hasFile('surat_pengantar')) {
            $profileData['surat_pengantar_path'] = $request->file('surat_pengantar')->store('surat', 'public');
        }

        JobSeekerProfile::updateOrCreate(['user_id' => $user->id], $profileData);
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function riwayat()
    {
        $lamarans = Lamaran::where('user_id', Auth::id())
            ->with('lowongan.company')->latest()->paginate(10);
        return view('pelamar.riwayat', compact('lamarans'));
    }

    public function lamar(Request $request, $lowongan_id)
    {
        if (!Auth::check()) return redirect()->route('login')->with('error', 'Login dulu!');

        // Cek CV & surat pengantar wajib ada di profil
        $profile = JobSeekerProfile::where('user_id', Auth::id())->first();

        $cvPath    = $request->hasFile('cv') ? true : ($profile?->cv_path ?? null);
        $suratPath = $request->hasFile('surat_pengantar') ? true : ($profile?->surat_pengantar_path ?? null);

        if (!$cvPath || !$suratPath) {
            $missing = [];
            if (!$cvPath)    $missing[] = 'CV / Resume';
            if (!$suratPath) $missing[] = 'Surat Pengantar';
            return back()->with('error',
                '⚠️ Kamu belum mengupload: ' . implode(' dan ', $missing) .
                '. Silakan upload dulu di halaman Profil sebelum melamar.'
            );
        }

        $sudah = Lamaran::where('user_id', Auth::id())->where('lowongan_id', $lowongan_id)->exists();
        if ($sudah) return back()->with('error', 'Kamu sudah melamar posisi ini!');

        $request->validate([
            'pesan'           => 'nullable|string',
            'cv'              => 'nullable|mimes:pdf,doc,docx|max:10240',
            'surat_pengantar' => 'nullable|mimes:pdf,doc,docx|max:10240',
            'portofolio'      => 'nullable|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $lowongan = JobListing::with('company')->findOrFail($lowongan_id);

        $data = [
            'user_id'         => Auth::id(),
            'lowongan_id'     => $lowongan_id,
            'nama_lowongan'   => $lowongan->title,
            'nama_perusahaan' => $lowongan->company->company_name ?? '',
            'pesan'           => $request->pesan,
            'status'          => 'menunggu',
            // Pakai dari profil jika tidak upload baru
            'cv_path'             => $profile?->cv_path,
            'surat_pengantar_path'=> $profile?->surat_pengantar_path,
        ];

        if ($request->hasFile('cv'))              $data['cv_path']              = $request->file('cv')->store('lamaran/cv', 'public');
        if ($request->hasFile('surat_pengantar')) $data['surat_pengantar_path'] = $request->file('surat_pengantar')->store('lamaran/surat', 'public');
        if ($request->hasFile('portofolio'))      $data['portofolio_path']      = $request->file('portofolio')->store('lamaran/porto', 'public');

        Lamaran::create($data);
        return back()->with('success', '✅ Lamaran berhasil dikirim! Pantau status di Riwayat Lamaran.');
    }
}
