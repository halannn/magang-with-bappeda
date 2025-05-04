<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        User::factory()->create([
            'name' => 'Admin BAPPEDA',
            'status' => 'admin',
            'email' => 'adminbappeda@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Hairul Irawan',
            'status' => 'user',
            'email' => 'hairulirawann@gmail.com',
        ]);

        Profile::factory()->create([
            'user_id' => 2,
            'nama_lengkap' => 'Hairul Irawan',
            'nomor_mahasiswa' => '11221043',
            'asal_kampus' => 'Institut Teknologi Kalimantan',
            'fakultas' => 'Sains dan Teknologi Informasi',
            'jurusan' => 'Teknik Elektro, Informatika, dan Bisnis',
            'program_studi' => 'Informatika',
            'kontak' => '081346509049',
            'bio' => 'Saya seorang mahasiswa semester 6.',
            'cv_link' => '',
            'status_magang' => 'aktif',
        ]);
    }
}
