<?php

namespace App\Http\Controllers;

use App\Models\DropPoint;
use App\Models\JenisResidu;
use App\Models\Nasabah;
use App\Models\Pengeluaran;
use App\Models\Pengumuman;
use App\Models\Residu;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard dengan metrik terintegrasi dari seluruh modul.
     */
    public function index()
    {
        $totalNasabah = Nasabah::count();
        $totalSaldoNasabah = Nasabah::sum('saldo');
        $totalDropPoints = DropPoint::count();
        $totalDropPointsAktif = DropPoint::where('status_aktif', true)->count();
        $totalPengeluaran = Pengeluaran::sum('nominal');
        $totalPengumuman = Pengumuman::count();
        $totalJenisResidu = JenisResidu::count();
        $totalBeratResidu = Residu::sum('berat_kg');
        $totalBiayaResidu = Residu::sum('total_biaya');
        $totalUsers = User::count();

        // 5 Data Nasabah Terbaru
        $nasabahTerbaru = Nasabah::latest('id')->take(5)->get();

        // 5 Data Residu Terbaru
        $residuTerbaru = Residu::with('jenisResidu')->latest('tanggal')->latest('id')->take(5)->get();

        // 5 Pengeluaran Terbaru
        $pengeluaranTerbaru = Pengeluaran::latest('tanggal')->latest('id')->take(5)->get();

        // 3 Pengumuman Aktif Terbaru
        $pengumumanTerbaru = Pengumuman::latest('tanggal_tayang')->latest('id')->take(3)->get();

        return view('admin.dashboard', compact(
            'totalNasabah',
            'totalSaldoNasabah',
            'totalDropPoints',
            'totalDropPointsAktif',
            'totalPengeluaran',
            'totalPengumuman',
            'totalJenisResidu',
            'totalBeratResidu',
            'totalBiayaResidu',
            'totalUsers',
            'nasabahTerbaru',
            'residuTerbaru',
            'pengeluaranTerbaru',
            'pengumumanTerbaru'
        ));
    }
}
