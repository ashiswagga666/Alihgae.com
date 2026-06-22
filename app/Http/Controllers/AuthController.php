<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()  { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required|min:6']);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:pelamar,perusahaan',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,  // auto-hashed via cast
            'role'     => $request->role,
        ]);

        Auth::login($user);
        return $this->redirectByRole();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('beranda');
    }

    private function redirectByRole()
    {
        return match(Auth::user()->role) {
            'admin'      => redirect()->route('admin.custom.dashboard'),
            'perusahaan' => redirect()->route('perusahaan.dashboard'),
            default      => redirect()->route('pelamar.dashboard'),
        };
    }
}
