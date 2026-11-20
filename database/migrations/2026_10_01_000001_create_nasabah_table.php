<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nasabah', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 100)->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('role', 30)->default('Nasabah'); // Admin, Petugas, Nasabah
            $table->string('status', 30)->default('Aktif'); // Aktif, Nonaktif
            $table->string('nik', 16)->nullable()->unique();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('rw', 10)->nullable();
            $table->decimal('saldo', 12, 2)->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nasabah');
    }
};
