<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalMengajar extends Model
{
    use HasFactory;

    protected $fillable = [
        'ceklok_id',
        'materi',
        'metode',
        'kendala',
        'lampiran_url',
    ];

    // Relasi ke Ceklok
    public function ceklok() {
        return $this->belongsTo(Ceklok::class);
    }
}