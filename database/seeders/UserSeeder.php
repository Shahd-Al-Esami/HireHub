<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        
        $freelancer = User::create([
            'first_name' => 'freelancer One',
            'last_name' => 'freelancer Last Name',
            'email' => 'freelancer@test.com',
            'password' => bcrypt('123456'),
            'role' => 'freelancer',
            'city_id' => 1,
            'is_verified' => true,
            'is_active' => true,
        ]);
           $client = User::create([
            'first_name' => 'client One',
            'last_name' => 'client Last Name',
            'email' => 'client@test.com',
            'password' => bcrypt('123666'),
            'role' => 'client',
            'city_id' => 2,
            'is_verified' => true,
            'is_active' => true,
        ]);

        // User::factory(5)->create([
        //     'role' => 'freelancer'
        // ]);
    }
}
