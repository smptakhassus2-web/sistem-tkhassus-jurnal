<?php

namespace App\Http\Controllers;

use App\Models\Rombel;
use App\Models\RombelSiswa;
use App\Models\Jadwal;
use App\Models\Absensi7Kaih;
use App\Models\JadwalPiket;
use App\Models\KelompokBtq;
use Carbon\Carbon;

class WaliKelasController extends Controller
{
    public function index() {
        $user = auth()->user();
        $tanggalHariIni = Carbon::today()->format('Y-m-d');
        $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];

        // ==========================================
        // BAGIAN 1: DATA WALI KELAS (MONITORING)
        // ==========================================
        $rombel = Rombel::where('wali_kelas_id', $user->id)->first();
        if (!$rombel) return redirect('/guru')->with('error', 'Anda tidak ditunjuk sebagai Wali Kelas.');

        $siswaList = RombelSiswa::where('rombel_id', $rombel->id)->with('siswa')->orderBy('siswa_id')->get();
        $siswaIds = $siswaList->pluck('siswa_id')->toArray();
        
        $rekapAbsensi = Absensi7Kaih::where('tanggal', $tanggalHariIni)
                                    ->whereIn('siswa_id', $siswaIds)
                                    ->where('status', '!=', 'Hadir')
                                    ->with('siswa')->get()->sortBy('status');

        $jadwalKelas = Jadwal::where('rombel_id', $rombel->id)
                             ->where('hari', $hariIni)
                             ->with(['mapel', 'guru', 'cekloks' => function($q) use ($tanggalHariIni) { 
                                 $q->whereDate('tanggal', $tanggalHariIni); 
                             }])
                             ->orderBy('jam_ke', 'asc')->get();

        // ==========================================
        // BAGIAN 2: DATA PRIBADI GURU (TUGAS & JADWAL)
        // ==========================================
        $isPiket = JadwalPiket::where('hari', $hariIni)->where('guru_id', $user->id)->exists();
        $isBtq = ($hariIni === 'Jumat') && KelompokBtq::where('pembina_id', $user->id)->exists();
        $isTahfidz = in_array($hariIni, ['Rabu', 'Kamis', 'Jumat']) && str_contains($user->nama, 'Miftahul');

        $tasks = [];
        if ($isPiket) $tasks[] = ['tipe' => 'piket', 'judul' => 'Absensi Kegiatan Pagi (Piket)', 'icon' => '🚩', 'url' => '/absensi-pagi/form/piket'];
        if ($isBtq) $tasks[] = ['tipe' => 'btq', 'judul' => 'Absensi Kelompok BTQ', 'icon' => '📖', 'url' => '/absensi-pagi/form/btq'];
        if ($isTahfidz) $tasks[] = ['tipe' => 'tahfidz', 'judul' => 'Absensi Program Tahfidz', 'icon' => '🕌', 'url' => '/absensi-pagi/form/tahfidz'];

        // PENTING: Eager load 'cekloks' agar tombol 'Lanjutkan Jurnal' berfungsi
        $jadwalPribadi = Jadwal::where('guru_id', $user->id)
                               ->where('hari', $hariIni)
                               ->with(['mapel', 'rombel', 'cekloks' => function($q) use ($tanggalHariIni) {
                                   $q->whereDate('tanggal', $tanggalHariIni);
                               }])
                               ->orderBy('jam_ke', 'asc')->get();

        return view('wali_kelas.dashboard', compact(
            'user', 'rombel', 'siswaList', 'jadwalKelas', 'hariIni', 'tanggalHariIni', 
            'rekapAbsensi', 'tasks', 'jadwalPribadi'
        ));
    }
}