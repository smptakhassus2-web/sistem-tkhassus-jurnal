<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('siswas', function (Blueprint $table) {
            // Menambahkan kolom baru (urutan otomatis di paling belakang tabel)
            $table->string('nipd')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('dusun')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
        });
    }

    public function down(): void {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['nipd', 'tempat_lahir', 'tanggal_lahir', 'rt', 'rw', 'dusun', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos']);
        });
    }
};