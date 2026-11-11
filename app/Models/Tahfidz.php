<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahfidz extends Model
{
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'juz',
        'surat',
        'ayat_awal',
        'ayat_akhir',
        'nilai',
        'tanggal'
    ];

    // Relasi ke tabel Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke tabel User (Guru)
    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }
}