<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan formulir login (FR-01)
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isNasabah()) {
                return redirect()->route('pengumuman.public');
            }
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login pengguna
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Validasi apakah akun berstatus aktif
            if (!$user->isActive()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            // Jika role adalah Nasabah, arahkan langsung ke Papan Info Publik
            if ($user->isNasabah()) {
                return redirect()->route('pengumuman.public')
                    ->with('success', 'Selamat datang kembali, ' . ($user->nama ?? $user->name) . ' (Nasabah)!');
            }

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, ' . ($user->nama ?? $user->name) . ' (' . $user->role . ')!');
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan password tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan formulir registrasi nasabah baru
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            if (Auth::user()->isNasabah()) {
                return redirect()->route('pengumuman.public');
            }
            return redirect()->route('admin.dashboard');
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi nasabah baru
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:nasabah,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'nik' => ['nullable', 'digits:16', 'unique:nasabah,nik'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'rw' => ['nullable', 'string', 'max:10'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ]);

        $nasabah = Nasabah::create([
            'nama' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'Nasabah',
            'status' => 'Aktif',
            'nik' => $data['nik'] ?? null,
            'no_hp' => $data['no_hp'] ?? '-',
            'rw' => $data['rw'] ?? '01',
            'alamat' => $data['alamat'] ?? 'Belum diatur',
            'saldo' => 0,
        ]);

        // Login otomatis setelah register
        Auth::login($nasabah);
        $request->session()->regenerate();

        return redirect()->route('pengumuman.public')
            ->with('success', 'Pendaftaran akun EcoBank berhasil! Selamat datang, ' . $nasabah->nama . '. Anda dapat melihat seluruh informasi resmi pada Papan Pengumuman Publik.');
    }

    /**
     * Logout pengguna dari sistem (FR-01)
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
