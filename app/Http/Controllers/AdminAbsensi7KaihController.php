<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi7Kaih;
use App\Models\Rombel;
use Carbon\Carbon;

class AdminAbsensi7KaihController extends Controller
{
    // 1. Tampilkan Rekap Absensi 7 KAIH (SUDAH ADA & TIDAK DIUBAH)
    public function index(Request $request) {
        $filterTanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));
        $filterRombel = $request->input('rombel_id', '');

        // 1. Query dasar untuk ringkasan
        $baseQuery = Absensi7Kaih::where('tanggal', $filterTanggal);
        if ($filterRombel) {
            $baseQuery->where('rombel_id', $filterRombel);
        }

        // 2. Hitung Ringkasan Statistik (menggunakan clone agar query asli tidak berubah)
        $totalHadir = (clone $baseQuery)->where('status', 'Hadir')->count();
        $totalSakit = (clone $baseQuery)->where('status', 'Sakit')->count();
        $totalIzin  = (clone $baseQuery)->where('status', 'Izin')->count();
        $totalAlpha = (clone $baseQuery)->where('status', 'Alpha')->count();

        // 3. Ambil Data Detail untuk Tabel
        $absensis = Absensi7Kaih::with(['siswa', 'rombel', 'inputOleh'])
            ->where('tanggal', $filterTanggal)
            ->when($filterRombel, function($q) use ($filterRombel) {
                $q->where('rombel_id', $filterRombel);
            })
            ->orderBy('jenis_kegiatan', 'asc')
            ->orderBy('siswa_id', 'asc')
            ->get();

        // 4. Ambil Daftar Rombel untuk Dropdown
        $rombels = Rombel::orderBy('kode', 'asc')->get();

        return view('admin.absensi_7kaih.index', compact(
            'absensis', 'rombels', 'filterTanggal', 'filterRombel',
            'totalHadir', 'totalSakit', 'totalIzin', 'totalAlpha'
        ));
    }

    // 🔴 2. BARU: Fungsi untuk Halaman Cetak (Print View)
    public function cetak(Request $request) {
        $filterTanggal = $request->input('tanggal', Carbon::today()->format('Y-m-d'));
        $filterRombel = $request->input('rombel_id', '');

        // Ambil data dengan filter yang sama persis seperti di halaman index
        $absensis = Absensi7Kaih::with(['siswa', 'rombel', 'inputOleh'])
            ->where('tanggal', $filterTanggal)
            ->when($filterRombel, function($q) use ($filterRombel) {
                $q->where('rombel_id', $filterRombel);
            })
            ->orderBy('jenis_kegiatan', 'asc')
            ->orderBy('siswa_id', 'asc')
            ->get();

        return view('admin.absensi_7kaih.cetak', compact('absensis', 'filterTanggal', 'filterRombel'));
    }
}