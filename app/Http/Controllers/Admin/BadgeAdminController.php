<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class BadgeAdminController extends Controller
{
    /**
     * Display listing of badges
     */
    public function index(Request $request)
    {
        $query = Badge::withCount('userBadges');

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $badges = $query->orderBy('points', 'desc')
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
            'type' => 'required|in:achievement,milestone,participation,special',
            'criteria' => 'required|string',
            'icon' => 'nullable|image|max:1024',
            'points' => 'required|integer|min:1|max:1000',
            'color' => 'nullable|string|max:7',
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
                'type' => $request->type,
                'criteria' => json_decode($request->criteria, true),
                'icon' => $iconPath,
                'image_path' => $iconPath,
                'points' => $request->points,
                'color' => $request->color ?? '#3B82F6',
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

        return view('admin.community.badges.show', compact('badge', 'stats'));
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
            'criteria' => 'required|string',
            'icon' => 'nullable|image|max:1024',
            'points' => 'required|integer|min:1|max:1000',
            'rarity' => 'required|in:common,uncommon,rare,epic,legendary',
            'is_active' => 'boolean',
        ]);

        try {
            // Decode criteria JSON string
            $criteria = json_decode($request->criteria, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()
                    ->withErrors(['criteria' => 'Invalid JSON format for criteria'])
                    ->withInput();
            }

            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'category' => $request->category,
                'type' => $request->type,
                'criteria' => $criteria,
                'points' => $request->points,
                'rarity' => $request->rarity,
                'is_active' => $request->boolean('is_active', true),
            ];

            if ($request->hasFile('icon')) {
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
            if ($badge->userBadges()->count() > 0) {
                return redirect()->route('admin.community.badges.index')
                    ->with('error', 'Cannot delete badge that has been earned by users.');
            }

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
     * Award badge manually
     */
    public function awardBadge(Request $request, Badge $badge): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $userId = $request->user_id;

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
} 