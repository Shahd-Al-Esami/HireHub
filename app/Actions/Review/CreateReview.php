<?php
namespace App\Actions\Review;

use App\Jobs\ReviewAverageJob;
use App\Models\Review;

class CreateReview{
    public function create(array $data){
        $review=Review::create([
            'rate'=>$data['rate'],
            'comment'=>$data['comment'],
            'client_id'=>$data['client_id']
        ]);
        if($review->reviewable_type ==='freelancer'){
        ReviewAverageJob::dispatch($review->reviewable_id);
        }
        return $review;
    }
}
