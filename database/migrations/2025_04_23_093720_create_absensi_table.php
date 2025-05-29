<?php

use App\Models\Profile;
use App\Models\ProfileMagang;
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
        Schema::create('absensi_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Profile::class)->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('waktu_datang')->nullable();
            $table->time('waktu_pulang')->nullable();
            $table->enum('status', ['Hadir', 'Sakit', 'Izin'])->nullable()->default(null);
            $table->string('keterangan')->nullable();
            $table->string('surat')->nullable();
            $table->enum('verifikasi', ['Valid', 'Tidak Valid', 'Pending'])->nullable()->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_magang');
    }
};
