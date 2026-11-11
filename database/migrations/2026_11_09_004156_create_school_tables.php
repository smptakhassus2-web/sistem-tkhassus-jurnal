<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL ROMBELS (Kelas Utama & Tambahan)
        Schema::create('rombels', function (Blueprint $table) {
            $table->id();
            $table->string('kode'); // Misal: '7A', 'TAHFIDZ-A'
            $table->string('nama'); // Misal: 'Kelas 7A', 'Kelompok Tahfidz A'
            $table->integer('tingkat'); // 7, 8, atau 9
            $table->enum('jenis', ['utama', 'tambahan']); 
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tahun_ajaran')->default('2026/2027');
            $table->timestamps();
        });

        // 2. TABEL SISWAS
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('nisn')->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_hp_ortu')->nullable();
            $table->string('nama_ortu')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });

        // 3. TABEL MAPELS
        Schema::create('mapels', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // Misal: '[M]', '[C]'
            $table->string('nama'); // Misal: 'Matematika', 'PAI'
            $table->enum('kategori', ['wajib', 'mulok', 'ciri_khas']);
            $table->timestamps();
        });

        // 4. TABEL PIVOT: ROMBEL_SISWA (Multi-Rombel)
        Schema::create('rombel_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('rombel_id')->constrained('rombels')->cascadeOnDelete();
            $table->string('tahun_ajaran')->default('2026/2027');
            $table->timestamps();
        });

        // 5. TABEL JADWALS
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->integer('jam_ke');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->foreignId('rombel_id')->constrained('rombels')->cascadeOnDelete();
            $table->foreignId('mapel_id')->constrained('mapels')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->enum('jenis', ['intrakurikuler', 'kokurikuler', 'ekstra'])->default('intrakurikuler');
            $table->timestamps();
        });

        // 6. TABEL CEKLOKS (Absensi Guru)
        Schema::create('cekloks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwals')->cascadeOnDelete();
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal');
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->enum('status', ['hadir', 'terlambat', 'alpha'])->default('hadir');
            $table->string('lokasi_gps')->nullable();
            $table->enum('tipe', ['kbm', 'ekstra', 'tahfidz'])->default('kbm');
            $table->timestamps();
        });

        // 7. TABEL JURNAL MENGAJAR
        Schema::create('jurnal_mengajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ceklok_id')->constrained('cekloks')->cascadeOnDelete();
            $table->text('materi');
            $table->string('metode')->nullable();
            $table->text('kendala')->nullable();
            $table->string('lampiran_url')->nullable();
            $table->timestamps();
        });

        // 8. TABEL LOGBOOK 7 KAIH
        Schema::create('logbook_kaihs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->date('tanggal');
            $table->boolean('pilar_1')->default(false); // Bangun Pagi
            $table->boolean('pilar_2')->default(false); // Beribadah
            $table->boolean('pilar_3')->default(false); // Berolahraga
            $table->boolean('pilar_4')->default(false); // Gemar Membaca
            $table->boolean('pilar_5')->default(false); // Peduli Sesama
            $table->boolean('pilar_6')->default(false); // Bergotong Royong
            $table->boolean('pilar_7')->default(false); // Berbakti
            $table->foreignId('divalidasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 9. TABEL PROGRES TAHFIDZ
        Schema::create('progres_tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->string('surat');
            $table->integer('jumlah_ayat');
            $table->date('tanggal_setor');
            $table->enum('status', ['proses', 'mutqin'])->default('proses');
            $table->foreignId('penguji_id')->constrained('users')->cascadeOnDelete();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // 10. TABEL LAPORAN TAHFIDZ (Untuk Dual-Channel WA)
        Schema::create('laporan_tahfidzs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('progres_tahfidz_id')->constrained('progres_tahfidzs')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('penguji_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['baru', 'sudah_wa', 'ditolak'])->default('baru');
            $table->foreignId('dikonfirmasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('waktu_konfirmasi')->nullable();
            $table->enum('tipe_pengirim', ['pembina', 'admin'])->nullable();
            $table->timestamps();
        });

        // 11. TABEL EKSTRAKURIKULERS
        Schema::create('ekstrakurikulers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jenis', ['wajib', 'pilihan']);
            $table->enum('hari', ['Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('tempat')->nullable();
            $table->foreignId('pembina_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // 12. TABEL PIVOT: SISWA_EKSTRAKURIKULER
        Schema::create('siswa_ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('ekstrakurikuler_id')->constrained('ekstrakurikulers')->cascadeOnDelete();
            $table->string('tahun_ajaran')->default('2026/2027');
            $table->timestamps();
        });

        // 13. TABEL TEGURAN ADMINS (War Room)
        Schema::create('teguran_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Yang ditegur
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete(); // Yang menegur
            $table->string('perihal');
            $table->text('pesan');
            $table->date('tanggal');
            $table->enum('status', ['baru', 'dibaca', 'ditindaklanjuti'])->default('baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Hapus tabel jika terjadi error (urutan terbalik)
        Schema::dropIfExists('teguran_admins');
        Schema::dropIfExists('siswa_ekstrakurikuler');
        Schema::dropIfExists('ekstrakurikulers');
        Schema::dropIfExists('laporan_tahfidzs');
        Schema::dropIfExists('progres_tahfidzs');
        Schema::dropIfExists('logbook_kaihs');
        Schema::dropIfExists('jurnal_mengajars');
        Schema::dropIfExists('cekloks');
        Schema::dropIfExists('jadwals');
        Schema::dropIfExists('rombel_siswa');
        Schema::dropIfExists('mapels');
        Schema::dropIfExists('siswas');
        Schema::dropIfExists('rombels');
    }
};