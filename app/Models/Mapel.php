<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $fillable = [
        'kode', 'nama', 'kategori'
    ];

    // Relasi ke tabel Jadwal
    public function jadwals() {
        return $this->hasMany(Jadwal::class);
    }
}