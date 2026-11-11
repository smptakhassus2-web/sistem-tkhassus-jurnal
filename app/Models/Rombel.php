<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $fillable = [
        'kode', 'nama', 'tingkat', 'jenis', 'wali_kelas_id', 'tahun_ajaran'
    ];

    // Relasi ke tabel Jadwal
    public function jadwals() {
        return $this->hasMany(Jadwal::class);
    }

    // Relasi ke tabel Users (Wali Kelas)
    public function waliKelas() {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }
}