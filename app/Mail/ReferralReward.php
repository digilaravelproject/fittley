<?php

namespace App\Mail;

use App\Models\User;
use App\Models\ReferralUsage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReferralReward extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $referrer;
    public $referredUser;
    public $discountAmount;
    public $totalReferrals;

    /**
     * Create a new message instance.
     */
    public function __construct(User $referrer, User $referredUser, $discountAmount, $totalReferrals)
    {
        $this->referrer = $referrer;
        $this->referredUser = $referredUser;
        $this->discountAmount = $discountAmount;
        $this->totalReferrals = $totalReferrals;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Congratulations! You Earned a Referral Reward 🎉',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.referral.reward',
            with: [
                'referrer' => $this->referrer,
                'referredUser' => $this->referredUser,
                'discountAmount' => $this->discountAmount,
                'totalReferrals' => $this->totalReferrals,
                'referralCode' => $this->referrer->getOrCreateReferralCode()->code,
                'dashboardUrl' => route('dashboard'),
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
