<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKelompokBtq extends Model
{
    protected $table = 'anggota_kelompok_btq';

    protected $fillable = ['kelompok_btq_id', 'siswa_id'];

    public function kelompok() {
        return $this->belongsTo(KelompokBtq::class);
    }

    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }
}