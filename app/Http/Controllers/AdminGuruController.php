<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rombel;

class AdminGuruController extends Controller
{
    // 1. Tampilkan daftar semua guru
    public function index() {
        // Ambil semua user dengan role terkait, diurutkan berdasarkan nama
        $gurus = User::whereIn('role', ['guru_mapel', 'admin', 'kepsek'])
                     ->orderBy('nama', 'asc')
                     ->get();

        // Ambil daftar rombel untuk kebutuhan dropdown dan pengecekan wali kelas di view
        $rombels = Rombel::orderBy('kode', 'asc')->get();

        return view('admin.guru.index', compact('gurus', 'rombels'));
    }

    // 2. Tampilkan form tambah guru
    public function create() {
        $rombels = Rombel::orderBy('kode', 'asc')->get();
        return view('admin.guru.create', compact('rombels'));
    }

    // 3. Simpan guru baru ke database
    public function store(Request $request) {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:guru_mapel,admin,kepsek',
            'no_hp' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:100',
            'wali_kelas_id' => 'nullable|exists:rombels,id',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
        ]);

        // Jika guru ini langsung ditunjuk sebagai wali kelas saat pembuatan
        if ($request->wali_kelas_id) {
            Rombel::where('id', $request->wali_kelas_id)->update(['wali_kelas_id' => $user->id]);
        }

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    // 4. Tampilkan form edit guru
    public function edit($id) {
        $guru = User::findOrFail($id);
        $rombels = Rombel::orderBy('kode', 'asc')->get();
        
        // Cari apakah guru ini sudah jadi wali kelas di rombel mana
        $currentRombel = Rombel::where('wali_kelas_id', $id)->first();
        $wali_kelas_id = $currentRombel ? $currentRombel->id : null;

        return view('admin.guru.edit', compact('guru', 'rombels', 'wali_kelas_id'));
    }

    // 5. Update data guru
    public function update(Request $request, $id) {
        $guru = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6', // Password opsional saat edit
            'role' => 'required|in:guru_mapel,admin,kepsek',
            'no_hp' => 'nullable|string|max:20',
            'jabatan' => 'nullable|string|max:100',
            'wali_kelas_id' => 'nullable|exists:rombels,id',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'no_hp' => $request->no_hp,
            'jabatan' => $request->jabatan,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $guru->update($data);

        // Update status wali kelas
        // 1. Kosongkan dulu wali kelas lama (jika ada)
        Rombel::where('wali_kelas_id', $id)->update(['wali_kelas_id' => null]);
        
        // 2. Isi wali kelas baru jika dipilih
        if ($request->wali_kelas_id) {
            Rombel::where('id', $request->wali_kelas_id)->update(['wali_kelas_id' => $id]);
        }

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    // 6. Hapus guru
    public function destroy($id) {
        $guru = User::findOrFail($id);
        
        // Kosongkan dulu jika dia adalah wali kelas agar tidak ada data yatim (orphan)
        Rombel::where('wali_kelas_id', $id)->update(['wali_kelas_id' => null]);
        
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus!');
    }
}