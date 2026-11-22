<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);

            $table->foreignId('id_jenis')
                ->constrained('jenis_sampah')
                ->restrictOnDelete();

            $table->enum('tipe_bonus', ['persen', 'rupiah']);
            $table->decimal('nilai_bonus', 12, 2);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};