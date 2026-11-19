<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\DropPointController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\MetodePenarikanController;

Route::view('/', 'admin.dashboard')->name('dashboard');

Route::view('/admin/dashboard', 'admin.dashboard')
    ->name('admin.dashboard');

Route::view('/admin/users', 'admin.users')
    ->name('admin.users');

// P-01 CRUD Data Nasabah (Muhammad Dhafin Razaqa)
Route::resource('/admin/nasabah', NasabahController::class)
    ->names('admin.nasabah');

// P-02 CRUD Lokasi Drop Point (Muhammad Dhafin Razaqa)
Route::resource('/admin/drop-points', DropPointController::class)
    ->names('admin.drop-points');

// P-11 CRUD Katalog Reward (Gracia Gebriella Sianturi)
Route::resource('/admin/rewards', RewardController::class)
    ->names('admin.rewards');

// P-12 CRUD Metode Penarikan (Gracia Gebriella Sianturi)
Route::resource('/admin/metode-penarikan', MetodePenarikanController::class)
    ->names('admin.metode-penarikan');

// Transaksi
Route::view('/admin/transactions', 'admin.placeholder', [
    'pageTitle' => 'Transaksi'
])->name('admin.transactions');

// Laporan
Route::view('/admin/reports', 'admin.placeholder', [
    'pageTitle' => 'Laporan'
])->name('admin.reports');
