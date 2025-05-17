<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PendaftaranMagangFactory extends Factory
{
    // protected $model = PendaftaranMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake('id_ID')->dateTimeBetween('now', '+1 month');
        $endDate = (clone $startDate)->modify('+3 months');

        $profile = \App\Models\Profile::factory()->create();

        return [
            'user_id' => $profile->user_id,
            'profile_id' => $profile->id,
            'posisi_magang' => fake('id_ID')->randomElement(['Frontend Developer', 'Data Analyst', 'UI/UX Designer', 'Backend Developer']),
            'deskripsi_magang' => fake('id_ID')->paragraph(),
            'tanggal_mulai' => $startDate->format('Y-m-d'),
            'tanggal_selesai' => $endDate->format('Y-m-d'),
            'surat_magang' => fake('id_ID')->url(),
        ];
    }
}
