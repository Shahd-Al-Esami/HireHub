<?php
namespace App\Http\Api\Controllers;

use App\Http\Api\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

protected UserService $service;
    public function __construct(UserService $service) {
$this->service = $service;
    }
public function availableFreelancers(Request $request)
{
    $users = $this->service->availableFreelancers($request);
    return response()->json($users);
}



}
