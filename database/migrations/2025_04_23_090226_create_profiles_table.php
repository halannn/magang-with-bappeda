<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nomor_mahasiswa');
            $table->string('asal_kampus');
            $table->string('fakultas');
            $table->string('jurusan');
            $table->string('program_studi');
            $table->text('deskripsi_diri');
            $table->string('kontak');   
            $table->string('foto_profile');   
            $table->string('cv_pribadi');
            $table->enum('bidang_magang', ['PIPP', 'KRA', 'P3'])->nullable();
            $table->enum('status_magang', ['Aktif', 'Selesai', 'Dikeluarkan', 'Pending'])->nullable()->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
