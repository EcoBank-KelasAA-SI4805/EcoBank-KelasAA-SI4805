<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\DropPointController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\JenisResiduController;
use App\Http\Controllers\ResiduController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes - EcoBank (Sistem Pengelolaan Bank Sampah Terpadu)
|--------------------------------------------------------------------------
*/

// Redirect root ke Papan Info Publik (untuk Nasabah/Tamu) atau Dashboard Admin (untuk Admin/Petugas)
Route::get('/', function () {
    if (Auth::check() && Auth::user()->isNasabah()) {
        return redirect()->route('pengumuman.public');
    }
    if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isPetugas())) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('pengumuman.public');
})->name('home');

// --------------------------------------------------------------------------
// AUTENTIKASI PENGGUNA (FR-01: Login, Register, Logout)
// --------------------------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// --------------------------------------------------------------------------
// PORTAL INFORMASI PUBLIK / NASABAH (P-14 Read Only)
// --------------------------------------------------------------------------
Route::get('/pengumuman', [PengumumanController::class, 'publicIndex'])->name('pengumuman.public');
Route::get('/portal-pengumuman', [PengumumanController::class, 'publicIndex'])->name('pengumuman.index');
Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'publicShow'])->name('pengumuman.public.show');
Route::get('/portal-pengumuman/{pengumuman}', [PengumumanController::class, 'publicShow'])->name('pengumuman.show');

// --------------------------------------------------------------------------
// MODUL RESIDU (P-15 & P-16: Jenis Residu & Pencatatan Residu - Khusus Admin & Petugas)
// --------------------------------------------------------------------------
Route::middleware(['auth', 'role:Admin,Petugas'])->group(function () {
    Route::resource('jenis-residu', JenisResiduController::class);
    Route::resource('residu', ResiduController::class);
});

// --------------------------------------------------------------------------
// PANEL OPERASIONAL & MASTER DATA (KHUSUS ADMIN & PETUGAS)
// --------------------------------------------------------------------------
Route::prefix('admin')->middleware(['auth', 'role:Admin,Petugas'])->group(function () {
    // 1. Dashboard Terpadu
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 2. P-01 CRUD Data Nasabah
    Route::resource('/nasabah', NasabahController::class)->names('admin.nasabah');

    // 3. P-02 CRUD Lokasi Drop Point
    Route::resource('/drop-points', DropPointController::class)->names('admin.drop-points');

    // 4. P-13 CRUD Pengeluaran Operasional
    Route::resource('/pengeluaran', PengeluaranController::class)->names('admin.pengeluaran');

    // 5. P-14 CRUD Pengumuman & Informasi (Kelola Pengumuman)
    Route::resource('/pengumuman', PengumumanController::class)->names('admin.pengumuman');

    // 6. Manajemen Akun Pengguna (Khusus Admin)
    Route::get('/users', function () {
        $dbUsers = User::orderBy('id', 'desc')->get()->map(function ($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'role' => ucfirst(strtolower($u->role)),
                'joined' => $u->created_at ? $u->created_at->format('d M Y') : '12 Jan 2026',
                'status' => ucfirst(strtolower($u->status ?? 'Aktif')),
            ];
        });
        return view('admin.users', ['dbUsers' => $dbUsers]);
    })->name('admin.users')->middleware('role:Admin');

    // 7. Transaksi & Laporan (Placeholder)
    Route::view('/transactions', 'admin.placeholder', [
        'pageTitle' => 'Transaksi Bank Sampah'
    ])->name('admin.transactions');

    Route::view('/reports', 'admin.placeholder', [
        'pageTitle' => 'Laporan Eksekutif'
    ])->name('admin.reports');
});
