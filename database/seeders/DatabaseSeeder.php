<?php

namespace Database\Seeders;

use App\Models\DropPoint;
use App\Models\MetodePenarikan;
use App\Models\Nasabah;
use App\Models\Reward;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder P-01: Nasabah
        Nasabah::create([
            'nama' => 'Siti Rahmawati',
            'nik' => '3273012345670001',
            'alamat' => 'Jl. Melati No. 12, RW 05',
            'no_hp' => '081234567890',
            'rw' => 'RW 05',
            'saldo' => 245000,
        ]);

        Nasabah::create([
            'nama' => 'Ahmad Fauzi',
            'nik' => '3273012345670002',
            'alamat' => 'Jl. Mawar No. 8, RW 05',
            'no_hp' => '081298765432',
            'rw' => 'RW 05',
            'saldo' => 180000,
        ]);

        // Seeder P-02: Drop Point
        DropPoint::create([
            'nama' => 'Drop Point RW 05 - Pos Melati',
            'alamat' => 'Jl. Melati No. 1, Balai Warga RW 05',
            'jam_buka' => 'Senin - Sabtu, 08.00 - 15.00 WIB',
            'status_aktif' => true,
        ]);

        // Seeder P-11: Reward (Gracia Gebriella Sianturi)
        Reward::create([
            'nama_reward' => 'Totebag Daur Ulang Eco',
            'poin_harga' => 150,
            'stok' => 25,
            'deskripsi' => 'Tas belanja ramah lingkungan hasil daur ulang plastik kemasan.',
            'status_aktif' => true,
        ]);

        Reward::create([
            'nama_reward' => 'Tumbler Stainless EcoBank',
            'poin_harga' => 350,
            'stok' => 15,
            'deskripsi' => 'Tumbler insulasi menjaga minuman panas/dingin hingga 12 jam.',
            'status_aktif' => true,
        ]);

        Reward::create([
            'nama_reward' => 'Sabun Cuci Piring Minyak Jelantah',
            'poin_harga' => 50,
            'stok' => 40,
            'deskripsi' => 'Sabun ramah lingkungan hasil olahan limbah minyak jelantah terverifikasi.',
            'status_aktif' => true,
        ]);

        Reward::create([
            'nama_reward' => 'Komposter Mini Rumah Tangga',
            'poin_harga' => 700,
            'stok' => 5,
            'deskripsi' => 'Alat pengolah sampah organik rumah tangga menjadi pupuk kompos cair & padat.',
            'status_aktif' => true,
        ]);

        // Seeder P-12: Metode Penarikan (Gracia Gebriella Sianturi)
        MetodePenarikan::create([
            'nama_metode' => 'Tunai Kasir Drop Point',
            'kategori' => 'tunai',
            'minimal_tarik' => 10000,
            'deskripsi' => 'Pengambilan uang tunai langsung di meja loket drop point pada jam operasional.',
            'status_aktif' => true,
        ]);

        MetodePenarikan::create([
            'nama_metode' => 'Transfer Bank BCA',
            'kategori' => 'transfer',
            'minimal_tarik' => 25000,
            'deskripsi' => 'Pencairan saldo ke rekening Bank Central Asia (BCA). Estimasi 1x24 jam kerja.',
            'status_aktif' => true,
        ]);

        MetodePenarikan::create([
            'nama_metode' => 'Transfer Bank Mandiri',
            'kategori' => 'transfer',
            'minimal_tarik' => 25000,
            'deskripsi' => 'Pencairan saldo ke rekening Bank Mandiri.',
            'status_aktif' => true,
        ]);

        MetodePenarikan::create([
            'nama_metode' => 'GoPay / OVO / Dana',
            'kategori' => 'ewallet',
            'minimal_tarik' => 15000,
            'deskripsi' => 'Pencairan saldo langsung ke saldo dompet digital nasabah.',
            'status_aktif' => true,
        ]);
    }
}
