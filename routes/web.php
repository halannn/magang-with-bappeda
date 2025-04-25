<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('tentang', function () {
    return Inertia::render('Tentang');
})->name('tentang');

Route::get('mahasiswa', function () {
    return Inertia::render('Mahasiswa');
})->name('mahasiswa');

Route::get('pendaftaran', function () {
    return Inertia::render('Pendaftaran');
})->name('pendaftaran');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
