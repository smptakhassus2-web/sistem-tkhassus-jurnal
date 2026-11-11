<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [
            ['kode' => '[B]', 'nama' => 'SBK / Seni Rupa', 'kategori' => 'wajib'],
            ['kode' => '[C]', 'nama' => 'PAI', 'kategori' => 'wajib'],
            ['kode' => '[D] INGG', 'nama' => 'Bahasa Inggris', 'kategori' => 'wajib'],
            ['kode' => '[D] ARAB', 'nama' => 'Bahasa Arab', 'kategori' => 'ciri_khas'],
            ['kode' => '[D] NU', 'nama' => 'Ke-NU-an', 'kategori' => 'ciri_khas'],
            ['kode' => '[E]', 'nama' => 'Matematika', 'kategori' => 'wajib'],
            ['kode' => '[F] IPA', 'nama' => 'IPA', 'kategori' => 'wajib'],
            ['kode' => '[F] MTK', 'nama' => 'Matematika (F)', 'kategori' => 'wajib'],
            ['kode' => '[G] INGG', 'nama' => 'Bahasa Inggris (G)', 'kategori' => 'wajib'],
            ['kode' => '[G] JAWA', 'nama' => 'Bahasa Jawa', 'kategori' => 'mulok'],
            ['kode' => '[H] IPA', 'nama' => 'IPA (H)', 'kategori' => 'wajib'],
            ['kode' => '[H] ARAB', 'nama' => 'Bahasa Arab (H)', 'kategori' => 'ciri_khas'],
            ['kode' => '[I] PKN', 'nama' => 'PKN', 'kategori' => 'wajib'],
            ['kode' => '[I] PJOK', 'nama' => 'PJOK', 'kategori' => 'wajib'],
            ['kode' => '[J] TIK', 'nama' => 'Informatika', 'kategori' => 'wajib'],
            ['kode' => '[J] KKA', 'nama' => 'Koding & KA', 'kategori' => 'ciri_khas'],
            ['kode' => '[K] IPS', 'nama' => 'IPS', 'kategori' => 'wajib'],
            ['kode' => '[K] PKN', 'nama' => 'PKN (K)', 'kategori' => 'wajib'],
            ['kode' => '[K] JAWA', 'nama' => 'Bahasa Jawa (K)', 'kategori' => 'mulok'],
            ['kode' => '[L] INDO', 'nama' => 'Bahasa Indonesia', 'kategori' => 'wajib'],
            ['kode' => '[L] PJOK', 'nama' => 'PJOK (L)', 'kategori' => 'wajib'],
            ['kode' => '[L] KKA', 'nama' => 'Koding & KA (L)', 'kategori' => 'ciri_khas'],
            ['kode' => '[M] INDO', 'nama' => 'Bahasa Indonesia (M)', 'kategori' => 'wajib'],
            ['kode' => '[M] KKA', 'nama' => 'Koding & KA (M)', 'kategori' => 'ciri_khas'],
            ['kode' => '[N] IPS', 'nama' => 'IPS (N)', 'kategori' => 'wajib'],
            ['kode' => '[N] NU', 'nama' => 'Ke-NU-an (N)', 'kategori' => 'ciri_khas'],
            ['kode' => '[N] PKN', 'nama' => 'PKN (N)', 'kategori' => 'wajib'],
        ];

        foreach ($mapels as $mapel) {
            DB::table('mapels')->updateOrInsert(
                ['kode' => $mapel['kode']],
                array_merge($mapel, ['created_at' => now(), 'updated_at' => now()])
            );
        }
        $this->command->info("✅ MapelSeeder selesai. Total mapel: " . count($mapels));
    }
}