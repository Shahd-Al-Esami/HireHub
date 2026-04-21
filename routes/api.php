<?php


use App\Http\Api\AuthController;
use App\Http\Api\Controllers\OfferController;
use App\Http\Api\Controllers\ProfileController;
use App\Http\Api\Controllers\ProjectController;
use App\Http\Api\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('freelancers')->group(function () {


});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






Route::prefix('v1')->group(function () {

    // Public routes — no token required
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login',    [AuthController::class, 'login']);


//project
Route::get('open-projects', [ProjectController::class, 'getOpenProjects'])->name('getOpenProjects')->middleware('logApi');
Route::get('projects/min-budget/{amount}', [ProjectController::class, 'getProjectsByMinBudget'])->name('getProjectsByMinBudget')->middleware('logApi');
Route::get('projects/this-month', [ProjectController::class, 'getProjectsByThisMonth'])->name('getProjectsByThisMonth')->middleware('logApi');

//freelancer

Route::get('top-rated', [ProfileController::class, 'getTopRatedFreelancers'])->name('freelancers.profile.top-rated')->middleware('logApi');
Route::get('available-freelancers', [ProfileController::class, 'getAvailableFreelancers'])->name('freelancers.profile.available')->middleware('logApi');

Route::get('{profile}', [ProfileController::class, 'show'])->name('freelancers.profile.show')->middleware('logApi');



Route::middleware(['auth:sanctum', 'FreelancerIsVerified'])->group(function () {
    Route::post('/store-offer/{project_id}', [OfferController::class, 'store']);
    
    Route::put('/freelancer/profile', [ProfileController::class, 'update']);
});






    // Protected routes — valid Sanctum token required
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me',     [AuthController::class, 'me']);
        Route::get('users',       [UserController::class, 'index']);
    });
});
