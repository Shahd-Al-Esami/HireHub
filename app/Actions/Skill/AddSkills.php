<?php

namespace App\Actions\Skill;

use App\Models\Skill;
use Illuminate\Support\Facades\Cache;

class AddSkills
{
    /**
     * Add a new skill to a profile with experience years.
     */
    public function add(array $data, $profile): Skill
    {
        // Create or find the skill
        $skill = Skill::firstOrCreate([
            'name' => $data['name'],
        ]);

        // Attach to profile with pivot data (experience_years)
        $profile->skills()->attach($skill->id, [
            'experience_years' => $data['experience_years'] ?? 0,
        ]);
    Cache::tags(['freelancers'])->flush();

        return $skill;
    }
}
