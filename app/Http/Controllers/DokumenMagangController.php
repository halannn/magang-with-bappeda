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
    public function index(Request $request)
    {
        // query setup
        $query = DokumenMagang::query();
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
                $mainQuery->where('deskripsi_dokumen', 'like', "%{$search}%");
            });
        });

        // filtering date
        $query->when($request->filled('date'), function ($q) use ($request) {
            return $q->whereDate('tanggal', $request->input('date'));
        });

        // showing the query
        $dokumen = $query->orderByDesc('tanggal')
            ->paginate($request->input('rows', 10))
            ->withQueryString();

        $view = $isAdmin ? 'admin/AdminDokumenMagang' : 'dokumen/Index';

        return Inertia::render($view, [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('dokumen/Create');
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

        return redirect()->route('dashboard.dokumen.index');
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
    public function edit(DokumenMagang $dokumen)
    {
        return Inertia::render('dokumen/Edit', [
            'dokumen' => $dokumen
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenMagang $dokumen)
    {
        $profile_id = auth()->user()->profile?->id;

        $validated = $request->validate([
            'tanggal' => ['required'],
            'deskripsi_dokumen' => ['required'],
            'file' => ['required'],
        ]);

        if ($request->hasFile('file')) {
            if ($dokumen->file && Storage::disk('local')->exists($dokumen->file)) {
                Storage::disk('local')->delete($dokumen->file);
            }

            $validated['file'] = $request->file('file')->store('dokumen_magang', 'local');
        }

        $validated['profile_id'] = $profile_id;

        $dokumen->update($validated);

        return redirect()->route('dashboard.dokumen.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenMagang $dokumen)
    {
        if ($dokumen->file && Storage::disk('local')->exists($dokumen->file)) {
            Storage::disk('local')->delete($dokumen->file);
        }
        $dokumen->delete();


        if (auth()->user()->status === 'admin') {
            return redirect()->route('admin.dashboard.dokumen.index');
        }

        return redirect()->route('dashboard.dokumen.index');
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
