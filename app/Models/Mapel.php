<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    // 🔴 PASTIKAN $FILLABLE LENGKAP (sesuai kolom di migration Bapak)
    protected $fillable = [
        'kode',
        'nama',
        'kategori',
    ];

    // Relasi: Satu Mapel bisa punya banyak Jadwal
    public function jadwals()
    {
        return $this->hasMany(\App\Models\Jadwal::class);
    }
}