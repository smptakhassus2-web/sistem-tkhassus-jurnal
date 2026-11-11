<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kepsek', 'guru_mapel', 'guru_tahfidz', 'wali_murid', 'wali_kelas', 'waka_kesiswaan') DEFAULT 'guru_mapel'");
    }

    public function down(): void {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kepsek', 'guru_mapel', 'guru_tahfidz', 'wali_murid') DEFAULT 'guru_mapel'");
    }
};