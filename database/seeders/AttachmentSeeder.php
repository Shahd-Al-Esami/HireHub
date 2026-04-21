<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $offers = Offer::all();

        foreach ($projects as $project) {
            $project->attachments()->create([
                'file_path' => 'uploads/sample.pdf',
                'user_id' => 2,
                'attachable_id' => $project->id,
                'attachable_type' => get_class($project),
            ]);
        }

          foreach ($offers as $offer) {
            $offer->attachments()->create([
                'file_path' => 'uploads/sample.pdf',
                'user_id' => 1,
                'attachable_id' => $offer->id,
                'attachable_type' => get_class($offer),
            ]);
        }
    }
}
