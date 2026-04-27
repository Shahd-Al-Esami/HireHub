<?php

namespace App\Jobs;

use App\Mail\OfferRejectedMail;
use App\Models\Offer;
use App\Notifications\OfferRejectedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOfferRejectedJob implements ShouldQueue
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
        $offer = Offer::findOrFail($this->offerId);

$offer->user->notify(new OfferRejectedNotification($offer));

        // 3. إرسال إيميل للمستقل
        // Mail::to($offer->user->email)
        //     ->send(new OfferRejectedMail($offer));
    }}
