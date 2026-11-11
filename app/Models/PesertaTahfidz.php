<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaTahfidz extends Model
{
    protected $table = 'peserta_tahfidz';

    protected $fillable = [
        'siswa_id',
    ];

    // Relasi ke Siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }
}