<?php

namespace App\Jobs;

use App\Mail\ProjectPublishedMail;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectCreatedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewProjectCreatedJob implements ShouldQueue
{
     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $project;
    public $tries = 3;
    public $backoff = [60, 300, 900]; // 1min, 5min, 15min



    public function __construct(
        public int $userId,
        public int $projectId
    ) {}

    public function handle(): void
    {
        $user = User::findOrFail($this->userId);
        $project = Project::findOrFail($this->projectId);

        if (!$user || !$project) {
            return;
        }
Project::findOrFail($this->projectId)->user->notify(new ProjectCreatedNotification($project));

        // Mail::to($user->email)
        //     ->send(new ProjectPublishedMail($project));
    }
}
