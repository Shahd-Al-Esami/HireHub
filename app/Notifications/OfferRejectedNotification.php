<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
     protected $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(' Offer Rejected')
            ->greeting('Hello ' . $notifiable->first_name)
            ->line('We are sorry, your offer was not accepted.')
            ->line('Offer Price: ' . $this->offer->price)
            ->line('Project: ' . $this->offer->project->title)
            ->line('Don’t give up, try again!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'offer_rejected',
            'message' => 'Your offer was rejected',
            'offer_id' => $this->offer->id,
        ];
    }
}
