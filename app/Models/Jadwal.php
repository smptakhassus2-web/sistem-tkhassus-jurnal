<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    // 🔴 PASTIKAN $FILLABLE LENGKAP (sesuai kolom di migration)
    protected $fillable = [
        'hari',
        'jam_ke',
        'waktu_mulai',
        'waktu_selesai',
        'rombel_id',
        'mapel_id',
        'guru_id',
        'jenis',
    ];

    // Relasi ke Rombel, Mapel, dan Guru
    public function rombel() {
        return $this->belongsTo(Rombel::class);
    }

    public function mapel() {
        return $this->belongsTo(Mapel::class);
    }

    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // 🔴 TAMBAHKAN INI: Relasi ke Ceklok (DIPERLUKAN OLEH DASHBOARD)
    public function cekloks() {
        return $this->hasMany(Ceklok::class);
    }
}