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
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ResiduController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\MetodePenarikanController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\HargaSampahController;

/*
|--------------------------------------------------------------------------
| Web Routes - EcoBank (Sistem Pengelolaan Bank Sampah Terpadu)
|--------------------------------------------------------------------------
*/

// Redirect halaman utama
Route::get('/', function () {
    if (Auth::check() && Auth::user()->isNasabah()) {
        return redirect()->route('pengumuman.public');
    }

    if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isPetugas())) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('login');
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
// MODUL RESIDU (P-15 & P-16: Jenis Residu & Pencatatan Residu)
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

    // 4. P-03 CRUD Jenis Sampah & Harga (khusus Admin)
    Route::middleware('role:Admin')->group(function () {
        Route::get('/jenis-sampah/{jenis_sampah}/harga', [HargaSampahController::class, 'edit'])->name('admin.harga.edit');
        Route::put('/jenis-sampah/{jenis_sampah}/harga', [HargaSampahController::class, 'update'])->name('admin.harga.update');

        Route::patch('/jenis-sampah/{jenis_sampah}/status', [JenisSampahController::class, 'toggleStatus'])->name('admin.jenis-sampah.status');

        Route::resource('/jenis-sampah', JenisSampahController::class)
            ->parameters(['jenis-sampah' => 'jenis_sampah'])
            ->names('admin.jenis-sampah');
    });

    // 5. P-04 CRUD Kelola Promo/Bonus Harga (khusus Admin)
    Route::middleware('role:Admin')->group(function () {
        Route::resource('/promo', PromoController::class)->names('admin.promo');
    });

    // 6. P-09 CRUD Jadwal Pengumpulan
    Route::resource('/jadwal', JadwalController::class)->names('admin.jadwal');

    // 7. P-10 CRUD Wilayah/RW
    Route::resource('/wilayah', WilayahController::class)->names('admin.wilayah');

    // 8. P-11 CRUD Katalog Reward (Gracia Gebriella Sianturi)
    Route::resource('/rewards', RewardController::class)->names('admin.rewards');

    // 9. P-12 CRUD Metode Penarikan (Gracia Gebriella Sianturi)
    Route::resource('/metode-penarikan', MetodePenarikanController::class)->names('admin.metode-penarikan');

    // 10. P-13 CRUD Pengeluaran Operasional
    Route::resource('/pengeluaran', PengeluaranController::class)->names('admin.pengeluaran');

    // 11. P-14 CRUD Pengumuman & Informasi (Kelola Pengumuman)
    Route::resource('/pengumuman', PengumumanController::class)->names('admin.pengumuman');
});

// Daftar Harga (P-03 / Aisyah)
Route::get('/daftar-harga', [HargaSampahController::class, 'index'])
    ->middleware('auth')
    ->name('admin.harga.index');
