<?php
namespace App\Actions\Profile;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;

class ShowProfileFreelancer{



/**
 * Summary of show
 * @param Profile $profile
 * @return Profile
 */
public function show(Profile $profile)
    {
        $profile->load([
            'user:id,first_name,last_name,email,created_at',

            'skills:id,name'
        ])
        ->loadCount('reviews')
        ->loadAvg('reviews', 'rate');

return $profile;    }

}
