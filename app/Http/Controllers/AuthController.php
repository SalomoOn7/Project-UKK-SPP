<?php

namespace App\Http\Controllers;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan login form (pakai view Breeze)
    public function showLoginForm()
    {
        return view('auth.login'); // login.blade.php Breeze
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Login petugas
        if (Auth::guard('petugas')->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::guard('petugas')->user();
            return $user->level === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('petugas.dashboard');
        }

        // Login siswa
        if (Auth::guard('siswa')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        if (Auth::guard('petugas')->check()) {
            Auth::guard('petugas')->logout();
        }

        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
