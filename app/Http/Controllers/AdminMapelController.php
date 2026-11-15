<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;

class AdminMapelController extends Controller
{
    // 1. Tampilkan daftar semua mata pelajaran
    public function index() {
        $mapels = Mapel::orderBy('nama', 'asc')->get();
        return view('admin.mapel.index', compact('mapels'));
    }

    // 2. Tampilkan form tambah mapel
    public function create() {
        return view('admin.mapel.create');
    }

    // 3. Simpan mapel baru
    public function store(Request $request) {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mapels,kode',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:wajib,mulok,ciri_khas',
        ]);

        Mapel::create([
            'kode' => strtoupper($request->kode),
            'nama' => $request->nama,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit mapel
    public function edit($id) {
        $mapel = Mapel::findOrFail($id);
        return view('admin.mapel.edit', compact('mapel'));
    }

    // 5. Update data mapel
    public function update(Request $request, $id) {
        $mapel = Mapel::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:20|unique:mapels,kode,' . $id,
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:wajib,mulok,ciri_khas',
        ]);

        $mapel->update([
            'kode' => strtoupper($request->kode),
            'nama' => $request->nama,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }

    // 6. Hapus mapel
    public function destroy($id) {
        $mapel = Mapel::findOrFail($id);

        // 🔒 AMAN: Cek dulu apakah mapel ini sudah dipakai di jadwal
        if ($mapel->jadwals()->count() > 0) {
            return redirect()->route('admin.mapel.index')
                ->with('error', 'Tidak bisa dihapus! Mapel ini masih dipakai dalam Jadwal Pelajaran.');
        }

        $mapel->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}