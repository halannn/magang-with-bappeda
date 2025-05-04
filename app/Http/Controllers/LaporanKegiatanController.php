<?php

namespace App\Http\Controllers;

use App\Models\LaporanKegiatan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LaporanKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile_id = auth()->user()->profile?->id;

        $laporan =  LaporanKegiatan::where('profile_id', $profile_id)->orderByDesc('tanggal')->Paginate(15);

        return Inertia::render('laporan_kegiatan/Index', [
            'laporan' => $laporan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
