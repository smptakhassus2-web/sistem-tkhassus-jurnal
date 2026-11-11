<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Ubah kolom 'name' menjadi 'nama'
            $table->renameColumn('name', 'nama');
            
            // 2. Tambah kolom 'role' (untuk membedakan admin/guru/kepsek/ortu)
            $table->enum('role', [
                'admin', 'kepsek', 'wakasek', 
                'wali_kelas', 'guru_mapel', 
                'pembina_ekstra', 'guru_tahfidz', 'ortu'
            ])->default('guru_mapel')->after('nama');
            
            // 3. Tambah kolom 'no_hp' (untuk tombol WA di War Room)
            $table->string('no_hp')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'no_hp']);
            $table->renameColumn('nama', 'name');
        });
    }
};