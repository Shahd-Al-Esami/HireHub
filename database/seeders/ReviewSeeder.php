<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $client = User::where('role', 'client')->first();
        $profile = Profile::findOrFail(1);

        $projects = Project::all();

        foreach ($projects as $project) {
            $project->review()->create([
                'client_id' => $client->id,
                'rate' => rand(3,5),
                'comment' => 'Nice project',
                'reviewable_id' => $project->id,
                'reviewable_type' => get_class($project),
            ]);
        }

            $profile->reviews()->create([
                'client_id' => $client->id,
                'rate' => rand(3,5),
                'comment' => 'Nice work',
                'reviewable_id' => $profile->user_id,
                'reviewable_type' => 'Freelancer',
            ]);

    }
}
