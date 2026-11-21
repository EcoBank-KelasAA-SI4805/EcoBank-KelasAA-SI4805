<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kegiatan')->constrained('kegiatan')->cascadeOnDelete();
            $table->foreignId('id_nasabah')->constrained('nasabah')->restrictOnDelete();
            $table->boolean('hadir')->default(false);
            $table->timestamps();

            $table->unique(['id_kegiatan', 'id_nasabah']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
