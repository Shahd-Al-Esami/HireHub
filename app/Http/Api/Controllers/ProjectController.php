<?php

namespace App\Http\Api\Controllers;

use App\Actions\Project\IndexProjects;
use App\Actions\Project\ShowProjectCard;
use App\Actions\Project\StoreProject;
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

    public function index(IndexProjects $action)
    {
        $projects = $action->index();
        return ProjectResource::collection($projects);

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

    public function store(StoreProject $action,StoreProjectRequest $request)
    {
        $project = $action->store($request->validated());

        return new ProjectResource($project);
    }

    public function show(ShowProjectCard $action, Project $project)
    {   $project=$action->show($project);

        return new ProjectResource(
            $project
        );
    }



    }
