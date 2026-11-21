<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\DropPointController;
use App\Http\Controllers\JenisResiduController;
use App\Http\Controllers\ResiduController;

Route::view('/', 'admin.dashboard')->name('dashboard');

Route::view('/admin/dashboard', 'admin.dashboard')
    ->name('admin.dashboard');

Route::view('/admin/users', 'admin.users')
    ->name('admin.users');

// P-01 CRUD Data Nasabah
Route::resource('/admin/nasabah', NasabahController::class)
    ->names('admin.nasabah');

// P-02 CRUD Lokasi Drop Point
Route::resource('/admin/drop-points', DropPointController::class)
    ->names('admin.drop-points');

// Transaksi
Route::view('/admin/transactions', 'admin.placeholder', [
    'pageTitle' => 'Transaksi'
])->name('admin.transactions');

// Laporan
Route::view('/admin/reports', 'admin.placeholder', [
    'pageTitle' => 'Laporan'
])->name('admin.reports');

// Modul Jenis Residu & Pencatatan Residu
Route::resource('jenis-residu', JenisResiduController::class);
Route::resource('residu', ResiduController::class);

// P-21: Kegiatan Penyuluhan & Peserta (Naila)
// TODO: Pasang middleware peran (misal: ->middleware('role:admin,petugas')) saat middleware sudah ada
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PesertaController;

Route::resource('kegiatan', KegiatanController::class);
Route::post('kegiatan/{kegiatan}/peserta', [PesertaController::class, 'store'])->name('peserta.store');
Route::patch('peserta/{peserta}/hadir', [PesertaController::class, 'updateHadir'])->name('peserta.hadir');
Route::delete('peserta/{peserta}', [PesertaController::class, 'destroy'])->name('peserta.destroy');