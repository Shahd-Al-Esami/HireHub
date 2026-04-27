<?php

namespace App\Mail;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OfferRejectedMail extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Offer $offer;

    /**
     * Create a new message instance.
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject(' Your Offer Has Been Rejected')
            ->text(
                'Hello ' . $this->offer->user->first_name .
                ', unfortunately your offer for project "' .
                $this->offer->project->title .
                '" has been rejected.'
            );
    }}
