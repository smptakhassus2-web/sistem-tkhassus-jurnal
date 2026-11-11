<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nis', 'nisn', 'nipd', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'alamat', 'rt', 'rw', 'dusun', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos',
        'no_hp_ortu', 'nama_ortu'
    ];

    // Relasi ke tabel Rombel (Many-to-Many)
    public function rombels() {
        return $this->belongsToMany(Rombel::class, 'rombel_siswa');
    }

    // Relasi ke tabel User (Wali Murid)
    public function users() {
        return $this->belongsToMany(User::class, 'user_siswa')->withPivot('hubungan');
    }
}