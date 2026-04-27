<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
      protected Project $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function via($notifiable)
    {
        return ['mail']; // ممكن تضيفي database لاحقًا
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New project Received')
            ->greeting('Hello ' . $notifiable->first_name)
            ->line('A new project has been created on your project.')
            ->line('From Freelancer: ' . $this->project->user->first_name)
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
