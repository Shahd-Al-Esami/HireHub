<?php

namespace App\Http\Api\Controllers;

use App\Http\Api\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;


class ProjectController extends Controller
{
protected ProjectService $service;
    public function __construct(ProjectService $service) {
$this->service = $service;
    }

    public function getOpenProjects()
    {
        $projects = $this->service->getOpenProjects();
    return ProjectResource::collection($projects);
    }

   public function getProjectsByMinBudget($amount)
    {
        $projects = $this->service->minBudget($amount);
    return ProjectResource::collection($projects);
    }

public function getProjectsByThisMonth(){
 $projects = $this->service->projectsByThisMonth();
    return ProjectResource::collection($projects);
}

    // public function store(StoreProjectRequest $request)
    // {
    //     $project = $this->service->store($request->validated());

    //     return new ProjectResource($project);
    // }

    // public function show(Project $project)
    // {
    //     return new ProjectResource(
    //         $this->service->show($project)
    //     );
    // }

    // public function update(UpdateProjectRequest $request, Project $project)
    // {
    //     $project = $this->service->update($project, $request->validated());

    //     return new ProjectResource($project);
    // }

    // public function destroy(Project $project)
    // {
    //     $this->service->delete($project);

    //     return response()->json([
    //         'message' => 'Deleted successfully'
    //     ]);}
    }
