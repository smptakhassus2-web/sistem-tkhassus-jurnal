<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Menambahkan 'wali_murid' ke dalam daftar nilai yang diizinkan pada kolom role
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kepsek', 'guru_mapel', 'guru_tahfidz', 'wali_murid') DEFAULT 'guru_mapel'");
    }

    public function down(): void {
        // Mengembalikan ke kondisi semula jika di-rollback
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'kepsek', 'guru_mapel', 'guru_tahfidz') DEFAULT 'guru_mapel'");
    }
};