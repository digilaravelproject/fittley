<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        try {
            // Create default referral code for new user
            $user->createDefaultReferralCode();
            
            Log::info("Referral code created for user: {$user->id}");
        } catch (\Exception $e) {
            Log::error("Failed to create referral code for user {$user->id}: " . $e->getMessage());
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Update referral discount when user's referral performance changes
        if ($user->isDirty(['referral_count'])) {
            try {
                $user->updateReferralDiscount();
            } catch (\Exception $e) {
                Log::error("Failed to update referral discount for user {$user->id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Deactivate referral code when user is deleted
        if ($user->referralCode) {
            $user->referralCode->update(['is_active' => false]);
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        // Reactivate referral code when user is restored
        if ($user->referralCode) {
            $user->referralCode->update(['is_active' => true]);
        }
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
