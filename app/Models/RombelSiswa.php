<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RombelSiswa extends Model
{
    protected $table = 'rombel_siswa';

    protected $fillable = [
        'siswa_id',
        'rombel_id',
        'tahun_ajaran',
    ];

    // Relasi ke tabel Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke tabel Rombel
    public function rombel() {
        return $this->belongsTo(Rombel::class);
    }
}