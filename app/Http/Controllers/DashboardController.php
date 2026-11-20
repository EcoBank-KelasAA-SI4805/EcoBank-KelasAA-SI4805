<?php

namespace App\Http\Controllers;

use App\Models\DropPoint;
use App\Models\Nasabah;
use App\Models\Pengeluaran;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama dashboard dengan metrik terintegrasi dari seluruh modul.
     */
    public function index()
    {
        $totalNasabah = Nasabah::where('role', 'Nasabah')->count();
        $totalSaldoNasabah = Nasabah::where('role', 'Nasabah')->sum('saldo');
        $totalDropPoints = DropPoint::count();
        $totalDropPointsAktif = DropPoint::where('status_aktif', true)->count();
        $totalPengeluaran = Pengeluaran::sum('nominal');
        $totalPengumuman = Pengumuman::count();

        // 5 Data Nasabah Terbaru
        $nasabahTerbaru = Nasabah::where('role', 'Nasabah')->latest('id')->take(5)->get();

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
            'nasabahTerbaru',
            'pengeluaranTerbaru',
            'pengumumanTerbaru'
        ));
    }
}
