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