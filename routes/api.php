<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public API routes (no authentication required)
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'apiLogin']);
    Route::post('/register', [AuthController::class, 'apiRegister']);
    
    // Firebase OTP routes
    Route::post('/otp/send', [App\Http\Controllers\Api\FirebaseOtpController::class, 'sendOtp']);
    Route::post('/otp/verify', [App\Http\Controllers\Api\FirebaseOtpController::class, 'verifyOtp']);
    Route::post('/otp/check-phone', [App\Http\Controllers\Api\FirebaseOtpController::class, 'checkPhone']);

    Route::get('/pages/{type}', [App\Http\Controllers\Api\StaticPageController::class, 'getPages']);

    Route::post('/contact_us', [App\Http\Controllers\Api\StaticPageController::class, 'contactUs']);
});

// Public content API routes (no authentication required)
Route::prefix('fitguide')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\FitGuideApiController::class, 'index']);
    Route::get('/categories', [App\Http\Controllers\Api\FitGuideApiController::class, 'categories']);
});

// FitDoc API routes (public)
Route::prefix('fitdoc')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\FitDocController::class, 'index']);
    Route::get('/categories', [App\Http\Controllers\Api\FitDocController::class, 'getCategories']);
    Route::get('/series/{id}', [App\Http\Controllers\Api\FitDocController::class, 'getSeries']);
    Route::get('/{id}', [App\Http\Controllers\Api\FitDocController::class, 'show']);
});

Route::prefix('fitnews')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\FitNewsApiController::class, 'index']);
});

Route::prefix('fitinsight')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\FitInsightApiController::class, 'index']);
    Route::get('/categories', [App\Http\Controllers\Api\FitInsightApiController::class, 'categories']);
});

// Public API routes for subscription system
Route::prefix('public')->group(function () {
    // Public subscription plans (for guest users to view)
    Route::get('/subscription/plans', [App\Http\Controllers\SubscriptionController::class, 'apiPublicPlans']);
    
    // Influencer tracking (no authentication required)
    Route::get('/ref/{code}', [App\Http\Controllers\SubscriptionController::class, 'apiTrackInfluencerLink']);
    Route::post('/ref/{code}/convert', [App\Http\Controllers\SubscriptionController::class, 'apiConvertInfluencerSale']);
    
    // Referral code validation (for guest users)
    Route::get('/referral/validate/{code}', [App\Http\Controllers\SubscriptionController::class, 'apiValidateReferralCode']);
});

// Commission tiers (public)
Route::get('/commission-tiers', [App\Http\Controllers\TrackingController::class, 'getCommissionTiers'])->name('api.commission-tiers');

// FitLive Public API routes
Route::prefix('fitlive')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'index']);
    
    // Protected content - requires subscription
    // Route::middleware(['auth:web', 'subscription:fitlive'])->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('{id}', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'show']);
        Route::get('/daily-live/{id}', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'DailyLiveClasses']);
        Route::get('{id}/details', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'details']);
        Route::get('{id}/stream-status', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'streamStatus']);
        
        // Agora Co-Host Authentication endpoints
        Route::get('{id}/agora-config', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'getAgoraConfig']);
        Route::post('{id}/switch-role', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'switchRole']);
        
        // Participant management endpoints
        Route::get('{id}/participants', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'getParticipants']);
        Route::post('{id}/join', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'joinSession']);
        Route::post('{id}/share', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'share']);
        Route::post('{id}/like', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'like']);
        Route::post('{id}/unlike', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'unlike']);
        Route::post('{id}/leave', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'leaveSession']);
        Route::post('{id}/chat/moderate', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'moderateChat']);
        
        // Chat endpoints
        Route::get('{id}/chat/messages', [App\Http\Controllers\Api\FitLiveChatController::class, 'getMessages']);
        Route::post('{id}/chat', [App\Http\Controllers\Api\FitLiveChatController::class, 'sendMessage']);
        Route::get('{id}/chat/status', [App\Http\Controllers\Api\FitLiveChatController::class, 'getChatStatus']);
    });
});

// FitArena Live API routes (PUBLIC)
Route::prefix('fitarena')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\FitArenaApiController::class, 'index']);
    Route::get('/{id}/live', [App\Http\Controllers\Api\FitArenaApiController::class, 'getFitArenaLiveById']);

    Route::post('{id}/share', [App\Http\Controllers\Api\FitArenaApiController::class, 'share']);
    Route::post('{id}/like', [App\Http\Controllers\Api\FitArenaApiController::class, 'like']);
    Route::post('{id}/unlike', [App\Http\Controllers\Api\FitArenaApiController::class, 'unlike']);

    Route::get('/{id}/liveSession', [App\Http\Controllers\Api\FitArenaApiController::class, 'getFitArenaLiveSessionById']);
    Route::get('/featured', [App\Http\Controllers\Api\FitArenaApiController::class, 'featured']);
    Route::get('/upcoming', [App\Http\Controllers\Api\FitArenaApiController::class, 'upcoming']);
    Route::get('/live', [App\Http\Controllers\Api\FitArenaApiController::class, 'live']);
    Route::get('/{eventSlug}', [App\Http\Controllers\Api\FitArenaApiController::class, 'show']);
    Route::get('/{eventSlug}/stages', [App\Http\Controllers\Api\FitArenaApiController::class, 'stages']);
    Route::get('/{eventSlug}/agenda', [App\Http\Controllers\Api\FitArenaApiController::class, 'agenda']);
    Route::get('/{eventSlug}/live-sessions', [App\Http\Controllers\Api\FitArenaApiController::class, 'liveSessions']);
    Route::get('/{eventSlug}/replays', [App\Http\Controllers\Api\FitArenaApiController::class, 'replays']);
    Route::get('/{eventSlug}/stages/{stageId}', [App\Http\Controllers\Api\FitArenaApiController::class, 'stageDetails']);
    Route::get('/{eventSlug}/sessions/{sessionId}', [App\Http\Controllers\Api\FitArenaApiController::class, 'sessionDetails']);
    
    // Protected content - requires authentication
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/{eventSlug}/stages/{stageId}/stream', [App\Http\Controllers\Api\FitArenaApiController::class, 'stageStream']);
        Route::get('/{eventSlug}/sessions/{sessionId}/replay', [App\Http\Controllers\Api\FitArenaApiController::class, 'sessionReplay']);
    });
});

// LiveKit webhook endpoint
Route::post('fitlive/webhook', App\Http\Controllers\Api\FitLiveKitWebhookController::class);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    // Authentication
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'apiLogout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
    
    // Admin API routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard/stats', [AdminController::class, 'dashboardStats']);
        
        // Users
        Route::get('/users', [AdminController::class, 'apiUsers']);
        Route::post('/users/{user}/assign-role', [AdminController::class, 'assignRole']);
        Route::delete('/users/{user}/remove-role', [AdminController::class, 'removeRole']);
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus']);
        
        // Roles
        Route::get('/roles', [AdminController::class, 'apiRoles']);
        
        // Permissions
        Route::get('/permissions', [AdminController::class, 'apiPermissions']);
        
        // FitLive Admin API
        Route::prefix('fitlive')->group(function () {
            Route::get('/sessions', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'index']);
            Route::post('/sessions/{session}/start', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'start']);
            Route::post('/sessions/{session}/end', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'end']);
            Route::post('/sessions/{session}/cancel', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'cancel']);
            Route::post('/sessions/{id}/update-stream', [App\Http\Controllers\Api\FitLiveSessionApiController::class, 'updateStream']);
        });
    });
    
    // General user routes
    Route::get('/user', function (Request $request) {
        return $request->user()->load('roles', 'permissions');
    });
    
    // Subscription API routes
    Route::prefix('subscription')->name('api.subscription.')->group(function () {
        // Plans and subscription management
        Route::get('/plans', [App\Http\Controllers\SubscriptionController::class, 'apiPlans']);
        Route::get('/current', [App\Http\Controllers\SubscriptionController::class, 'apiCurrent']);
        Route::post('/subscribe', [App\Http\Controllers\SubscriptionController::class, 'apiSubscribe']);
        Route::patch('/cancel', [App\Http\Controllers\SubscriptionController::class, 'apiCancel']);
        Route::post('/renew', [App\Http\Controllers\SubscriptionController::class, 'apiRenew']);
        Route::get('/history', [App\Http\Controllers\SubscriptionController::class, 'apiHistory']);
        
        // Referral system
        Route::prefix('referrals')->group(function () {
            Route::get('/', [App\Http\Controllers\SubscriptionController::class, 'apiReferrals']);
            Route::post('/apply', [App\Http\Controllers\SubscriptionController::class, 'apiApplyReferral']);
            Route::get('/my-code', [App\Http\Controllers\SubscriptionController::class, 'apiMyReferralCode']);
            Route::get('/validate/{code}', [App\Http\Controllers\SubscriptionController::class, 'apiValidateReferralCode']);
        });
    });
    
    // Payment API routes
    Route::prefix('payment')->name('api.payment.')->group(function () {
        // Payment processing
        Route::post('/create-intent', [App\Http\Controllers\PaymentController::class, 'createPaymentIntent']);
        Route::post('/calculate-pricing', [App\Http\Controllers\PaymentController::class, 'calculatePricing']);
        
        // Payment methods
        Route::get('/methods', [App\Http\Controllers\PaymentController::class, 'getPaymentMethods']);
        Route::post('/methods', [App\Http\Controllers\PaymentController::class, 'addPaymentMethod']);
        Route::delete('/methods', [App\Http\Controllers\PaymentController::class, 'removePaymentMethod']);
    });

    // Content APIs - Authentication Required for some features  
    // Route::prefix('fitguide')->middleware('subscription:fitguide')->group(function () {
    Route::prefix('fitguide')->group(function () {
        Route::get('/{id}', [App\Http\Controllers\Api\FitGuideApiController::class, 'show']);
        Route::get('/{id}/live', [App\Http\Controllers\Api\FitGuideApiController::class, 'getFitGuideById']);

        Route::post('{id}/share', [App\Http\Controllers\Api\FitGuideApiController::class, 'share']);
        Route::post('{id}/like', [App\Http\Controllers\Api\FitGuideApiController::class, 'like']);
        Route::post('{id}/unlike', [App\Http\Controllers\Api\FitGuideApiController::class, 'unlike']);

        Route::get('/single/{fgSingle}', [App\Http\Controllers\Api\FitGuideApiController::class, 'showSingle']);
        Route::get('/series/{fgSeries}', [App\Http\Controllers\Api\FitGuideApiController::class, 'showSeries']);
        Route::get('/{id}/fitcast', [App\Http\Controllers\Api\FitGuideApiController::class, 'getFitCastsById']);
        Route::get('/series/{fgSeries}/episodes', [App\Http\Controllers\Api\FitGuideApiController::class, 'seriesEpisodes']);
    });
    
    // Route::prefix('fitnews')->middleware('subscription:fitnews')->group(function () {
    Route::prefix('fitnews')->group(function () {
        Route::get('/{fitNews}', [App\Http\Controllers\Api\FitNewsApiController::class, 'show']);
        Route::get('/{id}/live', [App\Http\Controllers\Api\FitNewsApiController::class, 'getFitNewsById']);
        Route::post('/{fitNews}/join', [App\Http\Controllers\Api\FitNewsApiController::class, 'join']);
        Route::post('/{fitNews}/leave', [App\Http\Controllers\Api\FitNewsApiController::class, 'leave']);
        Route::post('/{id}/share', [App\Http\Controllers\Api\FitNewsApiController::class, 'share']);
        Route::post('/{id}/like', [App\Http\Controllers\Api\FitNewsApiController::class, 'like']);
        Route::post('/{id}/unlike', [App\Http\Controllers\Api\FitNewsApiController::class, 'unlike']);
    });
    
    Route::prefix('fitinsight')->group(function () {
        Route::get('/{blog}', [App\Http\Controllers\Api\FitInsightApiController::class, 'show']);
        Route::get('/{id}/live', [App\Http\Controllers\Api\FitInsightApiController::class, 'getFitInsightsById']);
        Route::post('/{id}/like', [App\Http\Controllers\Api\FitInsightApiController::class, 'like']);
        Route::post('/{id}/unlike', [App\Http\Controllers\Api\FitInsightApiController::class, 'unlike']);
        Route::post('/{id}/share', [App\Http\Controllers\Api\FitInsightApiController::class, 'share']);
    });

    // Content access check
    Route::get('/content/access-check', [App\Http\Controllers\SubscriptionController::class, 'apiContentAccessCheck']);
    Route::get('/content/{type}/{id}/access', [App\Http\Controllers\SubscriptionController::class, 'apiContentAccess']);

    // Community API routes
    Route::prefix('community')->group(function () {
        // Posts
        Route::get('/posts', [App\Http\Controllers\Api\CommunityController::class, 'getPosts']);
        Route::post('/posts', [App\Http\Controllers\Api\CommunityController::class, 'createPost']);
        Route::delete('/posts/{post}', [App\Http\Controllers\Api\CommunityController::class, 'deletePost']);
        Route::post('/posts/{post}/like', [App\Http\Controllers\Api\CommunityController::class, 'toggleLike']);
        Route::post('/posts/{post}/comment', [App\Http\Controllers\Api\CommunityController::class, 'addComment']);
        Route::post('/posts/{post}/share', [App\Http\Controllers\Api\CommunityController::class, 'sharePost']);

        // Categories
        Route::get('/categories', [App\Http\Controllers\Api\CommunityController::class, 'getCategories']);

        // Badges
        Route::get('/badges', [App\Http\Controllers\Api\BadgeController::class, 'getBadges']);
        Route::get('/badges/my', [App\Http\Controllers\Api\BadgeController::class, 'getMyBadges']);
        Route::get('/badges/{badge}', [App\Http\Controllers\Api\BadgeController::class, 'getBadge']);
        Route::get('/badges/user/{user}', [App\Http\Controllers\Api\BadgeController::class, 'getUserBadges']);

        // Friends/Follow System
        Route::get('/friends', [App\Http\Controllers\Api\FriendshipController::class, 'getFriends']);
        Route::get('/friends/pending', [App\Http\Controllers\Api\FriendshipController::class, 'getPendingRequests']);
        Route::get('/friends/sent', [App\Http\Controllers\Api\FriendshipController::class, 'getSentRequests']);
        Route::post('/friends/request', [App\Http\Controllers\Api\FriendshipController::class, 'sendFriendRequest']);
        Route::get('/friends/search', [App\Http\Controllers\Api\FriendshipController::class, 'searchUsers']);
        Route::get('/friends/{user}/status', [App\Http\Controllers\Api\FriendshipController::class, 'getFriendshipStatus']);
        Route::post('/friends/{friendship}/accept', [App\Http\Controllers\Api\FriendshipController::class, 'acceptFriendRequest']);
        Route::post('/friends/{friendship}/decline', [App\Http\Controllers\Api\FriendshipController::class, 'declineFriendRequest']);
        Route::post('/friends/{friendship}/block', [App\Http\Controllers\Api\FriendshipController::class, 'blockUser']);
        Route::delete('/friends/{friendship}', [App\Http\Controllers\Api\FriendshipController::class, 'unfriend']);

        // Groups
        Route::get('/groups', [App\Http\Controllers\Api\GroupController::class, 'getGroups']);
        Route::get('/search_group', [App\Http\Controllers\Api\GroupController::class, 'searchGroups']);
        Route::get('/groups/{group}', [App\Http\Controllers\Api\GroupController::class, 'getGroupById']);
        // Route::get('/groups/{group}', [App\Http\Controllers\Api\GroupController::class, 'getGroup']);
        Route::get('/groups/{group}/members', [App\Http\Controllers\Api\GroupController::class, 'getMembers']);
        Route::post('/groups/{group}/join', [App\Http\Controllers\Api\GroupController::class, 'joinGroup']);
        Route::post('/groups/{group}/leave', [App\Http\Controllers\Api\GroupController::class, 'leaveGroup']);
        Route::post('/groups/{group}/members/{user}/role', [App\Http\Controllers\Api\GroupController::class, 'changeRole']);
        Route::delete('/groups/{group}/members/{user}', [App\Http\Controllers\Api\GroupController::class, 'removeMember']);

        // Direct Messages
        Route::get('/messages/conversations', [App\Http\Controllers\Api\DirectMessageController::class, 'getConversations']);
        Route::post('/messages/conversations', [App\Http\Controllers\Api\DirectMessageController::class, 'createConversation']);
        Route::get('/messages/conversations/{conversation}', [App\Http\Controllers\Api\DirectMessageController::class, 'getMessages']);
        Route::post('/messages/conversations/{conversation}', [App\Http\Controllers\Api\DirectMessageController::class, 'sendMessage']);
        Route::patch('/messages/conversations/{conversation}/read', [App\Http\Controllers\Api\DirectMessageController::class, 'markAsRead']);
        Route::delete('/messages/conversations/{conversation}', [App\Http\Controllers\Api\DirectMessageController::class, 'deleteConversation']);

        // User Profiles
        Route::get('/profiles/me', [App\Http\Controllers\Api\UserProfileController::class, 'getMyProfile']);
        Route::get('/profiles/notification', [App\Http\Controllers\Api\UserProfileController::class, 'getMyNotification']);
        Route::put('/profiles/me', [App\Http\Controllers\Api\UserProfileController::class, 'updateMyProfile']);
        Route::get('/profiles/{user}', [App\Http\Controllers\Api\UserProfileController::class, 'getUserProfile']);
        Route::patch('/profiles/privacy', [App\Http\Controllers\Api\UserProfileController::class, 'updatePrivacy']);

        // Community Page APIs
        Route::prefix('community-page')->group(function () {
            Route::get('/posts', [App\Http\Controllers\Api\CommunityPageController::class, 'getAllPosts']);
            Route::get('/posts/user/{userId}', [App\Http\Controllers\Api\CommunityPageController::class, 'getUserPosts']);
            Route::post('/posts', [App\Http\Controllers\Api\CommunityPageController::class, 'createPost']);
            Route::post('/posts/{postId}/like', [App\Http\Controllers\Api\CommunityPageController::class, 'toggleLike']);
            Route::post('/posts/{postId}/comment', [App\Http\Controllers\Api\CommunityPageController::class, 'addComment']);
            Route::post('/users/{userId}/follow', [App\Http\Controllers\Api\CommunityPageController::class, 'toggleFollow']);
            Route::post('/posts/{postId}/share', [App\Http\Controllers\Api\CommunityPageController::class, 'sharePost']);
        });

        // FitTalk
        Route::prefix('fittalk')->group(function () {
            Route::get('/instructors', [App\Http\Controllers\Api\FittalkController::class, 'getInstructors']);
            Route::get('/sessions', [App\Http\Controllers\Api\FittalkController::class, 'getMySessions']);
            Route::post('/sessions', [App\Http\Controllers\Api\FittalkController::class, 'bookSession']);
            Route::get('/sessions/{session}', [App\Http\Controllers\Api\FittalkController::class, 'getSession']);
            Route::post('/sessions/{session}/start', [App\Http\Controllers\Api\FittalkController::class, 'startSession']);
            Route::post('/sessions/{session}/end', [App\Http\Controllers\Api\FittalkController::class, 'endSession']);
            Route::post('/sessions/{session}/cancel', [App\Http\Controllers\Api\FittalkController::class, 'cancelSession']);
            Route::get('/sessions/{session}/agora-config', [App\Http\Controllers\Api\FittalkController::class, 'getAgoraConfig']);
        });
    });
});

// Influencer API routes (requires authentication)
Route::middleware('auth:sanctum')->prefix('influencer')->name('api.influencer.')->group(function () {
    Route::get('/', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'apiIndex']);
    Route::post('/apply', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'apply']);
    Route::get('/status', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'status']);
    Route::get('/analytics', [App\Http\Controllers\TrackingController::class, 'getInfluencerAnalytics'])->name('analytics');
    Route::post('/generate-link', [App\Http\Controllers\TrackingController::class, 'generateInfluencerLink'])->name('generate-link');
    Route::get('/profile', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'profile']);
    Route::put('/profile', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'updateProfile']);
    Route::get('/links', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'links']);
    Route::post('/links', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'createLink']);
    Route::patch('/links/{influencerLink}/toggle', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'toggleLink']);
    Route::get('/sales', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'sales']);
    Route::get('/earnings', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'earnings']);
    Route::get('/payouts', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'payouts']);
    Route::post('/payouts/request', [App\Http\Controllers\Influencer\InfluencerDashboardController::class, 'requestPayout']);
});

// Bulk User Operations
Route::prefix('v1/users')->middleware('auth:sanctum')->group(function () {
    Route::post('bulk-create', [\App\Http\Controllers\Api\BulkUserController::class, 'bulkCreate']);
    Route::put('bulk-update', [\App\Http\Controllers\Api\BulkUserController::class, 'bulkUpdate']);
    Route::delete('bulk-delete', [\App\Http\Controllers\Api\BulkUserController::class, 'bulkDelete']);
    Route::patch('bulk-status', [\App\Http\Controllers\Api\BulkUserController::class, 'bulkStatusChange']);
});

// Bulk FitDoc Operations
Route::prefix('v1/fitdocs')->middleware('auth:sanctum')->group(function () {
    Route::post('bulk-create', [\App\Http\Controllers\Api\BulkFitDocController::class, 'bulkCreate']);
    Route::put('bulk-update', [\App\Http\Controllers\Api\BulkFitDocController::class, 'bulkUpdate']);
    Route::delete('bulk-delete', [\App\Http\Controllers\Api\BulkFitDocController::class, 'bulkDelete']);
    Route::patch('bulk-status', [\App\Http\Controllers\Api\BulkFitDocController::class, 'bulkStatusChange']);
});

// Bulk CommunityPost Operations
Route::prefix('v1/community-posts')->middleware('auth:sanctum')->group(function () {
    Route::post('bulk-create', [\App\Http\Controllers\Api\BulkCommunityPostController::class, 'bulkCreate']);
    Route::put('bulk-update', [\App\Http\Controllers\Api\BulkCommunityPostController::class, 'bulkUpdate']);
    Route::delete('bulk-delete', [\App\Http\Controllers\Api\BulkCommunityPostController::class, 'bulkDelete']);
    Route::patch('bulk-status', [\App\Http\Controllers\Api\BulkCommunityPostController::class, 'bulkStatusChange']);
});

// Enhanced Profile API Routes
Route::prefix('v1/profile')->middleware('auth:sanctum')->group(function () {
    // Get current user's enhanced profile
    Route::get('enhanced', [\App\Http\Controllers\Api\EnhancedProfileController::class, 'getMyEnhancedProfile']);
    
    // Get another user's enhanced profile
    Route::get('enhanced/{userId}', [\App\Http\Controllers\Api\EnhancedProfileController::class, 'getUserEnhancedProfile']);
    
    // Get user's activity history
    Route::get('activity', [\App\Http\Controllers\Api\EnhancedProfileController::class, 'getUserActivity']);
    
    // Get user's comment history
    Route::get('comments', [\App\Http\Controllers\Api\EnhancedProfileController::class, 'getUserComments']);
    Route::get('comments/{userId}', [\App\Http\Controllers\Api\EnhancedProfileController::class, 'getUserComments']);
    
    // Get user's chat history
    Route::get('chat-history', [\App\Http\Controllers\Api\EnhancedProfileController::class, 'getUserChatHistory']);
    
    // Get conversation messages
    Route::get('conversations/{conversationId}/messages', [\App\Http\Controllers\Api\EnhancedProfileController::class, 'getConversationMessages']);
});

// Homepage APIs
Route::prefix('v1/homepage')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\HomepageController::class, 'getHomepageContent']);
    Route::get('/fitseries', [App\Http\Controllers\Api\HomepageController::class, 'getFitSeries']);
    Route::get('/fitlive', [App\Http\Controllers\Api\HomepageController::class, 'getFitLive']);
    Route::get('/fitguide', [App\Http\Controllers\Api\HomepageController::class, 'getFitGuide']);
    Route::get('/fitcasts', [App\Http\Controllers\Api\HomepageController::class, 'getFitCasts']);
    Route::get('/fitnews', [App\Http\Controllers\Api\HomepageController::class, 'getFitNews']);
    Route::get('/fitinsights', [App\Http\Controllers\Api\HomepageController::class, 'getFitInsights']);
    Route::get('/fitseries/{id}', [App\Http\Controllers\Api\HomepageController::class, 'getFitSeriesById']);
    Route::get('/fitexpert/{id}', [App\Http\Controllers\Api\HomepageController::class, 'getFitExpertLiveById']);
    Route::post('/fitseries/videos/{videoId}/like', [App\Http\Controllers\Api\HomepageController::class, 'toggleLike']);
    Route::post('/fitseries/videos/{id}/share', [App\Http\Controllers\Api\HomepageController::class, 'share']);
    Route::post('/fitseries/videos/{videoId}/comment', [App\Http\Controllers\Api\HomepageController::class, 'addComment']);
    Route::get('/live-sessions/category/{categoryId}', [App\Http\Controllers\Api\HomepageController::class, 'getLiveSessionsByCategory']);
});

// My Plan APIs
Route::prefix('v1/myplan')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\MyPlanController::class, 'getMyPlans']);
    Route::get('/current', [App\Http\Controllers\Api\MyPlanController::class, 'getCurrentPlan']);
    Route::get('/subscription/{subscriptionId}', [App\Http\Controllers\Api\MyPlanController::class, 'getSubscriptionDetails']);
    Route::get('/available-plans', [App\Http\Controllers\Api\MyPlanController::class, 'getAvailablePlans']);
    Route::post('/subscription/{subscriptionId}/cancel', [App\Http\Controllers\Api\MyPlanController::class, 'cancelSubscription']);
    Route::post('/subscription/{subscriptionId}/reactivate', [App\Http\Controllers\Api\MyPlanController::class, 'reactivateSubscription']);
    Route::get('/payment-history', [App\Http\Controllers\Api\MyPlanController::class, 'getPaymentHistory']);
});

// My Plans APIs (Issues 13-19) - with correct prefix
Route::prefix('v1/my-plans')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\MyPlanController::class, 'getMyPlans']);
    Route::get('/current', [App\Http\Controllers\Api\MyPlanController::class, 'getCurrentPlan']);
    Route::get('/subscription/{subscriptionId}', [App\Http\Controllers\Api\MyPlanController::class, 'getSubscriptionDetails']);
    Route::get('/available-plans', [App\Http\Controllers\Api\MyPlanController::class, 'getAvailablePlans']);
    Route::post('/subscription/{subscriptionId}/cancel', [App\Http\Controllers\Api\MyPlanController::class, 'cancelSubscription']);
    Route::post('/subscription/{subscriptionId}/reactivate', [App\Http\Controllers\Api\MyPlanController::class, 'reactivateSubscription']);
    Route::get('/payment-history', [App\Http\Controllers\Api\MyPlanController::class, 'getPaymentHistory']);
});

// FitFlix APIs
Route::prefix('v1/fitflix')->middleware('auth:sanctum')->group(function () {
    Route::get('/videos', [App\Http\Controllers\Api\FitFlixController::class, 'getAllVideos']);
    Route::get('/videos/{videoId}', [App\Http\Controllers\Api\FitFlixController::class, 'getVideo']);
    Route::get('/videos/{videoId}/next', [App\Http\Controllers\Api\FitFlixController::class, 'getNextVideo']);
    Route::post('/videos/{videoId}/like', [App\Http\Controllers\Api\FitFlixController::class, 'toggleLike']);
    
    Route::post('/videos/{videoId}/comment', [App\Http\Controllers\Api\FitFlixController::class, 'addComment']);
    Route::get('/videos/{videoId}/comments', [App\Http\Controllers\Api\FitFlixController::class, 'getComments']);
    Route::get('/categories', [App\Http\Controllers\Api\FitFlixController::class, 'getCategories']);
});

// Chat and Group APIs
Route::prefix('v1/chat')->middleware('auth:sanctum')->group(function () {
    Route::get('/conversations', [App\Http\Controllers\Api\ChatGroupController::class, 'getAllConversations']);
    Route::get('/personal', [App\Http\Controllers\Api\ChatGroupController::class, 'getPersonalChats']);
    Route::get('/groups', [App\Http\Controllers\Api\ChatGroupController::class, 'getGroupChats']);
    Route::get('/personal/{conversationId}/messages', [App\Http\Controllers\Api\ChatGroupController::class, 'getPersonalMessages']);
    Route::get('/groups/{groupId}/messages', [App\Http\Controllers\Api\ChatGroupController::class, 'getGroupMessages']);
    Route::post('/personal/{conversationId}/send', [App\Http\Controllers\Api\ChatGroupController::class, 'sendPersonalMessage']);
    Route::post('/groups/{groupId}/send', [App\Http\Controllers\Api\ChatGroupController::class, 'sendGroupMessage']);
    Route::post('/groups/create', [App\Http\Controllers\Api\ChatGroupController::class, 'createGroup']);
});

// WebSocket Event Test Endpoints
Route::post('v1/live-session/broadcast', function (\Illuminate\Http\Request $request) {
    event(new \App\Events\LiveSessionUpdated($request->all()));
    return response()->json(['status' => 'LiveSessionUpdated event broadcasted']);
});

Route::post('v1/chat/broadcast', function (\Illuminate\Http\Request $request) {
    event(new \App\Events\NewChatMessage($request->all()));
    return response()->json(['status' => 'NewChatMessage event broadcasted']);
});

// New Mobile APIs as per tc1.md requirements

// Banner API - Homepage Heroes
Route::prefix('v1/mobile/banners')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\BannerController::class, 'getHomepageBanners']);
    Route::get('/{id}', [App\Http\Controllers\Api\BannerController::class, 'getBannerById']);
});

// Enhanced Homepage API for Mobile
Route::prefix('v1/mobile/homepage')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\MobileHomepageController::class, 'getHomepageContent']);
});

// Community Health Data API
Route::prefix('v1/mobile/community')->middleware('auth:sanctum')->group(function () {
    Route::get('/health-data', [App\Http\Controllers\Api\CommunityHealthController::class, 'getHealthData']);
    Route::get('/categories', [App\Http\Controllers\Api\CommunityHealthController::class, 'getCommunityCategories']);
    
    // Enhanced Community Posts API
    Route::get('/posts', [App\Http\Controllers\Api\MobileCommunityController::class, 'getCommunityPosts']);
    Route::get('/posts/{postId}/comments', [App\Http\Controllers\Api\MobileCommunityController::class, 'getPostComments']);
    Route::post('/posts/{postId}/comments', [App\Http\Controllers\Api\MobileCommunityController::class, 'addPostComment']);
    Route::delete('/comments/{commentId}', [App\Http\Controllers\Api\MobileCommunityController::class, 'deleteComment']);
});

// Enhanced FitFlix API for Mobile
Route::prefix('v1/mobile/fitflix')->middleware('auth:sanctum')->group(function () {
    Route::get('/videos', [App\Http\Controllers\Api\MobileFitFlixController::class, 'getFitFlixVideos']);
    Route::get('/videos/{videoId}', [App\Http\Controllers\Api\MobileFitFlixController::class, 'getFitFlixVideo']);
    Route::post('/videos/{videoId}/like', [App\Http\Controllers\Api\MobileFitFlixController::class, 'toggleLike']);
    Route::post('/videos/{videoId}/comment', [App\Http\Controllers\Api\MobileFitFlixController::class, 'addComment']);
    Route::post('/videos/{videoId}/share', [App\Http\Controllers\Api\MobileFitFlixController::class, 'shareVideo']);
});

// Enhanced FitTalk API for Mobile
Route::prefix('v1/mobile/fittalk')->middleware('auth:sanctum')->group(function () {
    Route::get('/filters', [App\Http\Controllers\Api\MobileFitTalkController::class, 'getFilters']);
    Route::get('/trainers/search', [App\Http\Controllers\Api\MobileFitTalkController::class, 'searchTrainers']);
    Route::get('/trainers/{trainerId}', [App\Http\Controllers\Api\MobileFitTalkController::class, 'getTrainerDetails']);
});