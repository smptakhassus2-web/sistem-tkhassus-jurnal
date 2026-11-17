<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi7Kaih;
use App\Models\ProgresTahfidz;
use Carbon\Carbon;

class WaliMuridController extends Controller
{
    // Constructor: Pastikan hanya wali_murid yang bisa akses
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'wali_murid') {
                abort(403, 'Akses ditolak. Halaman ini hanya untuk Wali Murid.');
            }
            return $next($request);
        });
    }

    // 1. Dashboard Wali Murid (Menampilkan data semua anak)
    public function index()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        // Ambil semua anak yang terhubung dengan user ini
        $anakList = $user->siswas()->with(['rombels'])->get();

        // Jika tidak ada anak yang terhubung, tampilkan pesan
        if ($anakList->isEmpty()) {
            return view('wali_murid.dashboard', compact('anakList'));
        }

        // Untuk setiap anak, ambil data Absensi 7 KAIH bulan ini
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        foreach ($anakList as $anak) {
            // Absensi 7 KAIH bulan ini
            $anak->absensiBulanIni = Absensi7Kaih::where('siswa_id', $anak->id)
                ->whereMonth('tanggal', $bulanIni)
                ->whereYear('tanggal', $tahunIni)
                ->orderBy('tanggal', 'desc')
                ->get();

            // Hitung ringkasan absensi
            $anak->totalHadir = $anak->absensiBulanIni->where('status', 'Hadir')->count();
            $anak->totalSakit = $anak->absensiBulanIni->where('status', 'Sakit')->count();
            $anak->totalIzin = $anak->absensiBulanIni->where('status', 'Izin')->count();
            $anak->totalAlpha = $anak->absensiBulanIni->where('status', 'Alpha')->count();

            // Progres Tahfidz terbaru (5 terakhir)
            $anak->tahfidzTerbaru = ProgresTahfidz::where('siswa_id', $anak->id)
                ->orderBy('tanggal_setor', 'desc')
                ->limit(5)
                ->get();

            // Total setoran tahfidz
            $anak->totalSetoranTahfidz = ProgresTahfidz::where('siswa_id', $anak->id)->count();
            $anak->totalMutqin = ProgresTahfidz::where('siswa_id', $anak->id)
                ->where('status', 'mutqin')
                ->count();
        }

        return view('wali_murid.dashboard', compact('anakList', 'bulanIni', 'tahunIni'));
    }

    // 2. Detail Absensi per Anak
    public function absensiDetail($siswaId)
    {
        $user = auth()->user();
        
        // Pastikan anak ini memang milik user yang login
        $anak = $user->siswas()->where('siswa_id', $siswaId)->first();
        
        if (!$anak) {
            abort(404, 'Data anak tidak ditemukan.');
        }

        // Ambil semua absensi 7 KAIH
        $absensiList = Absensi7Kaih::where('siswa_id', $siswaId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('wali_murid.absensi_detail', compact('anak', 'absensiList'));
    }

    // 3. Detail Tahfidz per Anak
    public function tahfidzDetail($siswaId)
    {
        $user = auth()->user();
        
        // Pastikan anak ini memang milik user yang login
        $anak = $user->siswas()->where('siswa_id', $siswaId)->first();
        
        if (!$anak) {
            abort(404, 'Data anak tidak ditemukan.');
        }

        // Ambil semua progres tahfidz
        $tahfidzList = ProgresTahfidz::where('siswa_id', $siswaId)
            ->orderBy('tanggal_setor', 'desc')
            ->get();

        return view('wali_murid.tahfidz_detail', compact('anak', 'tahfidzList'));
    }
}