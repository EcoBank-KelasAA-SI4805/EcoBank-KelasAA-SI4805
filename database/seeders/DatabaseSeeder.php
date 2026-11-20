<?php

namespace Database\Seeders;

use App\Models\DropPoint;
use App\Models\Jadwal;
use App\Models\Nasabah;
use App\Models\Pengeluaran;
use App\Models\Pengumuman;
use App\Models\Wilayah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Administrator
        Nasabah::firstOrCreate(
            ['email' => 'admin@ecobank.test'],
            [
                'nama' => 'Hasbi Admin',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'status' => 'Aktif',
            ]
        );

        // 2. Akun Petugas
        Nasabah::firstOrCreate(
            ['email' => 'petugas@ecobank.test'],
            [
                'nama' => 'Petugas Operasional',
                'password' => Hash::make('password'),
                'role' => 'Petugas',
                'status' => 'Aktif',
            ]
        );

        // 3. Data Nasabah
        Nasabah::firstOrCreate(
            ['email' => 'nasabah@ecobank.test'],
            [
                'nama' => 'Budi Nasabah',
                'password' => Hash::make('password'),
                'role' => 'Nasabah',
                'status' => 'Aktif',
                'nik' => '3201011204950001',
                'alamat' => 'Jl. Kenanga No. 14, RT 02 / RW 05',
                'no_hp' => '081234567890',
                'rw' => '05',
                'saldo' => 150000.00,
            ]
        );

        Nasabah::firstOrCreate(
            ['nik' => '3201015607980002'],
            [
                'nama' => 'Siti Aminah',
                'email' => 'siti@ecobank.test',
                'password' => Hash::make('password'),
                'role' => 'Nasabah',
                'status' => 'Aktif',
                'alamat' => 'Jl. Mawar No. 8, RT 01 / RW 03',
                'no_hp' => '082198765432',
                'rw' => '03',
                'saldo' => 275000.00,
            ]
        );

        Nasabah::firstOrCreate(
            ['nik' => '3201012301900003'],
            [
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad@ecobank.test',
                'password' => Hash::make('password'),
                'role' => 'Nasabah',
                'status' => 'Aktif',
                'alamat' => 'Jl. Melati No. 21, RT 04 / RW 02',
                'no_hp' => '085712349876',
                'rw' => '02',
                'saldo' => 85000.00,
            ]
        );

        // 4. Data Drop Points (P-02)
        if (DropPoint::count() === 0) {
            DropPoint::create([
                'nama' => 'Drop Point RW 01 (Balai Warga)',
                'alamat' => 'Balai Warga RW 01, Kompleks Asri Sejahtera',
                'jam_buka' => 'Senin - Sabtu (08:00 - 15:00)',
                'status_aktif' => true,
            ]);

            DropPoint::create([
                'nama' => 'Drop Point RW 03 (Kantor Kelurahan)',
                'alamat' => 'Halaman Samping Kantor Kelurahan',
                'jam_buka' => 'Setiap Hari (07:30 - 16:00)',
                'status_aktif' => true,
            ]);
        }

        // 5. Data Pengeluaran Operasional (P-13)
        if (Pengeluaran::count() === 0) {
            Pengeluaran::create([
                'tanggal' => now()->toDateString(),
                'kategori' => 'Operasional',
                'nominal' => 250000,
                'keterangan' => 'Pembelian karung penampungan dan timbangan gantung',
            ]);
        }

        // 6. Data Pengumuman Publik (P-14)
        if (Pengumuman::count() === 0) {
            Pengumuman::create([
                'judul' => 'Jadwal Penyetoran Sampah Anorganik Pekan Ini',
                'isi' => 'Diberitahukan kepada seluruh nasabah EcoBank bahwa jadwal penyetoran sampah daur ulang pekan ini dilayani di seluruh Drop Point RW mulai pukul 08:00 hingga 15:00 WIB.',
                'tanggal_tayang' => now()->toDateString(),
            ]);
        }

        // 7. Data Wilayah (P-10)
        $wilayah1 = Wilayah::firstOrCreate(
            ['nama_rw' => '05'],
            ['kelurahan' => 'Sukamaju']
        );
        $wilayah2 = Wilayah::firstOrCreate(
            ['nama_rw' => '03'],
            ['kelurahan' => 'Sukamaju']
        );
        $wilayah3 = Wilayah::firstOrCreate(
            ['nama_rw' => '02'],
            ['kelurahan' => 'Sukamaju']
        );

        // 8. Data Jadwal Pengumpulan (P-09)
        $petugas = Nasabah::where('role', 'Petugas')->first() ?? Nasabah::where('role', 'Admin')->first();
        if ($petugas && Jadwal::count() === 0) {
            Jadwal::create([
                'wilayah_id' => $wilayah1->id,
                'petugas_id' => $petugas->id,
                'tanggal' => now()->addDays(2)->toDateString(),
                'jam' => '08:30',
            ]);
            Jadwal::create([
                'wilayah_id' => $wilayah2->id,
                'petugas_id' => $petugas->id,
                'tanggal' => now()->addDays(4)->toDateString(),
                'jam' => '09:00',
            ]);
        }
    }
}
