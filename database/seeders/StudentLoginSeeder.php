<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentLogin;
use Illuminate\Support\Facades\Hash;

class StudentLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        StudentLogin::create([
            'nisn' => '0109722270',
            'password' => Hash::make('password123')
        ]);
    }
}
