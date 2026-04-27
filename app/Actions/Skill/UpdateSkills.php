<?php

namespace App\Actions\Skill;

use App\Models\Profile;
use App\Models\Skill;
use Illuminate\Support\Facades\Cache;

class UpdateSkills
{
    /**
     * Update a skill's name and sync with profile pivot data.
     */
    public function update(array $data, Skill $skill, Profile $profile): Skill
    {
        // Check if name already exists on another skill
        $exists = Skill::where('name', $data['name'])
            ->where('id', '!=', $skill->id)
            ->exists();

        if ($exists) {
            throw new \InvalidArgumentException('The skill name already exists.');
        }

        $skill->update([
            'name' => $data['name'],
        ]);

        // Sync with pivot data (experience_years)
        if (isset($data['experience_years'])) {
            $profile->skills()->syncWithoutDetaching([
                $skill->id => ['experience_years' => $data['experience_years']],
            ]);
        }
    Cache::tags(['freelancers'])->flush();

        return $skill->fresh();
    }
}
