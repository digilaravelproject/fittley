<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;
use App\Models\ReferralCode;
use App\Models\ReferralUsage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'phone',
        'date_of_birth',
        'gender',
        'fitness_level',
        'goals',
        'preferences',
        'timezone',
        'is_available_for_fittalk',
        'average_rating',
        'total_sessions',
        'google2fa_secret',
        'google2fa_enabled',
        'recovery_codes',
        'two_factor_confirmed_at',
        'referral_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
        'recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'preferences' => 'array',
            'google2fa_enabled' => 'boolean',
            'recovery_codes' => 'array',
            'two_factor_confirmed_at' => 'datetime',
            'specializations' => 'array',
        ];
    }

    protected $appends = ['next_available_slot', 'is_currently_available'];

    /**
     * Get the next available session slot for this instructor.
     */
    public function getNextAvailableSlotAttribute()
    {
        $nextSession = FittalkSession::where('instructor_id', $this->id)
            ->where('status', 'scheduled') // upcoming sessions
            ->where('scheduled_at', '>', now()) // only future sessions
            ->orderBy('scheduled_at', 'asc')
            ->first();

        return $nextSession ? $nextSession->scheduled_at : null;
    }

    /**
     * Check if the instructor is currently available.
     */
    public function getIsCurrentlyAvailableAttribute()
    {
        $now = now();

        $ongoingSession = FittalkSession::where('instructor_id', $this->id)
            ->where('status', 'scheduled')
            ->where('scheduled_at', '<=', $now)
            ->where('ended_at', '>=', $now)
            ->exists();

        return !$ongoingSession;
    }
    
    /**
     * Get sessions where this user is the instructor
     */
    public function instructorSessions()
    {
        return $this->hasMany(FitLiveSession::class, 'instructor_id');
    }

    /**
     * Get chat messages sent by this user
     */
    public function chatMessages()
    {
        return $this->hasMany(FitLiveChatMessage::class);
    }

    /**
     * Get user subscriptions
     */
    // public function subscriptions()
    // {
    //     return $this->hasMany(UserSubscription::class);
    // }

    /**
     * Get current active subscription
     */
    public function currentSubscription()
    {
        return $this->hasOne(UserSubscription::class)
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->latest();
    }

    /**
     * Get referral code owned by this user
     */
    public function referralCode()
    {
        return $this->hasOne(ReferralCode::class);
    }

    /**
     * Referral usages made by this user (as referrer)
     */
    public function referralUsages()
    {
        return $this->hasManyThrough(
            ReferralUsage::class,
            ReferralCode::class,
            'user_id', // Foreign key on referral_codes table
            'referral_code_id', // Foreign key on referral_usages table
            'id', // Local key on users table
            'id'  // Local key on referral_codes table
        );
    }

    /**
     * Referral usage when this user used a referral code
     */
    public function usedReferralCode()
    {
        return $this->hasOne(ReferralUsage::class, 'referred_user_id');
    }

    /**
     * Get referrals made by this user
     */
    public function referralsMade()
    {
        return $this->hasMany(ReferralUsage::class, 'referrer_id');
    }



    /**
     * Get referrals used by this user
     */
    public function referralsUsed()
    {
        return $this->hasMany(ReferralUsage::class, 'referred_user_id');
    }

    /**
     * Get influencer profile
     */
    public function influencerProfile()
    {
        return $this->hasOne(InfluencerProfile::class);
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription()
    {
        return $this->currentSubscription()->exists();
    }

    /**
     * Check if user is on trial
     */
    public function isOnTrial()
    {
        return $this->subscriptions()
            ->where('status', 'trial')
            ->where('trial_ends_at', '>', now())
            ->exists();
    }

    /**
     * Check if subscription is required for this user
     */
    public function requiresSubscription()
    {
        return $this->subscription_required && !$this->hasRole('admin');
    }

    /**
     * Check if user can access content
     */
    public function canAccessContent($contentType = null)
    {
        if (!$this->requiresSubscription()) {
            return true;
        }

        // Check if user has active subscription or trial
        if (!($this->hasActiveSubscription() || $this->isOnTrial())) {
            return false;
        }

        // For now, any active subscription grants access to all content types
        // TODO: Add plan-specific feature checking later if needed
        return true;
    }

    /**
     * Update subscription status
     */
    public function updateSubscriptionStatus($status, $endsAt = null)
    {
        $this->update([
            'subscription_status' => $status,
            'subscription_ends_at' => $endsAt,
        ]);
    }

    /**
     * Get or create referral code for this user
     */
    public function getOrCreateReferralCode()
    {
        return $this->referralCode ?: ReferralCode::create([
            'user_id' => $this->id,
        ]);
    }

    /**
     * Check if user is an approved influencer
     */
    public function isInfluencer()
    {
        return $this->influencerProfile && $this->influencerProfile->isApproved();
    }

    /**
     * Get subscription expiry days remaining
     */
    public function getSubscriptionDaysRemainingAttribute()
    {
        if (!$this->subscription_ends_at) {
            return 0;
        }

        return max(0, $this->subscription_ends_at->diffInDays(now()));
    }

    /**
     * Get subscription status with additional details
     */
    public function getSubscriptionStatus()
    {
        return [
            'status' => $this->subscription_status,
            'label' => $this->subscription_status_label,
            'ends_at' => $this->subscription_ends_at,
            'days_remaining' => $this->subscription_days_remaining,
            'is_active' => $this->hasActiveSubscription(),
            'is_trial' => $this->isOnTrial(),
            'requires_subscription' => $this->requiresSubscription(),
            'can_access_content' => $this->canAccessContent(),
            'current_plan' => $this->currentSubscription?->subscriptionPlan->name ?? null,
        ];
    }

    /**
     * Get formatted subscription status
     */
    public function getSubscriptionStatusLabelAttribute()
    {
        $labels = [
            'active' => 'Active',
            'trial' => 'Trial',
            'expired' => 'Expired',
            'inactive' => 'Inactive',
        ];

        return $labels[$this->subscription_status] ?? 'Unknown';
    }

    /**
     * Get the user's referral code (create if doesn't exist)
     */
    public function getReferralCodeAttribute()
    {
        if (!$this->referralCode()->exists()) {
            $this->createDefaultReferralCode();
        }
        return $this->referralCode()->first();
    }

    /**
     * Create default referral code for user
     */
    public function createDefaultReferralCode()
    {
        // Generate unique code
        $code = $this->generateUniqueReferralCode();
        
        // Get discount percentage based on referral count
        $discountPercent = $this->calculateReferralDiscount();
        
        return $this->referralCode()->create([
            'code' => $code,
            'discount_type' => 'percentage',
            'discount_value' => $discountPercent,
            'max_uses' => null, // Unlimited uses
            'expires_at' => null, // Never expires
            'is_active' => true,
            'description' => "Personal referral code for {$this->name}",
        ]);
    }

    /**
     * Generate unique referral code
     */
    private function generateUniqueReferralCode()
    {
        $baseCode = strtoupper(substr($this->name, 0, 3)) . $this->id;
        $code = $baseCode;
        $counter = 1;
        
        while (ReferralCode::where('code', $code)->exists()) {
            $code = $baseCode . $counter;
            $counter++;
        }
        
        return $code;
    }

    /**
     * Calculate referral discount based on successful referrals
     */
    public function calculateReferralDiscount()
    {
        $successfulReferrals = $this->referralUsages()
            ->whereNotNull('used_at')
            ->count();
            
        // Tiered discount system
        if ($successfulReferrals >= 4) {
            return 30; // 4+ users = 30% off
        } elseif ($successfulReferrals >= 3) {
            return 25; // 3 users = 25% off
        } elseif ($successfulReferrals >= 2) {
            return 20; // 2 users = 20% off
        }
        
        return 15; // Default starting discount
    }

    /**
     * User profile
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }


    /**
     * Update referral code discount based on performance
     */
    public function updateReferralDiscount()
    {
        $referralCode = $this->referralCode;
        if ($referralCode) {
            $newDiscount = $this->calculateReferralDiscount();
            $referralCode->update(['discount_value' => $newDiscount]);
        }
    }

    /**
     * Get referral usage statistics
     */
    public function getReferralStatsAttribute()
    {
        $code = $this->referralCode;
        if (!$code) {
            return [
                'total_uses' => 0,
                'successful_uses' => 0,
                'current_discount' => 15,
                'next_tier_needed' => 2,
            ];
        }

        $totalUses = $code->usages()->count();
        $successfulUses = $code->usages()->whereNotNull('used_at')->count();
        $currentDiscount = $this->calculateReferralDiscount();
        
        // Calculate next tier
        $nextTierNeeded = 2;
        if ($successfulUses >= 2) $nextTierNeeded = 3;
        if ($successfulUses >= 3) $nextTierNeeded = 4;
        if ($successfulUses >= 4) $nextTierNeeded = null; // Max tier reached
        
        return [
            'total_uses' => $totalUses,
            'successful_uses' => $successfulUses,
            'current_discount' => $currentDiscount,
            'next_tier_needed' => $nextTierNeeded,
        ];
    }

    // ====== COMMUNITY RELATIONSHIPS ======
    


    /**
     * Get community posts created by user
     */
    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    /**
     * Get post comments made by user
     */
    public function postComments()
    {
        return $this->hasMany(PostComment::class);
    }

    /**
     * Get post likes made by user
     */
    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     * Friend requests sent by this user
     */
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    /**
     * Friend requests received by this user
     */
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    /**
     * Get all friends (accepted friendships)
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted')
                    ->withPivot('status', 'accepted_at')
                    ->withTimestamps();
    }

    /**
     * Get friends in reverse direction
     */
    public function friendsOfMine()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                    ->wherePivot('status', 'accepted')
                    ->withPivot('status', 'accepted_at')
                    ->withTimestamps();
    }

    /**
     * Group memberships
     */
    public function groupMemberships()
    {
        return $this->hasMany(GroupMember::class);
    }

    /**
     * Groups where user is member
     */
    public function groups()
    {
        return $this->belongsToMany(CommunityGroup::class, 'group_members')
                    ->wherePivot('status', 'approved')
                    ->withPivot('role', 'status', 'joined_at')
                    ->withTimestamps();
    }

    /**
     * Groups administered by user
     */
    public function administeredGroups()
    {
        return $this->hasMany(CommunityGroup::class, 'admin_user_id');
    }

    /**
     * User badges earned
     */
    // public function userBadges()
    // {
    //     return $this->hasMany(UserBadge::class);
    // }

    /**
     * Badges earned by user
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('earned_at', 'achievement_data', 'is_visible')
                    ->withTimestamps();
    }

    /**
     * Direct messages sent by user
     */
    public function sentMessages()
    {
        return $this->hasMany(DirectMessage::class, 'sender_id');
    }

    /**
     * Direct messages received by user
     */
    public function receivedMessages()
    {
        return $this->hasMany(DirectMessage::class, 'receiver_id');
    }

    /**
     * FitTalk sessions as instructor
     */
    public function fittalkInstructorSessions()
    {
        return $this->hasMany(FittalkSession::class, 'instructor_id');
    }

    /**
     * FitTalk sessions as user/client
     */
    public function fittalkClientSessions()
    {
        return $this->hasMany(FittalkSession::class, 'user_id');
    }

    // ====== COMMUNITY HELPER METHODS ======

    /**
     * Check if user is friends with another user
     */
    public function isFriendsWith($userId)
    {
        return Friendship::areFriends($this->id, $userId);
    }

    public function followers()
    {
        return $this->hasMany(UserFollow::class, 'following_id');
    }

    public function followings()
    {
        return $this->hasMany(UserFollow::class, 'follower_id');
    }


    /**
     * Check if user has sent friend request to another user
     */
    public function hasSentFriendRequestTo($userId)
    {
        return $this->sentFriendRequests()
                    ->where('friend_id', $userId)
                    ->where('status', 'pending')
                    ->exists();
    }

    /**
     * Check if user has received friend request from another user
     */
    public function hasReceivedFriendRequestFrom($userId)
    {
        return $this->receivedFriendRequests()
                    ->where('user_id', $userId)
                    ->where('status', 'pending')
                    ->exists();
    }

    /**
     * Send friend request to another user
     */
    public function sendFriendRequestTo($userId)
    {
        return Friendship::sendFriendRequest($this->id, $userId);
    }

    /**
     * Get or create user profile
     */
    public function getOrCreateProfile()
    {
        return $this->profile ?: UserProfile::create(['user_id' => $this->id]);
    }

    /**
     * Get friends count
     */
    public function friendsCount()
    {
        return $this->friends()->count();
    }

    /**
     * Generate referral code for user
     */
    public function generateReferralCode()
    {
        if (!$this->referral_code) {
            $this->referral_code = strtoupper(Str::random(8));
            $this->save();
        }
        return $this->referral_code;
    }

    /**
     * Get friendship status with another user
     */
    public function getFriendshipStatus($userId)
    {
        if ($this->id == $userId) {
            return 'self';
        }

        $friendship = Friendship::betweenUsers($this->id, $userId)->first();

        if (!$friendship) {
            return 'none';
        }

        return $friendship->status;
    }

    /**
     * Get user badges (UserBadge pivot records)
     */
    public function userBadges()
    {
        return $this->hasMany(UserBadge::class);
    }

    /**
     * FitLive sessions attended by user
     */
    public function fitliveSessions()
    {
        return $this->hasMany(FitLiveSession::class, 'instructor_id');
    }

    /**
     * FitGuide progress for user
     */
    public function fitguideProgress()
    {
        return $this->hasMany(UserWatchProgress::class)->where('watchable_type', 'App\Models\FgSingle')
            ->orWhere('watchable_type', 'App\Models\FgSeries');
    }

    /**
     * FitNews articles read by user
     */
    public function fitnewsReads()
    {
        return $this->hasMany(UserWatchProgress::class)->where('watchable_type', 'App\Models\FitNews');
    }

    /**
     * FitArena participations by user
     */
    public function fitarenaParticipations()
    {
        return $this->hasMany(FitArenaParticipant::class);
    }

    /**
     * Check and award badges for this user
     */
    public function checkBadges(): array
    {
        $badgeService = app(\App\Services\BadgeService::class);
        return $badgeService->checkAndAwardBadges($this);
    }

    /**
     * Get user subscriptions
     */
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Check if user is member of a group
     */
    public function isMemberOf($groupId)
    {
        return $this->groupMemberships()
                    ->where('community_group_id', $groupId)
                    ->where('status', 'approved')
                    ->exists();
    }

    /**
     * Check if user has earned a specific badge
     */
    public function hasEarnedBadge($badgeId)
    {
        return $this->userBadges()->where('badge_id', $badgeId)->exists();
    }

    /**
     * Get unread messages count
     */
    public function getUnreadMessagesCount()
    {
        return $this->receivedMessages()
                    ->where('is_read', false)
                    ->where('is_deleted_by_receiver', false)
                    ->count();
    }

    /**
     * Get pending friend requests count
     */
    public function getPendingFriendRequestsCount()
    {
        return $this->receivedFriendRequests()
                    ->where('status', 'pending')
                    ->count();
    }

    /**
     * Get conversations where user is participant
     */
    public function getConversationsAttribute()
    {
        return Conversation::where('user_one_id', $this->id)
                          ->orWhere('user_two_id', $this->id)
                          ->orderBy('last_message_at', 'desc')
                          ->get();
    }

    /**
     * Check if the user has two-factor authentication enabled.
     */
    public function hasTwoFactorEnabled(): bool
    {
        return $this->google2fa_enabled && !is_null($this->google2fa_secret);
    }

    /**
     * Generate recovery codes for two-factor authentication.
     */
    public function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(Str::random(10));
        }
        
        $this->recovery_codes = $codes;
        $this->save();
        
        return $codes;
    }

    /**
     * Use a recovery code.
     */
    public function useRecoveryCode(string $code): bool
    {
        $codes = $this->recovery_codes ?? [];
        
        if (in_array(strtoupper($code), $codes)) {
            $this->recovery_codes = array_values(array_diff($codes, [strtoupper($code)]));
            $this->save();
            return true;
        }
        
        return false;
    }
}
