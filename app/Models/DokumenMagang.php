<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenMagang extends Model
{
    /** @use HasFactory<\Database\Factories\DokumenMagangFactory> */
    use HasFactory;

    protected $table = 'dokumen_magang';

    protected $fillable = [
        'deskripsi_dokumen',
        'tanggal',
        'file'
    ];

    public function profile(): BelongsTo
    {
        return $this->belBelongsTo(Profile::class);
    }
}
