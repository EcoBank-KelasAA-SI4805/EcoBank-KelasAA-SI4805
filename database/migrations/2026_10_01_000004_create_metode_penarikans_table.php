<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * P-12: CRUD Metode Penarikan (Gracia Gebriella Sianturi)
     */
    public function up(): void
    {
        Schema::create('metode_penarikans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_metode', 100);
            $table->string('kategori', 50)->comment('tunai, transfer, ewallet');
            $table->decimal('minimal_tarik', 12, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_penarikans');
    }
};
