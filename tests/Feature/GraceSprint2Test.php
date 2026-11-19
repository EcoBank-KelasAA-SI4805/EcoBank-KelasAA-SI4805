<?php

namespace Tests\Feature;

use App\Models\MetodePenarikan;
use App\Models\Nasabah;
use App\Models\PenarikanSaldo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * GraceSprint2Test – P-16 CRUD Penarikan Saldo
 * Gracia Gebriella Sianturi – 102022400331
 */
class GraceSprint2Test extends TestCase
{
    use RefreshDatabase;

    private Nasabah $nasabah;
    private MetodePenarikan $metode;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nasabah = Nasabah::create([
            'nama'  => 'Budi Santoso',
            'nik'   => '3201010101010001',
            'alamat'=> 'Jl. Merdeka No.1',
            'no_hp' => '081234567890',
            'rw'    => '001',
            'saldo' => 500000,
        ]);

        $this->metode = MetodePenarikan::create([
            'nama_metode'  => 'Transfer Bank BCA',
            'kategori'     => 'transfer',
            'minimal_tarik'=> 50000,
            'status_aktif' => true,
        ]);
    }

    // C: Nasabah ajukan penarikan berhasil
    public function test_p16_ajukan_penarikan_berhasil(): void
    {
        $response = $this->post(route('admin.penarikan-saldo.store'), [
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 100000,
            'catatan'             => 'Penarikan untuk kebutuhan bulanan',
        ]);

        $response->assertRedirect(route('admin.penarikan-saldo.index'));
        $this->assertDatabaseHas('penarikan_saldo', [
            'nasabah_id' => $this->nasabah->id,
            'jumlah'     => 100000,
            'status'     => 'diajukan',
        ]);
    }

    // C: Gagal jika saldo tidak cukup
    public function test_p16_ajukan_gagal_saldo_tidak_cukup(): void
    {
        $response = $this->post(route('admin.penarikan-saldo.store'), [
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 999999,
        ]);

        $response->assertSessionHasErrors('jumlah');
        $this->assertDatabaseMissing('penarikan_saldo', ['nasabah_id' => $this->nasabah->id]);
    }

    // C: Gagal jika di bawah minimal penarikan
    public function test_p16_ajukan_gagal_dibawah_minimal(): void
    {
        $response = $this->post(route('admin.penarikan-saldo.store'), [
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 10000, // minimal 50000
        ]);

        $response->assertSessionHasErrors('jumlah');
    }

    // R: Daftar penarikan tampil
    public function test_p16_read_daftar_penarikan(): void
    {
        PenarikanSaldo::create([
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 100000,
            'status'              => 'diajukan',
        ]);

        $response = $this->get(route('admin.penarikan-saldo.index'));
        $response->assertOk();
        $response->assertSee('Budi Santoso');
    }

    // R: Filter daftar berdasarkan status
    public function test_p16_read_filter_status(): void
    {
        PenarikanSaldo::create([
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 100000,
            'status'              => 'disetujui',
        ]);

        $response = $this->get(route('admin.penarikan-saldo.index', ['status' => 'disetujui']));
        $response->assertOk();
        $response->assertSee('Budi Santoso');
    }

    // U: Petugas ubah status ke selesai → saldo nasabah berkurang
    public function test_p16_update_status_selesai_saldo_berkurang(): void
    {
        $penarikan = PenarikanSaldo::create([
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 100000,
            'status'              => 'diajukan',
        ]);

        $response = $this->put(route('admin.penarikan-saldo.update', $penarikan), [
            'status'  => 'selesai',
            'catatan' => 'Sudah ditransfer',
        ]);

        $response->assertRedirect(route('admin.penarikan-saldo.show', $penarikan));
        $this->assertEquals('selesai', $penarikan->fresh()->status);
        $this->assertEquals(400000, $this->nasabah->fresh()->saldo); // 500000 - 100000
    }

    // U: Ubah status ke ditolak (saldo tidak berubah)
    public function test_p16_update_status_ditolak_saldo_tidak_berubah(): void
    {
        $penarikan = PenarikanSaldo::create([
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 100000,
            'status'              => 'diajukan',
        ]);

        $this->put(route('admin.penarikan-saldo.update', $penarikan), [
            'status'  => 'ditolak',
            'catatan' => 'Data tidak valid',
        ]);

        $this->assertEquals('ditolak', $penarikan->fresh()->status);
        $this->assertEquals(500000, $this->nasabah->fresh()->saldo); // saldo tidak berubah
    }

    // D: Batalkan pengajuan (status diajukan)
    public function test_p16_batalkan_pengajuan_berhasil(): void
    {
        $penarikan = PenarikanSaldo::create([
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 100000,
            'status'              => 'diajukan',
        ]);

        $response = $this->delete(route('admin.penarikan-saldo.destroy', $penarikan));

        $response->assertRedirect(route('admin.penarikan-saldo.index'));
        $this->assertDatabaseMissing('penarikan_saldo', ['id' => $penarikan->id]);
    }

    // D: Gagal batalkan jika status bukan diajukan
    public function test_p16_batalkan_gagal_status_bukan_diajukan(): void
    {
        $penarikan = PenarikanSaldo::create([
            'nasabah_id'          => $this->nasabah->id,
            'metode_penarikan_id' => $this->metode->id,
            'jumlah'              => 100000,
            'status'              => 'selesai',
        ]);

        $this->delete(route('admin.penarikan-saldo.destroy', $penarikan));

        $this->assertDatabaseHas('penarikan_saldo', ['id' => $penarikan->id]); // masih ada
    }
}
