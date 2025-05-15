<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProfileMagang extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $table = 'profile_magang';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nomor_mahasiswa',
        'asal_kampus',
        'fakultas',
        'jurusan',
        'program_studi',
        'deskripsi_diri',
        'kontak',
        'foto_profile',
        'cv_pribadi',
        'bidang_magang',
        'status_magang',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pendaftaran(): HasOne
    {
        return $this->hasOne(PendaftaranMagang::class);
    }

    public function sertifikat(): HasOne
    {
        return $this->hasOne(SertifikatMagang::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(LaporanKegiatan::class);
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenMagang::class);
    }
}
