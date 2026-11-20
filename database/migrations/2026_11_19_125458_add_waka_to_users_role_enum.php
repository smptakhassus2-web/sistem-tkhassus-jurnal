<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan 'waka' ke dalam daftar role yang diizinkan
        // Daftar ini mencakup semua role yang sudah kita bangun selama ini
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin', 'kepsek', 'guru_mapel', 'guru_tahfidz', 'wali_murid', 'wali_kelas', 'waka_kesiswaan', 'waka') NOT NULL DEFAULT 'guru_mapel'");
    }

    public function down(): void
    {
        // Rollback: Mengembalikan ke kondisi semula jika terjadi masalah
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin', 'kepsek', 'guru_mapel', 'guru_tahfidz', 'wali_murid', 'wali_kelas', 'waka_kesiswaan') NOT NULL DEFAULT 'guru_mapel'");
    }
};