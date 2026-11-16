<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPiket extends Model
{
    use HasFactory;

    // Nama tabel sesuai migrasi
    protected $table = 'jadwal_piket';

    // 🔴 PASTIKAN $FILLABLE LENGKAP (sesuai kolom di migration)
    protected $fillable = [
        'hari',
        'guru_id',
        'urutan',
    ];

    // Relasi ke Guru (User)
    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }
}