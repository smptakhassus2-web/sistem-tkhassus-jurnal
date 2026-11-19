<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianBtq extends Model
{
    protected $table = 'penilaian_btqs';

    protected $fillable = [
        'kelompok_btq_id',
        'siswa_id',
        'pembina_id',
        'jilid',
        'halaman',
        'juz',
        'surat',
        'ayat_awal',
        'ayat_akhir',
        'nilai',
        'catatan',
        'tanggal',
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Pembina (Guru)
    public function pembina()
    {
        return $this->belongsTo(User::class, 'pembina_id');
    }

    // Relasi ke Kelompok BTQ
    public function kelompok()
    {
        return $this->belongsTo(KelompokBtq::class, 'kelompok_btq_id');
    }
}