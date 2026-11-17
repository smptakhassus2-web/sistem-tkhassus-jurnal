<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi7Kaih extends Model
{
    use HasFactory;

    // 🔴 PENTING: Nama tabel di migration adalah 'absensi_7kaih' (tanpa 's' di akhir)
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
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Relasi ke Rombel
    public function rombel() {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    // Relasi ke User (yang menginput)
    public function inputOleh() {
        return $this->belongsTo(User::class, 'input_oleh');
    }
}