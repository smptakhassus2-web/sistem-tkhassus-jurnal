<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\RombelSiswa;
use App\Models\Absensi7Kaih;
use App\Models\KelompokBtq;
use App\Models\JadwalPiket;
use App\Models\PesertaTahfidz;
use App\Models\User;
use Carbon\Carbon;

class AbsensiPagiController extends Controller
{
    public function index() {
        $user = auth()->user();
        $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        $isPiket = JadwalPiket::where('hari', $hariIni)->where('guru_id', $user->id)->exists();
        $isBtq = ($hariIni === 'Jumat') && KelompokBtq::where('pembina_id', $user->id)->exists();
        $isTahfidz = in_array($hariIni, ['Rabu', 'Kamis', 'Jumat']) && str_contains($user->nama, 'Miftahul');

        $tasks = [];
        if ($isPiket) {
            $tasks[] = [
                'tipe' => 'piket',
                'judul' => 'Absensi Kegiatan Pagi (Piket)',
                'icon' => '🚩',
                'deskripsi' => 'Absen semua siswa reguler untuk kegiatan ' . $this->getNamaKegiatan($hariIni)
            ];
        }
        if ($isBtq) {
            $tasks[] = [
                'tipe' => 'btq',
                'judul' => 'Absensi Kelompok BTQ',
                'icon' => '📖',
                'deskripsi' => 'Absen siswa di kelompok BTQ Anda (07.20-08.00)'
            ];
        }
        if ($isTahfidz) {
            $tasks[] = [
                'tipe' => 'tahfidz',
                'judul' => 'Absensi Program Tahfidz',
                'icon' => '🕌',
                'deskripsi' => 'Absen 20 peserta Tahfidz (Jam 0-1)'
            ];
        }

        return view('absensi_pagi', compact('user', 'tasks', 'hariIni'));
    }

    public function form($tipe) {
        $user = auth()->user();
        $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];
        $tanggalHariIni = Carbon::today()->format('Y-m-d');
        $jenisKegiatan = $this->getNamaKegiatan($hariIni);

        // 1. Ambil daftar siswa sesuai tipe
        $siswaList = $this->getSiswaByTipe($tipe, $user, $hariIni);

        // 2. AMBIL DATA YANG SUDAH TERSIMPAN
        $absensiTersimpan = [];
        $inputOleh = null;
        $waktuInput = null;

        if ($tipe === 'btq') {
            $jenisKegiatan = 'BTQ';
        } elseif ($tipe === 'tahfidz') {
            $jenisKegiatan = 'Tahfidz';
        }

        $dataLama = Absensi7Kaih::where('tanggal', $tanggalHariIni)
            ->where('jenis_kegiatan', $jenisKegiatan)
            ->get();

        foreach ($dataLama as $d) {
            $absensiTersimpan[$d->siswa_id] = $d->status;
        }

        if ($dataLama->isNotEmpty()) {
            $lastInput = $dataLama->sortByDesc('updated_at')->first();
            $inputOleh = User::find($lastInput->input_oleh)->nama ?? 'Guru';
            $waktuInput = Carbon::parse($lastInput->updated_at)->format('H:i');
        }

        return view('absensi_pagi_form', compact(
            'user', 'siswaList', 'tipe', 'hariIni', 
            'tanggalHariIni', 'jenisKegiatan',
            'absensiTersimpan', 'inputOleh', 'waktuInput'
        ));
    }

    public function store(Request $request) {
        $user = auth()->user();
        $tipe = $request->input('tipe');
        $tanggal = $request->input('tanggal');
        $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];
        $jenisKegiatan = $this->getNamaKegiatan($hariIni);

        if ($tipe === 'btq') $jenisKegiatan = 'BTQ';
        if ($tipe === 'tahfidz') $jenisKegiatan = 'Tahfidz';

        $otoritas = $tipe === 'piket' ? 1 : ($tipe === 'tahfidz' ? 2 : 3);

        $saved = 0;
        foreach ($request->absensi as $siswaId => $status) {
            $siswa = Siswa::find($siswaId);
            
            // Ambil rombel_id dengan aman
            $rombelId = null;
            if ($siswa) {
                $rombelRelation = $siswa->rombels()->first();
                $rombelId = $rombelRelation ? $rombelRelation->id : null;
            }

            Absensi7Kaih::updateOrCreate(
                [
                    'tanggal' => $tanggal,
                    'jenis_kegiatan' => $jenisKegiatan,
                    'siswa_id' => $siswaId,
                ],
                [
                    'rombel_id' => $rombelId,
                    'status' => $status,
                    'input_oleh' => $user->id,
                    'otoritas_level' => $otoritas,
                ]
            );
            $saved++;
        }

        return redirect('/absensi-pagi')->with('success', "✅ Alhamdulillah, {$saved} data absensi {$jenisKegiatan} berhasil disimpan!");
    }

    private function getNamaKegiatan($hari) {
        return match($hari) {
            'Senin' => 'Upacara',
            'Selasa' => 'Apel',
            'Rabu' => 'Senam',
            'Kamis' => 'Apel',
            'Jumat' => 'Ziarah',
            'Sabtu' => 'Apel',
            default => 'Kegiatan Pagi',
        };
    }

    private function getSiswaByTipe($tipe, $user, $hari) {
        if ($tipe === 'btq') {
            $kelompok = KelompokBtq::where('pembina_id', $user->id)->first();
            if (!$kelompok) return collect();
            
            // 🔴 PERBAIKAN DI SINI: anggota() sudah mengembalikan model Siswa, 
            // jadi TIDAK PERLU ->with('siswa'). Langsung orderBy nama saja.
            return $kelompok->anggota()->orderBy('nama')->get();
        }

        if ($tipe === 'tahfidz') {
            // Untuk Tahfidz, model utamanya adalah PesertaTahfidz, jadi ->with('siswa') itu BENAR.
            return PesertaTahfidz::with('siswa')->get()->map(function($p) {
                return $p->siswa;
            })->sortBy('nama')->values();
        }

        // PIKET: semua siswa reguler (kecuali Tahfidz di hari Rabu & Kamis)
        if ($tipe === 'piket') {
            if (in_array($hari, ['Rabu', 'Kamis'])) {
                $tahfidzIds = PesertaTahfidz::pluck('siswa_id')->toArray();
                return Siswa::whereNotIn('id', $tahfidzIds)->orderBy('nama')->get();
            }
            return Siswa::orderBy('nama')->get();
        }

        return collect();
    }
}