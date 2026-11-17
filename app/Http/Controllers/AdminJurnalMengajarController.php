<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JurnalMengajar;
use Carbon\Carbon;

class AdminJurnalMengajarController extends Controller
{
    // 1. Tampilkan Rekap Jurnal Mengajar
    public function index(Request $request) {
        // Default filter: Hari ini
        $filterTanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));

        // Query dasar dengan relasi bertingkat (Jurnal -> Ceklok -> Guru/Jadwal -> Mapel/Rombel)
        $query = JurnalMengajar::with([
            'ceklok.guru', 
            'ceklok.jadwal.mapel', 
            'ceklok.jadwal.rombel'
        ])
        ->whereHas('ceklok', function ($q) use ($filterTanggal) {
            $q->whereDate('tanggal', $filterTanggal);
        });

        $jurnals = $query->orderBy('created_at', 'desc')->get();

        // Hitung Ringkasan Statistik
        $totalJurnal = $jurnals->count();
        $totalGuruMengajar = $jurnals->pluck('ceklok.guru_id')->unique()->count();

        return view('admin.jurnal_mengajar.index', compact('jurnals', 'filterTanggal', 'totalJurnal', 'totalGuruMengajar'));
    }

    // 2. Fungsi untuk Halaman Cetak (Print View)
       // 2. Fungsi untuk Halaman Cetak (Print View)
    public function cetak(Request $request) {
        $filterTanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));

        // 🔴 PERBAIKAN: Gunakan JOIN agar bisa orderBy berdasarkan kolom tabel relasi
        $jurnals = JurnalMengajar::select('jurnal_mengajars.*')
            ->join('cekloks', 'jurnal_mengajars.ceklok_id', '=', 'cekloks.id')
            ->join('jadwals', 'cekloks.jadwal_id', '=', 'jadwals.id')
            ->whereDate('cekloks.tanggal', $filterTanggal)
            ->with(['ceklok.guru', 'ceklok.jadwal.mapel', 'ceklok.jadwal.rombel'])
            ->orderBy('jadwals.rombel_id', 'asc')   // Urutkan per Kelas dulu
            ->orderBy('cekloks.guru_id', 'asc')     // Lalu per Guru
            ->get();

        return view('admin.jurnal_mengajar.cetak', compact('jurnals', 'filterTanggal'));
    }
}