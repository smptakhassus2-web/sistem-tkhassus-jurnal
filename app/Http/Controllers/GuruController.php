<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Ceklok;
use App\Models\JurnalMengajar;
use App\Models\AbsensiSiswa;
use App\Models\RombelSiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Menampilkan Dashboard Guru (Jadwal Hari Ini)
     */
public function index() {
    $user = auth()->user();
    $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];
    $tanggalHariIni = Carbon::today()->format('Y-m-d');

    // BARU: Cek tugas pagi (Piket/BTQ/Tahfidz)
    $isPiket = \App\Models\JadwalPiket::where('hari', $hariIni)->where('guru_id', $user->id)->exists();
    $isBtq = \App\Models\KelompokBtq::where('pembina_id', $user->id)->exists();
    $isTahfidz = str_contains($user->nama, 'Miftahul');
    
    $tasks = [];
    if ($isPiket) {
        $tasks[] = ['tipe' => 'piket', 'judul' => 'Absensi Kegiatan Pagi (Piket)', 'icon' => '🚩'];
    }
    if ($isBtq) {
        $tasks[] = ['tipe' => 'btq', 'judul' => 'Absensi Kelompok BTQ', 'icon' => '📖'];
    }
    if ($isTahfidz) {
        $tasks[] = ['tipe' => 'tahfidz', 'judul' => 'Absensi Program Tahfidz', 'icon' => '🕌'];
    }

    // Jadwal mengajar intrakurikuler
    $jadwalHariIni = Jadwal::where('hari', $hariIni)
                           ->where('guru_id', $user->id)
                           ->where('jenis', 'intrakurikuler')
                           ->with(['mapel', 'rombel'])
                           ->orderBy('jam_ke', 'asc')
                           ->get();

    foreach ($jadwalHariIni as $jadwal) {
        $ceklok = Ceklok::where('jadwal_id', $jadwal->id)
                        ->where('guru_id', $user->id)
                        ->whereDate('tanggal', $tanggalHariIni)
                        ->first();
        
        $jadwal->sudah_ceklok = $ceklok ? true : false;
        $jadwal->ceklok_id = $ceklok ? $ceklok->id : null;
    }

    return view('guru.dashboard', compact('user', 'jadwalHariIni', 'hariIni', 'tasks'));
}

    /**
     * Memproses tombol Mulai Kelas (Ceklok)
     */
    public function ceklok(Request $request, $jadwalId) {
        $user = auth()->user();
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        $sudahCeklok = Ceklok::where('jadwal_id', $jadwalId)
                             ->where('guru_id', $user->id)
                             ->whereDate('tanggal', $tanggalHariIni)
                             ->exists();

        if (!$sudahCeklok) {
            $jadwal = Jadwal::find($jadwalId);
            $status = (Carbon::now()->format('H:i:s') > $jadwal->waktu_mulai) ? 'terlambat' : 'hadir';

            Ceklok::create([
                'jadwal_id' => $jadwalId,
                'guru_id' => $user->id,
                'tanggal' => $tanggalHariIni,
                'waktu_mulai' => Carbon::now(),
                'status' => $status,
                'tipe' => 'kbm'
            ]);
        }

        return redirect()->back()->with('success', 'Alhamdulillah, Kelas dimulai!');
    }

    /**
     * Menampilkan form Jurnal & Absensi (dengan data yang sudah tersimpan jika ada)
     */
    public function jurnalForm($ceklokId) {
        $ceklok = Ceklok::with(['jadwal.mapel', 'jadwal.rombel'])->findOrFail($ceklokId);
        $siswaList = RombelSiswa::where('rombel_id', $ceklok->jadwal->rombel_id)
            ->with('siswa')
            ->get();

        // 1. Ambil data jurnal yang sudah ada (jika ada)
        $jurnal = JurnalMengajar::where('ceklok_id', $ceklokId)->first();

        // 2. Ambil data absensi yang sudah ada (jika ada)
        $absensiData = [];
        $absensiRecords = AbsensiSiswa::where('ceklok_id', $ceklokId)->get();
        foreach ($absensiRecords as $record) {
            $absensiData[$record->siswa_id] = [
                'status' => $record->status,
                'keterangan' => $record->keterangan
            ];
        }

        return view('guru.jurnal_form', compact('ceklok', 'siswaList', 'jurnal', 'absensiData'));
    }

    /**
     * Menyimpan data Jurnal & Absensi ke database
     */
    public function storeJurnal(Request $request, $ceklokId) {
        $request->validate([
            'materi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        // 1. Handle Upload Foto (jika ada file baru)
        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('jurnal_foto', 'public');
        }

        // 2. Simpan/Update Jurnal (termasuk GPS)
        $jurnalData = [
            'materi' => $request->materi,
            'metode' => $request->metode,
            'kendala' => $request->kendala,
            'lokasi_gps' => $request->lokasi_gps,
        ];

        // Hanya update path foto jika ada file baru yang diupload
        if ($path) {
            $jurnalData['lampiran_url'] = $path;
        }

        JurnalMengajar::updateOrCreate(
            ['ceklok_id' => $ceklokId],
            $jurnalData
        );

        // 3. Simpan/Update Absensi
        if ($request->has('absensi')) {
            foreach ($request->absensi as $siswaId => $data) {
                AbsensiSiswa::updateOrCreate(
                    ['ceklok_id' => $ceklokId, 'siswa_id' => $siswaId],
                    [
                        'status' => $data['status'],
                        'keterangan' => $data['keterangan'] ?? null,
                    ]
                );
            }
        }

        return redirect('/guru')->with('success', 'Alhamdulillah, Jurnal, Absensi, dan Lokasi berhasil disimpan!');
    }
}