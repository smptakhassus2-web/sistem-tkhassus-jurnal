<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ceklok extends Model
{
    protected $fillable = [
        'jadwal_id', 'guru_id', 'tanggal', 'waktu_mulai', 'waktu_selesai', 
        'status', 'lokasi_gps', 'tipe'
    ];

    // Relasi ke tabel Jadwal
    public function jadwal() {
        return $this->belongsTo(Jadwal::class);
    }

    // Relasi ke tabel Users (Guru)
    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }
}