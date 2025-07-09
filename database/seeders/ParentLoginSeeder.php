<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParentLogin;
use Illuminate\Support\Facades\Hash;

class ParentLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
   {
        ParentLogin::create([
            'name' => 'Orang Tua Alexandra',
            'email' => 'ortu@example.com',
            'password' => Hash::make('password123'),
            'nisn' => '0109722270'
        ]);
    }
}
