<?php

namespace Database\Seeders;

use App\Models\PendaftaranMagang;
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
            'password' => 'admin_bappeda_#1',
        ]);

        // PendaftaranMagang::factory(10)->create();
    }
}
