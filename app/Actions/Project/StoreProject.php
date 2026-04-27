<?php
namespace App\Actions\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StoreProject{


   public function store(array $data)
{
     return DB::transaction(function () use ($data) {

            $project = Project::create([
                'client_id'     =>Auth::id(),
                'title'         => $data['title'],
                'description'   => $data['description'],
                'budget_type'   => $data['budget_type'],
                'budget_amount' => $data['budget_amount'],
                'delivery_date' => $data['delivery_date'],
            ]);

            $tagIds = $data['tags'] ?? [];

            if (!empty($tagIds)) {
                $project->tags()->attach($tagIds);
            }
            //flush cache for open projects to get the new project in the list of open projects
             Cache::tags(['projects'])->flush();
            return $project;
        });



    }

    }
