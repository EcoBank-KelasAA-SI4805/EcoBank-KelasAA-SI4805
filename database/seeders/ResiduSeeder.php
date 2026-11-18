<?php

namespace Database\Seeders;

use App\Models\JenisResidu;
use App\Models\Residu;
use Illuminate\Database\Seeder;

class ResiduSeeder extends Seeder
{
    public function run(): void
    {
        $jenis = JenisResidu::all()->keyBy('nama');

        if ($jenis->isEmpty()) {
            return;
        }

        $contoh = [
            [
                'tanggal'         => '2026-11-01',
                'id_jenis_residu' => $jenis->first()->id,
                'berat_kg'        => 10.5,
                'asal'            => 'RT 01 Kelurahan Sukamaju',
                'status'          => 'ditampung',
            ],
            [
                'tanggal'         => '2026-11-05',
                'id_jenis_residu' => $jenis->skip(1)->first()->id,
                'berat_kg'        => 25.0,
                'asal'            => 'Pasar Baru Blok C',
                'status'          => 'diangkut',
            ],
            [
                'tanggal'         => '2026-11-10',
                'id_jenis_residu' => $jenis->skip(2)->first()->id,
                'berat_kg'        => 7.8,
                'asal'            => 'Kantor Kecamatan',
                'status'          => 'dibuang',
            ],
        ];

        foreach ($contoh as $item) {
            $jenisObj = JenisResidu::find($item['id_jenis_residu']);
            if (!$jenisObj) continue;

            $biayaPerKg = $jenisObj->biaya_per_kg;
            Residu::firstOrCreate(
                ['tanggal' => $item['tanggal'], 'id_jenis_residu' => $item['id_jenis_residu']],
                array_merge($item, [
                    'biaya_per_kg' => $biayaPerKg,
                    'total_biaya'  => round($item['berat_kg'] * $biayaPerKg, 2),
                ])
            );
        }
    }
}
