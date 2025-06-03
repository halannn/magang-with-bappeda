<?php

namespace App\Http\Controllers;

use App\Models\LaporanKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class LaporanKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->status === 'admin') {
            $query = LaporanKegiatan::with('profile')->orderByDesc('tanggal');

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

            $laporan = $query->paginate($request->input('rows', 10))->withQueryString();

            return Inertia::render('admin/AdminLaporanKegiatan', [
                'laporan' => $laporan,
            ]);
        }

        $profile_id = auth()->user()->profile?->id;

        $query = LaporanKegiatan::where('profile_id', $profile_id)->orderByDesc('tanggal');

        if ($request->has('search') && $request->search !== '') {
            $search = $request->input('search');
            $query->whereHas('profile', function ($q) use ($search) {
                $q->where('deskripsi_kegiatan', 'like', "%{$search}%")
                    ->orWhere('hasil', 'like', "%{$search}%");
            });
        }

        if ($request->has('date') && $request->date !== null) {
            $query->whereDate('tanggal', $request->input('date'));
        }

        $laporan = $query->paginate($request->input('rows', 10))->withQueryString();

        return Inertia::render('laporan_kegiatan/Index', [
            'laporan' => $laporan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('laporan_kegiatan/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $profile_id = auth()->user()->profile?->id;

        $validated = $request->validate([
            'tanggal' => ['required'],
            'deskripsi_kegiatan' => ['required'],
            'hasil' => ['required'],
            'waktu' => ['required'],
            'dokumentasi' => ['nullable'],
        ]);

        if ($request->hasFile('dokumentasi')) {
            $validated['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi', 'local');
        }

        $validated['profile_id'] = $profile_id;

        LaporanKegiatan::create($validated);

        return redirect()->route('dashboard.laporan.index');
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
        $laporan = LaporanKegiatan::where('id', $id)->get();

        return Inertia::render('laporan_kegiatan/Edit', [
            'laporan' => $laporan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $laporan = LaporanKegiatan::where('id', $id)->firstOrFail();

        $profile_id = auth()->user()->profile?->id;

        $validated = $request->validate([
            'tanggal' => ['required'],
            'deskripsi_kegiatan' => ['required'],
            'waktu' => ['required'],
            'hasil' => ['required'],
            'dokumentasi' => ['nullable'],
        ]);

        if ($request->hasFile('dokumentasi')) {
            if ($laporan->dokumentasi && Storage::disk('local')->exists($laporan->dokumentasi)) {
                Storage::disk('local')->delete($laporan->dokumentasi);
            }

            $validated['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi', 'local');
        }

        $validated['profile_id'] = $profile_id;

        $laporan->update($validated);

        return redirect()->route('dashboard.laporan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $laporan = LaporanKegiatan::where('id', $id)->firstOrFail();
        if ($laporan->dokumentasi && Storage::disk('local')->exists($laporan->dokumentasi)) {
            Storage::disk('local')->delete($laporan->dokumentasi);
        }
        $laporan->delete();

        if (auth()->user()->status === 'admin') {

            return redirect()->route('admin.dashboard.laporan.index');
        }


        return redirect()->route('dashboard.laporan.index');
    }

    public function showDokumentasi($dokumentasi)
    {
        $path = storage_path('app/private/dokumentasi/' . $dokumentasi);

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
