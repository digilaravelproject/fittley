<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommunityHealthController extends Controller
{
    /**
     * Get community health data for current user
     * As per tc1.md: Health Data - Today's Steps, Join Live Classes, Calories Consume, Streak, Remaining
     */
    public function getHealthData(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Mock data structure - in real implementation, these would come from user activity tracking
            $healthData = [
                'today_steps' => [
                    'current' => $this->getUserSteps($user),
                    'goal' => 10000,
                    'percentage' => min(100, ($this->getUserSteps($user) / 10000) * 100)
                ],
                'join_live_classes' => [
                    'joined_today' => $this->getUserLiveClassesToday($user),
                    'available_today' => $this->getAvailableLiveClassesToday(),
                    'next_class' => $this->getNextLiveClass()
                ],
                'calories_consume' => [
                    'consumed_today' => $this->getUserCaloriesToday($user),
                    'goal' => 2000,
                    'remaining' => max(0, 2000 - $this->getUserCaloriesToday($user)),
                    'percentage' => min(100, ($this->getUserCaloriesToday($user) / 2000) * 100)
                ],
                'streak' => [
                    'current_streak' => $this->getUserCurrentStreak($user),
                    'best_streak' => $this->getUserBestStreak($user),
                    'streak_type' => 'workout_days'
                ],
                'remaining' => [
                    'water_intake' => [
                        'consumed' => $this->getUserWaterIntake($user),
                        'goal' => 8, // glasses
                        'remaining' => max(0, 8 - $this->getUserWaterIntake($user))
                    ],
                    'workout_time' => [
                        'completed' => $this->getUserWorkoutTimeToday($user),
                        'goal' => 60, // minutes
                        'remaining' => max(0, 60 - $this->getUserWorkoutTimeToday($user))
                    ]
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'Health data retrieved successfully',
                'data' => $healthData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch health data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get community categories
     */
    public function getCommunityCategories(): JsonResponse
    {
        try {
            $categories = Category::select('id', 'name', 'description', 'image')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'description' => $category->description,
                        'image' => $category->image,
                        'posts_count' => $this->getCategoryPostsCount($category->id)
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Community categories retrieved successfully',
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch community categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Helper methods - In real implementation, these would query actual user data tables
    
    private function getUserSteps(User $user): int
    {
        // Mock implementation - replace with actual step tracking logic
        return rand(5000, 12000);
    }

    private function getUserLiveClassesToday(User $user): int
    {
        // Mock implementation - replace with actual live class attendance logic
        return rand(0, 3);
    }

    private function getAvailableLiveClassesToday(): int
    {
        // Mock implementation - replace with actual live class count logic
        return rand(5, 10);
    }

    private function getNextLiveClass(): ?array
    {
        // Mock implementation - replace with actual next live class logic
        return [
            'id' => 1,
            'title' => 'Morning Yoga Flow',
            'instructor' => 'Sarah Johnson',
            'time' => now()->addHours(2)->format('H:i'),
            'duration' => 45
        ];
    }

    private function getUserCaloriesToday(User $user): int
    {
        // Mock implementation - replace with actual calorie tracking logic
        return rand(1200, 2500);
    }

    private function getUserCurrentStreak(User $user): int
    {
        // Mock implementation - replace with actual streak calculation
        return rand(1, 30);
    }

    private function getUserBestStreak(User $user): int
    {
        // Mock implementation - replace with actual best streak calculation
        return rand(30, 100);
    }

    private function getUserWaterIntake(User $user): int
    {
        // Mock implementation - replace with actual water intake tracking
        return rand(2, 8);
    }

    private function getUserWorkoutTimeToday(User $user): int
    {
        // Mock implementation - replace with actual workout time tracking
        return rand(0, 90);
    }

    private function getCategoryPostsCount(int $categoryId): int
    {
        // Mock implementation - replace with actual posts count query
        return rand(10, 500);
    }
}
