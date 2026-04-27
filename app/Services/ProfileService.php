<?php
namespace App\Services;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileService{
/**
 * Summary of availableFreelancers
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */


/**
 * Summary of topRatedFreelancers
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */
public function topRatedFreelancers(Request $request){
$topRatedFreelancers=Profile::with('user')->withAvg('reviews','rate')->topRated()->paginate($request->input('per_page', 10));
return $topRatedFreelancers;
}





}
