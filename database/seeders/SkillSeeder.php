<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $skills = ['PHP', 'Laravel', 'JS', 'Vue', 'MySQL'];

        foreach ($skills as $name) {
            Skill::create(['name' => $name]);
        }

        $profiles = Profile::all();

        foreach ($profiles as $profile) {
            $skillIds = Skill::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            foreach ($skillIds as $skillId) {
                $profile->skills()->attach($skillId, ['experience_years' => rand(1, 10)]);
            }
        }
    }

}
