<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranMagang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PendaftaranMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('FormMagang');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'posisi_magang' =>  'required|string|max:255',
            'deskripsi_magang' =>  'required|string',
            'tanggal_mulai' =>  'required|date',
            'tanggal_selesai' =>  'required|date',
            'surat_magang' => 'required|file|mimes:pdf|max:2048',

        ]);
        $validated['user_id'] = auth()->id();
        $validated['profile_id'] = auth()->user()->profile->id;
        $validated['surat_magang'] = $request->file('surat_magang')->store('proposal', 'local');

        PendaftaranMagang::create($validated);

        return Inertia::location(route('pendaftaran.pemberitahuan'));
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
        //
    }
}
