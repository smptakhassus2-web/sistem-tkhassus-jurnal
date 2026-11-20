<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Rombel;
use Illuminate\Support\Facades\Auth;

class WakaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Keamanan: Pastikan hanya role 'waka', 'admin', atau 'kepsek' yang bisa akses
        if (!in_array($user->role, ['waka', 'admin', 'kepsek'])) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk monitoring Waka.');
        }

        // Ambil data statistik dasar untuk dashboard monitoring
        $totalGuru = User::whereIn('role', ['guru_mapel', 'guru_tahfidz'])->count();
        $totalSiswa = Siswa::count();
        $totalRombel = Rombel::count();

        return view('waka.index', compact('totalGuru', 'totalSiswa', 'totalRombel'));
    }
}