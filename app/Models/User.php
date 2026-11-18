<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama', 'email', 'password', 'role', 'jabatan', 'no_hp',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Jadwal Piket
    public function jadwalPikets() {
        return $this->hasMany(JadwalPiket::class, 'guru_id');
    }

    // Relasi ke Kelompok BTQ
    public function kelompokBtqs() {
        return $this->hasMany(KelompokBtq::class, 'pembina_id');
    }

    // Relasi ke Ceklok
    public function cekloks() {
        return $this->hasMany(Ceklok::class, 'guru_id');
    }

    // 🔴 RELASI BARU: Menghubungkan User (Wali) ke Siswa melalui tabel pivot 'user_siswa'
    public function siswas() {
        return $this->belongsToMany(Siswa::class, 'user_siswa', 'user_id', 'siswa_id')
                    ->withPivot('hubungan')
                    ->withTimestamps();
    }
}