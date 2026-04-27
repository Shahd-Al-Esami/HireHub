<?php


use App\Http\Api\AuthController;
use App\Http\Api\Controllers\DashboardController;
use App\Http\Api\Controllers\OfferController;
use App\Http\Api\Controllers\ProfileController;
use App\Http\Api\Controllers\ProjectController;
use App\Http\Api\Controllers\SkillController;
use App\Http\Api\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






Route::prefix('v1')->group(function () {

    // Public routes — no token required
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login',    [AuthController::class, 'login']);

//open projects
Route::get('projects', [ProjectController::class, 'index'])->name('projects.index')->middleware('logApi');
Route::get('/show-project/{project}', [ProjectController::class, 'show'])->middleware('logApi');


 Route::middleware('auth:sanctum')->group(function () {



Route::post('/store-project', [ProjectController::class, 'store'])->middleware('logApi');


Route::get('projects/min-budget/{amount}', [ProjectController::class, 'getProjectsByMinBudget'])->name('getProjectsByMinBudget')->middleware('logApi');
Route::get('projects/this-month', [ProjectController::class, 'getProjectsByThisMonth'])->name('getProjectsByThisMonth')->middleware('logApi');

//freelancer

Route::get('top-rated', [ProfileController::class, 'getTopRatedFreelancers'])->name('freelancers.profile.top-rated')->middleware('logApi');


//freelancers:verified
Route::get('show/{profile}', [ProfileController::class, 'show'])->name('freelancers.profile.show');
//available freelancers
Route::get('availableFreelancers', [UserController::class, 'availableFreelancers'])->middleware('logApi');

Route::put('/update-profile/{profile}', [ProfileController::class, 'update'])->middleware('FreelancerIsVerified');

//skills
Route::post('/add-skills/{profile}', [SkillController::class, 'store'])->middleware('FreelancerIsVerified');
Route::put('/update-skills/{profile}/{skill}', [SkillController::class, 'update'])->middleware('FreelancerIsVerified');

//offer
Route::get('show-offer/{offer}', [OfferController::class, 'show'])->middleware('logApi');
 Route::post('store-offer-project/{project_id}', [OfferController::class, 'store'])->middleware('FreelancerIsVerified');

Route::post('accept-offer/{offer}', [OfferController::class, 'acceptOffer'])->middleware('logApi');
Route::post('reject-offer/{offer}', [OfferController::class, 'rejectOffer'])->middleware('logApi');


//for admins
Route::get('/admin/stats', [DashboardController::class, 'index'])->middleware('IsAdmin');

    });





    // Protected routes — valid Sanctum token required
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me',     [AuthController::class, 'me']);
        Route::get('users',       [UserController::class, 'index']);
    });

});
