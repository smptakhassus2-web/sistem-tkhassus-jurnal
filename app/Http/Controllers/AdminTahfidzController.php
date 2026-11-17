<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgresTahfidz;
use App\Models\Rombel;
use Carbon\Carbon;

class AdminTahfidzController extends Controller
{
    // 1. Tampilkan Rekap Progres Tahfidz
    public function index(Request $request) {
        // Default filter: Bulan ini
        $filterBulan = $request->input('bulan', Carbon::now()->format('Y-m'));
        $filterRombel = $request->input('rombel_id', '');

        // Query dasar dengan relasi
        $query = ProgresTahfidz::with(['siswa.rombels', 'penguji'])
            ->whereMonth('tanggal_setor', Carbon::parse($filterBulan)->month)
            ->whereYear('tanggal_setor', Carbon::parse($filterBulan)->year);

        // Jika ada filter rombel, tambahkan ke query
        if ($filterRombel) {
            $query->whereHas('siswa.rombels', function($q) use ($filterRombel) {
                $q->where('rombel_id', $filterRombel);
            });
        }

        $progresList = $query->orderBy('tanggal_setor', 'desc')
                            ->orderBy('siswa_id', 'asc')
                            ->get();

        // Hitung Ringkasan Statistik
        $totalSetoran = $progresList->count();
        $totalMutqin = $progresList->where('status', 'mutqin')->count();
        $totalProses = $progresList->where('status', 'proses')->count();

        // Ambil daftar rombel untuk dropdown filter
        $rombels = Rombel::orderBy('kode', 'asc')->get();

        return view('admin.tahfidz.index', compact(
            'progresList', 'rombels', 'filterBulan', 'filterRombel',
            'totalSetoran', 'totalMutqin', 'totalProses'
        ));
    }

    // 2. Fungsi untuk Halaman Cetak (Print View)
    public function cetak(Request $request) {
        $filterBulan = $request->input('bulan', Carbon::now()->format('Y-m'));
        $filterRombel = $request->input('rombel_id', '');

        $query = ProgresTahfidz::with(['siswa.rombels', 'penguji'])
            ->whereMonth('tanggal_setor', Carbon::parse($filterBulan)->month)
            ->whereYear('tanggal_setor', Carbon::parse($filterBulan)->year);

        if ($filterRombel) {
            $query->whereHas('siswa.rombels', function($q) use ($filterRombel) {
                $q->where('rombel_id', $filterRombel);
            });
        }

        $progresList = $query->orderBy('siswa_id', 'asc')
                            ->orderBy('tanggal_setor', 'asc')
                            ->get();

        return view('admin.tahfidz.cetak', compact('progresList', 'filterBulan', 'filterRombel'));
    }
}