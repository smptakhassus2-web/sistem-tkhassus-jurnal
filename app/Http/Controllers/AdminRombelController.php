<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\User;

class AdminRombelController extends Controller
{
    // 1. Tampilkan daftar semua kelas
    public function index() {
        // Ambil semua rombel, urutkan berdasarkan kode
        $rombels = Rombel::orderBy('kode', 'asc')->get();
        
        // Ambil daftar guru yang bisa ditunjuk sebagai wali kelas (Guru Mapel, Admin, Kepsek)
        $gurus = User::whereIn('role', ['guru_mapel', 'admin', 'kepsek'])
                     ->orderBy('nama', 'asc')
                     ->get();

        return view('admin.rombel.index', compact('rombels', 'gurus'));
    }

    // 2. Tampilkan form tambah kelas
    public function create() {
        $gurus = User::whereIn('role', ['guru_mapel', 'admin', 'kepsek'])
                     ->orderBy('nama', 'asc')
                     ->get();
        return view('admin.rombel.create', compact('gurus'));
    }

    // 3. Simpan kelas baru ke database
    public function store(Request $request) {
        $request->validate([
            'kode' => 'required|string|max:20|unique:rombels,kode', // Misal: 7A, 8B
            'nama' => 'required|string|max:255', // Misal: Kelas 7A
            'tingkat' => 'required|in:7,8,9',
            'jenis' => 'required|in:utama,tambahan',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        Rombel::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'tingkat' => $request->tingkat,
            'jenis' => $request->jenis,
            'wali_kelas_id' => $request->wali_kelas_id,
            'tahun_ajaran' => '2026/2027', // Default sesuai sistem kita
        ]);

        return redirect()->route('admin.rombel.index')->with('success', 'Data kelas berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit kelas
    public function edit($id) {
        $rombel = Rombel::findOrFail($id);
        $gurus = User::whereIn('role', ['guru_mapel', 'admin', 'kepsek'])
                     ->orderBy('nama', 'asc')
                     ->get();

        return view('admin.rombel.edit', compact('rombel', 'gurus'));
    }

    // 5. Update data kelas
    public function update(Request $request, $id) {
        $rombel = Rombel::findOrFail($id);

        $request->validate([
            'kode' => 'required|string|max:20|unique:rombels,kode,' . $id,
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|in:7,8,9',
            'jenis' => 'required|in:utama,tambahan',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $rombel->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'tingkat' => $request->tingkat,
            'jenis' => $request->jenis,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()->route('admin.rombel.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    // 6. Hapus kelas
    public function destroy($id) {
        $rombel = Rombel::findOrFail($id);
        
        // Catatan: Karena di migrasi database kita menggunakan cascadeOnDelete untuk rombel_siswa,
        // maka saat rombel dihapus, data pivot siswa di kelas ini akan otomatis terhapus aman oleh database.
        $rombel->delete();

        return redirect()->route('admin.rombel.index')->with('success', 'Data kelas berhasil dihapus!');
    }
}