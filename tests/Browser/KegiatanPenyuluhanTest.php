<?php

namespace Tests\Browser;

use App\Models\Kegiatan;
use App\Models\Nasabah;
use App\Models\Peserta;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class KegiatanPenyuluhanTest extends DuskTestCase
{
    private function buatNasabah(): Nasabah
    {
        return Nasabah::create([
            'nama'   => 'Nasabah Dusk ' . uniqid(),
            'nik'    => (string) rand(1000000000000000, 9999999999999999),
            'alamat' => 'Jl. Merdeka No. 10',
            'no_hp'  => '081234567890',
            'rw'     => '03',
            'saldo'  => 0,
        ]);
    }

    /**
     * Test 1: Menampilkan halaman daftar kegiatan.
     */
    public function test_melihat_daftar_kegiatan(): void
    {
        Kegiatan::firstOrCreate(
            ['judul' => 'Sosialisasi Pemilahan Sampah Dusk'],
            [
                'tanggal' => now()->addDays(3)->format('Y-m-d'),
                'lokasi'  => 'Balai Warga RW 05',
                'kuota'   => 20,
                'status'  => 'dijadwalkan',
            ]
        );

        $this->browse(function (Browser $browser) {
            $browser->visit('/kegiatan')
                ->assertSee('Kegiatan Penyuluhan')
                ->assertSee('Tambah Kegiatan');
        });
    }

    /**
     * Test 2: Membuat kegiatan penyuluhan baru melalui form.
     */
    public function test_tambah_kegiatan_baru(): void
    {
        $judul = 'Workshop Kompos Dusk ' . uniqid();
        $tanggal = now()->addDays(5)->format('Y-m-d');

        $this->browse(function (Browser $browser) use ($judul, $tanggal) {
            $browser->visit('/kegiatan')
                ->clickLink('Tambah Kegiatan')
                ->assertPathIs('/kegiatan/create')
                ->type('judul', $judul)
                ->script("document.getElementById('tanggal').value = '{$tanggal}';");

            $browser->type('lokasi', 'Aula Serbaguna')
                ->type('kuota', '15')
                ->press('Simpan')
                ->waitForLocation('/kegiatan')
                ->assertSee('Kegiatan berhasil ditambahkan.')
                ->assertSee($judul);
        });
    }

    /**
     * Test 3: Halaman detail kegiatan dan pendaftaran peserta.
     */
    public function test_detail_kegiatan_dan_daftar_peserta(): void
    {
        $nasabah = $this->buatNasabah();

        $kegiatan = Kegiatan::create([
            'judul'   => 'Edukasi Daur Ulang Dusk ' . uniqid(),
            'tanggal' => now()->addDays(7)->format('Y-m-d'),
            'lokasi'  => 'Balai RT 01',
            'kuota'   => 5,
            'status'  => 'dijadwalkan',
        ]);

        $this->browse(function (Browser $browser) use ($kegiatan, $nasabah) {
            $browser->visit('/kegiatan/' . $kegiatan->id)
                ->assertSee($kegiatan->judul)
                ->assertSee('Daftar Peserta')
                ->select('id_nasabah', (string) $nasabah->id)
                ->press('Daftarkan')
                ->waitForText('Peserta berhasil didaftarkan.')
                ->assertSee($nasabah->nama);
        });
    }

    /**
     * Test 4: Catat kehadiran peserta di halaman detail kegiatan.
     */
    public function test_catat_kehadiran_peserta(): void
    {
        $nasabah = $this->buatNasabah();

        $kegiatan = Kegiatan::create([
            'judul'   => 'Pelatihan Bank Sampah Dusk ' . uniqid(),
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'lokasi'  => 'Gedung RW',
            'kuota'   => 10,
            'status'  => 'dijadwalkan',
        ]);

        Peserta::create([
            'id_kegiatan' => $kegiatan->id,
            'id_nasabah'  => $nasabah->id,
            'hadir'       => false,
        ]);

        $this->browse(function (Browser $browser) use ($kegiatan) {
            $browser->visit('/kegiatan/' . $kegiatan->id)
                ->assertSee('Belum Hadir')
                ->click('button[title="Tandai Hadir"]')
                ->waitForText('Status kehadiran peserta diubah menjadi "hadir".')
                ->assertSee('Hadir');
        });
    }

    /**
     * Test 5: Edit data kegiatan penyuluhan.
     */
    public function test_edit_kegiatan(): void
    {
        $kegiatan = Kegiatan::create([
            'judul'   => 'Kegiatan Lama Dusk ' . uniqid(),
            'tanggal' => now()->addDays(4)->format('Y-m-d'),
            'lokasi'  => 'Lokasi Lama',
            'kuota'   => 25,
            'status'  => 'dijadwalkan',
        ]);

        $judulBaru = 'Kegiatan Terupdate Dusk ' . uniqid();

        $this->browse(function (Browser $browser) use ($kegiatan, $judulBaru) {
            $browser->visit('/kegiatan/' . $kegiatan->id . '/edit')
                ->clear('judul')
                ->type('judul', $judulBaru)
                ->clear('lokasi')
                ->type('lokasi', 'Lokasi Baru')
                ->press('Perbarui')
                ->waitForLocation('/kegiatan')
                ->assertSee('Kegiatan berhasil diperbarui.')
                ->assertSee($judulBaru);
        });
    }
}
