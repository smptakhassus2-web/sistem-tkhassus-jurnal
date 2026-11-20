<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenilaianBtq;

class AdminBtqController extends Controller
{
    // 1. Menampilkan Halaman Rekap BTQ untuk Admin/Waka
    public function index()
    {
        // Ambil SEMUA data penilaian BTQ, urutkan dari yang terbaru
        $penilaians = PenilaianBtq::with(['siswa', 'pembina', 'kelompok'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.btq.index', compact('penilaians'));
    }

    // 2. Menampilkan Halaman Cetak Rekap BTQ
    public function cetak()
    {
        $penilaians = PenilaianBtq::with(['siswa', 'pembina', 'kelompok'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.btq.cetak', compact('penilaians'));
    }
}