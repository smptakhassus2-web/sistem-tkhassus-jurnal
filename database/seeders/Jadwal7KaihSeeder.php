<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Rombel;

class Jadwal7KaihSeeder extends Seeder
{
    public function run(): void
    {
        // Jadwal 7 KAIH (Kokurikuler) - Semua Kelas
        $jadwal7Kaih = [
            // Senin: Upacara 07.00-08.00, Sholat Dhuhur 11.40-12.10
            ['hari' => 'Senin', 'jam_ke' => 0, 'mulai' => '07:00:00', 'selesai' => '08:00:00', 'mapel' => 'Upacara Bendera + 7 KAIH', 'jenis' => 'kokurikuler'],
            ['hari' => 'Senin', 'jam_ke' => 7, 'mulai' => '11:40:00', 'selesai' => '12:10:00', 'mapel' => 'Sholat Dhuhur Berjamaah', 'jenis' => 'kokurikuler'],
            
            // Selasa: Apel+Dhuha 07.00-07.30, Sholat Dhuhur 11.50-12.20
            ['hari' => 'Selasa', 'jam_ke' => 0, 'mulai' => '07:00:00', 'selesai' => '07:30:00', 'mapel' => 'Apel Pagi + Sholat Dhuha + 7 KAIH', 'jenis' => 'kokurikuler'],
            ['hari' => 'Selasa', 'jam_ke' => 8, 'mulai' => '11:50:00', 'selesai' => '12:20:00', 'mapel' => 'Sholat Dhuhur Berjamaah', 'jenis' => 'kokurikuler'],
            
            // Rabu: Senam+Litnum 07.00-08.00, Sholat Dhuhur 11.40-12.10
            ['hari' => 'Rabu', 'jam_ke' => 0, 'mulai' => '07:00:00', 'selesai' => '08:00:00', 'mapel' => 'Senam Pagi + Literasi Numerasi', 'jenis' => 'kokurikuler'],
            ['hari' => 'Rabu', 'jam_ke' => 7, 'mulai' => '11:40:00', 'selesai' => '12:10:00', 'mapel' => 'Sholat Dhuhur Berjamaah', 'jenis' => 'kokurikuler'],
            
            // Kamis: Apel+Dhuha+Kamis Bersih 07.00-08.00, Sholat Dhuhur 11.40-12.10
            ['hari' => 'Kamis', 'jam_ke' => 0, 'mulai' => '07:00:00', 'selesai' => '08:00:00', 'mapel' => 'Apel Pagi + Sholat Dhuha + Kamis Bersih', 'jenis' => 'kokurikuler'],
            ['hari' => 'Kamis', 'jam_ke' => 7, 'mulai' => '11:40:00', 'selesai' => '12:10:00', 'mapel' => 'Sholat Dhuhur Berjamaah', 'jenis' => 'kokurikuler'],
            
            // Jumat: Ziarah+BTQ 07.00-08.00
            ['hari' => 'Jumat', 'jam_ke' => 0, 'mulai' => '07:00:00', 'selesai' => '08:00:00', 'mapel' => 'Ziarah + BTQ (Baca Tulis Al-Qur\'an)', 'jenis' => 'kokurikuler'],
            
            // Sabtu: Apel+Dhuha 07.00-07.30, Refleksi 11.50-12.00
            ['hari' => 'Sabtu', 'jam_ke' => 0, 'mulai' => '07:00:00', 'selesai' => '07:30:00', 'mapel' => 'Apel Pagi + Sholat Dhuha', 'jenis' => 'kokurikuler'],
            ['hari' => 'Sabtu', 'jam_ke' => 7, 'mulai' => '11:50:00', 'selesai' => '12:00:00', 'mapel' => 'Refleksi Mingguan', 'jenis' => 'kokurikuler'],
        ];

        $rombels = Rombel::all();
        $inserted = 0;

        foreach ($jadwal7Kaih as $jadwal) {
            foreach ($rombels as $rombel) {
                DB::table('jadwals')->updateOrInsert(
                    [
                        'hari' => $jadwal['hari'],
                        'jam_ke' => $jadwal['jam_ke'],
                        'rombel_id' => $rombel->id,
                    ],
                    [
                        'waktu_mulai' => $jadwal['mulai'],
                        'waktu_selesai' => $jadwal['selesai'],
                        'mapel_id' => null, // Kokurikuler tidak ada mapel_id
                        'guru_id' => null, // Akan diisi oleh guru piket saat absen
                        'jenis' => $jadwal['jenis'],
                        'updated_at' => now(),
                    ]
                );
                $inserted++;
            }
        }

        $this->command->info("✅ Berhasil memasukkan {$inserted} jadwal 7 KAIH (kokurikuler) untuk semua kelas.");
    }
}