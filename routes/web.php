<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardPerusahaanController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Admin\AdminBeritaController;
use App\Http\Controllers\Admin\AdminSiteController;

// ── Publik
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan');
Route::get('/lowongan/{id}', [LowonganController::class, 'detail'])->name('lowongan.detail');
Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan');
Route::get('/perusahaan/{id}', [PerusahaanController::class, 'detail'])->name('perusahaan.detail');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Redirect /blog ke /berita agar tidak 404
Route::redirect('/blog', '/berita', 301);
Route::get('/tentang', fn() => view('tentang'))->name('tentang');

// ── Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Auth Protected
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return match (Auth::user()->role) {
            'admin'      => redirect()->route('admin.custom.dashboard'),
            'perusahaan' => redirect()->route('perusahaan.dashboard'),
            default      => redirect()->route('pelamar.dashboard'),
        };
    })->name('dashboard');

    // ── PELAMAR
    Route::prefix('pelamar')->name('pelamar.')->middleware('can:ispelamar')->group(function () {
        Route::get('/dashboard', [PelamarController::class, 'dashboard'])->name('dashboard');
        Route::get('/profil', [PelamarController::class, 'profil'])->name('profil');
        Route::post('/profil', [PelamarController::class, 'updateProfil'])->name('profil.update');
        Route::get('/riwayat', [PelamarController::class, 'riwayat'])->name('riwayat');
    });
    Route::post('/lamar/{lowongan_id}', [PelamarController::class, 'lamar'])->name('lamaran.store');

    // ── PERUSAHAAN
    Route::prefix('dashboard/perusahaan')->name('perusahaan.')->middleware('can:isperusahaan')->group(function () {
        Route::get('/', [DashboardPerusahaanController::class, 'index'])->name('dashboard');
        Route::get('/profil', [DashboardPerusahaanController::class, 'editProfil'])->name('profil.edit');
        Route::post('/profil', [DashboardPerusahaanController::class, 'updateProfil'])->name('profil.update');
        Route::get('/lowongan/buat', [DashboardPerusahaanController::class, 'create'])->name('lowongan.create');
        Route::post('/lowongan', [DashboardPerusahaanController::class, 'store'])->name('lowongan.store');
        Route::get('/lowongan/{id}/edit', [DashboardPerusahaanController::class, 'edit'])->name('lowongan.edit');
        Route::put('/lowongan/{id}', [DashboardPerusahaanController::class, 'update'])->name('lowongan.update');
        Route::delete('/lowongan/{id}', [DashboardPerusahaanController::class, 'destroy'])->name('lowongan.destroy');
        Route::get('/lowongan/{id}/pelamar', [DashboardPerusahaanController::class, 'pelamar'])->name('lowongan.pelamar');
        Route::post('/lamaran/{id}/status', [DashboardPerusahaanController::class, 'updateStatus'])->name('lamaran.status');
        Route::get('/berita-request', [DashboardPerusahaanController::class, 'requestBerita'])->name('berita.request');
        Route::post('/berita-request', [DashboardPerusahaanController::class, 'storeBeritaRequest'])->name('berita.request.store');
    });

    // ── ADMIN (non-Filament)
    Route::prefix('admin-panel')->name('admin.')->middleware('can:isadmin')->group(function () {
        Route::get('/dashboard', [AdminSiteController::class, 'dashboard'])->name('custom.dashboard');
        Route::get('/settings', [AdminSiteController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminSiteController::class, 'updateSettings'])->name('settings.update');
        Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita.index');
        Route::get('/berita/buat', [AdminBeritaController::class, 'create'])->name('berita.create');
        Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
        Route::get('/berita/{id}/edit', [AdminBeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/{id}', [AdminBeritaController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{id}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
        Route::get('/berita-requests', [AdminBeritaController::class, 'requests'])->name('berita.requests');
        Route::post('/berita-requests/{id}', [AdminBeritaController::class, 'approveRequest'])->name('berita.requests.action');
    });
});
