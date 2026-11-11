<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'hari', 'jam_ke', 'waktu_mulai', 'waktu_selesai', 
        'rombel_id', 'mapel_id', 'guru_id', 'jenis'
    ];

    // Relasi ke tabel Users (Guru)
    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Relasi ke tabel Mapel
    public function mapel() {
        return $this->belongsTo(Mapel::class);
    }

    // Relasi ke tabel Rombel
    public function rombel() {
        return $this->belongsTo(Rombel::class);
    }

    // Relasi ke tabel Ceklok (One-to-Many)
    public function cekloks() {
        return $this->hasMany(Ceklok::class);
    }
}