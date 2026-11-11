<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Tahfidz;
use Carbon\Carbon;

class TahfidzController extends Controller
{
    // Menampilkan halaman input dan riwayat Tahfidz
    public function index() {
        $siswaList = Siswa::orderBy('nama')->get();
        $riwayat = Tahfidz::with(['siswa', 'guru'])
                          ->where('guru_id', auth()->id())
                          ->latest()
                          ->take(10)
                          ->get();
                          
        return view('tahfidz.index', compact('siswaList', 'riwayat'));
    }

    // Menyimpan data setoran hafalan baru
    public function store(Request $request) {
        $request->validate([
            'siswa_id' => 'required', 
            'juz' => 'required|integer|min:1|max:30',
            'surat' => 'required|string', 
            'ayat_awal' => 'required|integer', 
            'ayat_akhir' => 'required|integer',
            'nilai' => 'required|in:Lancar,Baik,Cukup,Kurang'
        ]);

        Tahfidz::create([
            'siswa_id' => $request->siswa_id,
            'guru_id' => auth()->id(),
            'juz' => $request->juz, 
            'surat' => $request->surat,
            'ayat_awal' => $request->ayat_awal, 
            'ayat_akhir' => $request->ayat_akhir,
            'nilai' => $request->nilai, 
            'tanggal' => Carbon::today()
        ]);

        return back()->with('success', 'Alhamdulillah, data setoran hafalan berhasil disimpan!');
    }
}