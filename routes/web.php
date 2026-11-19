<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\DropPointController;

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