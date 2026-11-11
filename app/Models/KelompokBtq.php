<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokBtq extends Model
{
    protected $table = 'kelompok_btq';

    protected $fillable = ['nama_kelompok', 'pembina_id'];

    public function pembina() {
        return $this->belongsTo(User::class, 'pembina_id');
    }

    public function anggota() {
        return $this->belongsToMany(Siswa::class, 'anggota_kelompok_btq');
    }
}