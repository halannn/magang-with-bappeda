<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
