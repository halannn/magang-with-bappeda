<?php

namespace App\Http\Controllers;

use App\Mail\VerificationNotice;
use App\Models\PendaftaranMagang;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class PendaftaranMagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PendaftaranMagang::with(['user', 'profile']);

        if ($request->has('search') && $request->search !== '') {
            $search = $request->input('search');
            $query->whereHas('profile', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('asal_kampus', 'like', "%{$search}%");
            });
        }

        if ($request->has('date') && $request->date !== null) {
            $query->whereDate('tanggal_mulai', $request->input('date'));
        }

        $verifikasi = $query->paginate($request->input('rows', 10))->withQueryString();

        return Inertia::render('admin/verifikasi/Index', [
            'verifikasi' => $verifikasi,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->profile && $user->profile->pendaftaran) {
            return Inertia::location(route('pendaftaran.pemberitahuan'));
        }

        return Inertia::render('FormMagang');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'posisi_magang' =>  'required|string|max:255',
            'deskripsi_magang' =>  'required|string',
            'tanggal_mulai' =>  'required|date',
            'tanggal_selesai' =>  'required|date',
            'surat_magang' => 'required|file|mimes:pdf|max:2048',

        ]);
        $validated['user_id'] = $user->id;
        $validated['profile_id'] = $user->profile->id;
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
        $profile = Profile::findOrFail($id);;

        $validated = $request->validate([
            'bidang_magang' => 'required|string',
            'status_magang' => 'required|string'
        ]);

        $oldStatus = $profile->status_magang;

        $profile->update($validated);

        if ($oldStatus !== $validated['status_magang']) {
            Mail::to($profile->user->email)->send(new VerificationNotice($profile));
        }

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
