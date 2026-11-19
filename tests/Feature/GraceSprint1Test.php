<?php

namespace Tests\Feature;

use App\Models\Reward;
use App\Models\MetodePenarikan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GraceSprint1Test extends TestCase
{
    use RefreshDatabase;

    /**
     * P-11: C - Tambah reward (nama, poin/harga, stok)
     */
    public function test_p11_create_reward_berhasil()
    {
        $payload = [
            'nama_reward' => 'Totebag Daur Ulang Kanvas',
            'poin_harga' => 150,
            'stok' => 20,
            'deskripsi' => 'Tas ramah lingkungan dari daur ulang',
            'status_aktif' => true,
        ];

        $response = $this->post(route('admin.rewards.store'), $payload);

        $response->assertRedirect(route('admin.rewards.index'));
        $this->assertDatabaseHas('rewards', [
            'nama_reward' => 'Totebag Daur Ulang Kanvas',
            'poin_harga' => 150,
            'stok' => 20,
            'status_aktif' => true,
        ]);
    }

    /**
     * P-11: R - Daftar reward + stok
     */
    public function test_p11_read_daftar_reward()
    {
        $reward = Reward::create([
            'nama_reward' => 'Tumbler EcoBank',
            'poin_harga' => 250,
            'stok' => 15,
            'deskripsi' => 'Tumbler stainless',
            'status_aktif' => true,
        ]);

        $response = $this->get(route('admin.rewards.index'));

        $response->assertStatus(200);
        $response->assertSee('Tumbler EcoBank');
        $response->assertSee('250');
        $response->assertSee('15 unit');
    }

    /**
     * P-11: U - Ubah reward / tambah stok
     */
    public function test_p11_update_reward_dan_tambah_stok()
    {
        $reward = Reward::create([
            'nama_reward' => 'Komposter Mini',
            'poin_harga' => 500,
            'stok' => 5,
            'status_aktif' => true,
        ]);

        $updatePayload = [
            'nama_reward' => 'Komposter Mini Organik',
            'poin_harga' => 550,
            'stok' => 15, // Tambah stok dari 5 menjadi 15
            'deskripsi' => 'Pengolah sampah organik modern',
            'status_aktif' => true,
        ];

        $response = $this->put(route('admin.rewards.update', $reward), $updatePayload);

        $response->assertRedirect(route('admin.rewards.show', $reward));
        $this->assertDatabaseHas('rewards', [
            'id' => $reward->id,
            'nama_reward' => 'Komposter Mini Organik',
            'poin_harga' => 550,
            'stok' => 15,
        ]);
    }

    /**
     * P-11: D - Hapus reward
     */
    public function test_p11_delete_reward_berhasil()
    {
        $reward = Reward::create([
            'nama_reward' => 'Produk Dihapus',
            'poin_harga' => 100,
            'stok' => 2,
            'status_aktif' => true,
        ]);

        $response = $this->delete(route('admin.rewards.destroy', $reward));

        $response->assertRedirect(route('admin.rewards.index'));
        $this->assertDatabaseMissing('rewards', [
            'id' => $reward->id,
        ]);
    }

    /**
     * P-12: C - Tambah metode (tunai, transfer, e-wallet) + minimal tarik
     */
    public function test_p12_create_metode_penarikan_berhasil()
    {
        $payload = [
            'nama_metode' => 'Transfer Bank BCA',
            'kategori' => 'transfer',
            'minimal_tarik' => 25000,
            'deskripsi' => 'Pencairan ke rekening BCA',
            'status_aktif' => true,
        ];

        $response = $this->post(route('admin.metode-penarikan.store'), $payload);

        $response->assertRedirect(route('admin.metode-penarikan.index'));
        $this->assertDatabaseHas('metode_penarikans', [
            'nama_metode' => 'Transfer Bank BCA',
            'kategori' => 'transfer',
            'minimal_tarik' => 25000,
            'status_aktif' => true,
        ]);
    }

    /**
     * P-12: R - Daftar metode
     */
    public function test_p12_read_daftar_metode_penarikan()
    {
        MetodePenarikan::create([
            'nama_metode' => 'GoPay Dompet Digital',
            'kategori' => 'ewallet',
            'minimal_tarik' => 15000,
            'status_aktif' => true,
        ]);

        $response = $this->get(route('admin.metode-penarikan.index'));

        $response->assertStatus(200);
        $response->assertSee('GoPay Dompet Digital');
        $response->assertSee('E-Wallet');
        $response->assertSee('15.000');
    }

    /**
     * P-12: U - Ubah metode / aktif-nonaktif
     */
    public function test_p12_update_metode_dan_toggle_aktif_nonaktif()
    {
        $metode = MetodePenarikan::create([
            'nama_metode' => 'Tunai Kasir',
            'kategori' => 'tunai',
            'minimal_tarik' => 10000,
            'status_aktif' => true,
        ]);

        $updatePayload = [
            'nama_metode' => 'Tunai Kasir Drop Point Utama',
            'kategori' => 'tunai',
            'minimal_tarik' => 5000,
            'deskripsi' => 'Pengambilan tunai langsung',
            'status_aktif' => false, // Nonaktifkan
        ];

        $response = $this->put(route('admin.metode-penarikan.update', $metode), $updatePayload);

        $response->assertRedirect(route('admin.metode-penarikan.show', $metode));
        $this->assertDatabaseHas('metode_penarikans', [
            'id' => $metode->id,
            'nama_metode' => 'Tunai Kasir Drop Point Utama',
            'minimal_tarik' => 5000,
            'status_aktif' => false,
        ]);
    }

    /**
     * P-12: D - Hapus metode
     */
    public function test_p12_delete_metode_penarikan_berhasil()
    {
        $metode = MetodePenarikan::create([
            'nama_metode' => 'Metode Dihapus',
            'kategori' => 'tunai',
            'minimal_tarik' => 10000,
            'status_aktif' => true,
        ]);

        $response = $this->delete(route('admin.metode-penarikan.destroy', $metode));

        $response->assertRedirect(route('admin.metode-penarikan.index'));
        $this->assertDatabaseMissing('metode_penarikans', [
            'id' => $metode->id,
        ]);
    }
}
