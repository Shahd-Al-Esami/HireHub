<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectPublishedMail extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Project $project;

    /**
     * Create a new message instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Project Published Successfully ')
            ->text('emails.project_published_plain')
            ->with([
                'project' => $this->project,
            ]);
    }
}
