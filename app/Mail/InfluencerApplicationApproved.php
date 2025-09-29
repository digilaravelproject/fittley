<?php

namespace App\Mail;

use App\Models\User;
use App\Models\InfluencerProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InfluencerApplicationApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $influencerProfile;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, InfluencerProfile $influencerProfile)
    {
        $this->user = $user;
        $this->influencerProfile = $influencerProfile;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Fittelly Influencer Program! 🌟',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.influencer.approved',
            with: [
                'user' => $this->user,
                'influencerProfile' => $this->influencerProfile,
                'commissionRates' => config('payment.influencer.commission_tiers'),
                'minimumPayout' => config('payment.influencer.minimum_payout'),
                'dashboardUrl' => route('influencer.index'),
                'linksUrl' => route('influencer.links'),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
