<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi7Kaih;
use App\Models\Tahfidz; // 🔴 PENTING: Menggunakan model Tahfidz, BUKAN ProgresTahfidz
use Carbon\Carbon;

class WaliController extends Controller
{
    public function index()
    {
        // 1. Keamanan: Cek role langsung di method (Aman untuk Laravel 13)
        if (!auth()->check() || auth()->user()->role !== 'wali_murid') {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Wali Murid.');
        }

        $user = auth()->user();

        // 2. Ambil data anak (Objek tunggal, sesuai ekspektasi view Bapak)
        $anak = $user->siswas()->with('rombels')->first();

        // Jika tidak ada anak terhubung, kembalikan data kosong agar view tidak error
        if (!$anak) {
            return view('wali.dashboard', [
                'anak' => null,
                'absensiBulanIni' => ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0],
                'tahfidzTerbaru' => collect()
            ]);
        }

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 3. Hitung Absensi 7 KAIH (Mapping ke 'H', 'S', 'I', 'A' sesuai view Bapak)
        $absensiRaw = Absensi7Kaih::where('siswa_id', $anak->id)
            ->whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->get();

        $absensiBulanIni = [
            'H' => $absensiRaw->where('status', 'Hadir')->count(),
            'S' => $absensiRaw->where('status', 'Sakit')->count(),
            'I' => $absensiRaw->where('status', 'Izin')->count(),
            'A' => $absensiRaw->where('status', 'Alpha')->count(),
        ];

        // 4. Ambil Data Tahfidz Terbaru (Sesuai kolom di view: juz, surat, ayat_awal, ayat_akhir, nilai)
        $tahfidzTerbaru = Tahfidz::where('siswa_id', $anak->id)
            ->with('guru') // Agar $item->guru->nama di view bisa dipanggil
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // 5. Kirim variabel yang PERSIS diharapkan oleh dashboard.blade.php Bapak
        return view('wali.dashboard', compact('anak', 'absensiBulanIni', 'tahfidzTerbaru'));
    }
}