<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi7Kaih extends Model
{
    protected $table = 'absensi_7kaih';

    protected $fillable = [
        'tanggal',
        'jenis_kegiatan',
        'rombel_id',
        'siswa_id',
        'status',
        'input_oleh',
        'otoritas_level',
        'keterangan',
    ];

    // Relasi ke Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Rombel
    public function rombel() {
        return $this->belongsTo(Rombel::class);
    }

    // Relasi ke User (yang input)
    public function user() {
        return $this->belongsTo(User::class, 'input_oleh');
    }
}