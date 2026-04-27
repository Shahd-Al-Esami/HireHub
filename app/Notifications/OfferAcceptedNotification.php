<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferAcceptedNotification extends Notification implements ShouldQueue
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
        return ['mail', 'database']; // اختياري تضيفي database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎉 Offer Accepted')
            ->greeting('Hello ' . $notifiable->first_name)
            ->line('Great news! Your offer has been ACCEPTED.')
            ->line('Offer Price: ' . $this->offer->price)
            ->line('Project: ' . $this->offer->project->title)
            ->action('View Project', url('/projects/' . Offer::findOrFail($this->offer->project_id)))
            ->line('Congratulations!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'offer_accepted',
            'message' => 'Your offer has been accepted',
            'offer_id' => $this->offer->id,
        ];
    }}
