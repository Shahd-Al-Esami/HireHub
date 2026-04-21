<?php
namespace App\Actions\Profile;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class UpdateProfile{


public function update(Profile $profile,array $data){
    $profile->update([
        // 'user_id' => $data['user_id'] ?? $profile->user_id,
        'bio' => $data['bio'] ?? $profile->bio,
        'hourly_rate' => $data['hourly_rate'] ?? $profile->hourly_rate,
        'image' => $data['image'] ?? $profile->image,
        'phone_number' => $data['phone_number'] ?? $profile->phone_number,
        'portfolio_links' => $data['portfolio_links'] ?? $profile->portfolio_links,
        'skills_summary' => $data['skills_summary'] ?? $profile->skills_summary,
        'availability_status' => $data['availability_status'] ?? $profile->availability_status,
    ]);
    return $profile;
}
}
