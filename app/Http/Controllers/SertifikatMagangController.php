<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\SertifikatMagang;
use Illuminate\Http\Request;
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
        $profile = Profile::all();

        return Inertia::render('admin/sertifikat/Create', [
            'profile' => $profile
        ]);
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
