<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminDetailController;
use App\Http\Controllers\TahfidzController;

Route::get('/', function () { return redirect('/login'); });

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Rute Admin Detail & Catatan
Route::get('/admin/detail/{ceklokId}', [AdminDetailController::class, 'show'])->middleware('auth');
Route::post('/admin/catatan/{ceklokId}', [AdminDetailController::class, 'updateCatatan'])->middleware('auth');

// Rute Guru
Route::get('/guru', [GuruController::class, 'index'])->middleware('auth')->name('guru.dashboard');
Route::post('/guru/ceklok/{jadwalId}', [GuruController::class, 'ceklok'])->middleware('auth');
Route::get('/guru/jurnal/{ceklokId}', [GuruController::class, 'jurnalForm'])->middleware('auth');
Route::post('/guru/jurnal/{ceklokId}', [GuruController::class, 'storeJurnal'])->middleware('auth');

// Rute Tahfidz
Route::get('/tahfidz', [TahfidzController::class, 'index'])->middleware('auth')->name('tahfidz.index');
Route::post('/tahfidz', [TahfidzController::class, 'store'])->middleware('auth');

// Route Penilaian BTQ
Route::get('/btq', [App\Http\Controllers\BtqController::class, 'index'])->middleware('auth')->name('btq.index');
Route::post('/btq', [App\Http\Controllers\BtqController::class, 'store'])->middleware('auth');
Route::get('/btq/cetak', [App\Http\Controllers\BtqController::class, 'cetak'])->middleware('auth')->name('btq.cetak');

// Route Portal Wali Murid
Route::get('/wali', [App\Http\Controllers\WaliController::class, 'index'])->middleware('auth')->name('wali.dashboard');

// Route Absensi Pagi (7 KAIH, Tahfidz, BTQ)
Route::get('/absensi-pagi', [App\Http\Controllers\AbsensiPagiController::class, 'index'])->middleware('auth')->name('absensi.pagi');
Route::get('/absensi-pagi/form/{tipe}', [App\Http\Controllers\AbsensiPagiController::class, 'form'])->middleware('auth')->name('absensi.pagi.form');
Route::post('/absensi-pagi/simpan', [App\Http\Controllers\AbsensiPagiController::class, 'store'])->middleware('auth')->name('absensi.pagi.store');

// Route untuk Dashboard Wali Kelas
Route::get('/wali-kelas', [App\Http\Controllers\WaliKelasController::class, 'index'])
    ->name('wali_kelas.dashboard')
    ->middleware('auth');

// ========================================================================
// 🔒 ROUTE CRUD ADMIN (HANYA ADMIN & KEPSEK)
// Menggunakan middleware alias 'admin.only' yang sudah didaftarkan di bootstrap/app.php
// ========================================================================

// --- ROUTE MANAJEMEN GURU (ADMIN) ---
Route::middleware('admin.only')->group(function () {
    Route::get('/admin/guru', [App\Http\Controllers\AdminGuruController::class, 'index'])->name('admin.guru.index');
    Route::get('/admin/guru/create', [App\Http\Controllers\AdminGuruController::class, 'create'])->name('admin.guru.create');
    Route::post('/admin/guru', [App\Http\Controllers\AdminGuruController::class, 'store'])->name('admin.guru.store');
    Route::get('/admin/guru/{id}/edit', [App\Http\Controllers\AdminGuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/admin/guru/{id}', [App\Http\Controllers\AdminGuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/admin/guru/{id}', [App\Http\Controllers\AdminGuruController::class, 'destroy'])->name('admin.guru.destroy');
});

// --- ROUTE MANAJEMEN SISWA (ADMIN) ---
Route::middleware('admin.only')->group(function () {
    Route::get('/admin/siswa', [App\Http\Controllers\AdminSiswaController::class, 'index'])->name('admin.siswa.index');
    Route::get('/admin/siswa/create', [App\Http\Controllers\AdminSiswaController::class, 'create'])->name('admin.siswa.create');
    Route::post('/admin/siswa', [App\Http\Controllers\AdminSiswaController::class, 'store'])->name('admin.siswa.store');
    Route::get('/admin/siswa/{id}/edit', [App\Http\Controllers\AdminSiswaController::class, 'edit'])->name('admin.siswa.edit');
    Route::put('/admin/siswa/{id}', [App\Http\Controllers\AdminSiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', [App\Http\Controllers\AdminSiswaController::class, 'destroy'])->name('admin.siswa.destroy');
});

// --- ROUTE MANAJEMEN KELAS / ROMBEL (ADMIN) ---
Route::middleware('admin.only')->group(function () {
    Route::get('/admin/rombel', [App\Http\Controllers\AdminRombelController::class, 'index'])->name('admin.rombel.index');
    Route::get('/admin/rombel/create', [App\Http\Controllers\AdminRombelController::class, 'create'])->name('admin.rombel.create');
    Route::post('/admin/rombel', [App\Http\Controllers\AdminRombelController::class, 'store'])->name('admin.rombel.store');
    Route::get('/admin/rombel/{id}/edit', [App\Http\Controllers\AdminRombelController::class, 'edit'])->name('admin.rombel.edit');
    Route::put('/admin/rombel/{id}', [App\Http\Controllers\AdminRombelController::class, 'update'])->name('admin.rombel.update');
    Route::delete('/admin/rombel/{id}', [App\Http\Controllers\AdminRombelController::class, 'destroy'])->name('admin.rombel.destroy');
});

// --- ROUTE MANAJEMEN MATA PELAJARAN (ADMIN) ---
Route::middleware('admin.only')->group(function () {
    Route::get('/admin/mapel', [App\Http\Controllers\AdminMapelController::class, 'index'])->name('admin.mapel.index');
    Route::get('/admin/mapel/create', [App\Http\Controllers\AdminMapelController::class, 'create'])->name('admin.mapel.create');
    Route::post('/admin/mapel', [App\Http\Controllers\AdminMapelController::class, 'store'])->name('admin.mapel.store');
    Route::get('/admin/mapel/{id}/edit', [App\Http\Controllers\AdminMapelController::class, 'edit'])->name('admin.mapel.edit');
    Route::put('/admin/mapel/{id}', [App\Http\Controllers\AdminMapelController::class, 'update'])->name('admin.mapel.update');
    Route::delete('/admin/mapel/{id}', [App\Http\Controllers\AdminMapelController::class, 'destroy'])->name('admin.mapel.destroy');
});

// --- ROUTE MANAJEMEN JADWAL PELAJARAN (ADMIN) ---
Route::middleware('admin.only')->group(function () {
    Route::get('/admin/jadwal', [App\Http\Controllers\AdminJadwalController::class, 'index'])->name('admin.jadwal.index');
    Route::get('/admin/jadwal/create', [App\Http\Controllers\AdminJadwalController::class, 'create'])->name('admin.jadwal.create');
    Route::post('/admin/jadwal', [App\Http\Controllers\AdminJadwalController::class, 'store'])->name('admin.jadwal.store');
    Route::get('/admin/jadwal/{id}/edit', [App\Http\Controllers\AdminJadwalController::class, 'edit'])->name('admin.jadwal.edit');
    Route::put('/admin/jadwal/{id}', [App\Http\Controllers\AdminJadwalController::class, 'update'])->name('admin.jadwal.update');
    Route::delete('/admin/jadwal/{id}', [App\Http\Controllers\AdminJadwalController::class, 'destroy'])->name('admin.jadwal.destroy');
});

// --- ROUTE MANAJEMEN JADWAL PIKET (ADMIN) ---
Route::middleware('admin.only')->group(function () {
    Route::get('/admin/jadwal-piket', [App\Http\Controllers\AdminJadwalPiketController::class, 'index'])->name('admin.jadwal_piket.index');
    Route::get('/admin/jadwal-piket/create', [App\Http\Controllers\AdminJadwalPiketController::class, 'create'])->name('admin.jadwal_piket.create');
    Route::post('/admin/jadwal-piket', [App\Http\Controllers\AdminJadwalPiketController::class, 'store'])->name('admin.jadwal_piket.store');
    Route::get('/admin/jadwal-piket/{id}/edit', [App\Http\Controllers\AdminJadwalPiketController::class, 'edit'])->name('admin.jadwal_piket.edit');
    Route::put('/admin/jadwal-piket/{id}', [App\Http\Controllers\AdminJadwalPiketController::class, 'update'])->name('admin.jadwal_piket.update');
    Route::delete('/admin/jadwal-piket/{id}', [App\Http\Controllers\AdminJadwalPiketController::class, 'destroy'])->name('admin.jadwal_piket.destroy');
});

// --- ROUTE REKAP (ADMIN & WAKA BISA AKSES) ---
Route::get('/admin/absensi-7kaih', [App\Http\Controllers\AdminAbsensi7KaihController::class, 'index'])->name('admin.absensi_7kaih.index');

Route::get('/admin/jurnal-mengajar', [App\Http\Controllers\AdminJurnalMengajarController::class, 'index'])->name('admin.jurnal_mengajar.index');
Route::get('/admin/jurnal-mengajar/cetak', [App\Http\Controllers\AdminJurnalMengajarController::class, 'cetak'])->name('admin.jurnal_mengajar.cetak');

Route::get('/admin/tahfidz', [App\Http\Controllers\AdminTahfidzController::class, 'index'])->name('admin.tahfidz.index');
Route::get('/admin/tahfidz/cetak', [App\Http\Controllers\AdminTahfidzController::class, 'cetak'])->name('admin.tahfidz.cetak');

Route::get('/admin/btq', [App\Http\Controllers\AdminBtqController::class, 'index'])->name('admin.btq.index');
Route::get('/admin/btq/cetak', [App\Http\Controllers\AdminBtqController::class, 'cetak'])->name('admin.btq.cetak');

// --- ROUTE DASHBOARD WAKA (MONITORING) ---
Route::get('/waka', [App\Http\Controllers\WakaController::class, 'index'])
    ->name('waka.dashboard')
    ->middleware('auth');