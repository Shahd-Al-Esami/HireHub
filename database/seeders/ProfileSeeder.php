<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $freelancers = User::where('role', 'freelancer')->get();

        foreach ($freelancers as $user) {
            Profile::create([
                'user_id' => $user->id,
                'bio' => 'Professional developer',
                'hourly_rate' => rand(10, 60),
                'phone_number' => '123-456-7890',
                'portfolio_links' => ['https://example.com/portfolio1', 'https://example.com/portfolio2'],
                'skills_summary' => ['PHP', 'JavaScript'],
                'availability_status' => 'available',
                'image' => 'https://via.placeholder.com/150',
            ]);
        }}}
