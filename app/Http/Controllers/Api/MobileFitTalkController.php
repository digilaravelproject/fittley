<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FittalkSession;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MobileFitTalkController extends Controller
{
    /**
     * Get filter options for FitTalk trainers
     * As per tc1.md: Filter list, Specialization, Budget
     */
    public function getFilters(): JsonResponse
    {
        try {
            $filters = [
                'specializations' => [
                    ['id' => 'fitness', 'name' => 'Fitness Training', 'icon' => '💪'],
                    ['id' => 'nutrition', 'name' => 'Nutrition', 'icon' => '🥗'],
                    ['id' => 'mental_health', 'name' => 'Mental Health', 'icon' => '🧠'],
                    ['id' => 'physiotherapy', 'name' => 'Physiotherapy', 'icon' => '🏥'],
                    ['id' => 'yoga', 'name' => 'Yoga', 'icon' => '🧘'],
                    ['id' => 'weight_loss', 'name' => 'Weight Loss', 'icon' => '⚖️'],
                    ['id' => 'muscle_gain', 'name' => 'Muscle Gain', 'icon' => '💪'],
                    ['id' => 'general', 'name' => 'General Wellness', 'icon' => '✨']
                ],
                'budget_ranges' => [
                    ['id' => 'budget_low', 'name' => 'Under $25', 'min_rate' => 0, 'max_rate' => 25],
                    ['id' => 'budget_mid', 'name' => '$25 - $50', 'min_rate' => 25, 'max_rate' => 50],
                    ['id' => 'budget_high', 'name' => '$50 - $100', 'min_rate' => 50, 'max_rate' => 100],
                    ['id' => 'budget_premium', 'name' => '$100+', 'min_rate' => 100, 'max_rate' => null]
                ],
                'rating_filters' => [
                    ['id' => 'rating_4_plus', 'name' => '4+ Stars', 'min_rating' => 4.0],
                    ['id' => 'rating_4_5_plus', 'name' => '4.5+ Stars', 'min_rating' => 4.5],
                    ['id' => 'rating_5', 'name' => '5 Stars', 'min_rating' => 5.0]
                ],
                'availability_filters' => [
                    ['id' => 'available_now', 'name' => 'Available Now'],
                    ['id' => 'available_today', 'name' => 'Available Today'],
                    ['id' => 'available_week', 'name' => 'Available This Week']
                ],
                'session_types' => [
                    ['id' => 'chat', 'name' => 'Text Chat', 'icon' => '💬'],
                    ['id' => 'voice', 'name' => 'Voice Call', 'icon' => '📞'],
                    ['id' => 'video', 'name' => 'Video Call', 'icon' => '📹']
                ]
            ];

            return response()->json([
                'success' => true,
                'message' => 'FitTalk filters retrieved successfully',
                'data' => $filters
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch filters',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search and filter trainers
     * As per tc1.md: Search Action, Trainer list with trainer details, specialities, badge, plan details
     */
    public function searchTrainers(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:100',
                'specialization' => 'nullable|string',
                'budget_min' => 'nullable|numeric|min:0',
                'budget_max' => 'nullable|numeric|min:0',
                'min_rating' => 'nullable|numeric|min:0|max:5',
                'availability' => 'nullable|in:available_now,available_today,available_week',
                'session_type' => 'nullable|in:chat,voice,video',
                'limit' => 'nullable|integer|min:1|max:50'
            ]);

            $limit = $request->get('limit', 20);
            $user = Auth::user();

            $query = User::with(['badges', 'profile'])
                ->whereHas('roles', function ($q) {
                    $q->where('name', 'instructor');
                })
                ->where('is_available_for_fittalk', true);

            // Search by name
            if ($request->search) {
                $query->where('name', 'like', "%{$request->search}%");
            }
            

            // Filter by specialization
            if ($request->specialization) {
                $query->whereHas('profile', function ($q) use ($request) {
                    $q->whereJsonContains('specializations', $request->specialization);
                });
            }

            // Filter by budget (hourly rate)
            if ($request->budget_min || $request->budget_max) {
                $query->whereHas('profile', function ($q) use ($request) {
                    if ($request->budget_min) {
                        $q->where('hourly_rate', '>=', $request->budget_min);
                    }
                    if ($request->budget_max) {
                        $q->where('hourly_rate', '<=', $request->budget_max);
                    }
                });
            }

            // Filter by minimum rating
            if ($request->min_rating) {
                $query->where('average_rating', '>=', $request->min_rating);
            }

            $trainers = $query->limit($limit)
                            ->get();

            $formattedTrainers = $trainers->map(function ($trainer) use ($user) {
                return [
                    'id' => $trainer->id,
                    'trainer_details' => [
                        'name' => $trainer->name,
                        'profile_picture' => $trainer->profile_picture,
                        'bio' => $trainer->profile->bio ?? '',
                        'rating' => round($trainer->average_rating ?? 0, 1),
                        'total_sessions' => $trainer->total_sessions ?? 0,
                        'years_experience' => $trainer->profile->years_experience ?? 0,
                        'is_online' => $this->isTrainerOnline($trainer),
                        'next_available' => $this->getNextAvailableSlot($trainer)
                    ],
                    'specialities_list' => $this->getTrainerSpecialities($trainer),
                    'badge' => $this->getUserTopBadge($trainer),
                    'plan_details' => [
                        'hourly_rate' => $trainer->profile->hourly_rate ?? 0,
                        'currency' => 'USD',
                        'session_types' => $this->getAvailableSessionTypes($trainer),
                        'packages' => $this->getTrainerPackages($trainer)
                    ],
                    'availability' => [
                        'is_available_now' => $this->isAvailableNow($trainer),
                        'is_available_today' => $this->isAvailableToday($trainer),
                        'next_slot' => $this->getNextAvailableSlot($trainer)
                    ],
                    'stats' => [
                        'completed_sessions' => $this->getCompletedSessionsCount($trainer),
                        'response_time' => $this->getAverageResponseTime($trainer),
                        'satisfaction_rate' => $this->getSatisfactionRate($trainer)
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Trainers retrieved successfully',
                'data' => [
                    'trainers' => $formattedTrainers,
                    'total' => $formattedTrainers->count(),
                    'filters_applied' => [
                        'search' => $request->search,
                        'specialization' => $request->specialization,
                        'budget_range' => [
                            'min' => $request->budget_min,
                            'max' => $request->budget_max
                        ],
                        'min_rating' => $request->min_rating
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search trainers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific trainer details
     */
    public function getTrainerDetails($trainerId): JsonResponse
    {
        try {
            $trainer = User::with(['badges', 'profile'])
                ->whereHas('roles', function ($q) {
                    $q->where('name', 'instructor');
                })
                ->where('id', $trainerId)
                ->where('is_available_for_fittalk', true)
                ->first();

            if (!$trainer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trainer not found'
                ], 404);
            }

            // current logged-in user
            $currentUser = Auth::user();

            // counts
            $followersCount = $trainer->followers()->count();
            $followingCount = $trainer->followings()->count();

            // is current user following this trainer?
            $isFollowing = false;
            if ($currentUser) {
                $isFollowing = UserFollow::where('follower_id', $currentUser->id)
                    ->where('following_id', $trainer->id)
                    ->exists();
            }

            $trainerData = [
                'id' => $trainer->id,
                'trainer_details' => [
                    'name' => $trainer->name,
                    'profile_picture' => $trainer->profile_picture,
                    'bio' => $trainer->profile->bio ?? '',
                    'description' => $trainer->profile->bio ?? '',
                    'rating' => round($trainer->average_rating ?? 0, 1),
                    'total_sessions' => $trainer->total_sessions ?? 0,
                    'years_experience' => $trainer->profile->years_experience ?? 0,
                    'is_online' => $this->isTrainerOnline($trainer),
                    'languages' => $trainer->profile->languages ?? ['English'],
                    'education' => $trainer->profile->education ?? [],
                    'certifications' => $trainer->profile->certifications ?? []
                ],
                'specialities_list' => $this->getTrainerSpecialities($trainer),
                'badge' => $this->getUserTopBadge($trainer),
                'plan_details' => [
                    'hourly_rate' => $trainer->profile->hourly_rate ?? 0,
                    'currency' => 'USD',
                    'session_types' => $this->getAvailableSessionTypes($trainer),
                    'packages' => $this->getTrainerPackages($trainer)
                ],
                'availability' => [
                    'is_available_now' => $this->isAvailableNow($trainer),
                    'is_available_today' => $this->isAvailableToday($trainer),
                    'schedule' => $this->getTrainerSchedule($trainer)
                ],
                'reviews' => $this->getTrainerReviews($trainer, 5),
                'followers_count' => $followersCount,
                'following_count' => $followingCount,
                'is_following' => $isFollowing
            ];

            return response()->json([
                'success' => true,
                'message' => 'Trainer details retrieved successfully',
                'data' => $trainerData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch trainer details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Helper methods
    
    private function getUserTopBadge($user): ?array
    {
        $topBadge = $user->badges()
            ->wherePivot('is_visible', true)
            ->orderByPivot('earned_at', 'desc')
            ->first();

        if (!$topBadge) {
            return null;
        }

        return [
            'id' => $topBadge->id,
            'name' => $topBadge->name,
            'icon' => $topBadge->icon,
            'color' => $topBadge->color ?? '#FFD700'
        ];
    }

    private function getTrainerSpecialities($trainer): array
    {
        $specializations = $trainer->profile->specializations ?? [];
        
        $specialityMap = [
            'fitness' => ['name' => 'Fitness Training', 'icon' => '💪'],
            'nutrition' => ['name' => 'Nutrition', 'icon' => '🥗'],
            'mental_health' => ['name' => 'Mental Health', 'icon' => '🧠'],
            'physiotherapy' => ['name' => 'Physiotherapy', 'icon' => '🏥'],
            'yoga' => ['name' => 'Yoga', 'icon' => '🧘'],
            'weight_loss' => ['name' => 'Weight Loss', 'icon' => '⚖️'],
            'muscle_gain' => ['name' => 'Muscle Gain', 'icon' => '💪'],
            'general' => ['name' => 'General Wellness', 'icon' => '✨']
        ];

        return array_map(function($spec) use ($specialityMap) {
            return $specialityMap[$spec] ?? ['name' => ucfirst($spec), 'icon' => '⭐'];
        }, $specializations);
    }

    private function getAvailableSessionTypes($trainer): array
    {
        // Mock implementation - replace with actual trainer session type preferences
        return [
            ['type' => 'chat', 'name' => 'Text Chat', 'icon' => '💬', 'available' => true],
            ['type' => 'voice', 'name' => 'Voice Call', 'icon' => '📞', 'available' => true],
            ['type' => 'video', 'name' => 'Video Call', 'icon' => '📹', 'available' => true]
        ];
    }

    private function getTrainerPackages($trainer): array
    {
        // Mock implementation - replace with actual trainer package data
        $hourlyRate = $trainer->profile->hourly_rate ?? 50;
        
        return [
            [
                'id' => 'single',
                'name' => 'Single Session',
                'duration' => 60,
                'price' => $hourlyRate,
                'description' => '1-hour individual session'
            ],
            [
                'id' => 'weekly',
                'name' => 'Weekly Package',
                'duration' => 60,
                'sessions' => 4,
                'price' => $hourlyRate * 4 * 0.9, // 10% discount
                'description' => '4 sessions per month'
            ],
            [
                'id' => 'monthly',
                'name' => 'Monthly Package',
                'duration' => 60,
                'sessions' => 8,
                'price' => $hourlyRate * 8 * 0.8, // 20% discount
                'description' => '8 sessions per month'
            ]
        ];
    }

    private function isTrainerOnline($trainer): bool
    {
        // Mock implementation - replace with actual online status logic
        return rand(0, 1) === 1;
    }

    private function isAvailableNow($trainer): bool
    {
        // Mock implementation - replace with actual availability logic
        return rand(0, 1) === 1;
    }

    private function isAvailableToday($trainer): bool
    {
        // Mock implementation - replace with actual availability logic
        return rand(0, 1) === 1;
    }

    private function getNextAvailableSlot($trainer): ?string
    {
        // Mock implementation - replace with actual schedule logic
        $slots = ['2 hours', '4 hours', '1 day', '2 days'];
        return 'Available in ' . $slots[array_rand($slots)];
    }

    private function getTrainerSchedule($trainer): array
    {
        // Mock implementation - replace with actual schedule data
        return [
            'today' => ['09:00', '14:00', '16:00'],
            'tomorrow' => ['10:00', '13:00', '15:00'],
            'this_week' => 'Multiple slots available'
        ];
    }

    private function getCompletedSessionsCount($trainer): int
    {
        return FittalkSession::where('instructor_id', $trainer->id)
            ->where('status', 'completed')
            ->count();
    }

    private function getAverageResponseTime($trainer): string
    {
        // Mock implementation - replace with actual response time calculation
        $times = ['< 1 hour', '< 2 hours', '< 4 hours', 'Same day'];
        return $times[array_rand($times)];
    }

    private function getSatisfactionRate($trainer): string
    {
        // Mock implementation - replace with actual satisfaction calculation
        return rand(85, 100) . '%';
    }

    private function getTrainerReviews($trainer, $limit = 5): array
    {
        // Mock implementation - replace with actual reviews
        return [
            [
                'id' => 1,
                'user_name' => 'Sarah M.',
                'rating' => 5,
                'comment' => 'Excellent trainer! Very knowledgeable and helpful.',
                'date' => '2024-01-10'
            ],
            [
                'id' => 2,
                'user_name' => 'John D.',
                'rating' => 4,
                'comment' => 'Great sessions, learned a lot about nutrition.',
                'date' => '2024-01-08'
            ]
        ];
    }
}
