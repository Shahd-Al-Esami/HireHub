<?php
namespace App\Actions\Project;

use App\Models\Project;

class ShowProjectCard{
 public function show(Project $project)
    {
        return $project->load(['user:id,first_name,last_name','attachments:id,file_path,attachable_id,attachable_type','offers','review'])->loadCount('offers');
    }
}
