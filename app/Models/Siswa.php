<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // 🔴 INI KUNCINYA: Memberitahu Laravel bahwa nama tabelnya adalah 'siswas' (pakai 's')
    protected $table = 'siswas';

    // Kolom yang diizinkan untuk diisi (sesuai migrasi asli database Bapak)
    protected $fillable = [
        'nama',
        'nis',
        'nisn',
        'jenis_kelamin',
        'no_hp_ortu',
        'nama_ortu',
        'alamat',
    ];

    // Relasi ke tabel Rombel
    public function rombels()
    {
        return $this->belongsToMany(Rombel::class, 'rombel_siswa');
    }
}