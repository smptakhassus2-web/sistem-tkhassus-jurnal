<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ceklok;
use App\Models\Jadwal;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function index() {
        $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];
        $waktuSekarang = Carbon::now()->format('H:i:s');
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        // 1. BACA LANGSUNG KOLOM 'status' DARI DATABASE
        $hadir = Ceklok::whereDate('tanggal', $tanggalHariIni)->where('status', 'hadir')->count();
        $terlambat = Ceklok::whereDate('tanggal', $tanggalHariIni)->where('status', 'terlambat')->count();

        // 2. Hitung Alpha (HANYA GURU ASLI, kecualikan jadwal tanpa guru)
        // 🔴 PERBAIKAN: whereNotNull('guru_id') ditambahkan
        $guruDenganJadwal = Jadwal::where('hari', $hariIni)
            ->whereNotNull('guru_id')
            ->pluck('guru_id')
            ->unique();

        $alpha = 0;
        foreach ($guruDenganJadwal as $guruId) {
            $sudahCeklok = Ceklok::where('guru_id', $guruId)->whereDate('tanggal', $tanggalHariIni)->exists();
            if (!$sudahCeklok) {
                $jamPertama = Jadwal::where('hari', $hariIni)->where('guru_id', $guruId)->min('waktu_mulai');
                if ($jamPertama && $waktuSekarang > $jamPertama) {
                    $alpha++;
                }
            }
        }

        // 3. Hitung Persentase Jurnal
        $totalSudahCeklok = Ceklok::whereDate('tanggal', $tanggalHariIni)->count();
        $totalIsiJurnal = \App\Models\JurnalMengajar::whereDate('created_at', $tanggalHariIni)->count();
        $persentaseJurnal = $totalSudahCeklok > 0 ? round(($totalIsiJurnal / $totalSudahCeklok) * 100) : 0;

        // 4. Tabel Peringatan (HANYA GURU ASLI yang belum ceklok)
        // 🔴 PERBAIKAN: whereNotNull('guru_id') ditambahkan
        $guruPerluPerhatian = Jadwal::where('hari', $hariIni)
            ->whereNotNull('guru_id')
            ->where('waktu_mulai', '<=', $waktuSekarang)
            ->whereDoesntHave('cekloks', function($query) use ($tanggalHariIni) {
                $query->whereDate('tanggal', $tanggalHariIni);
            })
            ->with(['guru', 'mapel', 'rombel'])
            ->distinct('guru_id')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'hadir', 'terlambat', 'alpha', 'persentaseJurnal', 'guruPerluPerhatian'
        ));
    }

}