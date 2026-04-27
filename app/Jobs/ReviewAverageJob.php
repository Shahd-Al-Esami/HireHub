<?php

namespace App\Jobs;

use App\Models\Profile;
use App\Models\Review;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReviewAverageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $freelancerId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $freelancerId)
    {
        $this->freelancerId = $freelancerId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $freelancer = Profile::where('user_id',$this->freelancerId)->first();

      $freelancer->reviews()->avg('rate');
    }}
