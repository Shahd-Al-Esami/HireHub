<?php
namespace App\Actions\Project;

use App\Models\Project;

class ShowProjectCard{
 public function show(Project $project)
    {
        return $project->load(['user:id,first_name,last_name', 'tags:id,name','offers','review']);
    }
}
