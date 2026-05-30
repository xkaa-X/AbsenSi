<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('siswa.dashboard');
            }
        }
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        // Validasi form login
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // Percobaan login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat datang kembali, ' . Auth::user()->username . '!');
            } else {
                $namaSiswa = Auth::user()->siswa ? Auth::user()->siswa->nama : Auth::user()->username;
                return redirect()->route('siswa.dashboard')
                    ->with('success', 'Selamat datang kembali, ' . $namaSiswa . '!');
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'loginError' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
