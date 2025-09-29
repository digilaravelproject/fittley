<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Services\BadgeService;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Display user's badges page
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $activeTab = $request->get('tab', 'earned');
        
        // Get user's earned badges
        $userBadges = $user->userBadges()
            ->with('badge')
            ->where('is_visible', true)
            ->orderBy('earned_at', 'desc')
            ->get();
        
        // Get available badges (not earned by user)
        $earnedBadgeIds = $userBadges->pluck('badge_id')->toArray();
        $availableBadges = Badge::active()
            ->whereNotIn('id', $earnedBadgeIds)
            ->orderBy('points', 'desc')
            ->orderBy('name')
            ->get();
        
        // Calculate total points
        $totalPoints = $userBadges->sum('badge.points');
        
        return view('user.badges', compact(
            'userBadges', 
            'availableBadges', 
            'totalPoints', 
            'activeTab'
        ));
    }

    /**
     * Get user's badge progress for a specific badge
     */
    public function progress(Request $request, Badge $badge)
    {
        $user = auth()->user();
        $progress = $this->badgeService->getBadgeProgress($user, $badge);
        
        return response()->json([
            'success' => true,
            'progress' => $progress,
            'overall_progress' => collect($progress)->avg('percentage') ?? 0,
            'is_earned' => $user->userBadges()->where('badge_id', $badge->id)->exists()
        ]);
    }

    /**
     * Manually check for new badges
     */
    public function checkBadges()
    {
        $user = auth()->user();
        $newlyAwarded = $user->checkBadges();
        
        return response()->json([
            'success' => true,
            'newly_awarded' => $newlyAwarded,
            'count' => count($newlyAwarded),
            'message' => count($newlyAwarded) > 0 
                ? 'Congratulations! You earned ' . count($newlyAwarded) . ' new badge(s)!'
                : 'No new badges earned yet. Keep participating!'
        ]);
    }

    /**
     * Toggle badge visibility
     */
    public function toggleVisibility(UserBadge $userBadge)
    {
        $this->authorize('update', $userBadge);
        
        $userBadge->update(['is_visible' => !$userBadge->is_visible]);
        
        return response()->json([
            'success' => true,
            'is_visible' => $userBadge->is_visible,
            'message' => $userBadge->is_visible 
                ? 'Badge is now visible on your profile'
                : 'Badge is now hidden from your profile'
        ]);
    }
}
