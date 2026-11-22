
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
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\HargaSampahController;
use App\Models\User;

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

    return redirect()->route('pengumuman.public');
})->name('home');

// AUTENTIKASI
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// PORTAL INFORMASI PUBLIK / NASABAH
Route::get('/pengumuman', [PengumumanController::class, 'publicIndex'])->name('pengumuman.public');
Route::get('/portal-pengumuman', [PengumumanController::class, 'publicIndex'])->name('pengumuman.index');
Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'publicShow'])->name('pengumuman.public.show');
Route::get('/portal-pengumuman/{pengumuman}', [PengumumanController::class, 'publicShow'])->name('pengumuman.show');

// MODUL RESIDU
Route::middleware(['auth', 'role:Admin,Petugas'])->group(function () {
    Route::resource('jenis-residu', JenisResiduController::class);
    Route::resource('residu', ResiduController::class);
});

// PANEL OPERASIONAL & MASTER DATA
Route::prefix('admin')->middleware(['auth', 'role:Admin,Petugas'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // P-01 CRUD Data Nasabah
    Route::resource('/nasabah', NasabahController::class)->names('admin.nasabah');

    // P-02 CRUD Lokasi Drop Point
    Route::resource('/drop-points', DropPointController::class)->names('admin.drop-points');

    // P-03 CRUD Jenis Sampah & Harga (khusus Admin)
    Route::middleware('role:Admin')->group(function () {
        Route::get('/jenis-sampah/{jenis_sampah}/harga', [HargaSampahController::class, 'edit'])->name('admin.harga.edit');
        Route::put('/jenis-sampah/{jenis_sampah}/harga', [HargaSampahController::class, 'update'])->name('admin.harga.update');

        Route::patch('/jenis-sampah/{jenis_sampah}/status', [JenisSampahController::class, 'toggleStatus'])->name('admin.jenis-sampah.status');

        Route::resource('/jenis-sampah', JenisSampahController::class)
            ->parameters(['jenis-sampah' => 'jenis_sampah'])
            ->names('admin.jenis-sampah');
    });

    // P-04 CRUD Kelola Promo/Bonus Harga (khusus Admin)
    Route::middleware('role:Admin')->group(function () {
        Route::resource('/promo', PromoController::class)->names('admin.promo');
    });

    // P-09 CRUD Jadwal Pengumpulan
    Route::resource('/jadwal', JadwalController::class)->names('admin.jadwal');

    // P-10 CRUD Wilayah/RW
    Route::resource('/wilayah', WilayahController::class)->names('admin.wilayah');

    // P-13 CRUD Pengeluaran Operasional
    Route::resource('/pengeluaran', PengeluaranController::class)->names('admin.pengeluaran');

    // P-14 CRUD Pengumuman & Informasi
    Route::resource('/pengumuman', PengumumanController::class)->names('admin.pengumuman');

    // Manajemen Akun Pengguna (khusus Admin)
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

    // Transaksi & Laporan
    Route::view('/transactions', 'admin.placeholder', [
        'pageTitle' => 'Transaksi Bank Sampah'
    ])->name('admin.transactions');

    Route::view('/reports', 'admin.placeholder', [
        'pageTitle' => 'Laporan Eksekutif'
    ])->name('admin.reports');
});

// Daftar Harga
Route::get('/daftar-harga', [HargaSampahController::class, 'index'])
    ->middleware('auth')
    ->name('admin.harga.index');
