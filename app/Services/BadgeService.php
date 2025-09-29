<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\UserBadge;
use Illuminate\Support\Facades\Log;

class BadgeService
{
    /**
     * Check and award badges for a user
     */
    public function checkAndAwardBadges(User $user): array
    {
        $newlyAwarded = [];
        
        try {
            $activeBadges = Badge::active()->get();
            
            foreach ($activeBadges as $badge) {
                // Skip if user already has this badge
                if ($user->userBadges()->where('badge_id', $badge->id)->exists()) {
                    continue;
                }
                
                // Check if user meets criteria
                if ($this->userMeetsCriteria($user, $badge)) {
                    $userBadge = $this->awardBadge($user, $badge);
                    $newlyAwarded[] = $userBadge;
                    
                    Log::info("Badge awarded", [
                        'user_id' => $user->id,
                        'badge_id' => $badge->id,
                        'badge_name' => $badge->name
                    ]);
                }
            }
            
        } catch (\Exception $e) {
            Log::error("Error checking badges for user {$user->id}: " . $e->getMessage());
        }
        
        return $newlyAwarded;
    }
    
    /**
     * Award a specific badge to a user
     */
    public function awardBadge(User $user, Badge $badge, array $achievementData = null): UserBadge
    {
        return UserBadge::create([
            'user_id' => $user->id,
            'badge_id' => $badge->id,
            'earned_at' => now(),
            'achievement_data' => $achievementData,
            'is_visible' => true,
        ]);
    }
    
    /**
     * Check if user meets badge criteria
     */
    public function userMeetsCriteria(User $user, Badge $badge): bool
    {
        if (!$badge->criteria || !is_array($badge->criteria)) {
            return false;
        }
        
        foreach ($badge->criteria as $criterion => $value) {
            if (!$this->checkCriterion($user, $criterion, $value)) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Check individual criterion
     */
    protected function checkCriterion(User $user, string $criterion, $value): bool
    {
        switch ($criterion) {
            case 'posts_count':
                return $user->communityPosts()->count() >= $value;
                
            case 'likes_received':
                $likesCount = $user->communityPosts()->sum('likes_count');
                return $likesCount >= $value;
                
            case 'comments_made':
                return $user->postComments()->count() >= $value;
                
            case 'days_active':
                $daysActive = $user->created_at->diffInDays(now());
                return $daysActive >= $value;
                
            case 'friends_count':
                $friendsCount = $user->friends()->where('status', 'accepted')->count();
                return $friendsCount >= $value;
                
            case 'groups_joined':
                $groupsCount = $user->groupMemberships()->where('status', 'approved')->count();
                return $groupsCount >= $value;
                
            // Fitness-specific criteria
            case 'fitlive_sessions_attended':
                $sessionsCount = $user->fitliveSessions()->where('status', 'ended')->count();
                return $sessionsCount >= $value;
                
            case 'fitguide_completed':
                $completedCount = $user->fitguideProgress()->where('completed', true)->count();
                return $completedCount >= $value;
                
            case 'fitnews_read':
                $readCount = $user->fitnewsReads()->count();
                return $readCount >= $value;
                
            case 'fitarena_participated':
                $participatedCount = $user->fitarenaParticipations()->count();
                return $participatedCount >= $value;
                
            case 'streak_days':
                $streakDays = $this->calculateStreakDays($user);
                return $streakDays >= $value;
                
            case 'total_points':
                $totalPoints = $user->userBadges()->with('badge')->get()->sum('badge.points');
                return $totalPoints >= $value;
                
            default:
                return false;
        }
    }
    
    /**
     * Calculate user's current streak days
     */
    protected function calculateStreakDays(User $user): int
    {
        // This would need to be implemented based on your activity tracking
        // For now, return a placeholder
        return 0;
    }
    
    /**
     * Get user's badge progress for a specific badge
     */
    public function getBadgeProgress(User $user, Badge $badge): array
    {
        $progress = [];
        
        if (!$badge->criteria || !is_array($badge->criteria)) {
            return $progress;
        }
        
        foreach ($badge->criteria as $criterion => $targetValue) {
            $currentValue = $this->getCurrentValue($user, $criterion);
            $progress[$criterion] = [
                'current' => $currentValue,
                'target' => $targetValue,
                'percentage' => $targetValue > 0 ? min(100, round(($currentValue / $targetValue) * 100, 2)) : 0
            ];
        }
        
        return $progress;
    }
    
    /**
     * Get current value for a criterion
     */
    protected function getCurrentValue(User $user, string $criterion): int
    {
        switch ($criterion) {
            case 'posts_count':
                return $user->communityPosts()->count();
                
            case 'likes_received':
                return $user->communityPosts()->sum('likes_count');
                
            case 'comments_made':
                return $user->postComments()->count();
                
            case 'days_active':
                return $user->created_at->diffInDays(now());
                
            case 'friends_count':
                return $user->friends()->where('status', 'accepted')->count();
                
            case 'groups_joined':
                return $user->groupMemberships()->where('status', 'approved')->count();
                
            case 'fitlive_sessions_attended':
                return $user->fitliveSessions()->where('status', 'ended')->count();
                
            case 'fitguide_completed':
                return $user->fitguideProgress()->where('completed', true)->count();
                
            case 'fitnews_read':
                return $user->fitnewsReads()->count();
                
            case 'fitarena_participated':
                return $user->fitarenaParticipations()->count();
                
            case 'streak_days':
                return $this->calculateStreakDays($user);
                
            case 'total_points':
                return $user->userBadges()->with('badge')->get()->sum('badge.points');
                
            default:
                return 0;
        }
    }
}
