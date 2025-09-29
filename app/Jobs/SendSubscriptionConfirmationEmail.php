<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserSubscription;
use App\Mail\SubscriptionConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendSubscriptionConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $subscription;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, UserSubscription $subscription = null)
    {
        $this->user = $user;
        $this->subscription = $subscription ?: $user->currentSubscription;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            if ($this->subscription) {
                Mail::to($this->user->email)->send(
                    new SubscriptionConfirmation($this->user, $this->subscription)
                );
                
                Log::info('Subscription confirmation email sent', [
                    'user_id' => $this->user->id,
                    'subscription_id' => $this->subscription->id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send subscription confirmation email', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }
}
