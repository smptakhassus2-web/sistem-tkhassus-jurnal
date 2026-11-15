<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    // 🔴 INI KUNCINYA: Mengizinkan kolom-kolom ini untuk diisi massal
    protected $fillable = [
        'kode',
        'nama',
        'tingkat',
        'jenis',
        'wali_kelas_id',
        'tahun_ajaran',
    ];

    // Relasi: Rombel memiliki banyak siswa (melalui tabel pivot)
    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'rombel_siswa');
    }

    // Relasi: Rombel dimiliki oleh 1 Wali Kelas (User)
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }
}