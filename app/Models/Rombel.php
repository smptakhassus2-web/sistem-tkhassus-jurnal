<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rombel extends Model
{
    protected $table = 'rombels';
    protected $fillable = ['kode', 'wali_kelas_id'];

    // Relasi ke Wali Kelas (User)
    public function waliKelas(): BelongsTo {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    // Relasi ke Siswa
    public function siswas() {
        return $this->belongsToMany(Siswa::class, 'rombel_siswa', 'rombel_id', 'siswa_id');
    }

    // Relasi ke Jadwal
    public function jadwals(): HasMany {
        return $this->hasMany(Jadwal::class);
    }
}