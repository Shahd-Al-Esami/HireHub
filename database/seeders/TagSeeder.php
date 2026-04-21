<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        $tags = ['Web', 'Mobile', 'Backend', 'API'];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }

        $projects = Project::all();

        foreach ($projects as $project) {
            $project->tags()->attach(
                Tag::inRandomOrder()->take(2)->pluck('id')->toArray()
            );
        }
    }
}
