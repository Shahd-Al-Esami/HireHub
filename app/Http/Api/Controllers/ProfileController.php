<?php

namespace App\Http\Api\Controllers;

use App\Actions\Profile\ShowProfileFreelancer;
use App\Actions\Profile\UpdateProfile;
use App\Actions\Profile\UpdateStatus;
use App\Http\Api\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
/**
 * Summary of service
 * @var ProfileService
 */
protected ProfileService $service;
    public function __construct(ProfileService $service) {
$this->service = $service;
    }

/**
 * Summary of updateStatus
 * @param UpdateStatus $action
 * @param Profile $profile
 * @param Request $request
 * @return ProfileResource
 */
public function updateStatus(UpdateStatus $action,Profile $profile,Request $request){
    $updatedProfile=$action->updateStatus($profile,$request->only('availability_status'));
    return new ProfileResource($updatedProfile);
}

/**
 * Summary of getTopRatedFreelancers
 * @return \Illuminate\Http\JsonResponse
 */
public function getTopRatedFreelancers(Request $request){

     $topRatedFreelancers= $this->service->topRatedFreelancers($request);
         return ProfileResource::collection($topRatedFreelancers);

}


 /**
     * Summary of show
     * @param Profile $profile
     * @param ShowProfileFreelancer $action
     * @return ProfileResource
     */
    public function show(Profile $profile,ShowProfileFreelancer $action)
    {
          $user=$action->show($profile);
          return new ProfileResource($user);
    }



  public function update(UpdateProfile $action,UpdateProfileRequest $request,Profile $profile)
    {
          $user=$action->update($profile,$request->validated(),);
          return new ProfileResource($user);
    }









    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
