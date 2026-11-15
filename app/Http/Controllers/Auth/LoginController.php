<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rombel;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 1. HANYA Admin & Kepala Sekolah yang masuk ke Dashboard Monitoring
            if ($user->role === 'admin' || $user->role === 'kepsek') {
                return redirect()->route('dashboard');
            }

            // 2. 🔴 CEK: Apakah user ini adalah Wali Kelas? 🔴
            $isWaliKelas = Rombel::where('wali_kelas_id', $user->id)->exists();
            
            if ($isWaliKelas) {
                return redirect('/wali-kelas'); // Arahkan ke Dashboard Wali Kelas
            }

            // 3. Wali Murid masuk ke portal wali
            if ($user->role === 'wali_murid') {
                return redirect('/wali');
            }

            // 4. Default untuk Guru Mapel biasa (yang bukan Wali Kelas)
            return redirect('/guru');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}