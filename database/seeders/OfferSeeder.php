<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $freelancers = User::where('role', 'freelancer')->get();
        $projects = Project::all();

        foreach ($projects as $project) {
            foreach ($freelancers->random(1) as $freelancer) {
                Offer::create([
                    'project_id' => $project->id,
                    'freelancer_id' => $freelancer->id,
                    'price' => rand(100, 500),
                    'delivery_time' => 5,
                    'status' => 'pending',
                    'cover_letter' => 'I am interested in this project and believe I can deliver high-quality work within the specified timeframe.',
                ]);
    }
        }}}
