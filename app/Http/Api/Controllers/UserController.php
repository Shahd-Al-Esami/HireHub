<?php
namespace App\Http\Api\Controllers;

use App\Http\Api\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{

protected UserService $service;
    public function __construct(UserService $service) {
$this->service = $service;
    }
public function activeVerifiedFreelancers()
{
    $users = $this->service->activeVerifiedFreelancers();
    return response()->json($users);
}



}
