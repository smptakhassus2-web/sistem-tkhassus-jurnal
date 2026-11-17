<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTahfidz extends Model
{
    use HasFactory;

    protected $table = 'laporan_tahfidzs';

    protected $fillable = [
        'progres_tahfidz_id',
        'siswa_id',
        'penguji_id',
        'status',
        'dikonfirmasi_oleh',
        'waktu_konfirmasi',
        'tipe_pengirim',
    ];

    // Relasi ke Progres Tahfidz
    public function progres() {
        return $this->belongsTo(ProgresTahfidz::class, 'progres_tahfidz_id');
    }

    // Relasi ke Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi ke Penguji (User)
    public function penguji() {
        return $this->belongsTo(User::class, 'penguji_id');
    }

    // Relasi ke User yang konfirmasi
    public function dikonfirmasiOleh() {
        return $this->belongsTo(User::class, 'dikonfirmasi_oleh');
    }
}