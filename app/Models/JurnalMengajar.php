<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    protected $fillable = [
        'ceklok_id',       // <-- TAMBAHKAN INI
        'materi',
        'metode',
        'kendala',
        'lampiran_url',
        'lokasi_gps',      // <-- TAMBAHKAN INI
    ];

    // Relasi ke tabel Ceklok
    public function ceklok() {
        return $this->belongsTo(Ceklok::class);
    }
}