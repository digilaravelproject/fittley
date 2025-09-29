<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class CommunityBadgeController extends Controller
{
    /**
     * Display listing of badges
     */
    public function index(Request $request)
    {
        $query = Badge::withCount('userBadges');

        // Filter by category
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // Filter by type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $badges = $query->orderBy('rarity')
            ->orderBy('points', 'desc')
            ->paginate(20);

        return view('admin.community.badges.index', compact('badges'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.community.badges.create');
    }

    /**
     * Store new badge
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:badges',
            'description' => 'required|string|max:500',
            'category' => 'required|in:community,fitness,milestone,special',
            'type' => 'required|in:post_count,like_count,friend_count,comment_count,streak_days,group_member,first_action',
            'criteria' => 'required|array',
            'icon' => 'nullable|image|max:1024',
            'points' => 'required|integer|min:1|max:1000',
            'rarity' => 'required|in:common,uncommon,rare,epic,legendary',
            'is_active' => 'boolean',
        ]);

        try {
            $iconPath = null;
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')
                    ->store('badges/icons', 'public');
            }

            $badge = Badge::create([
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'type' => $request->type,
                'criteria' => $request->criteria,
                'icon' => $iconPath,
                'points' => $request->points,
                'rarity' => $request->rarity,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.community.badges.index')
                ->with('success', 'Badge created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating badge: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display badge details
     */
    public function show(Badge $badge)
    {
        $badge->load(['userBadges' => function($query) {
            $query->with('user:id,name,email,avatar')
                  ->latest('earned_at')
                  ->take(20);
        }]);

        $stats = [
            'total_earned' => $badge->userBadges()->count(),
            'earned_this_month' => $badge->userBadges()
                ->where('earned_at', '>=', now()->startOfMonth())
                ->count(),
            'earned_this_week' => $badge->userBadges()
                ->where('earned_at', '>=', now()->startOfWeek())
                ->count(),
        ];

        // Badge progress analytics
        $progressData = $this->getBadgeProgressAnalytics($badge);

        return view('admin.community.badges.show', compact('badge', 'stats', 'progressData'));
    }

    /**
     * Show edit form
     */
    public function edit(Badge $badge)
    {
        return view('admin.community.badges.edit', compact('badge'));
    }

    /**
     * Update badge
     */
    public function update(Request $request, Badge $badge)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:badges,name,' . $badge->id,
            'description' => 'required|string|max:500',
            'category' => 'required|in:community,fitness,milestone,special',
            'type' => 'required|in:post_count,like_count,friend_count,comment_count,streak_days,group_member,first_action',
            'criteria' => 'required|array',
            'icon' => 'nullable|image|max:1024',
            'points' => 'required|integer|min:1|max:1000',
            'rarity' => 'required|in:common,uncommon,rare,epic,legendary',
            'is_active' => 'boolean',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'type' => $request->type,
                'criteria' => $request->criteria,
                'points' => $request->points,
                'rarity' => $request->rarity,
                'is_active' => $request->boolean('is_active', true),
            ];

            if ($request->hasFile('icon')) {
                // Delete old icon
                if ($badge->icon) {
                    Storage::disk('public')->delete($badge->icon);
                }
                
                $data['icon'] = $request->file('icon')
                    ->store('badges/icons', 'public');
            }

            $badge->update($data);

            return redirect()->route('admin.community.badges.index')
                ->with('success', 'Badge updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating badge: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete badge
     */
    public function destroy(Badge $badge)
    {
        try {
            // Check if badge has been earned by users
            if ($badge->userBadges()->count() > 0) {
                return redirect()->route('admin.community.badges.index')
                    ->with('error', 'Cannot delete badge that has been earned by users.');
            }

            // Delete icon
            if ($badge->icon) {
                Storage::disk('public')->delete($badge->icon);
            }

            $badge->delete();

            return redirect()->route('admin.community.badges.index')
                ->with('success', 'Badge deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.community.badges.index')
                ->with('error', 'Error deleting badge: ' . $e->getMessage());
        }
    }

    /**
     * Toggle badge status
     */
    public function toggleStatus(Badge $badge): JsonResponse
    {
        try {
            $badge->update(['is_active' => !$badge->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Badge status updated successfully',
                'is_active' => $badge->is_active,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating badge status: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Manually award badge to user
     */
    public function awardBadge(Request $request, Badge $badge): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $userId = $request->user_id;

            // Check if user already has this badge
            $existingBadge = UserBadge::where('user_id', $userId)
                ->where('badge_id', $badge->id)
                ->first();

            if ($existingBadge) {
                return response()->json([
                    'success' => false,
                    'message' => 'User already has this badge',
                ], 400);
            }

            UserBadge::create([
                'user_id' => $userId,
                'badge_id' => $badge->id,
                'earned_at' => now(),
                'awarded_by' => auth()->id(),
                'manual_reason' => $request->reason,
            ]);

            $user = User::find($userId);

            return response()->json([
                'success' => true,
                'message' => "Badge awarded to {$user->name} successfully",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error awarding badge: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Revoke badge from user
     */
    public function revokeBadge(Request $request, Badge $badge): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $userBadge = UserBadge::where('user_id', $request->user_id)
                ->where('badge_id', $badge->id)
                ->first();

            if (!$userBadge) {
                return response()->json([
                    'success' => false,
                    'message' => 'User does not have this badge',
                ], 404);
            }

            $userBadge->delete();

            $user = User::find($request->user_id);

            return response()->json([
                'success' => true,
                'message' => "Badge revoked from {$user->name} successfully",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error revoking badge: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check badge criteria for all users
     */
    public function checkCriteria(Badge $badge): JsonResponse
    {
        try {
            $newlyEarned = 0;
            $users = User::all();

            foreach ($users as $user) {
                // Check if user already has this badge
                if ($user->userBadges()->where('badge_id', $badge->id)->exists()) {
                    continue;
                }

                // Check if user meets criteria
                if ($this->userMeetsCriteria($user, $badge)) {
                    UserBadge::create([
                        'user_id' => $user->id,
                        'badge_id' => $badge->id,
                        'earned_at' => now(),
                        'auto_awarded' => true,
                    ]);
                    $newlyEarned++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Badge criteria check completed. {$newlyEarned} new badges awarded.",
                'newly_earned' => $newlyEarned,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking badge criteria: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get badge progress analytics
     */
    private function getBadgeProgressAnalytics(Badge $badge): array
    {
        $users = User::all();
        $progressData = [
            'eligible_users' => 0,
            'close_to_earning' => 0, // Within 20% of criteria
            'halfway_there' => 0,    // 50% or more progress
        ];

        foreach ($users as $user) {
            // Skip users who already have the badge
            if ($user->userBadges()->where('badge_id', $badge->id)->exists()) {
                continue;
            }

            $progress = $this->calculateUserProgress($user, $badge);
            if ($progress > 0) {
                $progressData['eligible_users']++;
                
                if ($progress >= 80) {
                    $progressData['close_to_earning']++;
                } elseif ($progress >= 50) {
                    $progressData['halfway_there']++;
                }
            }
        }

        return $progressData;
    }

    /**
     * Check if user meets badge criteria
     */
    private function userMeetsCriteria(User $user, Badge $badge): bool
    {
        $criteria = $badge->criteria;

        switch ($badge->type) {
            case 'post_count':
                return $user->communityPosts()->count() >= $criteria['count'];

            case 'like_count':
                return $user->communityPosts()->sum('likes_count') >= $criteria['count'];

            case 'friend_count':
                return $user->friendsCount() >= $criteria['count'];

            case 'comment_count':
                return $user->postComments()->count() >= $criteria['count'];

            case 'group_member':
                return $user->groupMemberships()->count() >= $criteria['count'];

            case 'first_action':
                // These are typically awarded on first action
                return true;

            default:
                return false;
        }
    }

    /**
     * Calculate user progress towards badge
     */
    private function calculateUserProgress(User $user, Badge $badge): float
    {
        $criteria = $badge->criteria;

        switch ($badge->type) {
            case 'post_count':
                $current = $user->communityPosts()->count();
                return min(100, ($current / $criteria['count']) * 100);

            case 'like_count':
                $current = $user->communityPosts()->sum('likes_count');
                return min(100, ($current / $criteria['count']) * 100);

            case 'friend_count':
                $current = $user->friendsCount();
                return min(100, ($current / $criteria['count']) * 100);

            case 'comment_count':
                $current = $user->postComments()->count();
                return min(100, ($current / $criteria['count']) * 100);

            case 'group_member':
                $current = $user->groupMemberships()->count();
                return min(100, ($current / $criteria['count']) * 100);

            default:
                return 0;
        }
    }
} 