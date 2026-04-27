<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
      protected Offer $offer;

    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    public function via($notifiable)
    {
        return ['mail']; // ممكن تضيفي database لاحقًا
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Offer Received')
            ->greeting('Hello ' . $notifiable->first_name)
            ->line('A new offer has been created on your project.')
            ->line('Offer Price: ' . $this->offer->price)
            ->line('From Freelancer: ' . $this->offer->user->first_name)
            ->action('View Offer', url('/show-project/' .Offer::findOrFail( $this->offer->project_id)))
            ->line('Thank you for using HireHub!');
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
