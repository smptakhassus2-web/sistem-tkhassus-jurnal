<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan nilai 'Apel', 'Tahfidz', 'Ziarah', 'BTQ' ke enum yang sudah ada
        DB::statement("ALTER TABLE `absensi_7kaih` MODIFY `jenis_kegiatan` ENUM('Upacara','Sholat_Dhuha','Senam','Ziarah_BTQ','Sholat_Dzuhur','Refleksi','Apel','Tahfidz','Ziarah','BTQ') NOT NULL");
    }

    public function down(): void
    {
        // Rollback: Mengembalikan ke kondisi semula jika terjadi masalah
        DB::statement("ALTER TABLE `absensi_7kaih` MODIFY `jenis_kegiatan` ENUM('Upacara','Sholat_Dhuha','Senam','Ziarah_BTQ','Sholat_Dzuhur','Refleksi') NOT NULL");
    }
};