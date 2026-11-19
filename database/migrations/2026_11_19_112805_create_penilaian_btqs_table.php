<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_btqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_btq_id')->constrained('kelompok_btq')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('pembina_id')->constrained('users')->cascadeOnDelete();
            $table->string('jilid')->nullable();
            $table->integer('halaman')->nullable();
            $table->integer('juz')->nullable();
            $table->string('surat')->nullable();
            $table->integer('ayat_awal')->nullable();
            $table->integer('ayat_akhir')->nullable();
            $table->enum('nilai', ['Lancar', 'Baik', 'Cukup', 'Kurang']);
            $table->text('catatan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_btqs');
    }
};