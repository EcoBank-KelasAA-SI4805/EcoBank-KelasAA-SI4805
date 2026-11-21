<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_residu', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->text('alasan');
            $table->enum('cara_penanganan', ['TPA', 'insinerasi', 'lainnya']);
            $table->decimal('biaya_per_kg', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_residu');
    }
};
