<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\Nasabah;
use App\Models\Peserta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenyuluhanFeatureTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helper ────────────────────────────────────────────────────────────

    private function buatNasabah(array $override = []): Nasabah
    {
        return Nasabah::create(array_merge([
            'nama'    => 'Nasabah Uji ' . uniqid(),
            'nik'     => (string) rand(1000000000000000, 9999999999999999),
            'alamat'  => 'Jl. Uji No. 1',
            'no_hp'   => '081234567890',
            'rw'      => '01',
            'saldo'   => 0,
        ], $override));
    }

    private function buatKegiatan(array $override = []): Kegiatan
    {
        return Kegiatan::create(array_merge([
            'judul'   => 'Kegiatan Uji ' . uniqid(),
            'tanggal' => now()->addDays(7)->toDateString(),
            'lokasi'  => 'Lokasi Uji',
            'kuota'   => 10,
            'status'  => 'dijadwalkan',
        ], $override));
    }

    private function buatPeserta(Kegiatan $kegiatan, Nasabah $nasabah, array $override = []): Peserta
    {
        return Peserta::create(array_merge([
            'id_kegiatan' => $kegiatan->id,
            'id_nasabah'  => $nasabah->id,
            'hadir'       => false,
        ], $override));
    }

    // ─── Test 1: Daftar peserta saat kuota penuh ditolak ───────────────────
    public function test_daftar_peserta_saat_kuota_penuh_ditolak(): void
    {
        $kegiatan = $this->buatKegiatan(['kuota' => 2]);

        // Isi kuota penuh
        $n1 = $this->buatNasabah();
        $n2 = $this->buatNasabah();
        $this->buatPeserta($kegiatan, $n1);
        $this->buatPeserta($kegiatan, $n2);

        $nasahabBaru = $this->buatNasabah();

        $response = $this->post(route('peserta.store', $kegiatan), [
            'id_nasabah' => $nasahabBaru->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('peserta', [
            'id_kegiatan' => $kegiatan->id,
            'id_nasabah'  => $nasahabBaru->id,
        ]);
    }

    // ─── Test 2: Daftar nasabah yang sama dua kali ditolak ─────────────────
    public function test_daftar_nasabah_duplikat_ditolak(): void
    {
        $kegiatan = $this->buatKegiatan(['kuota' => 10]);
        $nasabah  = $this->buatNasabah();

        // Daftar pertama
        $this->buatPeserta($kegiatan, $nasabah);

        // Daftar kedua via HTTP
        $response = $this->post(route('peserta.store', $kegiatan), [
            'id_nasabah' => $nasabah->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('peserta', 1);
    }

    // ─── Test 3: Daftar peserta di kegiatan selesai ditolak ────────────────
    public function test_daftar_peserta_kegiatan_selesai_ditolak(): void
    {
        $kegiatan = $this->buatKegiatan(['status' => 'selesai', 'kuota' => 10]);
        $nasabah  = $this->buatNasabah();

        $response = $this->post(route('peserta.store', $kegiatan), [
            'id_nasabah' => $nasabah->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('peserta', [
            'id_kegiatan' => $kegiatan->id,
            'id_nasabah'  => $nasabah->id,
        ]);
    }

    // ─── Test 4: Daftar peserta di kegiatan dibatalkan ditolak ─────────────
    public function test_daftar_peserta_kegiatan_dibatalkan_ditolak(): void
    {
        $kegiatan = $this->buatKegiatan(['status' => 'dibatalkan', 'kuota' => 10]);
        $nasabah  = $this->buatNasabah();

        $response = $this->post(route('peserta.store', $kegiatan), [
            'id_nasabah' => $nasabah->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('peserta', [
            'id_kegiatan' => $kegiatan->id,
            'id_nasabah'  => $nasabah->id,
        ]);
    }

    // ─── Test 5: Kuota tidak boleh dikecilkan di bawah jumlah peserta ──────
    public function test_update_kuota_lebih_kecil_dari_peserta_ditolak(): void
    {
        $kegiatan = $this->buatKegiatan(['kuota' => 10]);
        $n1 = $this->buatNasabah();
        $n2 = $this->buatNasabah();
        $n3 = $this->buatNasabah();
        $this->buatPeserta($kegiatan, $n1);
        $this->buatPeserta($kegiatan, $n2);
        $this->buatPeserta($kegiatan, $n3);

        // Coba ubah kuota menjadi 2 (lebih kecil dari 3 peserta)
        $response = $this->put(route('kegiatan.update', $kegiatan), [
            'judul'   => $kegiatan->judul,
            'tanggal' => $kegiatan->tanggal->format('Y-m-d'),
            'lokasi'  => $kegiatan->lokasi,
            'kuota'   => 2,
            'status'  => $kegiatan->status,
        ]);

        $response->assertSessionHasErrors('kuota');
        $this->assertDatabaseHas('kegiatan', ['id' => $kegiatan->id, 'kuota' => 10]);
    }

    // ─── Test 6: Catat kehadiran – jumlah hadir berubah ───────────────────
    public function test_catat_kehadiran_mengubah_jumlah_hadir(): void
    {
        $kegiatan = $this->buatKegiatan();
        $nasabah  = $this->buatNasabah();
        $peserta  = $this->buatPeserta($kegiatan, $nasabah, ['hadir' => false]);

        $response = $this->patch(route('peserta.hadir', $peserta));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('peserta', ['id' => $peserta->id, 'hadir' => true]);

        // Jumlah hadir di kegiatan = 1
        $this->assertEquals(1, $kegiatan->peserta()->where('hadir', true)->count());
    }

    // ─── Test 7: Hapus kegiatan – peserta ikut terhapus ───────────────────
    public function test_hapus_kegiatan_menghapus_peserta(): void
    {
        $kegiatan = $this->buatKegiatan();
        $nasabah  = $this->buatNasabah();
        $peserta  = $this->buatPeserta($kegiatan, $nasabah);

        $response = $this->delete(route('kegiatan.destroy', $kegiatan));

        $response->assertRedirect(route('kegiatan.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('kegiatan', ['id' => $kegiatan->id]);
        $this->assertDatabaseMissing('peserta', ['id' => $peserta->id]);
    }

    // ─── Test 8: Keluarkan peserta – jumlah peserta berkurang ─────────────
    public function test_keluarkan_peserta_mengurangi_jumlah(): void
    {
        $kegiatan = $this->buatKegiatan();
        $n1 = $this->buatNasabah();
        $n2 = $this->buatNasabah();
        $p1 = $this->buatPeserta($kegiatan, $n1);
        $p2 = $this->buatPeserta($kegiatan, $n2);

        $jumlahAwal = $kegiatan->peserta()->count();
        $this->assertEquals(2, $jumlahAwal);

        $response = $this->delete(route('peserta.destroy', $p1));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('peserta', ['id' => $p1->id]);
        $this->assertEquals(1, $kegiatan->fresh()->peserta()->count());
    }

    // ─── Test 9: Tambah kegiatan valid berhasil ────────────────────────────
    public function test_tambah_kegiatan_valid_berhasil(): void
    {
        $response = $this->post(route('kegiatan.store'), [
            'judul'   => 'Penyuluhan Uji',
            'tanggal' => '2026-12-01',
            'lokasi'  => 'Balai Warga',
            'kuota'   => 20,
        ]);

        $response->assertRedirect(route('kegiatan.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('kegiatan', [
            'judul'  => 'Penyuluhan Uji',
            'status' => 'dijadwalkan',
        ]);
    }

    // ─── Test 10: Index kegiatan dapat diakses ─────────────────────────────
    public function test_index_kegiatan_dapat_diakses(): void
    {
        $this->buatKegiatan();
        $response = $this->get(route('kegiatan.index'));
        $response->assertOk();
        $response->assertViewIs('kegiatan.index');
    }
}
