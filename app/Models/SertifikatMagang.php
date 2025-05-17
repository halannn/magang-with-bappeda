<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SertifikatMagang extends Model
{
    /** @use HasFactory<\Database\Factories\SertifikatMagangFactory> */
    use HasFactory;

    protected $table = 'sertifikat_magang';

    protected $fillable = [
        'profile_id',
        'tanggal_terbit',
        'file',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
