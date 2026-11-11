<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_piket', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('urutan')->comment('1, 2, atau 3 (urutan piket)');
            $table->timestamps();
            
            $table->unique(['hari', 'urutan']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('jadwal_piket');
    }
};