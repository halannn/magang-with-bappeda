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
        Schema::create('sertifikat_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProfileMagang::class)->constrained()->cascadeOnDelete();
            $table->date('tanggal_terbit');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_magang');
    }
};
