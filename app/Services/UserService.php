<?php
namespace App\Services;

use App\Models\User;

class UserService{

//filters
/**
 * Summary of activeVerifiedFreelancers
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */
public function activeVerifiedFreelancers(){
    $users= User::freelancers()->active()->verified()->latest()->paginate(15);
    return $users;



}



//  public function index( $request): JsonResponse
//     {
//         $query = User::freelancers()->active()->verified() 
//             ->with(['profile' => fn($q) => $q->select('user_id', 'hourly_rate', 'availability_status', 'skills_summary', 'image')]);

//         if ($request->filled('skill')) {
//             $skills = explode(',', $request->skill);
//             $query->where(function($q) use ($skills) {
//                 foreach ($skills as $skill) {
//                     $q->orWhereJsonContains('profiles.skills_summary', trim($skill));
//                 }
//             });
//         }}




}
