<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftaranMagang extends Model
{

    protected $table = 'pendaftaran_magang';

    protected $fillable = [
        'posisi_magang',
        'deskripsi_magang',
        'tanggal_mulai',
        'tanggal_selesai',
        'surat_magang',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
