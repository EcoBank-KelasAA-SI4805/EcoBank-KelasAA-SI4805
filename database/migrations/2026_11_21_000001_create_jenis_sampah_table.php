<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // P-03: katalog jenis sampah (FR-07) + harga per kg (FR-08)
        Schema::create('jenis_sampah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis', 100)->unique();
            $table->string('kategori', 50);
            $table->string('satuan', 20)->default('kg');
            $table->decimal('harga_per_kg', 12, 2);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });

        // Riwayat perubahan harga (UC-11 langkah 10)
        Schema::create('riwayat_harga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah')->cascadeOnDelete();
            $table->decimal('harga_lama', 12, 2)->nullable(); // null = harga awal
            $table->decimal('harga_baru', 12, 2);
            // Belum pakai foreign key ke users karena tabel users belum ada di repo.
            $table->unsignedBigInteger('diubah_oleh')->nullable();
            $table->timestamp('diubah_pada')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_harga');
        Schema::dropIfExists('jenis_sampah');
    }
};
