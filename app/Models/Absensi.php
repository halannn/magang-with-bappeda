<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    /** @use HasFactory<\Database\Factories\AbsensiFactory> */
    use HasFactory;

    protected $table = 'absensi_magang';

    protected $fillable = [
        'profile_id',
        'tanggal',
        'waktu_datang',
        'waktu_pulang',
        'status',
        'keterangan',
        'surat',
        'verifikasi'
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(ProfileMagang::class);
    }
}
