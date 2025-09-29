<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityCategory;
use App\Models\CommunityGroup;
use App\Models\Badge;
use App\Models\UserBadge;
use App\Models\Friendship;
use App\Models\DirectMessage;
use App\Models\FittalkSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class CommunityDashboardController extends Controller
{
    /**
     * Show community dashboard
     */
    public function index()
    {
        $stats = $this->getCommunityStats();
        
        return view('admin.community.dashboard', compact('stats'));
    }

    /**
     * Get community analytics data (API)
     */
    public function analytics(Request $request): JsonResponse
    {
        $request->validate([
            'period' => 'nullable|in:7,30,90,365',
            'type' => 'nullable|in:posts,users,messages,sessions',
        ]);

        $period = $request->period ?? 30;
        $type = $request->type ?? 'posts';

        $data = $this->getAnalyticsData($type, $period);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Get community statistics
     */
    private function getCommunityStats(): array
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            // Posts Statistics
            'posts' => [
                'total' => CommunityPost::count(),
                'today' => CommunityPost::whereDate('created_at', $today)->count(),
                'this_week' => CommunityPost::where('created_at', '>=', $thisWeek)->count(),
                'this_month' => CommunityPost::where('created_at', '>=', $thisMonth)->count(),
                'by_category' => CommunityCategory::withCount('posts')
                    ->orderBy('posts_count', 'desc')
                    ->take(5)
                    ->get(),
            ],

            // Users & Engagement
            'users' => [
                'total_community_users' => User::whereHas('communityPosts')->count(),
                'active_today' => User::whereHas('communityPosts', function($q) use ($today) {
                    $q->whereDate('created_at', $today);
                })->count(),
                'new_friendships_today' => Friendship::whereDate('created_at', $today)
                    ->where('status', 'accepted')->count(),
                'total_friendships' => Friendship::where('status', 'accepted')->count(),
            ],

            // Groups
            'groups' => [
                'total' => CommunityGroup::count(),
                'active' => CommunityGroup::where('is_active', true)->count(),
                'with_recent_activity' => CommunityGroup::whereHas('posts', function($q) use ($thisWeek) {
                    $q->where('created_at', '>=', $thisWeek);
                })->count(),
                'most_popular' => CommunityGroup::orderBy('members_count', 'desc')
                    ->take(5)
                    ->get(['id', 'name', 'members_count']),
            ],

            // Badges & Gamification
            'badges' => [
                'total_badges' => Badge::where('is_active', true)->count(),
                'badges_earned_today' => UserBadge::whereDate('earned_at', $today)->count(),
                'badges_earned_this_month' => UserBadge::where('earned_at', '>=', $thisMonth)->count(),
                'most_earned' => Badge::withCount('userBadges')
                    ->orderBy('user_badges_count', 'desc')
                    ->take(5)
                    ->get(['id', 'name', 'icon', 'user_badges_count']),
            ],

            // Messaging
            'messaging' => [
                'total_conversations' => \App\Models\Conversation::count(),
                'messages_today' => DirectMessage::whereDate('created_at', $today)->count(),
                'messages_this_week' => DirectMessage::where('created_at', '>=', $thisWeek)->count(),
                'active_conversations_today' => \App\Models\Conversation::whereHas('messages', function($q) use ($today) {
                    $q->whereDate('created_at', $today);
                })->count(),
            ],

            // FitTalk Sessions
            'fittalk' => [
                'total_sessions' => FittalkSession::count(),
                'sessions_today' => FittalkSession::whereDate('scheduled_at', $today)->count(),
                'completed_sessions' => FittalkSession::where('status', 'completed')->count(),
                // 'revenue_this_month' => FittalkSession::where('status', 'completed')
                //     ->where('created_at', '>=', $thisMonth)
                //     ->sum('cost'),
                'top_instructors' => User::whereHas('roles', function($q) {
                        $q->where('name', 'instructor');
                    })->withCount(['instructorSessions as completed_sessions' => function($q) {
                        $q->where('status', 'completed');
                    }])->orderBy('completed_sessions', 'desc')
                    ->take(5)
                    ->get(['id', 'name', 'avatar', 'completed_sessions']),
            ],

            // Content Moderation
            'moderation' => [
                'pending_reports' => 0, // Placeholder for future reporting system
                'flagged_posts' => CommunityPost::where('is_flagged', true)->count(),
                // 'blocked_users' => User::where('is_blocked', true)->count(),
            ],

            // Recent Activity (last 10 items)
            'recent_activity' => $this->getRecentActivity(),
        ];
    }

    /**
     * Get analytics data for specific type and period
     */
    private function getAnalyticsData(string $type, int $days): array
    {
        $startDate = Carbon::now()->subDays($days);
        $dates = [];
        $data = [];

        // Generate date range
        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;
            $data[$date] = 0;
        }

        switch ($type) {
            case 'posts':
                $posts = CommunityPost::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', $startDate)
                    ->groupBy('date')
                    ->pluck('count', 'date')
                    ->toArray();

                foreach ($posts as $date => $count) {
                    if (isset($data[$date])) {
                        $data[$date] = $count;
                    }
                }
                break;

            case 'users':
                $users = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', $startDate)
                    ->groupBy('date')
                    ->pluck('count', 'date')
                    ->toArray();

                foreach ($users as $date => $count) {
                    if (isset($data[$date])) {
                        $data[$date] = $count;
                    }
                }
                break;

            case 'messages':
                $messages = DirectMessage::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', $startDate)
                    ->groupBy('date')
                    ->pluck('count', 'date')
                    ->toArray();

                foreach ($messages as $date => $count) {
                    if (isset($data[$date])) {
                        $data[$date] = $count;
                    }
                }
                break;

            case 'sessions':
                $sessions = FittalkSession::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', $startDate)
                    ->groupBy('date')
                    ->pluck('count', 'date')
                    ->toArray();

                foreach ($sessions as $date => $count) {
                    if (isset($data[$date])) {
                        $data[$date] = $count;
                    }
                }
                break;
        }

        return [
            'labels' => $dates,
            'data' => array_values($data),
            'type' => $type,
            'period' => $days,
        ];
    }

    /**
     * Get recent activity across all community features
     */
    private function getRecentActivity(): array
    {
        $activities = collect();

        // Recent posts
        $recentPosts = CommunityPost::with('user:id,name', 'category:id,name')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($post) {
                return [
                    'type' => 'post',
                    'message' => "{$post->user->name} created a new post in {$post->category->name}",
                    'time' => $post->created_at,
                    'link' => route('admin.community.posts.show', $post->id),
                ];
            });

        // Recent groups
        $recentGroups = CommunityGroup::with('category:id,name')
            ->latest()
            ->take(3)
            ->get()
            ->map(function($group) {
                return [
                    'type' => 'group',
                    'message' => "New group '{$group->name}' created in {$group->category->name}",
                    'time' => $group->created_at,
                    'link' => route('admin.community.groups.show', $group->id),
                ];
            });

        // Recent badges earned
        $recentBadges = UserBadge::with(['user:id,name', 'badge:id,name'])
            ->latest('earned_at')
            ->take(3)
            ->get()
            ->map(function($userBadge) {
                return [
                    'type' => 'badge',
                    'message' => "{$userBadge->user->name} earned the '{$userBadge->badge->name}' badge",
                    'time' => $userBadge->earned_at,
                    'link' => route('admin.community.badges.show', $userBadge->badge->id),
                ];
            });

        // Recent FitTalk sessions
        $recentSessions = FittalkSession::with(['user:id,name', 'instructor:id,name'])
            ->latest()
            ->take(3)
            ->get()
            ->map(function($session) {
                return [
                    'type' => 'fittalk',
                    'message' => "{$session->user->name} booked a FitTalk session with {$session->instructor->name}",
                    'time' => $session->created_at,
                    'link' => route('admin.community.fittalk.show', $session->id),
                ];
            });

        // Merge and sort by time
        $activities = $activities
            ->merge($recentPosts)
            ->merge($recentGroups)
            ->merge($recentBadges)
            ->merge($recentSessions)
            ->sortByDesc('time')
            ->take(10)
            ->values();

        return $activities->toArray();
    }
} 