<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateLaporanKegiatanRequest;
use App\Models\LaporanKegiatan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class LaporanKegiatanController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // query setup
        $query = LaporanKegiatan::query();
        $user  = auth()->user();
        $isAdmin = $user->status === 'admin';

        // check status
        if ($isAdmin) {
            $query->with('profile');
        } else {
            $query->where('profile_id', $user->profile?->id);
        }

        // filtering input
        $query->when($request->filled('search'), function ($q) use ($request, $isAdmin) {
            $search = $request->input('search');

            // admin side
            if ($isAdmin) {
                return $q->whereHas('profile', function ($profileQuery) use ($search) {
                    $profileQuery->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('bidang_magang', 'like', "%{$search}%");
                });
            }

            // user side
            return $q->where(function ($mainQuery) use ($search) {
                $mainQuery->where('deskripsi_kegiatan', 'like', "%{$search}%")
                    ->orWhere('hasil', 'like', "%{$search}%");
            });
        });

        // filtering date
        $query->when($request->filled('date'), function ($q) use ($request) {
            return $q->whereDate('tanggal', $request->input('date'));
        });

        // showing the query
        $laporan = $query->orderByDesc('tanggal')
            ->paginate($request->input('rows', 10))
            ->withQueryString();

        $view = $isAdmin ? 'admin/AdminLaporanKegiatan' : 'laporan_kegiatan/Index';

        return Inertia::render($view, [
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
    public function store(ValidateLaporanKegiatanRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('dokumentasi')) {
            $validated['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi', 'local');
        }

        $request->user()->profile->laporan()->create($validated);

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
    public function edit(LaporanKegiatan $laporan)
    {
        return Inertia::render('laporan_kegiatan/Edit', [
            'laporan' => $laporan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ValidateLaporanKegiatanRequest $request, LaporanKegiatan $laporan)
    {
        $this->authorize('update', $laporan);

        $validated = $request->validated();

        if ($request->hasFile('dokumentasi')) {
            if ($laporan->dokumentasi && Storage::disk('local')->exists($laporan->dokumentasi)) {
                Storage::disk('local')->delete($laporan->dokumentasi);
            }

            $validated['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi', 'local');
        }

        $laporan->update($validated);

        return redirect()->route('dashboard.laporan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LaporanKegiatan $laporan)
    {
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
            abort(404, 'File tidak ditemukan!');
        }

        return response()->file($path);
    }
}
