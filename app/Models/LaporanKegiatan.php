<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKegiatan extends Model
{
    /** @use HasFactory<\Database\Factories\LaporanKegiatanFactory> */
    use HasFactory;

    protected $table = 'laporan_kegiatan';

    protected $fillable = [
        'deskripsi_kegiatan',
        'tanggal',
        'dokumentasi',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
