<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\JadwalPiket;

class JadwalPiketSeeder extends Seeder
{
    public function run(): void
    {
        // Data Jadwal Piket sesuai Excel Bapak
        $jadwalPiket = [
            'Senin' => ['Rizki', 'Adit', 'Ika'],
            'Selasa' => ['Muhamad', 'Rizki', 'Ahmad'],
            'Rabu' => ['Akhmad', 'Muhamad', 'Nur'],
            'Kamis' => ['Abdul Rohman', 'Asmaul', 'Malisa', 'Miftahul'],
            'Jumat' => ['Muh Taqiyudin', 'Rudiantoro', 'Sokhibah'],
            'Sabtu' => ['Slamet', 'Tria', 'Sokhibah'],
        ];

        $inserted = 0;
        $failed = 0;

        foreach ($jadwalPiket as $hari => $guruList) {
            foreach ($guruList as $urutan => $namaGuru) {
                $guru = User::where('nama', 'LIKE', "%{$namaGuru}%")->first();
                
                if ($guru) {
                    JadwalPiket::updateOrCreate(
                        ['hari' => $hari, 'urutan' => $urutan + 1],
                        ['guru_id' => $guru->id]
                    );
                    $inserted++;
                } else {
                    $this->command->warn("❌ Guru tidak ditemukan: {$namaGuru} ({$hari})");
                    $failed++;
                }
            }
        }

        $this->command->info("✅ Berhasil memasukkan {$inserted} jadwal piket. Gagal: {$failed}");
    }
}