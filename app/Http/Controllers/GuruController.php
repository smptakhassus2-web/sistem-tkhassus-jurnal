<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Ceklok;
use App\Models\JurnalMengajar;
use App\Models\AbsensiSiswa;
use App\Models\RombelSiswa;
use App\Models\JadwalPiket;
use App\Models\KelompokBtq;
use App\Models\Absensi7Kaih;
use Carbon\Carbon;

class GuruController extends Controller
{
    public function index() {
        $user = auth()->user();
        $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        $isPiket = \App\Models\JadwalPiket::where('hari', $hariIni)->where('guru_id', $user->id)->exists();
        $isBtq = \App\Models\KelompokBtq::where('pembina_id', $user->id)->exists();
        $isTahfidz = str_contains($user->nama, 'Miftahul');
        
        $tasks = [];
        if ($isPiket) $tasks[] = ['tipe' => 'piket', 'judul' => 'Absensi Kegiatan Pagi (Piket)', 'icon' => '🚩'];
        if ($isBtq) $tasks[] = ['tipe' => 'btq', 'judul' => 'Absensi Kelompok BTQ', 'icon' => '📖'];
        if ($isTahfidz) $tasks[] = ['tipe' => 'tahfidz', 'judul' => 'Absensi Program Tahfidz', 'icon' => '🕌'];

        $jadwalHariIni = Jadwal::where('hari', $hariIni)
                               ->where('guru_id', $user->id)
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

    public function ceklok(Request $request, $jadwalId) {
        $user = auth()->user();
        $tanggalHariIni = Carbon::today()->format('Y-m-d');
        $sudahCeklok = Ceklok::where('jadwal_id', $jadwalId)->where('guru_id', $user->id)->whereDate('tanggal', $tanggalHariIni)->exists();

        if (!$sudahCeklok) {
            $jadwal = Jadwal::find($jadwalId);
            $status = (Carbon::now()->format('H:i:s') > $jadwal->waktu_mulai) ? 'terlambat' : 'hadir';
            Ceklok::create(['jadwal_id' => $jadwalId, 'guru_id' => $user->id, 'tanggal' => $tanggalHariIni, 'waktu_mulai' => Carbon::now(), 'status' => $status, 'tipe' => 'kbm']);
        }
        return redirect()->back()->with('success', 'Alhamdulillah, Kelas dimulai!');
    }

    public function jurnalForm($ceklokId) {
        $ceklok = Ceklok::with(['jadwal.mapel', 'jadwal.rombel'])->findOrFail($ceklokId);
        $rombelId = $ceklok->jadwal->rombel_id;
        $tanggalHariIni = Carbon::today()->format('Y-m-d');
        $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];

        $siswaList = RombelSiswa::where('rombel_id', $rombelId)->with('siswa')->get();
        $siswaIds = $siswaList->pluck('siswa_id')->toArray();
        $siswaTahfidzIds = \App\Models\PesertaTahfidz::pluck('siswa_id')->toArray();

        // 🔴 AMBIL SEMUA DATA ABSENSI PAGI HARI INI (semua jenis kegiatan) 🔴
        $semuaAbsensi = Absensi7Kaih::where('tanggal', $tanggalHariIni)
            ->whereIn('siswa_id', $siswaIds)
            ->get()
            ->groupBy('siswa_id');

        $siswaTidakHadir7Kaih = [];

        foreach ($siswaList as $item) {
            $siswaId = $item->siswa_id;
            $isTahfidz = in_array($siswaId, $siswaTahfidzIds);

            // 🔴 TENTUKAN KEGIATAN WAJIB UNTUK SISWA INI SESUAI HARI + STATUS 🔴
            $kegiatanWajib = $this->getKegiatanWajib($hariIni, $isTahfidz);

            $absensiSiswaIni = $semuaAbsensi->get($siswaId, collect())->keyBy('jenis_kegiatan');

            foreach ($kegiatanWajib as $kegiatan) {
                $record = $absensiSiswaIni->get($kegiatan);

                if (!$record) {
                    // Belum diabsen sama sekali di kegiatan ini
                    $siswaTidakHadir7Kaih[] = [
                        'nama' => $item->siswa->nama,
                        'kegiatan' => $kegiatan,
                        'status' => 'Belum Diabsen'
                    ];
                } elseif ($record->status !== 'Hadir') {
                    // Diabsen tapi bukan Hadir
                    $siswaTidakHadir7Kaih[] = [
                        'nama' => $item->siswa->nama,
                        'kegiatan' => $kegiatan,
                        'status' => $record->status
                    ];
                }
            }
        }

        $jurnal = JurnalMengajar::where('ceklok_id', $ceklokId)->first();
        $absensiData = [];
        foreach (AbsensiSiswa::where('ceklok_id', $ceklokId)->get() as $record) {
            $absensiData[$record->siswa_id] = ['status' => $record->status, 'keterangan' => $record->keterangan];
        }

        return view('guru.jurnal_form', compact('ceklok', 'siswaList', 'jurnal', 'absensiData', 'siswaTidakHadir7Kaih', 'hariIni'));
    }

    public function storeJurnal(Request $request, $ceklokId) {
        $request->validate(['materi' => 'required|string', 'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120']);
        $path = $request->hasFile('foto') ? $request->file('foto')->store('jurnal_foto', 'public') : null;
        
        $jurnalData = ['materi' => $request->materi, 'metode' => $request->metode, 'kendala' => $request->kendala, 'lokasi_gps' => $request->lokasi_gps];
        if ($path) $jurnalData['lampiran_url'] = $path;
        
        JurnalMengajar::updateOrCreate(['ceklok_id' => $ceklokId], $jurnalData);

        if ($request->has('absensi')) {
            foreach ($request->absensi as $siswaId => $data) {
                AbsensiSiswa::updateOrCreate(['ceklok_id' => $ceklokId, 'siswa_id' => $siswaId], ['status' => $data['status'], 'keterangan' => $data['keterangan'] ?? null]);
            }
        }
        return redirect('/guru')->with('success', 'Alhamdulillah, Jurnal, Absensi, dan Lokasi berhasil disimpan!');
    }

    // 🔴 HELPER: Tentukan kegiatan wajib per hari & status Tahfidz 🔴
    private function getKegiatanWajib($hari, $isTahfidz) {
        return match($hari) {
            'Senin'  => ['Upacara'],
            'Selasa' => ['Apel'],
            'Rabu'   => $isTahfidz ? ['Tahfidz'] : ['Senam'],
            'Kamis'  => $isTahfidz ? ['Tahfidz'] : ['Apel'],
            'Jumat'  => $isTahfidz ? ['Ziarah'] : ['Ziarah', 'BTQ'],
            'Sabtu'  => ['Apel'],
            default  => [],
        };
    }
}