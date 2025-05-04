<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanKegiatanController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('public/Home');
})->name('home');

Route::get('tentang', function () {
    return Inertia::render('public/Tentang');
})->name('tentang');

Route::get('mahasiswa', function () {
    return Inertia::render('public/Mahasiswa');
})->name('mahasiswa');

Route::get('pendaftaran', function () {
    return Inertia::render('public/Pendaftaran');
})->name('pendaftaran');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('absensi/izin-sakit', [AbsensiController::class, 'create'])->name('absensi.leave');
    Route::get('absensi/lupa-absen', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::put('absensi/lupa-absen/{absen}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::get('absensi/riwayat', [AbsensiController::class, 'index'])->name('absensi.list');
    Route::get('surat/{surat}', [AbsensiController::class, 'showSurat'])->name('absensi.surat');

    Route::controller(LaporanKegiatanController::class)->group(function () {
        Route::get('laporan-kegiatan', 'index')->name('laporan.index');
    });
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
