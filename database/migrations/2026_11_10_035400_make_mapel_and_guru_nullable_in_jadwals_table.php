<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('jadwals', function (Blueprint $table) {
            // Ubah mapel_id dan guru_id menjadi nullable untuk mendukung jadwal kokurikuler
            $table->foreignId('mapel_id')->nullable()->change();
            $table->foreignId('guru_id')->nullable()->change();
        });
    }

    public function down(): void {
        Schema::table('jadwals', function (Blueprint $table) {
            // Kembalikan ke kondisi semula jika di-rollback
            $table->foreignId('mapel_id')->nullable(false)->change();
            $table->foreignId('guru_id')->nullable(false)->change();
        });
    }
};