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
    $users= User::freelancers()->active()->verified()->with('profile')->latest()->paginate(15);
    return $users;



}

}
