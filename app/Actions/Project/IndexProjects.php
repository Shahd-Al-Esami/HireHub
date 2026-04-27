<?php
namespace App\Actions\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Cache;

class IndexProjects
{


    public function index()
    {
        //task 3
        //use  DB::enableQueryLog(); and DB::getQueryLog() to log the number of queries executed before and after refactoring the code to avoid N+1 problem
        //in logApi middelware
        //for example if we have a 50 projects
        //before refactor :201 queries

        //  $projects= Project::all();//1 query
        // foreach ($projects as $project) {
        //     $project->user;//50 queries
        //     $project->tags;//50 queries
        //     $project->offers;//50 queries
        //     $project->review;//50 queries
        // }
        // return $projects;


        //after refactor: 6 queries

//withCount for offers to get the count of offers without loading them
//with for eager loading user, tags, attachments and review to avoid N+1 problem
//latest to order by created_at desc
//paginate to get 15 projects per page
//get only id, first_name and last_name of user to reduce the amount of data loaded
//get only id and name of tags to reduce the amount of data loaded
//get only id and file_path of attachments to reduce the amount of data loaded

$page = request('page', 1);

$projects=Cache::tags(['projects'])->remember("open_projects_page_{$page}", now()->addMinutes(5), function () {
     $projects= Project::openProjects()->with(['user:id,first_name,last_name','tags:id,name'])
    ->withCount('offers')->withAvg('review', 'rate')->latest()
    ->paginate(15);

    });
    return $projects;


}


}
