<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->integer('juz');
            $table->string('surat');
            $table->integer('ayat_awal');
            $table->integer('ayat_akhir');
            $table->enum('nilai', ['Lancar', 'Baik', 'Cukup', 'Kurang']);
            $table->date('tanggal');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('tahfidzs');
    }
};