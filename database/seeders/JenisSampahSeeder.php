<?php

namespace Database\Seeders;

use App\Models\JenisSampah;
use App\Models\RiwayatHarga;
use Illuminate\Database\Seeder;

class JenisSampahSeeder extends Seeder
{
    /** Data uji mengikuti mockup proposal (Daftar Harga Sampah). */
    public function run(): void
    {
        $data = [
            ['Plastik PET', 'Plastik', 4000],
            ['Kardus', 'Kertas', 2000],
            ['Kertas', 'Kertas', 1500],
            ['Aluminium', 'Logam', 15000],
            ['Besi', 'Logam', 3000],
            ['Kaca', 'Kaca', 500],
        ];

        foreach ($data as [$nama, $kategori, $harga]) {
            $jenis = JenisSampah::firstOrCreate(
                ['nama_jenis' => $nama],
                ['kategori' => $kategori, 'satuan' => 'kg', 'harga_per_kg' => $harga, 'status_aktif' => true]
            );

            if ($jenis->wasRecentlyCreated) {
                RiwayatHarga::create(['jenis_sampah_id' => $jenis->id, 'harga_lama' => null, 'harga_baru' => $harga]);
            }
        }
    }
}
