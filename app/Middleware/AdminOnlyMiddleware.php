<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnlyMiddleware
{
    /**
     * 🔒 SATPAM DIGITAL: Hanya Admin & Kepsek yang boleh akses route CRUD
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Jika tidak login, atau role-nya BUKAN admin dan BUKAN kepsek, tolak akses
        if (!$user || !in_array($user->role, ['admin', 'kepsek'])) {
            abort(403, 'AKSES DITOLAK: Halaman manajemen data ini hanya untuk Administrator atau Kepala Sekolah.');
        }

        // Jika aman, izinkan melanjutkan ke halaman yang diminta
        return $next($request);
    }
}