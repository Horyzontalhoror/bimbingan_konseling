<?php

namespace Database\Seeders;

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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            UserSeeder::class,
            StudentSeeder::class,
            KonfigurasiKMeansSeeder::class,
            NilaiSeeder::class,
            ParentLoginSeeder::class,
            StudentLoginSeeder::class,
            JenisPelanggaranSeeder::class,
            ViolationSeeder::class,
            AbsensiSeeder::class,
            KonfigurasiAbsensiSeeder::class,
        ]);
    }
}
