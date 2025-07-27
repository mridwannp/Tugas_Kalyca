<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\DB;
//Login
Route::get('/', function () {
    return redirect()->route('login');
});
require __DIR__.'/auth.php';

// Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


//Edit Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// masukan dan keluaran
Route::resource('pengeluaran', PengeluaranController::class);
Route::resource('masukan', MasukanController::class);

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');

// Laporan
Route::get('/laporan/ppn-keluaran', [LaporanController::class, 'ppnKeluaran']);
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

// Laporan per barang
Route::get('/laporan/per-barang', [LaporanController::class, 'viewPerBarang'])->name('laporan.per-barang');
Route::get('/laporan/pdf/per-barang', [LaporanController::class, 'cetakPerBarang'])->name('laporan.pdf.per-barang');


// Print
Route::get('/laporan/pdf/ppn-masukan', [LaporanController::class, 'cetakPpnMasukan'])->name('laporan.pdf.ppn_masukan');
Route::get('/laporan/pdf/ppn-keluaran', [LaporanController::class, 'cetakPpnKeluaran'])->name('laporan.pdf.ppn_keluaran');
Route::get('/laporan/pdf/selisih-ppn', [LaporanController::class, 'cetakSelisihPpn'])->name('laporan.pdf.selisih_ppn');
Route::get('/laporan/pdf/rekapitulasi', [LaporanController::class, 'cetakRekapitulasi'])->name('laporan.pdf.rekapitulasi');

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Koneksi database berhasil!";
    } catch (\Exception $e) {
        return "❌ Gagal terkoneksi ke database: " . $e->getMessage();
    }
});
