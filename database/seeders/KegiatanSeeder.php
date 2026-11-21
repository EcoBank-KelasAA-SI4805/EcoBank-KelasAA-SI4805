<?php

namespace Database\Seeders;

use App\Models\Kegiatan;
use App\Models\Nasabah;
use App\Models\Peserta;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $kegiatan = [
            [
                'judul'   => 'Penyuluhan Pemilahan Sampah Organik & Anorganik',
                'tanggal' => '2026-11-20',
                'lokasi'  => 'Balai Warga RW 03, Kelurahan Sukamaju',
                'kuota'   => 30,
                'status'  => 'dijadwalkan',
            ],
            [
                'judul'   => 'Sosialisasi Bank Sampah Digital EcoBank',
                'tanggal' => '2026-11-10',
                'lokasi'  => 'Aula Kelurahan Bahagia',
                'kuota'   => 50,
                'status'  => 'selesai',
            ],
            [
                'judul'   => 'Pelatihan Daur Ulang Sampah Plastik',
                'tanggal' => '2026-10-25',
                'lokasi'  => 'Gedung Serbaguna RT 07',
                'kuota'   => 20,
                'status'  => 'dibatalkan',
            ],
            [
                'judul'   => 'Workshop Pengomposan Sampah Rumah Tangga',
                'tanggal' => '2026-12-05',
                'lokasi'  => 'Taman Edukasi Lingkungan RT 02',
                'kuota'   => 25,
                'status'  => 'dijadwalkan',
            ],
        ];

        foreach ($kegiatan as $data) {
            Kegiatan::firstOrCreate(['judul' => $data['judul']], $data);
        }

        // Tambahkan peserta dari data nasabah yang ada
        $nasabahList = Nasabah::orderBy('id')->take(5)->get();

        if ($nasabahList->isEmpty()) {
            // Tidak ada nasabah – lewati bagian peserta
            // CATATAN: Jalankan seeder nasabah terlebih dahulu agar peserta dapat dibuat.
            return;
        }

        // Kegiatan pertama (dijadwalkan) – tambah beberapa peserta
        $k1 = Kegiatan::where('judul', 'Penyuluhan Pemilahan Sampah Organik & Anorganik')->first();
        if ($k1) {
            foreach ($nasabahList->take(3) as $nasabah) {
                Peserta::firstOrCreate(
                    ['id_kegiatan' => $k1->id, 'id_nasabah' => $nasabah->id],
                    ['hadir' => false]
                );
            }
        }

        // Kegiatan kedua (selesai) – semua hadir
        $k2 = Kegiatan::where('judul', 'Sosialisasi Bank Sampah Digital EcoBank')->first();
        if ($k2) {
            foreach ($nasabahList as $nasabah) {
                Peserta::firstOrCreate(
                    ['id_kegiatan' => $k2->id, 'id_nasabah' => $nasabah->id],
                    ['hadir' => true]
                );
            }
        }
    }
}
