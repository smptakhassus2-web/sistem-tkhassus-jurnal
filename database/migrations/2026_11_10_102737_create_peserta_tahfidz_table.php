<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('peserta_tahfidz', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->timestamps();
            
            // Pastikan satu siswa tidak terinput dua kali
            $table->unique('siswa_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('peserta_tahfidz');
    }
};