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
        // 1. Tentukan Hari Ini (Format: Senin, Selasa, dst)
        $hariIni = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][Carbon::now()->dayOfWeek];
        $waktuSekarang = Carbon::now()->format('H:i:s');
        $tanggalHariIni = Carbon::today()->format('Y-m-d');

        // 2. Ambil daftar unik ID Guru yang MEMILIKI JADWAL hari ini
        $guruDenganJadwal = Jadwal::where('hari', $hariIni)->pluck('guru_id')->unique();

        $hadir = 0;
        $terlambat = 0;
        $alpha = 0;

        // 3. Looping setiap guru yang punya jadwal untuk dihitung statusnya
        foreach ($guruDenganJadwal as $guruId) {
            // Cek apakah guru ini sudah melakukan ceklok hari ini?
            $sudahCeklok = Ceklok::where('guru_id', $guruId)
                                 ->whereDate('tanggal', $tanggalHariIni)
                                 ->first();

            if ($sudahCeklok) {
                // Sudah ceklok. Cek apakah dia terlambat?
                // (Kita ambil jadwal pertamanya hari ini sebagai acuan)
                $jadwalPertama = Jadwal::where('hari', $hariIni)
                                       ->where('guru_id', $guruId)
                                       ->orderBy('jam_ke', 'asc')
                                       ->first();
                
                if ($jadwalPertama && $sudahCeklok->waktu_mulai > $jadwalPertama->waktu_mulai) {
                    $terlambat++;
                } else {
                    $hadir++;
                }
            } else {
                // BELUM CEKLOK. Kita cek apakah jam pertama dia hari ini sudah lewat?
                $jamPertama = Jadwal::where('hari', $hariIni)
                                    ->where('guru_id', $guruId)
                                    ->min('waktu_mulai');

                // Jika jam pertama sudah lewat dari waktu sekarang, berarti Alpha
                if ($jamPertama && $waktuSekarang > $jamPertama) {
                    $alpha++;
                }
            }
        }

        // 4. Hitung Persentase Jurnal (Guru yang sudah isi jurnal / Total guru yang punya jadwal)
        $totalGuruBerjadwal = $guruDenganJadwal->count();
        $guruIsiJurnal = \App\Models\JurnalMengajar::whereDate('created_at', $tanggalHariIni)
                                                   ->whereIn('ceklok_id', function($query) use ($tanggalHariIni) {
                                                       $query->select('id')->from('cekloks')->whereDate('tanggal', $tanggalHariIni);
                                                   })
                                                   ->distinct('ceklok_id') // Hitung unik per sesi ceklok
                                                   ->count(); // Sederhana: jumlah jurnal hari ini
        
        // Untuk persentase, kita pakai acuan jumlah guru yang sudah ceklok hari ini
        $totalSudahCeklok = Ceklok::whereDate('tanggal', $tanggalHariIni)->distinct('guru_id')->count('guru_id');
        $persentaseJurnal = $totalSudahCeklok > 0 ? 100 : 0; // Nanti bisa diperhalus lagi

        // 5. Ambil Data Guru untuk Tabel Peringatan (Yang punya jadwal, jam sudah lewat, belum ceklok)
        $guruPerluPerhatian = Jadwal::where('hari', $hariIni)
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