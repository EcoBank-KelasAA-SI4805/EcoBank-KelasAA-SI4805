<?php

namespace Database\Seeders;

use App\Models\JenisResidu;
use Illuminate\Database\Seeder;

class JenisResiduSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama'            => 'Popok Bayi Bekas',
                'alasan'          => 'Mengandung limbah biologis dan material campuran yang tidak dapat dipisahkan sehingga tidak layak didaur ulang.',
                'cara_penanganan' => 'TPA',
                'biaya_per_kg'    => 1500.00,
            ],
            [
                'nama'            => 'Styrofoam Terkontaminasi',
                'alasan'          => 'Styrofoam yang telah terkontaminasi makanan sulit dibersihkan dan proses daur ulangnya tidak ekonomis.',
                'cara_penanganan' => 'insinerasi',
                'biaya_per_kg'    => 2500.00,
            ],
            [
                'nama'            => 'Kertas Karbon Bekas',
                'alasan'          => 'Mengandung tinta karbon yang bersifat kimia sehingga tidak dapat diproses ulang secara aman.',
                'cara_penanganan' => 'TPA',
                'biaya_per_kg'    => 1000.00,
            ],
            [
                'nama'            => 'Lampu Neon Rusak',
                'alasan'          => 'Mengandung merkuri yang berbahaya sehingga memerlukan penanganan khusus dan tidak bisa didaur ulang biasa.',
                'cara_penanganan' => 'lainnya',
                'biaya_per_kg'    => 5000.00,
            ],
            [
                'nama'            => 'Kantong Plastik Multilayer',
                'alasan'          => 'Terdiri dari beberapa lapisan plastik berbeda yang tidak dapat dipisahkan, sehingga tidak layak proses daur ulang.',
                'cara_penanganan' => 'insinerasi',
                'biaya_per_kg'    => 2000.00,
            ],
        ];

        foreach ($data as $item) {
            JenisResidu::firstOrCreate(['nama' => $item['nama']], $item);
        }
    }
}
