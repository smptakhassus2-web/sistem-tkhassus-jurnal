<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RombelSeeder extends Seeder
{
    public function run(): void
    {
        $rombels = [
            ['kode' => '7A', 'nama' => 'Kelas 7A', 'tingkat' => 7, 'jenis' => 'utama'],
            ['kode' => '7B', 'nama' => 'Kelas 7B', 'tingkat' => 7, 'jenis' => 'utama'],
            ['kode' => '8A', 'nama' => 'Kelas 8A', 'tingkat' => 8, 'jenis' => 'utama'],
            ['kode' => '8B', 'nama' => 'Kelas 8B', 'tingkat' => 8, 'jenis' => 'utama'],
            ['kode' => '9A', 'nama' => 'Kelas 9A', 'tingkat' => 9, 'jenis' => 'utama'],
            ['kode' => '9B', 'nama' => 'Kelas 9B', 'tingkat' => 9, 'jenis' => 'utama'],
        ];

        foreach ($rombels as $rombel) {
            DB::table('rombels')->insert([
                'kode' => $rombel['kode'],
                'nama' => $rombel['nama'],
                'tingkat' => $rombel['tingkat'],
                'jenis' => $rombel['jenis'],
                'tahun_ajaran' => '2026/2027',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}