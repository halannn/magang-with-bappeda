<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DokumenMagangController;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\PendaftaranMagangController;
use App\Http\Controllers\ProfileMagangController;
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

Route::middleware(['auth', 'verified'])
    ->prefix('pendaftaran')
    ->name('pendaftaran.')
    ->group(function () {
        Route::get('/form-profile', [ProfileMagangController::class, 'create'])->name('profile.create');
        Route::post('/profile', [ProfileMagangController::class, 'store'])->name('profile.store');

        Route::get('/form-magang', [PendaftaranMagangController::class, 'create'])->name('magang.create');
        Route::post('/magang', [PendaftaranMagangController::class, 'store'])->name('magang.store');

        Route::get('/pemberitahuan', function () {
            return Inertia::render('Pemberitahuan');
        })->name('pemberitahuan');
    });

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', 'checkStatus' . ':admin'])->name('dashboard');

Route::middleware(['auth', 'verified', 'checkStatus' . ':user'])->prefix('dashboard')->name('dashboard.')->group(function () {

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('index');

    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('index'); // absensi.index
        Route::post('/', [AbsensiController::class, 'store'])->name('store'); // absensi.store
        Route::get('/izin-sakit', [AbsensiController::class, 'create'])->name('leave'); // absensi.leave
        Route::get('/lupa-absen', [AbsensiController::class, 'create'])->name('create'); // absensi.create
        Route::put('/lupa-absen/{absen}', [AbsensiController::class, 'update'])->name('update'); // absensi.update
        Route::get('/riwayat', [AbsensiController::class, 'index'])->name('list'); // absensi.list
        Route::get('surat/{surat}', [AbsensiController::class, 'showSurat'])->name('surat'); // absensi.surat
    });

    Route::prefix('laporan-kegiatan')->name('laporan.')->controller(LaporanKegiatanController::class)->group(function () {
        Route::get('/', 'index')->name('index'); // laporan.index
        Route::post('/', 'store')->name('store'); // laporan.store
        Route::get('/tambah-kegiatan', 'create')->name('create'); // laporan.create
        Route::get('/edit-kegiatan/{id}', 'edit')->name('edit'); // laporan.edit
        Route::get('dokumentasi/{dokumentasi}', 'showDokumentasi')->name('dokumentasi');
        Route::put('/{id}', 'update')->name('update'); // laporan.update
        Route::delete('/{id}', 'destroy')->name('destroy'); // laporan.destroy
    });

    Route::prefix('dokumen')->name('dokumen.')->controller(DokumenMagangController::class)->group(function () {
        Route::get('/', 'index')->name('index'); // dokumen.index
        Route::post('/', 'store')->name('store'); // dokumen.store
        Route::get('/tambah-dokumen', 'create')->name('create'); // dokumen.create
        Route::get('/edit-dokumen/{id}', 'edit')->name('edit'); // dokumen.edit
        Route::get('file/{file}', 'showFile')->name('file'); // dokumen.file
        Route::put('/{id}', 'update')->name('update'); // dokumen.update
        Route::delete('/{id}', 'destroy')->name('destroy'); // dokumen.destroy
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
