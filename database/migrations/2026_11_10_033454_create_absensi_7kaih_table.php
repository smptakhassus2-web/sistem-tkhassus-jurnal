<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('absensi_7kaih', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis_kegiatan', ['Upacara', 'Sholat_Dhuha', 'Senam', 'Ziarah_BTQ', 'Sholat_Dzuhur', 'Refleksi']);
            $table->foreignId('rombel_id')->constrained('rombels')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpha']);
            $table->foreignId('input_oleh')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('otoritas_level')->comment('1=Piket, 2=Guru_Mapel, 3=Wali_Kelas, 4=Waka, 5=Admin');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            // Index untuk mempercepat query
            $table->index(['tanggal', 'jenis_kegiatan', 'rombel_id']);
            $table->index(['siswa_id', 'tanggal']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('absensi_7kaih');
    }
};