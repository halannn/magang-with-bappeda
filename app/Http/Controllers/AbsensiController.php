<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Inertia\Inertia;


class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile_id = auth()->user()->profile?->id;

        if (request()->is('absensi')) {
            $absen = Absensi::where('profile_id', $profile_id)->orderByDesc('tanggal')->get();
            return Inertia::render('absensi/Index', [
                'absen' => $absen
            ]);
        }

        if (request()->is('absensi/riwayat')) {
            $absen = Absensi::where('profile_id', $profile_id)->orderByDesc('tanggal')->Paginate(15);
            return Inertia::render('absensi/List', [
                'absen' => $absen,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profile_id = auth()->user()->profile?->id;
        $absen = Absensi::where('profile_id', $profile_id)->get();

        if (request()->is('absensi/lupa-absen')) {
            return Inertia::render('absensi/Create', [
                'absen' => $absen
            ]);
        }

        if (request()->is('absensi/izin-sakit')) {
            return Inertia::render('absensi/Leave', [
                'absen' => $absen
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $profile_id = auth()->user()->profile?->id;

        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'waktu_datang' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable'],
            'keterangan' => ['nullable'],
            'surat' => ['nullable'],
        ]);

        $exists = Absensi::where('profile_id', $profile_id)
            ->where('tanggal', $validated['tanggal'])
            ->exists();


        if (! $exists) {
            if ($request->hasFile('surat')) {
                $validated['surat'] = $request->file('surat')->store('surat', 'local');
            }

            $validated['profile_id'] = $profile_id;

            Absensi::create($validated);

            return Inertia::location(route('absensi.index'));
        }

        return back()->withErrors([
            'absen' => 'Anda sudah melakukan absen pada tanggal tersebut.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Absensi $absen)
    {
        if (!is_null($absen->waktu_pulang)) {
            return back()->withErrors([
                'absen' => 'Anda sudah melakukan absen pada tanggal tersebut.'
            ]);
        }

        $validated = $request->validate([
            'waktu_pulang' => ['required', 'date_format:H:i'],
        ]);

        $absen->update($validated);

        return Inertia::location(route('absensi.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showSurat($surat)
    {
        $path = storage_path('app/private/surat/' . $surat);

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
