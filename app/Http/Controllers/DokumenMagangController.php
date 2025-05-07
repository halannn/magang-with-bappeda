<?php

namespace App\Http\Controllers;

use App\Models\DokumenMagang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DokumenMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile_id = auth()->user()->profile?->id;

        $dokumen = DokumenMagang::where('profile_id', $profile_id)->orderByDesc('tanggal')->Paginate(15);

        return Inertia::render('dokumen/Index', [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profile_id = auth()->user()->profile?->id;
        $dokumen = DokumenMagang::where('profile_id', $profile_id)->get();

        return Inertia::render('dokumen/Create', [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $profile_id = auth()->user()->profile?->id;

        $validated = $request->validate([
            'tanggal' => ['required'],
            'deskripsi_dokumen' => ['required'],
            'file' => ['required'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('dokumen_magang', 'local');
        }

        $validated['profile_id'] = $profile_id;

        DokumenMagang::create($validated);

        return Inertia::location(route('dokumen.index'));
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
        $dokumen = DokumenMagang::where('id', $id)->get();

        return Inertia::render('dokumen/Edit', [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dokumen = DokumenMagang::where('id', $id)->firstOrFail();

        $profile_id = auth()->user()->profile?->id;

        // dd($request);

        $validated = $request->validate([
            'tanggal' => ['required'],
            'deskripsi_dokumen' => ['required'],
            'file' => ['required'],
        ]);

        if ($request->hasFile('dokumentasi')) {
            if ($dokumen->file && Storage::disk('local')->exists($dokumen->file)) {
                Storage::disk('local')->delete($dokumen->file);
            }

            $validated['file'] = $request->file('file')->store('dokumen_magang', 'local');
        }

        $validated['profile_id'] = $profile_id;

        $dokumen->update($validated);

        return Inertia::location(route('dokumen.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dokumen = DokumenMagang::where('id', $id)->firstOrFail();
        if ($dokumen->file && Storage::disk('local')->exists($dokumen->file)) {
            Storage::disk('local')->delete($dokumen->file);
        }
        $dokumen->delete();

        return Inertia::location(route('dokumen.index'));
    }

    public function showFile($file)
    {
        $path = storage_path('app/private/dokumen_magang/' . $file);

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
