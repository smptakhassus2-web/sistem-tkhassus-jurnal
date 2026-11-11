<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // 1. KEPALA SEKOLAH
            ['nama' => 'Abdul Bar, M.Pd.', 'email' => 'bar@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'kepsek', 'no_hp' => '6281234567001'],
            
            // 2. ADMIN / TU
            ['nama' => 'Abdul Rohman Sholeh, S.Kom.', 'email' => 'admin@smptaqdua.sch.id', 'password' => Hash::make('admin123'), 'role' => 'admin', 'no_hp' => '6281234567009'],
            ['nama' => 'Malisa Setya Saputri, S.H.', 'email' => 'malisa@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'admin', 'no_hp' => '6281234567011'], // Staff TU
            
            // 3. GURU MAPEL
            ['nama' => 'M. Asmaul Chusna, S. Ag.', 'email' => 'asmaul@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567002'],
            ['nama' => 'Muh Taqiyudin, S.Pd.I., M.Pd.', 'email' => 'taqiyudin@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567003'], // Koordinator Tahfidz
            ['nama' => 'Nur Rahmawati, S.S.', 'email' => 'nur@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567004'],
            ['nama' => 'Ahmad Rosyem, S.Pd.', 'email' => 'rosyem@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567005'],
            ['nama' => 'Rizki Laela Khanifah, S.Pd.', 'email' => 'rizki@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567006'],
            ['nama' => 'Sokhibah, S.S.', 'email' => 'sokhibah@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567007'],
            ['nama' => 'Muhamad Yasin, S.Pd.', 'email' => 'yasin@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567008'],
            ['nama' => 'Akhmad Sholahudin, S.Pd.', 'email' => 'akhmad@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567010'],
            ['nama' => 'Rudiantoro, S.Kom.', 'email' => 'rudiantoro@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567012'],
            ['nama' => 'Ika Elisia, S.M.', 'email' => 'ika@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567013'],
            ['nama' => 'Slamet Rianto, S.S.', 'email' => 'slamet@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567014'],
            ['nama' => 'Adit Khaeruloh, S.Pd., M.Pd.', 'email' => 'adit@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567015'],
            ['nama' => 'Tria Nurbaeti, S.Pd.', 'email' => 'tria@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_mapel', 'no_hp' => '6281234567016'],
            
            // 4. GURU TAHFIDZ (Pembina)
            ['nama' => 'Miftahul Hayat', 'email' => 'miftahul@smptaqdua.sch.id', 'password' => Hash::make('12345678'), 'role' => 'guru_tahfidz', 'no_hp' => '6281234567017'],
        ];

        $count = 0;
        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                array_merge($user, ['created_at' => now(), 'updated_at' => now()])
            );
            $count++;
        }
        
        $this->command->info("✅ UserSeeder selesai. Total {$count} guru & karyawan berhasil dimasukkan.");
    }
}