<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPiket extends Model
{
    protected $table = 'jadwal_piket';

    protected $fillable = [
        'hari',
        'guru_id',
        'urutan',
    ];

    // Relasi ke Guru
    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }
}