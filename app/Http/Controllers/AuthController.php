<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Login
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

            // 🔥 CATAT LOG LOGIN
            ActivityLog::create([
                'user_id'   => $user->id_petugas,
                'user_type' => 'petugas',
                'aktivitas' => 'Login',
                'waktu' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return $user->level === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('petugas.dashboard');
        }

        // Login siswa
        if (Auth::guard('siswa')->attempt($credentials)) {

            $request->session()->regenerate();
            $user = Auth::guard('siswa')->user();

            // 🔥 CATAT LOG LOGIN
            ActivityLog::create([
                'user_id'   => $user->nisn,
                'user_type' => 'siswa',
                'aktivitas' => 'Login',
                'waktu' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput();
    }

    // Proses Logout
    public function logout(Request $request)
    {
        if (Auth::guard('petugas')->check()) {
            $user = Auth::guard('petugas')->user();

            // 🔥 CATAT LOG LOGOUT
            ActivityLog::create([
                'user_id'   => $user->id_petugas,
                'user_type' => 'petugas',
                'aktivitas' => 'Logout',
                'waktu' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            Auth::guard('petugas')->logout();
        }

        if (Auth::guard('siswa')->check()) {
            $user = Auth::guard('siswa')->user();

            // 🔥 CATAT LOG LOGOUT
            ActivityLog::create([
                'user_id'   => $user->nisn,
                'user_type' => 'siswa',
                'aktivitas' => 'Logout',
                'waktu' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            Auth::guard('siswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
