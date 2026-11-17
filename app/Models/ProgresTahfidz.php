<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresTahfidz extends Model
{
    use HasFactory;

    protected $table = 'progres_tahfidzs';

    protected $fillable = [
        'siswa_id',
        'surat',
        'jumlah_ayat',
        'tanggal_setor',
        'status',
        'penguji_id',
        'catatan',
    ];

    // Relasi ke Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi ke Penguji (User)
    public function penguji() {
        return $this->belongsTo(User::class, 'penguji_id');
    }

    // Relasi ke Laporan Tahfidz
    public function laporan() {
        return $this->hasOne(LaporanTahfidz::class, 'progres_tahfidz_id');
    }
}
