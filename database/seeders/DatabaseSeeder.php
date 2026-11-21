<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            JenisResiduSeeder::class,
            ResiduSeeder::class,
            KegiatanSeeder::class,
            // TODO: tambahkan seeder anggota lain di sini
        ]);
    }
}
