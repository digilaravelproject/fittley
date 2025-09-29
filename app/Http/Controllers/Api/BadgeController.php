<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Models\User;
use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BadgeController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }
    /**
     * Get all available badges
     */
    public function getBadges(Request $request): JsonResponse
    {
        $request->validate([
            'category' => 'nullable|string|in:community,fitness,milestone,special',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $perPage = $request->per_page ?? 20;
        $userId = auth()->id();

        $query = Badge::where('is_active', true);

        // Filter by category
        if ($request->category) {
            $query->where('category', $request->category);
        }

        $badges = $query->orderBy('points', 'desc')
            ->paginate($perPage);

        // Add user achievement status for each badge
        $userBadgeIds = UserBadge::where('user_id', $userId)->pluck('badge_id')->toArray();

        $badges->getCollection()->transform(function ($badge) use ($userBadgeIds) {
            $badge->is_earned = in_array($badge->id, $userBadgeIds);
            $badge->progress = $this->badgeService->getBadgeProgress(auth()->user(), $badge);
            return $badge;
        });

        return response()->json([
            'success' => true,
            'data' => $badges,
        ]);
    }

    /**
     * Get current user's badges
     */
    public function getMyBadges(Request $request): JsonResponse
    {
        $request->validate([
            'category' => 'nullable|string|in:community,fitness,milestone,special',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        $query = UserBadge::with(['badge'])
            ->where('user_id', $userId);

        // Filter by badge category
        if ($request->category) {
            $query->whereHas('badge', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        $userBadges = $query->orderBy('earned_at', 'desc')
            ->paginate($perPage);

        // Calculate total points
        $totalPoints = UserBadge::where('user_id', $userId)
            ->join('badges', 'user_badges.badge_id', '=', 'badges.id')
            ->sum('badges.points');

        return response()->json([
            'success' => true,
            'data' => [
                'badges' => $userBadges,
                'total_points' => $totalPoints,
                'total_count' => UserBadge::where('user_id', $userId)->count(),
            ],
        ]);
    }

    /**
     * Get specific badge details
     */
    public function getBadge($badgeId): JsonResponse
    {
        $badge = Badge::where('is_active', true)->findOrFail($badgeId);
        $userId = auth()->id();

        // Check if user has earned this badge
        $userBadge = UserBadge::where('user_id', $userId)
            ->where('badge_id', $badgeId)
            ->first();

        $badgeData = $badge->toArray();
        $badgeData['is_earned'] = $userBadge !== null;
        $badgeData['earned_at'] = $userBadge ? $userBadge->earned_at : null;
        $badgeData['progress'] = $this->badgeService->getBadgeProgress(User::find($userId), $badge);

        // Get recent earners (last 10)
        $recentEarners = UserBadge::with(['user:id,name,avatar'])
            ->where('badge_id', $badgeId)
            ->orderBy('earned_at', 'desc')
            ->limit(10)
            ->get();

        $badgeData['recent_earners'] = $recentEarners;
        $badgeData['total_earners'] = UserBadge::where('badge_id', $badgeId)->count();

        return response()->json([
            'success' => true,
            'data' => $badgeData,
        ]);
    }

    /**
     * Get another user's badges
     */
    public function getUserBadges(Request $request, $userId): JsonResponse
    {
        $request->validate([
            'category' => 'nullable|string|in:community,fitness,milestone,special',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $user = User::findOrFail($userId);
        $currentUserId = auth()->id();
        $perPage = $request->per_page ?? 20;

        // Check if current user can view this user's badges
        $canView = $this->canViewUserBadges($currentUserId, $userId);
        if (!$canView) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to view this user\'s badges',
            ], 403);
        }

        $query = UserBadge::with(['badge'])
            ->where('user_id', $userId);

        // Filter by badge category
        if ($request->category) {
            $query->whereHas('badge', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        $userBadges = $query->orderBy('earned_at', 'desc')
            ->paginate($perPage);

        // Calculate total points
        $totalPoints = UserBadge::where('user_id', $userId)
            ->join('badges', 'user_badges.badge_id', '=', 'badges.id')
            ->sum('badges.points');

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                ],
                'badges' => $userBadges,
                'total_points' => $totalPoints,
                'total_count' => UserBadge::where('user_id', $userId)->count(),
            ],
        ]);
    }


    /**
     * Check if current user can view another user's badges
     */
    private function canViewUserBadges(int $currentUserId, int $targetUserId): bool
    {
        if ($currentUserId === $targetUserId) {
            return true; // Can always view own badges
        }

        // Check if target user's profile allows showing achievements
        $targetUser = User::find($targetUserId);
        $profile = $targetUser->profile;

        if (!$profile || !$profile->show_achievements) {
            // Check if they are friends
            $currentUser = User::find($currentUserId);
            return $currentUser->isFriendsWith($targetUserId);
        }

        return true; // Public achievements
    }
} 