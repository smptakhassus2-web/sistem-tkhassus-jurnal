<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\PesertaTahfidz;

class PesertaTahfidzSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar 20 Peserta Program Tahfidz sesuai data Bapak
        $daftarPeserta = [
            'NAJIB TAUFIQUR ROHMAN',
            'MUHAMAD ARSYAD ALBANJARI',
            'MUHAMMAD NADIF ADICANDRA',
            'QURROTUL AMIRA',
            'FITRIA SILVI AZZAHRA',
            'ARUNA ASYA ANGGRAENI',
            'CAHYA LUTFI SARI',
            'NUR MUHAMMAD AUFA ALFARUQ',
            'KURNIA SEPTIANI',
            'KHUSNA FATIMATUN NISA',
            'MUHAMMAD MAVAIL MU\'AFA',
            'CALLYSTA DEANA ALFAN',
            'NIDAUL HUSNA',
            'SEPTI SAFITRI',
            'SEPTIYANA TADZKIROH',
            'ZUKHROTUL LAELY',
            'FATIKHATUS SOLIKHAH',
            'ADELIA RISKA SARI',
            'AYU SETYA NINGRUM',
            'AISYA AZZAHRA',
        ];

        $berhasil = 0;
        $gagal = 0;

        foreach ($daftarPeserta as $nama) {
            // Cari siswa berdasarkan nama
            $siswa = Siswa::where('nama', $nama)->first();
            
            if ($siswa) {
                PesertaTahfidz::updateOrCreate(
                    ['siswa_id' => $siswa->id],
                    ['siswa_id' => $siswa->id]
                );
                $berhasil++;
            } else {
                $this->command->warn("⚠️ Siswa tidak ditemukan: {$nama}");
                $gagal++;
            }
        }

        $this->command->info("✅ Berhasil mendaftarkan {$berhasil} peserta Tahfidz. Gagal: {$gagal}");
    }
}