<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_siswa', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (akun wali)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Menghubungkan ke tabel siswas (data anak)
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            // Status hubungan (Ayah, Ibu, atau Wali lainnya)
            $table->enum('hubungan', ['Ayah', 'Ibu', 'Wali'])->default('Ayah');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('user_siswa');
    }
};