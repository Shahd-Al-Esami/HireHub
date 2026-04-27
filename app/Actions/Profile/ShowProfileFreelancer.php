<?php
namespace App\Actions\Profile;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ShowProfileFreelancer{



/**
 * Summary of show
 * @param Profile $profile
 * @return Profile
 */
public function show(Profile $profile)
{
    //task 3
      //use  DB::enableQueryLog(); and DB::getQueryLog() to log the number of queries executed before and after refactoring the code to avoid N+1 problem
        //in logApi middelware
        //for example if we have a profile with 10 reviews
        //before refactor :11 queries
    // lazy loading causes n+1 problem
    //get all details of relation user,skills and reviews
    // $profile->user; //1 query
    //   //to get the count of reviews we need to load all reviews and then  count
    // count($profile->reviews);//10 query
    // //to get the average rating we need to load all reviews and then calculate the average

    // $averageRating = array_sum($profile->reviews->pluck('rate')->toArray()) / count($profile->reviews->pluck('rate')->toArray());
    // return $profile;


    //after refactor: 3 query only

//eager loading user and skills to avoid n+1 problem
//get only id, first_name , last_name, created_at and email of user to reduce the amount of data loaded
//get only id and name of skills to reduce the amount of data loaded

 $profile->loadMissing([
        'user:id,first_name,last_name,email,created_at','reviews','skills'

    ])
    //loadCount to get the count of reviews without loading them
    ->loadCount('reviews')
    ////loadAvg to get the average rating without loading all reviews
    ->loadAvg('reviews', 'rate');

    return $profile;
 }

}
