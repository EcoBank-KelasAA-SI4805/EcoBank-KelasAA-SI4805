<?php

namespace Tests\Feature;

use App\Models\JenisResidu;
use App\Models\Residu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResiduFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function buatJenis(array $override = []): JenisResidu
    {
        return JenisResidu::create(array_merge([
            'nama'            => 'Jenis Uji ' . uniqid(),
            'alasan'          => 'Alasan pengujian',
            'cara_penanganan' => 'TPA',
            'biaya_per_kg'    => 2000.00,
        ], $override));
    }

    private function buatResidu(JenisResidu $jenis, array $override = []): Residu
    {
        $berat = $override['berat_kg'] ?? 10.0;
        $biaya = $jenis->biaya_per_kg;
        return Residu::create(array_merge([
            'tanggal'         => now()->toDateString(),
            'id_jenis_residu' => $jenis->id,
            'berat_kg'        => $berat,
            'asal'            => 'Lokasi Uji',
            'biaya_per_kg'    => $biaya,
            'total_biaya'     => Residu::hitungTotalBiaya((float)$berat, (float)$biaya),
            'status'          => 'ditampung',
        ], $override));
    }

    // ─── JenisResidu Tests ──────────────────────────────────────────────────

    // Test 1: Hapus jenis residu yang sudah dipakai ditolak
    public function test_hapus_jenis_residu_yang_dipakai_ditolak(): void
    {
        $jenis = $this->buatJenis();
        $this->buatResidu($jenis);

        $response = $this->delete(route('jenis-residu.destroy', $jenis));

        $response->assertRedirect(route('jenis-residu.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('jenis_residu', ['id' => $jenis->id]);
    }

    // Test 2: Hapus jenis residu yang belum dipakai berhasil
    public function test_hapus_jenis_residu_yang_belum_dipakai_berhasil(): void
    {
        $jenis = $this->buatJenis();

        $response = $this->delete(route('jenis-residu.destroy', $jenis));

        $response->assertRedirect(route('jenis-residu.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('jenis_residu', ['id' => $jenis->id]);
    }

    // Test 3: Tambah jenis residu dengan data valid berhasil
    public function test_tambah_jenis_residu_valid_berhasil(): void
    {
        $data = [
            'nama'            => 'Plastik Campuran',
            'alasan'          => 'Tidak dapat dipisahkan jenisnya',
            'cara_penanganan' => 'insinerasi',
            'biaya_per_kg'    => 3000,
        ];

        $response = $this->post(route('jenis-residu.store'), $data);

        $response->assertRedirect(route('jenis-residu.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('jenis_residu', ['nama' => 'Plastik Campuran']);
    }

    // Test 4: Tambah jenis residu dengan nama duplikat ditolak
    public function test_tambah_jenis_residu_duplikat_ditolak(): void
    {
        $this->buatJenis(['nama' => 'Popok Bekas']);

        $response = $this->post(route('jenis-residu.store'), [
            'nama'            => 'Popok Bekas',
            'alasan'          => 'Duplikat',
            'cara_penanganan' => 'TPA',
            'biaya_per_kg'    => 1500,
        ]);

        $response->assertSessionHasErrors('nama');
    }

    // Test 5: Edit jenis residu berhasil
    public function test_edit_jenis_residu_berhasil(): void
    {
        $jenis = $this->buatJenis(['nama' => 'Jenis Lama']);

        $response = $this->put(route('jenis-residu.update', $jenis), [
            'nama'            => 'Jenis Baru',
            'alasan'          => 'Alasan baru',
            'cara_penanganan' => 'lainnya',
            'biaya_per_kg'    => 9999,
        ]);

        $response->assertRedirect(route('jenis-residu.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('jenis_residu', ['id' => $jenis->id, 'nama' => 'Jenis Baru']);
    }

    // Test 6: Index jenis residu dapat diakses
    public function test_index_jenis_residu_dapat_diakses(): void
    {
        $this->buatJenis();
        $response = $this->get(route('jenis-residu.index'));
        $response->assertOk();
        $response->assertViewIs('jenis_residu.index');
    }

    // ─── Residu Tests ───────────────────────────────────────────────────────

    // Test 7: Catat residu baru berhasil dan total biaya dihitung otomatis
    public function test_catat_residu_baru_berhasil(): void
    {
        $jenis = $this->buatJenis(['biaya_per_kg' => 2000]);

        $response = $this->post(route('residu.store'), [
            'tanggal'         => '2026-11-01',
            'id_jenis_residu' => $jenis->id,
            'berat_kg'        => 5.0,
            'asal'            => 'RT 02',
        ]);

        $response->assertRedirect(route('residu.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('residu', [
            'id_jenis_residu' => $jenis->id,
            'berat_kg'        => 5.0,
            'biaya_per_kg'    => 2000,
            'total_biaya'     => 10000,
            'status'          => 'ditampung',
        ]);
    }

    // Test 8: Hapus residu berstatus "ditampung" berhasil
    public function test_hapus_residu_ditampung_berhasil(): void
    {
        $jenis  = $this->buatJenis();
        $residu = $this->buatResidu($jenis, ['status' => 'ditampung']);

        $response = $this->delete(route('residu.destroy', $residu));

        $response->assertRedirect(route('residu.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('residu', ['id' => $residu->id]);
    }

    // Test 9: Hapus residu berstatus "diangkut" ditolak
    public function test_hapus_residu_diangkut_ditolak(): void
    {
        $jenis  = $this->buatJenis();
        $residu = $this->buatResidu($jenis, ['status' => 'diangkut']);

        $response = $this->delete(route('residu.destroy', $residu));

        $response->assertRedirect(route('residu.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('residu', ['id' => $residu->id]);
    }

    // Test 10: Hapus residu berstatus "dibuang" ditolak
    public function test_hapus_residu_dibuang_ditolak(): void
    {
        $jenis  = $this->buatJenis();
        $residu = $this->buatResidu($jenis, ['status' => 'dibuang']);

        $response = $this->delete(route('residu.destroy', $residu));

        $response->assertRedirect(route('residu.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('residu', ['id' => $residu->id]);
    }

    // Test 11: Edit residu berhasil dengan recalculate total_biaya
    public function test_edit_residu_berhasil_dengan_recalculate(): void
    {
        $jenis  = $this->buatJenis(['biaya_per_kg' => 2000]);
        $residu = $this->buatResidu($jenis, ['berat_kg' => 5.0]);

        $response = $this->put(route('residu.update', $residu), [
            'tanggal'         => '2026-11-15',
            'id_jenis_residu' => $jenis->id,
            'berat_kg'        => 10.0,
            'asal'            => 'Lokasi Baru',
            'status'          => 'diangkut',
        ]);

        $response->assertRedirect(route('residu.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('residu', [
            'id'          => $residu->id,
            'berat_kg'    => 10.0,
            'total_biaya' => 20000,
            'status'      => 'diangkut',
        ]);
    }

    // Test 12: Index residu dapat diakses
    public function test_index_residu_dapat_diakses(): void
    {
        $jenis = $this->buatJenis();
        $this->buatResidu($jenis);

        $response = $this->get(route('residu.index'));
        $response->assertOk();
        $response->assertViewIs('residu.index');
    }

    // Test 13: Validasi berat_kg minimal 0.01
    public function test_validasi_berat_minimal(): void
    {
        $jenis = $this->buatJenis();

        $response = $this->post(route('residu.store'), [
            'tanggal'         => '2026-11-01',
            'id_jenis_residu' => $jenis->id,
            'berat_kg'        => 0,
            'asal'            => 'RT 01',
        ]);

        $response->assertSessionHasErrors('berat_kg');
    }

    // Test 14: Filter residu berdasarkan tanggal
    public function test_filter_residu_berdasarkan_tanggal(): void
    {
        $jenis = $this->buatJenis();
        $this->buatResidu($jenis, ['tanggal' => '2026-11-01']);
        $this->buatResidu($jenis, ['tanggal' => '2026-11-15']);

        $response = $this->get(route('residu.index', [
            'dari'   => '2026-11-10',
            'sampai' => '2026-11-20',
        ]));

        $response->assertOk();
        $response->assertViewHas('residu');
    }

    // Test 15: hitungTotalBiaya static method benar
    public function test_hitung_total_biaya_static(): void
    {
        $result = Residu::hitungTotalBiaya(10.0, 2000.0);
        $this->assertEquals(20000.0, $result);

        $result2 = Residu::hitungTotalBiaya(1.5, 1333.33);
        $this->assertEquals(1999.995, round(1.5 * 1333.33, 3));
    }
}
