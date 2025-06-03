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
    public function index(Request $request)
    {
        if (auth()->user()->status === 'admin') {
            $query = Absensi::with('profile')->orderByDesc('tanggal');

            if ($request->has('search') && $request->search !== '') {
                $search = $request->input('search');
                $query->whereHas('profile', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('bidang_magang', 'like', "%{$search}%");
                });
            }

            if ($request->has('date') && $request->date !== null) {
                $query->whereDate('tanggal', $request->input('date'));
            }

            $absen = $query->paginate(10)->withQueryString();
            return Inertia::render('admin/AdminAbsensi', [
                'absen' => $absen
            ]);
        }

        $absen = Absensi::where('profile_id', auth()->user()->profile?->id)->orderByDesc('tanggal')->limit(5)->get();
        return Inertia::render('absensi/Index', [
            'absen' => $absen
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profile_id = auth()->user()->profile?->id;
        $absen = Absensi::where('profile_id', $profile_id)->get();

        if (request()->is('dashboard/absensi/lupa-absen')) {
            return Inertia::render('absensi/Create', [
                'absen' => $absen
            ]);
        }

        if (request()->is('dashboard/absensi/izin-sakit')) {
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

            return redirect()->route('dashboard.absensi.index');
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

        if (auth()->user()->status === 'admin') {
            $validated = $request->validate([
                'verifikasi' => 'required|string'
            ]);

            $absen->update($validated);

            return redirect()->back()->with('success', 'Verifikasi berhasil diperbarui.');
        }

        if (!is_null($absen->waktu_pulang)) {
            return back()->withErrors([
                'absen' => 'Anda sudah melakukan absen pada tanggal tersebut.'
            ]);
        }

        $validated = $request->validate([
            'waktu_pulang' => ['required', 'date_format:H:i'],
            'keterangan' => ['nullable'],
        ]);

        $absen->update($validated);

        return redirect()->route('dashboard.absensi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function list(Request $request)
    {
        $query = Absensi::where('profile_id',  auth()->user()->profile?->id)->orderByDesc('tanggal');

        if ($request->has('search') && $request->search !== '') {
            $search = $request->input('search');
            $query->whereHas('profile', function ($q) use ($search) {
                $q->where('status', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if ($request->has('date') && $request->date !== null) {
            $query->whereDate('tanggal', $request->input('date'));
        }

        $absen = $query->paginate($request->input('rows', 10))->withQueryString();

        return Inertia::render('absensi/List', [
            'absen' => $absen,
        ]);
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
