<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// PERUBAHAN DI SINI: Ganti 'name' menjadi 'nama', dan tambahkan 'role' serta 'no_hp'
#[Fillable(['nama', 'email', 'password', 'role', 'no_hp'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
        // Tambahkan method ini di dalam class User
    public function siswas() {
        return $this->belongsToMany(Siswa::class, 'user_siswa')->withPivot('hubungan');
    }
}