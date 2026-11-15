<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\RombelSiswa;

class AdminSiswaController extends Controller
{
    public function index() {
        $siswas = Siswa::with('rombels')->orderBy('nama', 'asc')->get();
        $rombels = Rombel::orderBy('kode', 'asc')->get();

        return view('admin.siswa.index', compact('siswas', 'rombels'));
    }

    public function create() {
        $rombels = Rombel::orderBy('kode', 'asc')->get();
        return view('admin.siswa.create', compact('rombels'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'nullable|string|max:50|unique:siswas,nis', // 🔴 DIPERBAIKI: siswas
            'jenis_kelamin' => 'required|in:L,P',
            'rombel_id' => 'nullable|exists:rombels,id',
        ]);

        $siswa = Siswa::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        if ($request->rombel_id) {
            RombelSiswa::create([
                'rombel_id' => $request->rombel_id,
                'siswa_id' => $siswa->id,
            ]);
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit($id) {
        $siswa = Siswa::findOrFail($id);
        $rombels = Rombel::orderBy('kode', 'asc')->get();
        
        $currentRombel = RombelSiswa::where('siswa_id', $id)->first();
        $rombel_id = $currentRombel ? $currentRombel->rombel_id : null;

        return view('admin.siswa.edit', compact('siswa', 'rombels', 'rombel_id'));
    }

    public function update(Request $request, $id) {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'nullable|string|max:50|unique:siswas,nis,' . $id, // 🔴 DIPERBAIKI: siswas
            'jenis_kelamin' => 'required|in:L,P',
            'rombel_id' => 'nullable|exists:rombels,id',
        ]);

        $siswa->update([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        RombelSiswa::where('siswa_id', $id)->delete();
        
        if ($request->rombel_id) {
            RombelSiswa::create([
                'rombel_id' => $request->rombel_id,
                'siswa_id' => $id,
            ]);
        }

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id) {
        RombelSiswa::where('siswa_id', $id)->delete();
        Siswa::findOrFail($id)->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}