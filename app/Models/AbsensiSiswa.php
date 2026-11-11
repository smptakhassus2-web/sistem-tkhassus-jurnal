<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
    protected $table = 'absensi_siswas';

    protected $fillable = [
        'ceklok_id',
        'siswa_id',
        'status',
        'keterangan',
    ];

    // Relasi ke tabel Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke tabel Ceklok
    public function ceklok() {
        return $this->belongsTo(Ceklok::class);
    }
}