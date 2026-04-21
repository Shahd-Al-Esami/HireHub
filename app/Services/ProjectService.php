<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{

//filters
    /**
     * Summary of getOpenProjects
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getOpenProjects()
    {
        $projects= Project::openProjects()->with(['user:id,first_name,last_name', 'tags:id,name','attachments','review'])->withCount('offers')->latest()
    ->paginate(15);
    return $projects;

    }

/**
 * Summary of minBudget
 * @param mixed $amount
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */
public function minBudget($amount){
    $projects= Project::openProjects()->minBudget($amount)->with(['user:id,first_name,last_name', 'tags:id,name','attachments','review'])->withCount('offers')->latest()
    ->paginate(15);
    return $projects;
}
/**
 * Summary of projectsByThisMonth
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */
public function projectsByThisMonth(){
    $projects= Project::openProjects()->thisMonth()->with(['user:id,first_name,last_name', 'tags:id,name','attachments','review'])->withCount('offers')->latest()
    ->paginate(15);
    return $projects;
}




    // public function store(array $data)
    // {
    //     return Project::create($data);
    // }

    // public function show(Project $project)
    // {
    //     return $project->load(['user:id,name', 'tags:id,name','offers','review']);
    // }




    // public function update(Project $project, array $data)
    // {
    //     $project->update($data);
    //     return $project;
    // }

    // public function delete(Project $project)
    // {
    //     $project->delete($project);
    //     return true;
    // }
}
