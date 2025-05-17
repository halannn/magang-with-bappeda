<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nama_lengkap' => fake('id_ID')->name(),
            'nomor_mahasiswa' => fake('id_ID')->numerify('##########'),
            'asal_kampus' => fake('id_ID')->word(),
            'fakultas' => fake('id_ID')->word(),
            'jurusan' => fake('id_ID')->word(),
            'program_studi' => fake('id_ID')->word(),
            'deskripsi_diri' => fake('id_ID')->sentence(),
            'kontak' => fake('id_ID')->phoneNumber(),
            'foto_profile' => fake('id_ID')->imageUrl(),
            'cv_pribadi' => fake('id_ID')->url(),
            'bidang_magang' => fake('id_ID')->randomElement(['PIPP', 'KRA', 'P3', 'Litbang', 'Seketariat']),
            'status_magang' => fake('id_ID')->randomElement(['Aktif', 'Selesai', 'Dikeluarkan', 'Pending']),
        ];
    }
}
