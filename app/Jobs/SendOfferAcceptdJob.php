<?php

namespace App\Jobs;

use App\Mail\OfferAcceptedMail;
use App\Models\Offer;
use App\Notifications\OfferAcceptedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOfferAcceptdJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $offerId;


        public $tries = 3;
    public $backoff = [60, 300, 900]; // 1min, 5min, 15min


    /**
     * Create a new job instance.
     */
    public function __construct(int $offerId)
    {
        $this->offerId = $offerId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $offer=Offer::findOrFail($this->offerId);
$offer->user->notify(new OfferAcceptedNotification($offer));

        // Mail::to($offer->user->email)
        //     ->send(new OfferAcceptedMail($offer));
    }}
