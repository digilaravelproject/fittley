<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FittalkSession;
use App\Models\User;
use App\Services\AgoraService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FittalkController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    /**
     * Get available instructors for FitTalk sessions
     */
    public function getInstructors(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|in:fitness,nutrition,mental_health,physiotherapy,general',
            'min_rating' => 'nullable|numeric|min:0|max:5',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $perPage = $request->per_page ?? 20;

        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'instructor');
        })->where('is_available_for_fittalk', true)
          ->with(['profile:user_id,bio,specializations,hourly_rate','badges']);
          
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

        // Filter by minimum rating
        if ($request->min_rating) {
            $query->where('average_rating', '>=', $request->min_rating);
        }

        $instructors = $query->orderBy('average_rating', 'desc')
            ->paginate($perPage);
        
        // Add session statistics and availability
        $instructors->getCollection()->transform(function ($instructor) {
            $instructor->append(['next_available_slot', 'is_currently_available']);
            $instructor->total_sessions = FittalkSession::where('instructor_id', $instructor->id)
                ->where('status', 'completed')
                ->count();
            
                // if you want specializations right on the instructor object:
            $instructor->specializations = $instructor->profile->specializations ?? [];
            $instructor->description     = $instructor->profile->bio ?? null;

            return $instructor;
        });

       

        return response()->json([
            'success' => true,
            'data' => $instructors,
        ]);
    }

    /**
     * Get user's FitTalk sessions
     */
    public function getMySessions(Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'nullable|in:scheduled,in_progress,completed,cancelled',
            'type' => 'nullable|in:chat,voice,video',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        $userId = auth()->id();
        $perPage = $request->per_page ?? 20;

        $query = FittalkSession::with(['instructor:id,name,avatar', 'user:id,name,avatar'])
            ->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)->orWhere('instructor_id', $userId);
            });

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by session type
        if ($request->type) {
            $query->where('session_type', $request->type);
        }

        $sessions = $query->orderBy('scheduled_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $sessions,
        ]);
    }

    /**
     * Book a new FitTalk session
     */
    public function bookSession(Request $request): JsonResponse
    {
        $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'session_type' => 'required|in:chat,voice,video',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|in:30,60,90',
            'description' => 'nullable|string|max:500',
        ]);

        $userId = auth()->id();
        $instructor = User::findOrFail($request->instructor_id);

        // Verify instructor is available for FitTalk
        if (!$instructor->is_available_for_fittalk) {
            return response()->json([
                'success' => false,
                'message' => 'Instructor is not available for FitTalk sessions',
            ], 400);
        }

        // Check if instructor has instructor role
        if (!$instructor->hasRole('instructor')) {
            return response()->json([
                'success' => false,
                'message' => 'User is not an instructor',
            ], 400);
        }

        // Calculate session cost
        $hourlyRate = $instructor->profile->hourly_rate ?? 50; // Default rate
        $cost = ($hourlyRate / 60) * $request->duration_minutes;

        DB::beginTransaction();
        try {
            $session = FittalkSession::create([
                'user_id' => $userId,
                'instructor_id' => $request->instructor_id,
                'session_type' => $request->session_type,
                'scheduled_at' => Carbon::parse($request->scheduled_at),
                'duration_minutes' => $request->duration_minutes,
                'cost' => $cost,
                'description' => $request->description,
                'status' => 'scheduled',
                'agora_channel' => 'fittalk_' . uniqid(),
            ]);

            DB::commit();

            $session->load(['instructor:id,name,avatar', 'user:id,name,avatar']);

            return response()->json([
                'success' => true,
                'message' => 'Session booked successfully',
                'data' => $session,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to book session',
            ], 500);
        }
    }

    /**
     * Get specific session details
     */
    public function getSession($sessionId): JsonResponse
    {
        $session = FittalkSession::with(['instructor:id,name,avatar', 'user:id,name,avatar'])
            ->findOrFail($sessionId);

        $userId = auth()->id();

        // Check if user is participant
        if ($session->user_id !== $userId && $session->instructor_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to access this session',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $session,
        ]);
    }

    /**
     * Start a FitTalk session
     */
    public function startSession($sessionId): JsonResponse
    {
        $session = FittalkSession::findOrFail($sessionId);
        $userId = auth()->id();

        // Check if user is participant
        if ($session->user_id !== $userId && $session->instructor_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to start this session',
            ], 403);
        }

        // Check if session is scheduled
        if ($session->status !== 'scheduled') {
            return response()->json([
                'success' => false,
                'message' => 'Session cannot be started in current status: ' . $session->status,
            ], 400);
        }

        DB::beginTransaction();
        try {
            
            $session->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);

            // Generate Agora token if needed for voice/video
            $agoraToken = null;
            if (in_array($session->session_type, ['voice_call', 'video_call'])) {
                $agoraToken = $this->agoraService->generateToken(
                    $session->agora_channel,
                    $userId,
                    3600 // 1 hour expiry
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Session started successfully',
                'data' => [
                    'session' => $session->fresh(),
                    'agora_token' => $agoraToken,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to start session',
            ], 500);
        }
    }

    /**
     * End a FitTalk session
     */
    public function endSession(Request $request, $sessionId): JsonResponse
    {
        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $session = FittalkSession::findOrFail($sessionId);
        $userId = auth()->id();

        // Check if user is participant
        if ($session->user_id !== $userId && $session->instructor_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to end this session',
            ], 403);
        }

        // Check if session is in progress
        if ($session->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Session is not currently in progress',
            ], 400);
        }

        DB::beginTransaction();
        try {
            $endTime = now();
            $actualDuration = $session->started_at 
                ? $session->started_at->diffInMinutes($endTime)
                : $session->duration_minutes;

            $updateData = [
                'status' => 'completed',
                'ended_at' => $endTime,
                'actual_duration_minutes' => $actualDuration,
            ];

            // Only the user (not instructor) can provide rating and feedback
            if ($userId === $session->user_id) {
                if ($request->rating) {
                    $updateData['rating'] = $request->rating;
                }
                if ($request->feedback) {
                    $updateData['feedback'] = $request->feedback;
                }
            }

            $session->update($updateData);

            // Update instructor's average rating if rating was provided
            if ($request->rating && $userId === $session->user_id) {
                $this->updateInstructorRating($session->instructor_id);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Session ended successfully',
                'data' => $session->fresh(),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to end session',
            ], 500);
        }
    }

    /**
     * Cancel a FitTalk session
     */
    public function cancelSession(Request $request, $sessionId): JsonResponse
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $session = FittalkSession::findOrFail($sessionId);
        $userId = auth()->id();

        // Check if user is participant
        if ($session->user_id !== $userId && $session->instructor_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to cancel this session',
            ], 403);
        }

        // Check if session can be cancelled
        if (!in_array($session->status, ['scheduled'])) {
            return response()->json([
                'success' => false,
                'message' => 'Session cannot be cancelled in current status: ' . $session->status,
            ], 400);
        }

        $session->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => $userId,
            'cancellation_reason' => $request->reason,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Session cancelled successfully',
            'data' => $session->fresh(),
        ]);
    }

    /**
     * Get Agora configuration for session
     */
    public function getAgoraConfig($sessionId): JsonResponse
    {
        $session = FittalkSession::findOrFail($sessionId);
        $userId = auth()->id();

        // Check if user is participant
        if ($session->user_id !== $userId && $session->instructor_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to access this session',
            ], 403);
        }

        // Check if session is in progress or about to start
        if (!in_array($session->status, ['scheduled', 'in_progress'])) {
            return response()->json([
                'success' => false,
                'message' => 'Session is not active',
            ], 400);
        }

        try {
            $token = $this->agoraService->generateToken(
                $session->agora_channel,
                $userId,
                3600 // 1 hour expiry
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'app_id' => config('agora.app_id'),
                    'channel' => $session->agora_channel,
                    'token' => $token,
                    'uid' => $userId,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate Agora configuration',
            ], 500);
        }
    }

    /**
     * Update instructor's average rating
     */
    private function updateInstructorRating($instructorId): void
    {
        $averageRating = FittalkSession::where('instructor_id', $instructorId)
            ->whereNotNull('rating')
            ->avg('rating');

        User::where('id', $instructorId)->update([
            'average_rating' => round($averageRating, 2),
        ]);
    }
} 