<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\JadwalPiket;
use App\Models\User;

class AdminJadwalPiketController extends Controller
{
    // 1. Tampilkan daftar semua jadwal piket
    public function index() {
        $jadwalPikets = JadwalPiket::with('guru')
            ->orderBy('hari', 'asc')
            ->orderBy('urutan', 'asc')
            ->get();
            
        return view('admin.jadwal_piket.index', compact('jadwalPikets'));
    }

    // 2. Tampilkan form tambah jadwal piket
    public function create() {
        $gurus = User::whereIn('role', ['guru_mapel', 'admin', 'kepsek'])->orderBy('nama', 'asc')->get();
        return view('admin.jadwal_piket.create', compact('gurus'));
    }

    // 3. Simpan jadwal piket baru
    public function store(Request $request) {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'guru_id' => 'required|exists:users,id',
            'urutan' => [
                'required',
                'integer',
                'in:1,2,3',
                Rule::unique('jadwal_piket', 'urutan')->where(function ($query) use ($request) {
                    return $query->where('hari', $request->hari);
                }),
            ],
        ], [
            // 🔴 PERUBAHAN 1: Pesan kustom untuk duplikasi slot
            'urutan.unique' => 'Urutan piket ini sudah diisi oleh guru lain pada hari yang sama. Silakan pilih urutan yang masih kosong.',
        ]);

        JadwalPiket::create([
            'hari' => $request->hari,
            'guru_id' => $request->guru_id,
            'urutan' => $request->urutan,
        ]);

        return redirect()->route('admin.jadwal_piket.index')->with('success', 'Jadwal Piket berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit jadwal piket
    public function edit($id) {
        $jadwalPiket = JadwalPiket::findOrFail($id);
        $gurus = User::whereIn('role', ['guru_mapel', 'admin', 'kepsek'])->orderBy('nama', 'asc')->get();
        
        return view('admin.jadwal_piket.edit', compact('jadwalPiket', 'gurus'));
    }

    // 5. Update data jadwal piket
    public function update(Request $request, $id) {
        $jadwalPiket = JadwalPiket::findOrFail($id);

        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'guru_id' => 'required|exists:users,id',
            'urutan' => [
                'required',
                'integer',
                'in:1,2,3',
                Rule::unique('jadwal_piket', 'urutan')->where(function ($query) use ($request) {
                    return $query->where('hari', $request->hari);
                })->ignore($id),
            ],
        ], [
            // 🔴 PERUBAHAN 2: Pesan kustom untuk duplikasi slot (sama dengan store)
            'urutan.unique' => 'Urutan piket ini sudah diisi oleh guru lain pada hari yang sama. Silakan pilih urutan yang masih kosong.',
        ]);

        $jadwalPiket->update([
            'hari' => $request->hari,
            'guru_id' => $request->guru_id,
            'urutan' => $request->urutan,
        ]);

        return redirect()->route('admin.jadwal_piket.index')->with('success', 'Jadwal Piket berhasil diperbarui!');
    }

    // 6. Hapus jadwal piket
    public function destroy($id) {
        JadwalPiket::findOrFail($id)->delete();
        return redirect()->route('admin.jadwal_piket.index')->with('success', 'Jadwal Piket berhasil dihapus!');
    }
}