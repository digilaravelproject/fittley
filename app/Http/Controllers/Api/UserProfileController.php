<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    /**
     * Get current user's profile
     */
    public function getMyProfile(): JsonResponse
    {
        $user = auth()->user();
        $profile = $user->profile()->firstOrCreate([]);

        $profile->load(['user:id,name,email,avatar']);
        $profile->append(['bmi', 'age']);

        return response()->json([
            'success' => true,
            'data' => $profile,
        ]);
    }

    /**
     * Get current user's notification
     */
    public function getMyNotification(): JsonResponse
    {
        $user = auth()->user();
    
        $profile = $user->profile()->firstOrCreate([]);

        // eager load relationships
        $profile->load(['user:id,name,email,avatar']);

        // add your accessors
        $profile->append(['bmi', 'age']);

        return response()->json([
            'success' => true,
            'data' => [
                'profile' => $profile,
                'notification' => $user->preferences, // 👈 preferences column value here
            ],
        ]);
    }

    /**
     * Update current user's profile
     */
    public function updateMyProfile(Request $request): JsonResponse
    {
        $request->validate([
            'bio' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other,prefer_not_to_say',
            'location' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            
            // Body stats
            'height' => 'nullable|numeric|min:50|max:300', // cm
            'weight' => 'nullable|numeric|min:20|max:500', // kg
            'body_fat_percentage' => 'nullable|numeric|min:0|max:100',
            'muscle_mass' => 'nullable|numeric|min:0|max:200', // kg
            
            // Measurements (in cm)
            'chest' => 'nullable|numeric|min:30|max:200',
            'waist' => 'nullable|numeric|min:30|max:200',
            'hips' => 'nullable|numeric|min:30|max:200',
            'biceps' => 'nullable|numeric|min:10|max:100',
            'thigh' => 'nullable|numeric|min:30|max:150',
            
            // Arrays
            'fitness_goals' => 'nullable|array',
            'fitness_goals.*' => 'string|in:weight_loss,muscle_gain,strength,endurance,flexibility,general_fitness,sports_performance',
            'interests' => 'nullable|array',
            'interests.*' => 'string|max:50',
            'workout_preferences' => 'nullable|array',
            'workout_preferences.*' => 'string|in:cardio,strength,yoga,pilates,crossfit,running,cycling,swimming,martial_arts,dance',
            
            // Privacy settings
            'show_body_stats' => 'boolean',
            'show_goals' => 'boolean',
            'show_achievements' => 'boolean',
            'show_activity' => 'boolean',
            'allow_friend_requests' => 'boolean',
        ]);

        $user = auth()->user();
        $profile = $user->profile()->firstOrCreate([]);

        DB::beginTransaction();
        try {
            $profile->update([
                'bio' => $request->bio,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'location' => $request->location,
                'phone' => $request->phone,
                'height' => $request->height,
                'weight' => $request->weight,
                'body_fat_percentage' => $request->body_fat_percentage,
                'muscle_mass' => $request->muscle_mass,
                'chest' => $request->chest,
                'waist' => $request->waist,
                'hips' => $request->hips,
                'biceps' => $request->biceps,
                'thigh' => $request->thigh,
                'fitness_goals' => $request->fitness_goals ?? [],
                'interests' => $request->interests ?? [],
                'workout_preferences' => $request->workout_preferences ?? [],
                'show_body_stats' => $request->boolean('show_body_stats', true),
                'show_goals' => $request->boolean('show_goals', true),
                'show_achievements' => $request->boolean('show_achievements', true),
                'show_activity' => $request->boolean('show_activity', true),
                'allow_friend_requests' => $request->boolean('allow_friend_requests', true),
            ]);

            DB::commit();

            $profile->load(['user:id,name,email,avatar']);
            $profile->append(['bmi', 'age']);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $profile,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
            ], 500);
        }
    }

    /**
     * Get another user's profile (with privacy restrictions)
     */
    public function getUserProfile($userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        $currentUserId = auth()->id();

        // Can't view your own profile through this endpoint
        if ($currentUserId === (int)$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Use /me endpoint for your own profile',
            ], 400);
        }

        $profile = $user->profile()->firstOrCreate([]);
        $profile->load(['user:id,name,avatar']);

        // Check friendship status
        $currentUser = auth()->user();
        $isFriend = $currentUser->isFriendsWith($userId);

        // Apply privacy filters
        $profileData = $this->applyPrivacyFilters($profile, $isFriend);

        return response()->json([
            'success' => true,
            'data' => [
                'profile' => $profileData,
                'is_friend' => $isFriend,
                'friendship_status' => $currentUser->getFriendshipStatus($userId),
            ],
        ]);
    }

    /**
     * Update privacy settings
     */
    public function updatePrivacySettings(Request $request): JsonResponse
    {
        $request->validate([
            'show_body_stats' => 'boolean',
            'show_goals' => 'boolean',
            'show_achievements' => 'boolean',
            'show_activity' => 'boolean',
            'allow_friend_requests' => 'boolean',
        ]);

        $user = auth()->user();
        $profile = $user->profile()->firstOrCreate([]);

        $profile->update([
            'show_body_stats' => $request->boolean('show_body_stats', $profile->show_body_stats),
            'show_goals' => $request->boolean('show_goals', $profile->show_goals),
            'show_achievements' => $request->boolean('show_achievements', $profile->show_achievements),
            'show_activity' => $request->boolean('show_activity', $profile->show_activity),
            'allow_friend_requests' => $request->boolean('allow_friend_requests', $profile->allow_friend_requests),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Privacy settings updated successfully',
            'data' => [
                'show_body_stats' => $profile->show_body_stats,
                'show_goals' => $profile->show_goals,
                'show_achievements' => $profile->show_achievements,
                'show_activity' => $profile->show_activity,
                'allow_friend_requests' => $profile->allow_friend_requests,
            ],
        ]);
    }

    /**
     * Apply privacy filters to profile data
     */
    private function applyPrivacyFilters(UserProfile $profile, bool $isFriend): array
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
            $data['height'] = $profile->height;
            $data['weight'] = $profile->weight;
            $data['body_fat_percentage'] = $profile->body_fat_percentage;
            $data['muscle_mass'] = $profile->muscle_mass;
            $data['chest'] = $profile->chest;
            $data['waist'] = $profile->waist;
            $data['hips'] = $profile->hips;
            $data['biceps'] = $profile->biceps;
            $data['thigh'] = $profile->thigh;
            $data['bmi'] = $profile->bmi;
        }

        // Show goals based on privacy settings
        if ($profile->show_goals || $isFriend) {
            $data['fitness_goals'] = $profile->fitness_goals;
            $data['workout_preferences'] = $profile->workout_preferences;
        }

        // Always show interests and basic info
        $data['interests'] = $profile->interests;

        // Show achievements count if privacy allows
        if ($profile->show_achievements || $isFriend) {
            $data['badges_count'] = $profile->user->userBadges()->count();
        }

        // Show activity stats if privacy allows
        if ($profile->show_activity || $isFriend) {
            $data['posts_count'] = $profile->user->communityPosts()->count();
            $data['friends_count'] = $profile->user->friendsCount();
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