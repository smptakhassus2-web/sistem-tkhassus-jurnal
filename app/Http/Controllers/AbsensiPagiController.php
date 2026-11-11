<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPiket;
use App\Models\KelompokBtq;
use App\Models\PesertaTahfidz;
use App\Models\Rombel;
use App\Models\RombelSiswa;
use App\Models\Siswa;
use App\Models\Absensi7Kaih;
use Carbon\Carbon;

class AbsensiPagiController extends Controller
{
    // 1. Dashboard Pilihan (Otomatis mendeteksi tugas user hari ini)
    public function index() {
        $user = auth()->user();
        $hariIni = Carbon::now()->locale('id')->dayName; // 'Senin', 'Selasa', dll
        $tasks = [];

        // Cek Tugas Piket
        $isPiket = JadwalPiket::where('hari', $hariIni)->where('guru_id', $user->id)->exists();
        if ($isPiket) {
            $tasks[] = [
                'tipe' => 'piket',
                'judul' => 'Absensi Kegiatan Pagi (Piket)',
                'deskripsi' => 'Absen Upacara/Apel/Senam untuk siswa reguler.',
                'icon' => '🚩'
            ];
        }

        // Cek Tugas Tahfidz (Khusus Miftahul)
        if (str_contains($user->nama, 'Miftahul')) {
            $tasks[] = [
                'tipe' => 'tahfidz',
                'judul' => 'Absensi Program Tahfidz',
                'deskripsi' => 'Absen 20 peserta Program Tahfidz.',
                'icon' => '🕌'
            ];
        }

        // Cek Tugas BTQ
        $kelompokBtq = KelompokBtq::where('pembina_id', $user->id)->first();
        if ($kelompokBtq) {
            $tasks[] = [
                'tipe' => 'btq',
                'judul' => 'Absensi Kelompok BTQ',
                'deskripsi' => 'Absen anggota ' . $kelompokBtq->nama_kelompok,
                'icon' => '📖'
            ];
        }

        return view('absensi_pagi', compact('tasks', 'user'));
    }

    // 2. Halaman Form Absensi
    public function form($tipe) {
        $user = auth()->user();
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        if ($tipe === 'piket') {
            $dataKelas = [];
            $tahfidzIds = PesertaTahfidz::pluck('siswa_id');
            $rombels = Rombel::orderBy('kode')->get();
            
            foreach ($rombels as $rombel) {
                $siswaKelas = RombelSiswa::where('rombel_id', $rombel->id)
                    ->whereNotIn('siswa_id', $tahfidzIds)
                    ->with('siswa')
                    ->get();
                if ($siswaKelas->isNotEmpty()) {
                    $dataKelas[$rombel->kode] = $siswaKelas;
                }
            }
            return view('absensi_pagi_form', compact('tipe', 'dataKelas', 'tanggalHariIni'));

        } elseif ($tipe === 'tahfidz') {
            $peserta = PesertaTahfidz::with('siswa')->get()->sortBy('siswa.nama');
            return view('absensi_pagi_form', compact('tipe', 'peserta', 'tanggalHariIni'));

        } elseif ($tipe === 'btq') {
            $kelompok = KelompokBtq::where('pembina_id', $user->id)->first();
            $peserta = $kelompok->anggota()->with('siswa')->get()->sortBy('siswa.nama');
            return view('absensi_pagi_form', compact('tipe', 'peserta', 'kelompok', 'tanggalHariIni'));
        }

        return redirect('/absensi-pagi');
    }

    // 3. Simpan Data ke Database
    public function store(Request $request) {
        $request->validate(['absensi' => 'required|array', 'tipe' => 'required']);
        
        $tipe = $request->tipe;
        $tanggal = $request->tanggal;
        $user = auth()->user();

        // Tentukan Jenis Kegiatan berdasarkan Hari (untuk Piket)
        $hariIni = Carbon::now()->locale('id')->dayName;
        $mapKegiatan = ['Senin' => 'Upacara', 'Selasa' => 'Apel', 'Rabu' => 'Senam', 'Kamis' => 'Apel', 'Jumat' => 'Ziarah', 'Sabtu' => 'Apel'];
        $jenisKegiatan = $tipe === 'piket' ? ($mapKegiatan[$hariIni] ?? 'Kegiatan Pagi') : ucfirst($tipe);

        foreach ($request->absensi as $siswaId => $status) {
            $siswa = Siswa::find($siswaId);
            $rombelId = $siswa ? $siswa->rombels->first()->id : null;

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
                    'otoritas_level' => $tipe === 'piket' ? 1 : ($tipe === 'tahfidz' ? 2 : 3),
                ]
            );
        }

        return redirect('/absensi-pagi')->with('success', 'Alhamdulillah, absensi pagi berhasil disimpan!');
    }
}