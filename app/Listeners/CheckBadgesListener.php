<?php

namespace App\Listeners;

use App\Events\UserActivityEvent;
use App\Services\BadgeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CheckBadgesListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $badgeService;

    /**
     * Create the event listener.
     */
    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Handle the event.
     */
    public function handle(UserActivityEvent $event): void
    {
        try {
            $newlyAwarded = $this->badgeService->checkAndAwardBadges($event->user);
            
            if (!empty($newlyAwarded)) {
                Log::info("Badges awarded to user {$event->user->id} after {$event->activityType}", [
                    'user_id' => $event->user->id,
                    'activity_type' => $event->activityType,
                    'badges_count' => count($newlyAwarded),
                    'badge_ids' => collect($newlyAwarded)->pluck('badge_id')->toArray()
                ]);
            }
            
        } catch (\Exception $e) {
            Log::error("Error checking badges for user {$event->user->id}: " . $e->getMessage());
        }
    }
}
