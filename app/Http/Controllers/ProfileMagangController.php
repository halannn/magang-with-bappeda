<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileMagangController extends Controller
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
        if (auth()->user()->profile?->id) {
            return Inertia::location(route('pendaftaran.magang.create'));
        }

        return Inertia::render('FormProfile');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'nomor_mahasiswa' => 'required|string|max:100',
            'asal_kampus'     => 'required|string|max:255',
            'fakultas'        => 'required|string|max:255',
            'jurusan'         => 'required|string|max:255',
            'program_studi'   => 'required|string|max:255',
            'deskripsi_diri'  => 'required|string',
            'kontak'          => 'required|string',
            'foto_profile'    => 'required|file|image|max:2048',
            'cv_pribadi'      => 'required|file|mimes:pdf|max:2048',
        ]);

        $validated['user_id']      = auth()->id();
        $validated['foto_profile'] = $request->file('foto_profile')->store('avatar', 'local');
        $validated['cv_pribadi']   = $request->file('cv_pribadi')->store('cv', 'local');

        Profile::create($validated);

        return redirect()->route('pendaftaran.magang.create');
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
