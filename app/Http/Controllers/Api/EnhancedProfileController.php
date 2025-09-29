<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\PostComment;
use App\Models\DirectMessage;
use App\Models\Conversation;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EnhancedProfileController extends Controller
{
    /**
     * Get enhanced profile data for current user
     */
    public function getMyEnhancedProfile(): JsonResponse
    {
        $user = auth()->user();
        $profile = $user->profile()->firstOrCreate([]);
        $influencerProfile = $user->influencerProfile; // returns InfluencerProfile model or null
        $roleNames = $user->getRoleNames()->first(); // e.g. "instructor"
        // returns ['instructor', 'admin', ...]
        // Load relationships
        $profile->load(['user:id,name,email,avatar']);
        $profile->append(['bmi', 'age']);

        // Get subscription status
        $subscription = $user->subscriptions()->active()->first();

        // Get user comments (recent 10)
        $recentComments = PostComment::with(['post:id,content', 'user:id,name,avatar'])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        // Get chat history (recent conversations)
        // $chatHistory = Conversation::with(['participants:id,name,avatar', 'lastMessage'])
        $chatHistory = Conversation::with(['userOne:id,name,avatar', 'userTwo:id,name,avatar', 'lastMessage'])
            ->forUser($user->id)
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($conversation) use ($user) {
                $conversation->unread_count = $conversation->getUnreadCount($user->id);
                $conversation->other_participant = $conversation->getOtherParticipant($user->id);
                return $conversation;
            });

        // Get referral code
        $referralCode = $user->referral_code ?? $user->generateReferralCode();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'description' => $profile->bio,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'role' => $roleNames,
                    'referral_code' => $referralCode,
                ],
                'profile' => $profile,
                'subscription' => [
                    'is_subscribed' => !is_null($subscription),
                    'plan_name' => $subscription?->plan?->name,
                    'expires_at' => $subscription?->ends_at,
                    'status' => $subscription?->status ?? 'inactive',
                ],
                'body_stats' => [
                    'height' => $profile->height,
                    'weight' => $profile->weight,
                    'body_fat_percentage' => $profile->body_fat_percentage,
                    'muscle_mass' => $profile->muscle_mass,
                    'bmi' => $profile->bmi,
                    'measurements' => [
                        'chest' => $profile->chest,
                        'waist' => $profile->waist,
                        'hips' => $profile->hips,
                        'biceps' => $profile->biceps,
                        'thigh' => $profile->thigh,
                    ],
                ],
                'interests' => $profile->interests ?? [],
                'fitness_goals' => $profile->fitness_goals ?? [],
                'workout_preferences' => $profile->workout_preferences ?? [],
                'recent_comments' => $recentComments,
                'chat_history' => $chatHistory,
                'stats' => [
                    'total_posts' => $user->communityPosts()->count(),
                    'total_comments' => $user->postComments()->count(),
                    'total_friends' => $user->friendsCount(),
                    'badges_count' => $user->userBadges()->count(),
                ],
            ],
        ]);
    }

    /**
     * Get enhanced profile data for another user
     */
    public function getUserEnhancedProfile($userId): JsonResponse
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($userId);
        $profile = $user->profile;

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' => 'Profile not found',
            ], 404);
        }

        // Check friendship status
        $isFriend = $currentUser->isFriendsWith($userId);
        $friendshipStatus = $currentUser->getFriendshipStatus($userId);

        // Apply privacy filters
        $profileData = $this->formatProfileData($profile, $isFriend);

        // Get user comments (only if friend or public)
        $recentComments = [];
        if ($isFriend || $profile->show_activity) {
            $recentComments = PostComment::with(['post:id,content', 'user:id,name,avatar'])
                ->where('user_id', $user->id)
                ->latest()
                ->limit(10)
                ->get();
        }

        // Get subscription status (basic info only)
        $subscription = $user->subscriptions()->active()->first();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                ],
                'profile' => $profileData,
                'subscription' => [
                    'is_subscribed' => !is_null($subscription),
                ],
                'recent_comments' => $recentComments,
                'friendship_status' => $friendshipStatus,
                'is_friend' => $isFriend,
                'can_send_friend_request' => $profile->allow_friend_requests && !$isFriend && $friendshipStatus === 'none',
            ],
        ]);
    }

    /**
     * Get user's activity history
     */
    public function getUserActivity(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:50',
            'type' => 'nullable|string|in:all,workouts,community,fittalk,subscriptions,achievements,logins',
        ]);

        $user = auth()->user();
        $perPage = $request->per_page ?? 20;
        $activityType = $request->type ?? 'all';
        $activities = collect();

        try {
            // Community Activities (Posts, Comments, Likes)
            if ($activityType === 'all' || $activityType === 'community') {
                // Recent posts
                $posts = $user->communityPosts()
                    ->with(['category:id,name'])
                    ->latest()
                    ->limit(10)
                    ->get()
                    ->map(function ($post) {
                        return [
                            'id' => $post->id,
                            'type' => 'community_post',
                            'title' => 'Created a post',
                            'description' => substr($post->content, 0, 100) . '...',
                            'data' => [
                                'post_id' => $post->id,
                                'category' => $post->category?->name,
                                'likes_count' => $post->likes()->count(),
                                'comments_count' => $post->comments()->count(),
                            ],
                            'created_at' => $post->created_at,
                        ];
                    });
                $activities = $activities->merge($posts);

                // Recent comments
                $comments = $user->postComments()
                    ->with(['post:id,content,user_id'])
                    ->latest()
                    ->limit(10)
                    ->get()
                    ->map(function ($comment) {
                        return [
                            'id' => $comment->id,
                            'type' => 'community_comment',
                            'title' => 'Commented on a post',
                            'description' => substr($comment->content, 0, 100) . '...',
                            'data' => [
                                'comment_id' => $comment->id,
                                'post_id' => $comment->post_id,
                                'post_content' => substr($comment->post?->content ?? '', 0, 50) . '...',
                            ],
                            'created_at' => $comment->created_at,
                        ];
                    });
                $activities = $activities->merge($comments);
            }

            // FitTalk Sessions
            if ($activityType === 'all' || $activityType === 'fittalk') {
                if (class_exists('\App\Models\FittalkSession')) {
                    $fittalkSessions = $user->fittalkSessions()
                        ->with(['instructor:id,name'])
                        ->latest()
                        ->limit(10)
                        ->get()
                        ->map(function ($session) {
                            return [
                                'id' => $session->id,
                                'type' => 'fittalk_session',
                                'title' => 'Attended FitTalk session',
                                'description' => 'Session with ' . ($session->instructor?->name ?? 'instructor'),
                                'data' => [
                                    'session_id' => $session->id,
                                    'session_type' => $session->session_type ?? 'chat',
                                    'duration' => $session->duration_minutes ?? 30,
                                    'instructor' => $session->instructor?->name,
                                ],
                                'created_at' => $session->created_at,
                            ];
                        });
                    $activities = $activities->merge($fittalkSessions);
                }
            }

            // Subscription Activities
            if ($activityType === 'all' || $activityType === 'subscriptions') {
                $subscriptions = $user->subscriptions()
                    ->with(['plan:id,name'])
                    ->latest()
                    ->limit(5)
                    ->get()
                    ->map(function ($subscription) {
                        return [
                            'id' => $subscription->id,
                            'type' => 'subscription',
                            'title' => 'Subscription activity',
                            'description' => 'Subscribed to ' . ($subscription->plan?->name ?? 'plan'),
                            'data' => [
                                'subscription_id' => $subscription->id,
                                'plan_name' => $subscription->plan?->name,
                                'status' => $subscription->status,
                                'starts_at' => $subscription->starts_at,
                                'ends_at' => $subscription->ends_at,
                            ],
                            'created_at' => $subscription->created_at,
                        ];
                    });
                $activities = $activities->merge($subscriptions);
            }

            // Achievements/Badges
            if ($activityType === 'all' || $activityType === 'achievements') {
                if (method_exists($user, 'userBadges')) {
                    $badges = $user->userBadges()
                        ->with(['badge:id,name,description,icon'])
                        ->latest()
                        ->limit(10)
                        ->get()
                        ->map(function ($userBadge) {
                            return [
                                'id' => $userBadge->id,
                                'type' => 'achievement',
                                'title' => 'Earned a badge',
                                'description' => 'Earned "' . ($userBadge->badge?->name ?? 'badge') . '"',
                                'data' => [
                                    'badge_id' => $userBadge->badge_id,
                                    'badge_name' => $userBadge->badge?->name,
                                    'badge_description' => $userBadge->badge?->description,
                                    'badge_icon' => $userBadge->badge?->icon,
                                ],
                                'created_at' => $userBadge->created_at,
                            ];
                        });
                    $activities = $activities->merge($badges);
                }
            }

            // Login History (if tracking exists)
            if ($activityType === 'all' || $activityType === 'logins') {
                // Add login activity if login tracking exists
                $activities->push([
                    'id' => 'login_' . time(),
                    'type' => 'login',
                    'title' => 'Logged in',
                    'description' => 'User logged into the application',
                    'data' => [
                        'login_time' => now(),
                        'ip_address' => $request->ip(),
                    ],
                    'created_at' => now(),
                ]);
            }

            // Sort activities by created_at and paginate
            $sortedActivities = $activities->sortByDesc('created_at')->values();
            $total = $sortedActivities->count();
            $currentPage = $request->get('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $paginatedActivities = $sortedActivities->slice($offset, $perPage)->values();

            // Calculate pagination info
            $lastPage = ceil($total / $perPage);
            $hasMorePages = $currentPage < $lastPage;

            return response()->json([
                'success' => true,
                'data' => [
                    'activities' => $paginatedActivities,
                    'pagination' => [
                        'current_page' => $currentPage,
                        'per_page' => $perPage,
                        'total' => $total,
                        'last_page' => $lastPage,
                        'has_more_pages' => $hasMorePages,
                    ],
                    'summary' => [
                        'total_activities' => $total,
                        'activity_types' => $activities->groupBy('type')->map->count(),
                    ],
                ],
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user activity',
                'error' => $e->getMessage(),
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0',
                ],
            ], 500);
        }
    }

    /**
     * Get user's comment history
     */
    public function getUserComments(Request $request, $userId = null): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $currentUser = auth()->user();
        $targetUserId = $userId ?? $currentUser->id;
        $user = User::findOrFail($targetUserId);
        $perPage = $request->per_page ?? 20;

        // Check if current user can view comments
        if ($targetUserId !== $currentUser->id) {
            $profile = $user->profile;
            $isFriend = $currentUser->isFriendsWith($targetUserId);

            if (!$profile || (!$profile->show_activity && !$isFriend)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to view this user\'s comments',
                ], 403);
            }
        }

        $comments = PostComment::with([
            'post:id,content,user_id',
            'post.user:id,name,avatar',
            'user:id,name,avatar',
            'replies.user:id,name,avatar'
        ])
            ->where('user_id', $targetUserId)
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }

    /**
     * Get user's chat history
     */
    public function getUserChatHistory(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $user = auth()->user();
        $perPage = $request->per_page ?? 20;

        $conversations = Conversation::with([
            'userOne:id,name,avatar',
            'userTwo:id,name,avatar',
            'lastMessage.sender:id,name,avatar'
        ])
            ->forUser($user->id)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);

        // Add additional data for each conversation
        $conversations->getCollection()->transform(function ($conversation) use ($user) {
            $conversation->unread_count = $conversation->getUnreadCount($user->id);
            $conversation->other_participant = $conversation->getOtherParticipant($user->id);
            $conversation->last_message_time_ago = $conversation->last_message_time_ago;
            return $conversation;
        });

        return response()->json([
            'success' => true,
            'data' => $conversations,
        ]);
    }

    /**
     * Get detailed conversation messages
     */
    public function getConversationMessages(Request $request, $conversationId): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:100',
            'before' => 'nullable|integer', // Message ID for pagination
        ]);

        $conversation = Conversation::findOrFail($conversationId);
        $user = auth()->user();
        $perPage = $request->per_page ?? 50;

        // Check if user is participant
        if (!$conversation->hasParticipant($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to access this conversation',
            ], 403);
        }

        $query = $conversation->messages()
            ->with(['sender:id,name,avatar'])
            ->orderBy('created_at', 'desc');

        // Pagination using before cursor
        if ($request->before) {
            $query->where('id', '<', $request->before);
        }

        $messages = $query->limit($perPage)->get()->reverse()->values();

        return response()->json([
            'success' => true,
            'data' => [
                // 'conversation' => $conversation->load(['participants:id,name,avatar']),
                'conversation' => $conversation->load(['userOne:id,name,avatar', 'userTwo:id,name,avatar']),
                'messages' => $messages,
                'has_more' => $messages->count() === $perPage,
            ],
        ]);
    }

    /**
     * Format profile data with privacy filters
     */
    private function formatProfileData(UserProfile $profile, bool $isFriend): array
    {
        $data = [
            'id' => $profile->id,
            'user' => $profile->user,
            'bio' => $profile->bio,
            'location' => $profile->location,
            'gender' => $profile->gender,
        ];

        // Show age if date_of_birth is available
        if ($profile->date_of_birth) {
            $data['age'] = $profile->age;
        }

        // Show body stats based on privacy settings
        if ($profile->show_body_stats || $isFriend) {
            $data['body_stats'] = [
                'height' => $profile->height,
                'weight' => $profile->weight,
                'body_fat_percentage' => $profile->body_fat_percentage,
                'muscle_mass' => $profile->muscle_mass,
                'bmi' => $profile->bmi,
                'measurements' => [
                    'chest' => $profile->chest,
                    'waist' => $profile->waist,
                    'hips' => $profile->hips,
                    'biceps' => $profile->biceps,
                    'thigh' => $profile->thigh,
                ],
            ];
        }

        // Show goals based on privacy settings
        if ($profile->show_goals || $isFriend) {
            $data['fitness_goals'] = $profile->fitness_goals;
            $data['workout_preferences'] = $profile->workout_preferences;
        }

        // Always show interests
        $data['interests'] = $profile->interests;

        // Show achievements count if privacy allows
        if ($profile->show_achievements || $isFriend) {
            $data['badges_count'] = $profile->user->userBadges()->count();
        }

        // Show activity stats if privacy allows
        if ($profile->show_activity || $isFriend) {
            $data['stats'] = [
                'posts_count' => $profile->user->communityPosts()->count(),
                'comments_count' => $profile->user->postComments()->count(),
                'friends_count' => $profile->user->friendsCount(),
            ];
        }

        $data['privacy_settings'] = [
            'show_body_stats' => $profile->show_body_stats,
            'show_goals' => $profile->show_goals,
            'show_achievements' => $profile->show_achievements,
            'show_activity' => $profile->show_activity,
            'allow_friend_requests' => $profile->allow_friend_requests,
        ];

        return $data;
    }
}
