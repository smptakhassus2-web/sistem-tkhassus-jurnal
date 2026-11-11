<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\KelompokBtq;
use App\Models\AnggotaKelompokBtq;

class KelompokBtqSeeder extends Seeder
{
    public function run(): void
    {
        // Data Pembina dan Anggota Kelompok BTQ (108 Siswa)
        $dataKelompok = [
            'MUH TAQIYUDIN' => [
                'ABDULLAH ALKAF', 'DZIKRO \'AINUL YAKIN', 'NURIN KHALISATUS ZALIFAH',
                'AZKA NURDIANSYAH', 'NAJLA NAZILATUNNADA', 'ZIKRO MAULIDI AHMAD',
                'FEBRIANTI NUR HAMDANI', 'ZAAKIYAH KHAIRUN NISA', 'ASMAUL RIZKILLAH',
                'MOHAMAD SARIF', 'SAFIRA YULFIANA IZATI', 'MOHAMAD NADZIF ZUHRI', 'SAIPUL'
            ],
            'AHMAD ROSYEM' => [
                'AHMAD BAYU SETIYAWAN', 'HAF DLA LAFISA', 'REZA ADITYA NUGRAHA',
                'DAFID CHOIRUL FACHMI', 'NUR ALIFAH', 'AFNITA', 'MAJID USMAN',
                'AHMAD FAIRUZ ASYROF', 'RADIT', 'AULINA SYIFA', 'MUHAMAD IBNU SAHAL',
                'SATRIA AKBAR AL GHIFARI', 'MUNIFFATUL KHUSNA', 'SHAFARA AMELIA'
            ],
            'MUHAMAD YASIN' => [
                'AHMAD MUSLIMIN', 'HARUUN SADINURHIKMA', 'UMI DWI SYAFANA',
                'FERDI KURNIA PUTRA', 'NUR ISTA DWI CHAITRA', 'AHMAD REZA ARDIAN',
                'MAKRIFATUN HASANAH', 'KAFA BILLAH', 'SILVIANA MUTIARA RAMADANI',
                'AZKA ABDILLAH', 'MUHAMMAD FAATKHUL IZZY', 'ULIL MAHFIROH',
                'NANDA PRAWIRA DHARMA', 'WAHID AR-ROKHMAN'
            ],
            'ADIT KHAERULOH' => [
                'AL CHOISAH', 'KHAILA AZZUHRO', 'ZAIN ZHA ALBA', 'IFNA MAULIDA',
                'RIZAL KURNIAWAN', 'ANNISATUL AZIFAH', 'NOVITA SARI',
                'KHANZA FIARENZA HAFIDZAH', 'ZAHRATU HAFIZAH', 'ZIDAN MAULANA',
                'CHIKA SYAFIRA', 'NASYA RAHMADINA', 'AHMAD CAHYO', 'NAYLA MUDRIKAH',
                'WIDI WAFROTUNNAFISAH'
            ],
            'MALISA' => [
                'ALFIYAH', 'LAILATUL ZABANIYAH', '\'AZIZAH NURJANNAH', 'LAILATUN HASANAH',
                'ROIHANI FAIZAH', 'CHUSNA AMALINA', 'QAILA RAFEEFA', 'LARISA NADIFA NURPASHA',
                'ABDUL NASIR', 'DIKA MUSLIMIN', 'NUR KHOIRUL RIFKI', 'ANDY ASZUWARI JANTO',
                'OKA FEBRIYAN'
            ],
            'SOKHIBAH' => [
                'AMELIA', 'MUHAMMAD IQBAL KHOIRURRIZA', 'AHMAD FIKRI', 'LINA AMELIA',
                'RUKIYAH', 'ELISA RIZKIANA', 'RISMA NUR EKA SEPTIANA', 'NGA\'IDA NAJMA QUMAILA',
                'ALKHA RIZKY ADINATA SUBRATA', 'EFTIAN', 'RAFKA PUTRA MAULANA',
                'DUROTUN NAFISAH', 'PUTRI CAHYONI RAHMADANI'
            ],
            'NUR RAHMAWATI' => [
                'ARYANUR QIROM', 'MUHAMMAD TSABIT AL \'AZMI', 'ALFIATUS SA\'DIYAH',
                'LUFIYANA', 'TEGAR', 'ERWIN JUNIYANTO', 'SERLIN', 'NOVITA',
                'ANA MASRUROH', 'LAILI MAHFIROH', 'RIYANTI', 'HELDI TRI MANDELA',
                'RAMADIKA KURNIA CHANDRA'
            ],
            'RUDIANTORO' => [
                'ASYIFA KHUSNUL KHOTIMAH', 'NADIYA RIYANTIKA', 'ARDIKA NUR HELMAN',
                'NAFISA NUR HASANAH', 'ZAHWA NAZILATUN NISA', 'FA\'IZ ARIKA ZULFA',
                'SOFA RIYAWAN', 'NUR AFIFAH KHASANAH', 'ANNGGITA NAULY NI\'MA',
                'LALA ROFIANA PUTRI', 'ROHMAT ADITIYA', 'MAUREN ANGELINA', 'ROUF KHOIRUDIN'
            ],
        ];

        $totalSiswa = 0;
        $gagal = 0;

        foreach ($dataKelompok as $namaPembina => $daftarSiswa) {
            // Cari user pembina
            $pembina = User::where('nama', 'LIKE', "%{$namaPembina}%")->first();
            
            if (!$pembina) {
                $this->command->warn("⚠️ Pembina tidak ditemukan: {$namaPembina}");
                continue;
            }

            // Buat atau update kelompok
            $kelompok = KelompokBtq::updateOrCreate(
                ['pembina_id' => $pembina->id],
                ['nama_kelompok' => "Kelompok {$namaPembina}"]
            );

            // Masukkan anggota
            foreach ($daftarSiswa as $namaSiswa) {
                $siswa = Siswa::where('nama', $namaSiswa)->first();
                
                if ($siswa) {
                    AnggotaKelompokBtq::updateOrCreate(
                        ['siswa_id' => $siswa->id],
                        ['kelompok_btq_id' => $kelompok->id]
                    );
                    $totalSiswa++;
                } else {
                    $this->command->warn("⚠️ Siswa tidak ditemukan: {$namaSiswa}");
                    $gagal++;
                }
            }
        }

        $this->command->info("✅ Berhasil mendaftarkan {$totalSiswa} siswa ke dalam 8 kelompok BTQ. Gagal: {$gagal}");
    }
}