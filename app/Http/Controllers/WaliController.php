<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\AbsensiSiswa;
use App\Models\Tahfidz;
use App\Models\Ceklok;

class WaliController extends Controller
{
    public function index() {
        $user = auth()->user();
        
        // Ambil data anak yang terhubung dengan akun wali ini
        $anak = Siswa::whereHas('users', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('rombels')->first();

        if (!$anak) {
            return redirect('/logout')->withErrors('Akun tidak terhubung dengan data siswa. Hubungi Admin.');
        }

        // Ambil Data Absensi Bulan Ini (Gabungan Intrakurikuler & 7 KAIH nanti)
        $absensiBulanIni = AbsensiSiswa::where('siswa_id', $anak->id)
            ->whereMonth('created_at', now()->month)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Ambil Data Tahfidz Terbaru
        $tahfidzTerbaru = Tahfidz::where('siswa_id', $anak->id)
            ->with('guru')
            ->latest()
            ->take(5)
            ->get();

        return view('wali.dashboard', compact('anak', 'absensiBulanIni', 'tahfidzTerbaru'));
    }
}
