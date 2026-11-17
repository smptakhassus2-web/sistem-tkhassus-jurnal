<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi7Kaih; // Menggunakan tabel absensi 7 KAIH
use App\Models\Tahfidz;      // Menggunakan tabel tahfidzs (sesuai view: juz, surat, nilai)
use Carbon\Carbon;

class WaliController extends Controller
{
    // 1. Middleware: Pastikan hanya role 'wali_murid' yang bisa akses
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'wali_murid') {
                abort(403, 'Akses ditolak. Halaman ini khusus untuk Wali Murid.');
            }
            return $next($request);
        });
    }

    // 2. Dashboard Utama Wali Murid
    public function index()
    {
        $user = auth()->user();

        // 🔴 PENTING: View mengharapkan objek tunggal $anak, bukan collection
        $anak = $user->siswas()->with('rombels')->first();

        // Jika tidak ada anak yang terhubung, kirim data kosong agar view tidak error
        if (!$anak) {
            return view('wali.dashboard', [
                'anak' => null,
                'absensiBulanIni' => ['H' => 0, 'S' => 0, 'I' => 0, 'A' => 0],
                'tahfidzTerbaru' => collect()
            ]);
        }

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 🔴 HITUNG ABSENSI (Mapping ke H, S, I, A sesuai kebutuhan View)
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

        // 🔴 AMBIL DATA TAHFIDZ TERBARU (Sesuai kolom di view: juz, surat, ayat_awal, ayat_akhir, nilai)
        $tahfidzTerbaru = Tahfidz::where('siswa_id', $anak->id)
            ->with('guru') // Untuk memanggil $item->guru->nama di view
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // Kirim variabel yang PERSIS diharapkan oleh dashboard.blade.php
        return view('wali.dashboard', compact('anak', 'absensiBulanIni', 'tahfidzTerbaru'));
    }

    // 3. (Opsional untuk nanti) Detail Absensi
    public function absensiDetail($siswaId)
    {
        // Akan kita isi setelah dashboard utama berhasil
    }

    // 4. (Opsional untuk nanti) Detail Tahfidz
    public function tahfidzDetail($siswaId)
    {
        // Akan kita isi setelah dashboard utama berhasil
    }
}