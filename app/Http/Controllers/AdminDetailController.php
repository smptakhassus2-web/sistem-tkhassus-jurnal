<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ceklok;
use App\Models\JurnalMengajar;
use App\Models\AbsensiSiswa;

class AdminDetailController extends Controller
{
    public function show($ceklokId) {
        $ceklok = Ceklok::with(['jadwal.mapel', 'jadwal.rombel', 'guru', 'jurnal', 'absensi.siswa'])
                        ->findOrFail($ceklokId);
        return view('admin.detail', compact('ceklok'));
    }

    public function updateCatatan(Request $request, $ceklokId) {
        $request->validate(['catatan' => 'required|string']);
        $ceklok = Ceklok::findOrFail($ceklokId);
        $ceklok->catatan_admin = $request->catatan;
        $ceklok->save();
        return back()->with('success', 'Catatan teguran berhasil disimpan!');
    }
}