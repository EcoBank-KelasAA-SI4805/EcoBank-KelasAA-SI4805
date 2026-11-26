<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residu', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('id_jenis_residu')->constrained('jenis_residu')->restrictOnDelete();
            $table->decimal('berat_kg', 10, 2);
            $table->string('asal');
            $table->decimal('biaya_per_kg', 12, 2);
            $table->decimal('total_biaya', 12, 2);
            $table->enum('status', ['ditampung', 'diangkut', 'dibuang'])->default('ditampung');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residu');
    }
};
