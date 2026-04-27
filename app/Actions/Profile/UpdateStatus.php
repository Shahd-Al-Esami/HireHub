<?php
namespace App\Actions\Profile;

use App\Models\Profile;
use Illuminate\Support\Facades\Cache;

class UpdateStatus{


public function updateStatus(Profile $profile,array $data){
    $profile->update([
        'availability_status' => $data['availability_status'] ?? $profile->availability_status,
    ]);
    //for update cache for freelancers available now
    Cache::tags(['freelancers'])->flush();
    return $profile;

}
}
