<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tabel Kelompok BTQ (Per Pembina)
        Schema::create('kelompok_btq', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok'); // Contoh: "Kelompok Bu Malisa"
            $table->foreignId('pembina_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // Tabel Anggota Kelompok BTQ (Mapping Siswa ke Kelompok)
        Schema::create('anggota_kelompok_btq', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_btq_id')->constrained('kelompok_btq')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->timestamps();
            
            // Pastikan satu siswa hanya ada di 1 kelompok BTQ
            $table->unique('siswa_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('anggota_kelompok_btq');
        Schema::dropIfExists('kelompok_btq');
    }
};