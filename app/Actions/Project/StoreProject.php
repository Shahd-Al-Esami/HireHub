<?php
namespace App\Actions\Project;

use App\Models\Project;

class StoreProject{


   public function store(array $data)
    {
        return Project::create($data);
    }}
