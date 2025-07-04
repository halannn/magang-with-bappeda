<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\DokumenMagang;
use App\Models\LaporanKegiatan;
use App\Models\PendaftaranMagang;
use App\Models\Profile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function user()
    {
        $profile = auth()->user()->profile;

        if (!$profile) {
            return redirect()->route('pendaftaran.profile.create');
        }

        // 5 absensi terakhir
        $absen = Absensi::where('profile_id', $profile->id)
            ->orderByDesc('tanggal')
            ->limit(5)
            ->get();

        // Jumlah absensi laporan bulan ini
        $absenCount = Absensi::where('profile_id', $profile->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        $laporan = LaporanKegiatan::where('profile_id', $profile->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Jumlah dokumen
        $dokumen = DokumenMagang::where('profile_id', $profile->id)->count();

        return Inertia::render('Dashboard', [
            'absen' => $absen,
            'absenCount' => $absenCount,
            'laporan' => $laporan,
            'dokumen' => $dokumen,
        ]);
    }

    public function admin()
    {
        $verifikasi = PendaftaranMagang::with(['user', 'profile'])->orderByDesc('tanggal_mulai')
            ->limit(5)
            ->get();

        $mahasiswa = Profile::where('status_magang', 'Aktif')->count();

        $absen = Absensi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        $laporan = LaporanKegiatan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Jumlah dokumen
        $dokumen = DokumenMagang::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        return Inertia::render('admin/AdminDashboard', [
            'verifikasi' => $verifikasi,
            'mahasiswa' => $mahasiswa,
            'absen' => $absen,
            'laporan' => $laporan,
            'dokumen' => $dokumen,
        ]);
    }
}
