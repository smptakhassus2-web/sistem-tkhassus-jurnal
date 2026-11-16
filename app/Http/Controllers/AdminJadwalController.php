<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Rombel;
use App\Models\Mapel;
use App\Models\User;

class AdminJadwalController extends Controller
{
    // 1. Tampilkan daftar semua jadwal
    public function index() {
        $jadwals = Jadwal::with(['rombel', 'mapel', 'guru'])
                         ->orderBy('hari', 'asc')
                         ->orderBy('jam_ke', 'asc')
                         ->get();
                         
        return view('admin.jadwal.index', compact('jadwals'));
    }

    // 2. Tampilkan form tambah jadwal
    public function create() {
        $rombels = Rombel::orderBy('kode', 'asc')->get();
        $mapels = Mapel::orderBy('nama', 'asc')->get();
        $gurus = User::whereIn('role', ['guru_mapel', 'admin', 'kepsek'])->orderBy('nama', 'asc')->get();
        
        return view('admin.jadwal.create', compact('rombels', 'mapels', 'gurus'));
    }

    // 3. Simpan jadwal baru
    public function store(Request $request) {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_ke' => 'required|integer|min:0|max:10',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'rombel_id' => 'required|exists:rombels,id',
            'mapel_id' => 'nullable|exists:mapels,id',
            'guru_id' => 'nullable|exists:users,id',
            'jenis' => 'required|in:intrakurikuler,kokurikuler,ekstra',
        ]);

        // 🔒 AMAN: Simpan hanya kolom yang valid, hindari null yang tidak disengaja
        Jadwal::create([
            'hari' => $request->hari,
            'jam_ke' => $request->jam_ke,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'rombel_id' => $request->rombel_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pelajaran berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit jadwal
    public function edit($id) {
        $jadwal = Jadwal::findOrFail($id);
        $rombels = Rombel::orderBy('kode', 'asc')->get();
        $mapels = Mapel::orderBy('nama', 'asc')->get();
        $gurus = User::whereIn('role', ['guru_mapel', 'admin', 'kepsek'])->orderBy('nama', 'asc')->get();
        
        return view('admin.jadwal.edit', compact('jadwal', 'rombels', 'mapels', 'gurus'));
    }

    // 5. Update data jadwal
    public function update(Request $request, $id) {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_ke' => 'required|integer|min:0|max:10',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'rombel_id' => 'required|exists:rombels,id',
            'mapel_id' => 'nullable|exists:mapels,id',
            'guru_id' => 'nullable|exists:users,id',
            'jenis' => 'required|in:intrakurikuler,kokurikuler,ekstra',
        ]);

        $jadwal->update([
            'hari' => $request->hari,
            'jam_ke' => $request->jam_ke,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'rombel_id' => $request->rombel_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pelajaran berhasil diperbarui!');
    }

    // 6. Hapus jadwal
    public function destroy($id) {
        Jadwal::findOrFail($id)->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pelajaran berhasil dihapus!');
    }
}