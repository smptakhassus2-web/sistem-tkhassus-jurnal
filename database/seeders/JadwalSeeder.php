<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Rombel;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        // Helper untuk mencari ID berdasarkan nama/kode (menggunakan LIKE agar fleksibel)
        $getGuru = function($nama) { return User::where('nama', 'LIKE', "%{$nama}%")->first()?->id; };
        $getMapel = function($kode) { return Mapel::where('kode', $kode)->first()?->id; };
        $getRombel = function($kode) { return Rombel::where('kode', $kode)->first()?->id; };

        $jadwals = [
            // ================= SENIN =================
            ['hari' => 'Senin', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '7A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Senin', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '7B', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Senin', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '8A', 'mapel' => '[D] ARAB', 'guru' => 'Nur'],
            ['hari' => 'Senin', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '8B', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],
            ['hari' => 'Senin', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '9A', 'mapel' => '[K] JAWA', 'guru' => 'Ika'],
            ['hari' => 'Senin', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '9B', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            
            ['hari' => 'Senin', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '7A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Senin', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '7B', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Senin', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '8A', 'mapel' => '[D] ARAB', 'guru' => 'Nur'],
            ['hari' => 'Senin', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '8B', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],
            ['hari' => 'Senin', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '9A', 'mapel' => '[K] JAWA', 'guru' => 'Ika'],
            ['hari' => 'Senin', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '9B', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],

            ['hari' => 'Senin', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '7A', 'mapel' => '[F] MTK', 'guru' => 'Rizki'],
            ['hari' => 'Senin', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '7B', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Senin', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '8A', 'mapel' => '[M] KKA', 'guru' => 'Adit'],
            ['hari' => 'Senin', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '8B', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],
            ['hari' => 'Senin', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '9A', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Senin', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '9B', 'mapel' => '[D] NU', 'guru' => 'Nur'],

            ['hari' => 'Senin', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '7A', 'mapel' => '[F] MTK', 'guru' => 'Rizki'],
            ['hari' => 'Senin', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '7B', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Senin', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '8A', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Senin', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '8B', 'mapel' => '[D] ARAB', 'guru' => 'Nur'],
            ['hari' => 'Senin', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '9A', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Senin', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '9B', 'mapel' => '[M] INDO', 'guru' => 'Adit'],

            ['hari' => 'Senin', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '7A', 'mapel' => '[G] JAWA', 'guru' => 'Sokhibah'],
            ['hari' => 'Senin', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '7B', 'mapel' => '[J] KKA', 'guru' => 'Rudiantoro'],
            ['hari' => 'Senin', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '8A', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Senin', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '8B', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Senin', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '9A', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],
            ['hari' => 'Senin', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '9B', 'mapel' => '[M] INDO', 'guru' => 'Adit'],

            ['hari' => 'Senin', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '7A', 'mapel' => '[G] JAWA', 'guru' => 'Sokhibah'],
            ['hari' => 'Senin', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '7B', 'mapel' => '[J] KKA', 'guru' => 'Rudiantoro'],
            ['hari' => 'Senin', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '8A', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Senin', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '8B', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Senin', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '9A', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],
            ['hari' => 'Senin', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '9B', 'mapel' => '[M] INDO', 'guru' => 'Adit'],

            // ================= SELASA =================
            ['hari' => 'Selasa', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '7A', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Selasa', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '7B', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Selasa', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '8A', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Selasa', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '8B', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Selasa', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '9A', 'mapel' => '[L] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Selasa', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '9B', 'mapel' => '[N] IPS', 'guru' => 'Tria'],

            ['hari' => 'Selasa', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '7A', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Selasa', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '7B', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Selasa', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '8A', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Selasa', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '8B', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Selasa', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '9A', 'mapel' => '[L] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Selasa', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '9B', 'mapel' => '[N] IPS', 'guru' => 'Tria'],

            ['hari' => 'Selasa', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '7A', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Selasa', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '7B', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Selasa', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '8A', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Selasa', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '8B', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Selasa', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '9A', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Selasa', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '9B', 'mapel' => '[N] IPS', 'guru' => 'Tria'],

            ['hari' => 'Selasa', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '7A', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Selasa', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '7B', 'mapel' => '[N] NU', 'guru' => 'Tria'],
            ['hari' => 'Selasa', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '8A', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Selasa', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '8B', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Selasa', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '9A', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Selasa', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '9B', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],

            ['hari' => 'Selasa', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '7A', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Selasa', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '7B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Selasa', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '8A', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Selasa', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '8B', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Selasa', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '9A', 'mapel' => '[D] NU', 'guru' => 'Nur'],
            ['hari' => 'Selasa', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '9B', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],

            ['hari' => 'Selasa', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '7A', 'mapel' => '[N] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad (PKN)
            ['hari' => 'Selasa', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '7B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Selasa', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '8A', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Selasa', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '8B', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Selasa', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '9A', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],
            ['hari' => 'Selasa', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '9B', 'mapel' => '[D] NU', 'guru' => 'Nur'],

            ['hari' => 'Selasa', 'jam_ke' => 7, 'mulai' => '12:20:00', 'selesai' => '13:00:00', 'rombel' => '7A', 'mapel' => '[N] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad (PKN)
            ['hari' => 'Selasa', 'jam_ke' => 7, 'mulai' => '12:20:00', 'selesai' => '13:00:00', 'rombel' => '7B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Selasa', 'jam_ke' => 7, 'mulai' => '12:20:00', 'selesai' => '13:00:00', 'rombel' => '8A', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Selasa', 'jam_ke' => 7, 'mulai' => '12:20:00', 'selesai' => '13:00:00', 'rombel' => '8B', 'mapel' => '[D] ARAB', 'guru' => 'Nur'],
            ['hari' => 'Selasa', 'jam_ke' => 7, 'mulai' => '12:20:00', 'selesai' => '13:00:00', 'rombel' => '9A', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],
            ['hari' => 'Selasa', 'jam_ke' => 7, 'mulai' => '12:20:00', 'selesai' => '13:00:00', 'rombel' => '9B', 'mapel' => '[H] ARAB', 'guru' => 'Muhamad'],

            // ================= RABU =================
            ['hari' => 'Rabu', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '7A', 'mapel' => '[N] NU', 'guru' => 'Tria'],
            ['hari' => 'Rabu', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '7B', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Rabu', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '8A', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Rabu', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '8B', 'mapel' => '[I] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Rabu', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '9A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Rabu', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '9B', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],

            ['hari' => 'Rabu', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '7A', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Rabu', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '7B', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Rabu', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '8A', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Rabu', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '8B', 'mapel' => '[I] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Rabu', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '9A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Rabu', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '9B', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],

            ['hari' => 'Rabu', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '7A', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Rabu', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '7B', 'mapel' => '[N] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
            ['hari' => 'Rabu', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '8A', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Rabu', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '8B', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Rabu', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '9A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Rabu', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '9B', 'mapel' => '[K] JAWA', 'guru' => 'Ika'],

            ['hari' => 'Rabu', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '7A', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Rabu', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '7B', 'mapel' => '[N] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
            ['hari' => 'Rabu', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '8A', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Rabu', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '8B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Rabu', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '9A', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Rabu', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '9B', 'mapel' => '[K] JAWA', 'guru' => 'Ika'],

            ['hari' => 'Rabu', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '7A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Rabu', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '7B', 'mapel' => '[G] JAWA', 'guru' => 'Sokhibah'],
            ['hari' => 'Rabu', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '8A', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Rabu', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '8B', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Rabu', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '9A', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Rabu', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '9B', 'mapel' => '[B]', 'guru' => 'Asmaul'],

            ['hari' => 'Rabu', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '7A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Rabu', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '7B', 'mapel' => '[G] JAWA', 'guru' => 'Sokhibah'],
            ['hari' => 'Rabu', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '8A', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Rabu', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '8B', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Rabu', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '9A', 'mapel' => '[N] IPS', 'guru' => 'Tria'],
            ['hari' => 'Rabu', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '9B', 'mapel' => '[B]', 'guru' => 'Asmaul'],

            // ================= KAMIS =================
            ['hari' => 'Kamis', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '7A', 'mapel' => '[I] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Kamis', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '7B', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Kamis', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '8A', 'mapel' => '[K] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
            ['hari' => 'Kamis', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '8B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Kamis', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '9A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Kamis', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '9B', 'mapel' => '[H] ARAB', 'guru' => 'Muhamad'],

            ['hari' => 'Kamis', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '7A', 'mapel' => '[I] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Kamis', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '7B', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Kamis', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '8A', 'mapel' => '[K] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
            ['hari' => 'Kamis', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '8B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Kamis', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '9A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Kamis', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '9B', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],

            ['hari' => 'Kamis', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '7A', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Kamis', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '7B', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Kamis', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '8A', 'mapel' => '[G] JAWA', 'guru' => 'Sokhibah'],
            ['hari' => 'Kamis', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '8B', 'mapel' => '[I] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
            ['hari' => 'Kamis', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '9A', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Kamis', 'jam_ke' => 3, 'mulai' => '09:40:00', 'selesai' => '10:20:00', 'rombel' => '9B', 'mapel' => '[L] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet

            ['hari' => 'Kamis', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '7A', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Kamis', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '7B', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Kamis', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '8A', 'mapel' => '[M] KKA', 'guru' => 'Adit'],
            ['hari' => 'Kamis', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '8B', 'mapel' => '[I] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
            ['hari' => 'Kamis', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '9A', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Kamis', 'jam_ke' => 4, 'mulai' => '10:20:00', 'selesai' => '11:00:00', 'rombel' => '9B', 'mapel' => '[L] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet

            ['hari' => 'Kamis', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '7A', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Kamis', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '7B', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Kamis', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '8A', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Kamis', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '8B', 'mapel' => '[L] KKA', 'guru' => 'Slamet'],
            ['hari' => 'Kamis', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '9A', 'mapel' => '[I] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
            ['hari' => 'Kamis', 'jam_ke' => 5, 'mulai' => '11:00:00', 'selesai' => '11:40:00', 'rombel' => '9B', 'mapel' => '[E]', 'guru' => 'Ahmad'],

            ['hari' => 'Kamis', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '7A', 'mapel' => '[K] IPS', 'guru' => 'Ika'],
            ['hari' => 'Kamis', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '7B', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Kamis', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '8A', 'mapel' => '[B]', 'guru' => 'Asmaul'],
            ['hari' => 'Kamis', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '8B', 'mapel' => '[L] KKA', 'guru' => 'Slamet'],
            ['hari' => 'Kamis', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '9A', 'mapel' => '[I] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
            ['hari' => 'Kamis', 'jam_ke' => 6, 'mulai' => '12:10:00', 'selesai' => '12:50:00', 'rombel' => '9B', 'mapel' => '[E]', 'guru' => 'Ahmad'],

            // ================= JUMAT =================
            ['hari' => 'Jumat', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '7A', 'mapel' => '[J] KKA', 'guru' => 'Rudiantoro'],
            ['hari' => 'Jumat', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '7B', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Jumat', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '8A', 'mapel' => '[G] JAWA', 'guru' => 'Sokhibah'],
            ['hari' => 'Jumat', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '8B', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Jumat', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '9A', 'mapel' => '[D] NU', 'guru' => 'Nur'],
            ['hari' => 'Jumat', 'jam_ke' => 1, 'mulai' => '08:00:00', 'selesai' => '08:40:00', 'rombel' => '9B', 'mapel' => '[M] INDO', 'guru' => 'Adit'],

            ['hari' => 'Jumat', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '7A', 'mapel' => '[J] KKA', 'guru' => 'Rudiantoro'],
            ['hari' => 'Jumat', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '7B', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Jumat', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '8A', 'mapel' => '[E]', 'guru' => 'Ahmad'],
            ['hari' => 'Jumat', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '8B', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Jumat', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '9A', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],
            ['hari' => 'Jumat', 'jam_ke' => 2, 'mulai' => '08:40:00', 'selesai' => '09:20:00', 'rombel' => '9B', 'mapel' => '[M] INDO', 'guru' => 'Adit'],

            ['hari' => 'Jumat', 'jam_ke' => 3, 'mulai' => '09:35:00', 'selesai' => '10:15:00', 'rombel' => '7A', 'mapel' => '[C]', 'guru' => 'Muh Taqiyudin'],
            ['hari' => 'Jumat', 'jam_ke' => 3, 'mulai' => '09:35:00', 'selesai' => '10:15:00', 'rombel' => '7B', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Jumat', 'jam_ke' => 3, 'mulai' => '09:35:00', 'selesai' => '10:15:00', 'rombel' => '8A', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Jumat', 'jam_ke' => 3, 'mulai' => '09:35:00', 'selesai' => '10:15:00', 'rombel' => '8B', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],
            ['hari' => 'Jumat', 'jam_ke' => 3, 'mulai' => '09:35:00', 'selesai' => '10:15:00', 'rombel' => '9A', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],
            ['hari' => 'Jumat', 'jam_ke' => 3, 'mulai' => '09:35:00', 'selesai' => '10:15:00', 'rombel' => '9B', 'mapel' => '[E]', 'guru' => 'Ahmad'],

            ['hari' => 'Jumat', 'jam_ke' => 4, 'mulai' => '10:15:00', 'selesai' => '10:55:00', 'rombel' => '7A', 'mapel' => '[M] INDO', 'guru' => 'Adit'],
            ['hari' => 'Jumat', 'jam_ke' => 4, 'mulai' => '10:15:00', 'selesai' => '10:55:00', 'rombel' => '7B', 'mapel' => '[D] INGG', 'guru' => 'Nur'],
            ['hari' => 'Jumat', 'jam_ke' => 4, 'mulai' => '10:15:00', 'selesai' => '10:55:00', 'rombel' => '8A', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Jumat', 'jam_ke' => 4, 'mulai' => '10:15:00', 'selesai' => '10:55:00', 'rombel' => '8B', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],
            ['hari' => 'Jumat', 'jam_ke' => 4, 'mulai' => '10:15:00', 'selesai' => '10:55:00', 'rombel' => '9A', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],
            ['hari' => 'Jumat', 'jam_ke' => 4, 'mulai' => '10:15:00', 'selesai' => '10:55:00', 'rombel' => '9B', 'mapel' => '[E]', 'guru' => 'Ahmad'],

            // ================= SABTU =================
            ['hari' => 'Sabtu', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '7A', 'mapel' => '[N] NU', 'guru' => 'Tria'],
            ['hari' => 'Sabtu', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '7B', 'mapel' => '[I] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Sabtu', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '8A', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Sabtu', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '8B', 'mapel' => '[G] JAWA', 'guru' => 'Sokhibah'],
            ['hari' => 'Sabtu', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '9A', 'mapel' => '[H] ARAB', 'guru' => 'Muhamad'],
            ['hari' => 'Sabtu', 'jam_ke' => 1, 'mulai' => '07:30:00', 'selesai' => '08:10:00', 'rombel' => '9B', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],

            ['hari' => 'Sabtu', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '7A', 'mapel' => '[F] MTK', 'guru' => 'Rizki'],
            ['hari' => 'Sabtu', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '7B', 'mapel' => '[I] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Sabtu', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '8A', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Sabtu', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '8B', 'mapel' => '[G] JAWA', 'guru' => 'Sokhibah'],
            ['hari' => 'Sabtu', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '9A', 'mapel' => '[H] ARAB', 'guru' => 'Muhamad'],
            ['hari' => 'Sabtu', 'jam_ke' => 2, 'mulai' => '08:10:00', 'selesai' => '08:50:00', 'rombel' => '9B', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],

            ['hari' => 'Sabtu', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '7A', 'mapel' => '[F] MTK', 'guru' => 'Rizki'],
            ['hari' => 'Sabtu', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '7B', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Sabtu', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '8A', 'mapel' => '[I] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Sabtu', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '8B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Sabtu', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '9A', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Sabtu', 'jam_ke' => 3, 'mulai' => '08:50:00', 'selesai' => '09:30:00', 'rombel' => '9B', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],

            ['hari' => 'Sabtu', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '7A', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Sabtu', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '7B', 'mapel' => '[N] NU', 'guru' => 'Tria'],
            ['hari' => 'Sabtu', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '8A', 'mapel' => '[I] PJOK', 'guru' => 'Slamet'], // DIPERBAIKI: Slamet
            ['hari' => 'Sabtu', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '8B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Sabtu', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '9A', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Sabtu', 'jam_ke' => 4, 'mulai' => '09:50:00', 'selesai' => '10:30:00', 'rombel' => '9B', 'mapel' => '[G] INGG', 'guru' => 'Sokhibah'],

            ['hari' => 'Sabtu', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '7A', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Sabtu', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '7B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Sabtu', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '8A', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Sabtu', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '8B', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],
            ['hari' => 'Sabtu', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '9A', 'mapel' => '[N] IPS', 'guru' => 'Tria'],
            ['hari' => 'Sabtu', 'jam_ke' => 5, 'mulai' => '10:30:00', 'selesai' => '11:10:00', 'rombel' => '9B', 'mapel' => '[I] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad

            ['hari' => 'Sabtu', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '7A', 'mapel' => '[H] IPA', 'guru' => 'Muhamad'],
            ['hari' => 'Sabtu', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '7B', 'mapel' => '[L] INDO', 'guru' => 'Slamet'],
            ['hari' => 'Sabtu', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '8A', 'mapel' => '[J] TIK', 'guru' => 'Rudiantoro'],
            ['hari' => 'Sabtu', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '8B', 'mapel' => '[F] IPA', 'guru' => 'Rizki'],
            ['hari' => 'Sabtu', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '9A', 'mapel' => '[N] IPS', 'guru' => 'Tria'],
            ['hari' => 'Sabtu', 'jam_ke' => 6, 'mulai' => '11:10:00', 'selesai' => '11:50:00', 'rombel' => '9B', 'mapel' => '[I] PKN', 'guru' => 'Akhmad'], // DIPERBAIKI: Akhmad
        ];

        $inserted = 0;
        $failed = 0;

        foreach ($jadwals as $j) {
            $guruId = $getGuru($j['guru']);
            $mapelId = $getMapel($j['mapel']);
            $rombelId = $getRombel($j['rombel']);

            if ($guruId && $mapelId && $rombelId) {
                DB::table('jadwals')->updateOrInsert(
                    ['hari' => $j['hari'], 'jam_ke' => $j['jam_ke'], 'rombel_id' => $rombelId],
                    [
                        'waktu_mulai' => $j['mulai'],
                        'waktu_selesai' => $j['selesai'],
                        'mapel_id' => $mapelId,
                        'guru_id' => $guruId,
                        'jenis' => 'intrakurikuler',
                        'updated_at' => now(),
                    ]
                );
                $inserted++;
            } else {
                $this->command->warn("❌ Gagal: {$j['guru']} - {$j['mapel']} - {$j['rombel']}");
                $failed++;
            }
        }
        $this->command->info("✅ Berhasil memasukkan {$inserted} jadwal. Gagal: {$failed}");
    }
}