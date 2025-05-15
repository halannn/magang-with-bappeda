<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranMagang;
use App\Models\Profile;
use App\Models\ProfileMagang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PendaftaranMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $verifikasi = PendaftaranMagang::with(['user', 'profile'])->paginate(15);

        return Inertia::render('admin/verifikasi/Index', [
            'verifikasi' => $verifikasi
        ]);
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
        $verifikasi = PendaftaranMagang::with(['user', 'profile'])->find($id);;

        return Inertia::render('admin/verifikasi/Edit', [
            'verifikasi' => $verifikasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::where('id', $id)->find($id);

        $validated = $request->validate([
            'bidang_magang' => 'required|string',
            'status_magang' => 'required|string'
        ]);

        $profile->update($validated);

        return Inertia::location(route('admin.dashboard.verifikasi.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showProposal($proposal)
    {
        $path = storage_path('app/private/proposal/' . $proposal);

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function showAvatar($avatar)
    {
        $path = storage_path('app/private/avatar/' . $avatar);

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function showCV($cv)
    {
        $path = storage_path('app/private/cv/' . $cv);

        if (! file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
