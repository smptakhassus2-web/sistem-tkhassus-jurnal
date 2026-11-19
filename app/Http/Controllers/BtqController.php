<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelompokBtq;
use App\Models\PenilaianBtq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Rule;

class BtqController extends Controller
{
    // 1. Tampilkan Halaman Input & Riwayat
    public function index()
    {
        $user = Auth::user();

        // Cari kelompok BTQ yang dibina oleh guru ini
        $kelompok = KelompokBtq::where('pembina_id', $user->id)->first();

        // Jika guru ini bukan pembina BTQ, tolak akses
        if (!$kelompok) {
            abort(403, 'Anda tidak terdaftar sebagai Pembina BTQ.');
        }

        // Ambil daftar siswa yang menjadi anggota kelompok ini saja
        $siswaList = $kelompok->anggota()->orderBy('nama')->get();

        // Ambil riwayat penilaian yang pernah diinput oleh pembina ini
        $riwayat = PenilaianBtq::where('pembina_id', $user->id)
            ->with('siswa')
            ->latest()
            ->take(15)
            ->get();

        return view('btq.index', compact('kelompok', 'siswaList', 'riwayat'));
    }

    // 2. Simpan Data Penilaian Baru
    public function store(Request $request)
    {
        $user = Auth::user();
        $kelompok = KelompokBtq::where('pembina_id', $user->id)->first();

        // Validasi Keamanan: Pastikan siswa yang dipilih benar-benar anggota kelompok ini
        $anggotaIds = $kelompok->anggota->pluck('id')->toArray();

        $request->validate([
            'siswa_id' => ['required', Rule::in($anggotaIds)],
            'jilid' => 'nullable|string|max:50',
            'halaman' => 'nullable|integer|min:1',
            'juz' => 'nullable|integer|min:1|max:30',
            'surat' => 'nullable|string|max:100',
            'ayat_awal' => 'nullable|integer|min:1',
            'ayat_akhir' => 'nullable|integer|min:1',
            'nilai' => 'required|in:Lancar,Baik,Cukup,Kurang',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Simpan ke database
        PenilaianBtq::create([
            'kelompok_btq_id' => $kelompok->id,
            'siswa_id' => $request->siswa_id,
            'pembina_id' => $user->id,
            'jilid' => $request->jilid,
            'halaman' => $request->halaman,
            'juz' => $request->juz,
            'surat' => $request->surat,
            'ayat_awal' => $request->ayat_awal,
            'ayat_akhir' => $request->ayat_akhir,
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
            'tanggal' => now()->format('Y-m-d'),
        ]);

        return back()->with('success', 'Alhamdulillah, penilaian BTQ berhasil disimpan!');
    }
        // 3. Fungsi untuk halaman cetak laporan pembina
    public function cetak()
    {
        $user = Auth::user();

        // Cari kelompok BTQ yang dibina oleh guru ini
        $kelompok = KelompokBtq::where('pembina_id', $user->id)->first();

        // Jika bukan pembina, tolak akses
        if (!$kelompok) {
            abort(403, 'Anda tidak terdaftar sebagai Pembina BTQ.');
        }

        // Ambil SEMUA data penilaian yang diinput oleh pembina ini
        $dataPenilaian = PenilaianBtq::with(['siswa', 'kelompok'])
            ->where('pembina_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('siswa_id', 'asc')
            ->get();

        return view('btq.cetak', compact('kelompok', 'dataPenilaian'));
    }
}