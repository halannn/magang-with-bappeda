<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranMagang;
use App\Models\SertifikatMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SertifikatMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sertifikat = SertifikatMagang::with('profile')->paginate(15);

        return Inertia::render('admin/sertifikat/Index', [
            'sertifikat' => $sertifikat
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pendaftar = PendaftaranMagang::with('profile')->get();

        return Inertia::render('admin/sertifikat/Create', [
            'pendaftar' => $pendaftar
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'profile_id' => 'required|int',
            'tanggal_terbit' => 'required|date',
        ]);

        $filePath = $request->file('file')->store('sertifikat', 'local');

        $validated['file'] = $filePath;

        SertifikatMagang::create($validated);

        return Inertia::location(route('admin.dashboard.sertifikat.index'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sertifikat = SertifikatMagang::where('id', $id)->firstOrFail();
        if ($sertifikat->file && Storage::disk('local')->exists($sertifikat->file)) {
            Storage::disk('local')->delete($sertifikat->file);
        }
        $sertifikat->delete();

        return Inertia::location(route('admin.dashboard.sertifikat.index'));
    }

    public function showFile($file)
    {
        $path = storage_path('app/private/sertifikat/' . $file);

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
