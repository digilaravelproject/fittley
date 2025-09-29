<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitLiveSession;
use App\Models\PostLike;
use App\Models\SubCategory;
use App\Models\User;
use App\Services\AgoraService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FitLiveSessionApiController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    /**
     * Display a listing of public FitLive sessions
     */
    public function index(): JsonResponse
    {
        $sessions = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('visibility', 'public')
            ->where('status', '!=', 'ended')
            ->orderBy('scheduled_at')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $sessions,
        ]);
    }

    /**
     * Display the FitLive daily session with HLS URL
     */
    public function DailyLiveClasses($id): JsonResponse
    {
        $subcategories = SubCategory::where('category_id', 21)
            ->where('id', '!=', 17)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug']);

        $selectedSubcategory = $subcategories->firstWhere('id', $id);
        if (!$selectedSubcategory) {
            return response()->json([
                'success' => false,
                'message' => 'Subcategory not found',
            ], 404);
        }

        $now = Carbon::now();

        // Fetch all today sessions for the selected subcategory
        $sessions = FitLiveSession::liveToday()
            ->where('sub_category_id', $selectedSubcategory->id)
            ->orderBy('scheduled_at')
            ->get();

        // Find live session
        $liveSessionId = null;
        foreach ($sessions as $index => $session) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            $nextSession = $sessions->get($index + 1);
            $nextSessionTime = $nextSession ? Carbon::parse($nextSession->scheduled_at) : null;

            if ($now->gte($sessionTime)) {
                if ($nextSessionTime) {
                    if ($now->lt($nextSessionTime) && $now->lte($sessionTime->copy()->addHour())) {
                        $liveSessionId = $session->id;
                        break;
                    }
                } else {
                    if ($now->lte($sessionTime->copy()->addHour())) {
                        $liveSessionId = $session->id;
                        break;
                    }
                }
            }
        }

        // Filter sessions (live + upcoming)
        $filteredSessions = $sessions->filter(function ($session) use ($now, $liveSessionId) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            if ($session->id === $liveSessionId) return true;
            return $sessionTime->gte($now);
        })->values();

        // Map live slots
        $liveSlots = $filteredSessions->map(function ($session) use ($liveSessionId) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            return [
                'id' => $session->id,
                'title' => $session->title,
                'time' => $sessionTime->format('h:i A'),
                'banner_image_url' => $session->banner_image_url,
                'is_live' => $session->id === $liveSessionId,
            ];
        });

        // Active session
        $activeSession = $sessions->firstWhere('id', $liveSessionId);

        // Instructor
        $instructor = $activeSession ? User::find($activeSession->instructor_id) : null;

        // Archived sessions
        $allPastSessions = FitLiveSession::where('sub_category_id', $selectedSubcategory->id)
            ->where('scheduled_at', '<', Carbon::now())
            // ->whereNotNull('ended_at')
            // ->orderBy('ended_at', 'desc')
            ->get();

        $archivedSessions = $allPastSessions->filter(function ($session) use ($liveSlots) {
            return !$liveSlots->contains('id', $session->id);
        });

        $groupedArchived = $archivedSessions->groupBy(function ($session) {
            return Carbon::parse($session->scheduled_at)->format('Y-m-d');
        });

        // 🔑 Prepare JSON response
        return response()->json([
            'success' => true,
            'data' => [
                'subcategories' => $subcategories,
                'selected_subcategory' => $selectedSubcategory,
                'active_session' => $activeSession,
                'instructor' => $instructor,
                'live_slots' => $liveSlots,
                'archived_sessions' => $archivedSessions,
                'grouped_archived' => $groupedArchived,
            ]
        ]);
    }

    /**
     * Display the specified FitLive session with HLS URL
     */
    public function show(string $id): JsonResponse
    {
        $session = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('id', $id)
            ->where('visibility', 'public')
            ->firstOrFail();

        $AnontherLiveSession = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('visibility', 'public')
            ->where('status', 'live')
            ->get();

        $archiveSession = FitLiveSession::with(['category', 'subCategory', 'instructor'])
                        ->whereNotNull('ended_at')
                        ->orderBy('ended_at', 'desc')->get();

        $upcomingSessions = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('status', 'scheduled')
            ->where('visibility', 'public')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->take(6)
            ->get();

        // 🔑 Get current user
        $user = auth()->user();

        // 🔎 Check if user liked this series
        $isLiked = false;
        if ($user) {
            $isLiked = PostLike::where('post_type', 'fit_live_video')
                ->where('post_id', $id)
                ->where('user_id', $user->id)
                ->exists();
        }

        $response = [
            'success' => true,
            'data' => [
                'id' => $session->id,
                'title' => $session->title,
                'description' => $session->description,
                'status' => $session->status,
                'scheduled_at' => $session->scheduled_at,
                'category' => $session->category?->name,
                'subcategory' => $session->subCategory?->name,
                'instructor' => $session->instructor?->name,
                'viewer_peak' => $session->viewer_peak ?? 0,
                'views_count' => $session->views_count ?? 0,
                'likes_count' => $session->likes_count ?? 0,
                'shares_count' => $session->shares_count ?? 0,
                'is_liked' => $isLiked,
                'rating' => $session->average_rating ?? 0,
                'mp4_path' => $session->mp4_path,
                'banner_image' => $session->banner_image,
                'recording_url' => $session->recording_url,
                'recording_status' => $session->recording_status,
                'recording_duration' => $session->recording_duration,
                'recording_file_size' => $session->recording_file_size,
                'chat_mode' => $session->chat_mode ?? $session->category->chat_mode,
                'is_live' => $session->isLive(),
            ],
            'live_classes' => $AnontherLiveSession,
            'archiv_classes' => $archiveSession,
            'upcomingSessions' => $upcomingSessions,
        ];

        // Add HLS URL if session is live
        if ($session->isLive() && $session->hls_url) {
            $response['data']['hls_url'] = $session->hls_url;
        }

        return response()->json($response);
    }

    /**
     * Join a session (for authenticated users)
     */
    public function join(Request $request, string $id): JsonResponse
    {
        $session = FitLiveSession::findOrFail($id);

        if (!$session->isLive()) {
            return response()->json([
                'success' => false,
                'message' => 'Session is not currently live',
            ], 400);
        }

        // Generate viewer token for LiveKit
        $token = $this->fitLiveKitService->mintToken(
            $session->livekit_room,
            auth()->id(),
            'viewer'
        );

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate access token',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
                'room' => $session->livekit_room,
                'hls_url' => $session->hls_url,
            ],
        ]);
    }

    /**
     * Like a blog
     */
    public function like_old(Request $request, FitLiveSession $fitLiveSession): JsonResponse
    {
        try {
                // Like → increment likes_count
                $fitLiveSession->increment('likes_count');
                $liked = true;

            return response()->json([
                'success' => true,
                'data' => [
                    'liked' => $liked,
                    'total_likes' => $fitLiveSession->likes_count
                ],
                'message' => 'Session liked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to like session',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
 * Like or unlike a blog (FitLiveSession)
 */
    public function like(Request $request, $sessionId): JsonResponse
    {
        try {
            $request->validate([
                'post_type' => 'required|in:fit_series_video,fit_live_video,fit_guide_video,fit_cast_video,fit_news_video,fit_insight_video'
            ]);

            $user = Auth::user();
            $session = FitLiveSession::find($sessionId);

            if (!$session) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session not found'
                ], 404);
            }

            $existingLike = PostLike::where('post_type', $request->post_type)
                ->where('post_id', $sessionId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingLike) {
                // Remove like
                $existingLike->delete();
                $session->decrement('likes_count'); // optional if you want live count tracking
                $isLiked = false;
                $message = 'Like removed';
            } else {
                // Add new like
                PostLike::create([
                    'post_type' => $request->post_type,
                    'post_id' => $sessionId,
                    'user_id' => $user->id
                ]);
                $session->increment('likes_count'); // optional if you want live count tracking
                $isLiked = true;
                $message = 'Session liked';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_liked' => $isLiked,
                    'likes_count' => $session->fresh()->likes_count
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle like',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Share a blog
     */
    public function share(Request $request, $id): JsonResponse
    {
        try {   

            $FitLiveSession = FitLiveSession::find($id);

            if (!$FitLiveSession) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to share session',
                    'error'   => 'Session not found'
                ], 404); // Use 404 since resource not found
            }

            // Increment share count
            $FitLiveSession->increment('shares_count');

            return response()->json([
                'success' => true,
                'data' => [
                    'share_url' => url("/fitlive/session/{$FitLiveSession->id}"),
                    'total_shares' => $FitLiveSession->shares_count
                ],
                'message' => 'Session shared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share session',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Start a session (admin only)
     */
    public function start(Request $request, FitLiveSession $fitLiveSession): JsonResponse
    {
        if (!$fitLiveSession->isScheduled()) {
            return response()->json([
                'success' => false,
                'message' => 'Only scheduled sessions can be started',
            ], 400);
        }

        $fitLiveSession->update(['status' => 'live']);

        // Start egress recording
        $egressId = $this->fitLiveKitService->startEgress(
            $fitLiveSession->livekit_room,
            $fitLiveSession->id
        );

        if ($egressId) {
            // Store egress ID for later use
            $fitLiveSession->update(['egress_id' => $egressId]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Session started successfully',
            'data' => $fitLiveSession->fresh(),
        ]);
    }

    /**
     * End a session (admin only)
     */
    public function end(Request $request, FitLiveSession $fitLiveSession): JsonResponse
    {
        if (!$fitLiveSession->isLive()) {
            return response()->json([
                'success' => false,
                'message' => 'Only live sessions can be ended',
            ], 400);
        }

        $fitLiveSession->update(['status' => 'ended']);

        // Stop egress recording if exists
        if ($fitLiveSession->egress_id) {
            $this->fitLiveKitService->stopEgress($fitLiveSession->egress_id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Session ended successfully',
            'data' => $fitLiveSession->fresh(),
        ]);
    }

    /**
     * Update stream status for real-time broadcasting
     */
    public function updateStream(Request $request, $id)
    {
        try {
            $session = FitLiveSession::findOrFail($id);
            
            // Validate request
            $request->validate([
                'streaming' => 'required|boolean',
                'room' => 'required|string'
            ]);
            
            if ($request->streaming) {
                // Generate HLS URL for the session
                $hlsUrl = "http://127.0.0.1:8080/hls/{$session->livekit_room}/index.m3u8";
                
                $session->update([
                    'hls_url' => $hlsUrl,
                    'status' => 'live'
                ]);
                
                // Broadcast to viewers that stream is now available
                broadcast(new \App\Events\FitLiveSessionStatusUpdated($session))->toOthers();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Stream started successfully',
                    'hls_url' => $hlsUrl,
                    'room' => $session->livekit_room
                ]);
            } else {
                $session->update([
                    'hls_url' => null
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Stream stopped'
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stream: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get stream status for public viewers
     */
    public function streamStatus($id)
    {
        try {
            $session = FitLiveSession::with(['instructor', 'category'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $session->id,
                    'title' => $session->title,
                    'status' => $session->status,
                    'hls_url' => $session->hls_url,
                    'room' => $session->livekit_room,
                    'instructor' => $session->instructor->name,
                    'category' => $session->category->name,
                    'viewer_peak' => $session->viewer_peak ?? 0,
                    'is_streaming' => !empty($session->hls_url) && $session->status === 'live'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Session not found'
            ], 404);
        }
    }

    /**
     * Get Agora streaming configuration with Co-Host Authentication
     */
    public function getAgoraConfig($sessionId)
    {
        try {
            $session = FitLiveSession::findOrFail($sessionId);
            $userId = auth()->id() ?? 1; // Default user ID for testing
            
            // Determine initial role based on user permissions
            $userRole = $this->determineUserRole($userId, $session);
            
            $config = $this->agoraService->getCoHostStreamingConfig($sessionId, $userId, $userRole);
            
            return response()->json([
                'success' => true,
                'data' => $config,
                'session' => [
                    'id' => $session->id,
                    'title' => $session->title,
                    'status' => $session->status,
                    'co_host_enabled' => true
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get Agora configuration: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Switch user role (audience to host or vice versa) with Co-Host Authentication
     */
    public function switchRole(Request $request, $sessionId)
    {
        try {
            $request->validate([
                'new_role' => 'required|in:publisher,subscriber',
                'user_id' => 'required|integer'
            ]);

            $session = FitLiveSession::findOrFail($sessionId);
            $userId = $request->user_id;
            $newRole = $request->new_role;
            
            // Check if user has permission to switch to this role
            if (!$this->canSwitchToRole($userId, $newRole, $session)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User does not have permission to switch to this role'
                ], 403);
            }
            
            $channelName = $this->agoraService->generateChannelName($sessionId);
            $tokenData = $this->agoraService->generateRoleSwitchToken($channelName, $userId, $newRole);
            
            return response()->json([
                'success' => true,
                'data' => $tokenData,
                'message' => "Role switched to {$newRole} successfully"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to switch role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Determine initial user role based on permissions
     */
    private function determineUserRole($userId, $session)
    {
        // In a real application, you would check user permissions
        // For now, return 'publisher' for session owner, 'subscriber' for others
        
        if ($userId == 1) { // Admin or session owner
            return 'publisher';
        }
        
        return 'subscriber'; // Default to audience
    }

    /**
     * Get comprehensive session details
     */
    public function details(string $id): JsonResponse
    {
        try {
            $session = FitLiveSession::with([
                'category', 
                'subCategory', 
                'instructor.profile',
                'chatMessages' => function($query) {
                    $query->latest()->limit(50);
                }
            ])
            ->where('id', $id)
            ->where('visibility', 'public')
            ->firstOrFail();

            // Get current participant count (mock data for now)
            $participantCount = rand(10, 100);
            
            // Prepare instructor details
            $instructorDetails = [
                'id' => $session->instructor->id,
                'name' => $session->instructor->name,
                'email' => $session->instructor->email,
                'profile_image' => $session->instructor->profile->profile_image ?? null,
                'bio' => $session->instructor->profile->bio ?? null,
                'specialization' => $session->instructor->profile->specialization ?? null,
                'experience_years' => $session->instructor->profile->experience_years ?? null,
            ];

            // Prepare session schedule info
            $scheduleInfo = [
                'scheduled_at' => $session->scheduled_at,
                'started_at' => $session->started_at,
                'ended_at' => $session->ended_at,
                'duration' => $session->getDuration(),
                'timezone' => 'UTC', // You can make this dynamic based on user preference
            ];

            // Prepare recording info
            $recordingInfo = [
                'recording_enabled' => $session->isRecordingEnabled(),
                'has_recording' => $session->hasRecording(),
                'recording_url' => $session->recording_url,
                'recording_status' => $session->recording_status,
                'recording_duration' => $session->getFormattedRecordingDuration(),
                'recording_file_size' => $session->getFormattedRecordingFileSize(),
            ];

            // Prepare Agora/LiveKit channel info
            $channelInfo = [
                'livekit_room' => $session->livekit_room,
                'channel_name' => $session->getChannelName(),
                'hls_url' => $session->hls_url,
                'is_streaming' => !empty($session->hls_url) && $session->isLive(),
            ];

            // Prepare chat info
            $chatInfo = [
                'chat_enabled' => $session->chat_mode !== 'disabled',
                'chat_mode' => $session->chat_mode ?? $session->category->chat_mode ?? 'enabled',
                'recent_messages_count' => $session->chatMessages->count(),
                'recent_messages' => $session->chatMessages->map(function($message) {
                    return [
                        'id' => $message->id,
                        'user_name' => $message->user->name ?? 'Anonymous',
                        'message' => $message->message,
                        'created_at' => $message->created_at,
                    ];
                }),
            ];

            // Determine join/leave capabilities
            $capabilities = [
                'can_join' => $session->isLive() || $session->isScheduled(),
                'can_leave' => true,
                'can_chat' => $session->chat_mode !== 'disabled',
                'can_view_recording' => $session->hasRecording() && $session->isEnded(),
            ];

            $response = [
                'success' => true,
                'data' => [
                    // Basic session info
                    'id' => $session->id,
                    'title' => $session->title,
                    'description' => $session->description,
                    'status' => $session->status,
                    'visibility' => $session->visibility,
                    'banner_image' => $session->banner_image,
                    'viewer_peak' => $session->viewer_peak ?? 0,
                    'current_participants' => $participantCount,
                    
                    // Category info
                    'category' => [
                        'id' => $session->category->id,
                        'name' => $session->category->name,
                        'type' => $session->category->type,
                    ],
                    'sub_category' => $session->subCategory ? [
                        'id' => $session->subCategory->id,
                        'name' => $session->subCategory->name,
                    ] : null,
                    
                    // Detailed sections
                    'instructor' => $instructorDetails,
                    'schedule' => $scheduleInfo,
                    'recording' => $recordingInfo,
                    'channel' => $channelInfo,
                    'chat' => $chatInfo,
                    'capabilities' => $capabilities,
                    
                    // Status flags
                    'is_live' => $session->isLive(),
                    'is_scheduled' => $session->isScheduled(),
                    'is_ended' => $session->isEnded(),
                    'has_ended' => $session->hasEnded(),
                ],
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ];

            return response()->json($response);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'FitLive session not found',
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve session details: ' . $e->getMessage(),
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 500);
        }
    }

    /**
     * Check if user can switch to the requested role
     */
    private function canSwitchToRole($userId, $newRole, $session)
    {
        // Implement your business logic here
        // For example:
        // - Only session owner can be publisher
        // - Check user permissions
        // - Check if session allows co-hosts
        
        if ($newRole === 'publisher') {
            // Check if user has host privileges
            return $userId == 1; // For demo, only user 1 can be publisher
        }
        
        // Anyone can be subscriber
        return true;
    }

    /**
     * Get session participants
     */
    public function getParticipants(string $id): JsonResponse
    {
        try {
            $session = FitLiveSession::findOrFail($id);
            
            // For now, we'll return mock participant data
            // In a real implementation, you would fetch from a participants table
            $participants = [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'name' => 'John Doe',
                    'role' => 'instructor',
                    'status' => 'active',
                    'joined_at' => now()->subMinutes(30)->toISOString(),
                    'is_speaking' => false,
                    'is_video_enabled' => true,
                    'is_audio_enabled' => true,
                ],
                [
                    'id' => 2,
                    'user_id' => 2,
                    'name' => 'Jane Smith',
                    'role' => 'participant',
                    'status' => 'active',
                    'joined_at' => now()->subMinutes(15)->toISOString(),
                    'is_speaking' => false,
                    'is_video_enabled' => false,
                    'is_audio_enabled' => true,
                ],
                [
                    'id' => 3,
                    'user_id' => 3,
                    'name' => 'Mike Johnson',
                    'role' => 'participant',
                    'status' => 'active',
                    'joined_at' => now()->subMinutes(5)->toISOString(),
                    'is_speaking' => true,
                    'is_video_enabled' => true,
                    'is_audio_enabled' => true,
                ]
            ];
            
            return response()->json([
                'success' => true,
                'data' => [
                    'session_id' => $session->id,
                    'session_title' => $session->title,
                    'session_status' => $session->status,
                    'total_participants' => count($participants),
                    'max_capacity' => 100, // You can make this configurable
                    'participants' => $participants
                ],
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'FitLive session not found',
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve participants: ' . $e->getMessage(),
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 500);
        }
     }

    /**
     * Join a session as a participant
     */
    public function joinSession(Request $request, string $id): JsonResponse
    {
        try {
            $session = FitLiveSession::findOrFail($id);
            $user = auth()->user();
            
            // Check if session is available for joining
            if (!$session->isLive() && !$session->isScheduled()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session is not available for joining',
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 400);
            }
            
            // Check capacity (mock implementation)
            $currentParticipants = 45; // In real implementation, get from participants table
            $maxCapacity = 100;
            
            if ($currentParticipants >= $maxCapacity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session has reached maximum capacity',
                    'data' => [
                        'current_participants' => $currentParticipants,
                        'max_capacity' => $maxCapacity
                    ],
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 400);
            }
            
            // In a real implementation, you would:
            // 1. Check if user is already a participant
            // 2. Add user to participants table
            // 3. Generate LiveKit/Agora token
            // 4. Broadcast participant joined event
            
            // Mock successful join response
            $participantData = [
                'participant_id' => rand(1000, 9999),
                'user_id' => $user->id,
                'name' => $user->name,
                'role' => 'participant',
                'status' => 'active',
                'joined_at' => now()->toISOString(),
                'permissions' => [
                    'can_speak' => true,
                    'can_video' => true,
                    'can_chat' => true,
                    'can_share_screen' => false
                ]
            ];
            
            // Generate access token (mock)
            $accessToken = 'mock_token_' . uniqid();
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully joined the session',
                'data' => [
                    'session' => [
                        'id' => $session->id,
                        'title' => $session->title,
                        'status' => $session->status,
                        'livekit_room' => $session->livekit_room,
                        'hls_url' => $session->hls_url
                    ],
                    'participant' => $participantData,
                    'access_token' => $accessToken,
                    'session_info' => [
                        'current_participants' => $currentParticipants + 1,
                        'max_capacity' => $maxCapacity,
                        'chat_enabled' => $session->chat_mode !== 'disabled'
                    ]
                ],
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'FitLive session not found',
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to join session: ' . $e->getMessage(),
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 500);
        }
     }

    /**
     * Leave a session as a participant
     */
    public function leaveSession(Request $request, string $id): JsonResponse
    {
        try {
            $session = FitLiveSession::findOrFail($id);
            $user = auth()->user();
            
            // In a real implementation, you would:
            // 1. Check if user is actually a participant
            // 2. Remove user from participants table
            // 3. Revoke LiveKit/Agora token
            // 4. Broadcast participant left event
            // 5. Update participant count
            
            // Mock participant data
            $participantData = [
                'user_id' => $user->id,
                'name' => $user->name,
                'left_at' => now()->toISOString(),
                'session_duration' => '00:15:30', // Mock duration
            ];
            
            // Mock updated session info
            $currentParticipants = 44; // Decreased by 1
            $maxCapacity = 100;
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully left the session',
                'data' => [
                    'session' => [
                        'id' => $session->id,
                        'title' => $session->title,
                        'status' => $session->status
                    ],
                    'participant' => $participantData,
                    'session_info' => [
                        'current_participants' => $currentParticipants,
                        'max_capacity' => $maxCapacity,
                        'participant_left' => true
                    ],
                    'session_summary' => [
                        'joined_at' => now()->subMinutes(15)->toISOString(),
                        'left_at' => now()->toISOString(),
                        'duration_minutes' => 15,
                        'was_speaking' => false,
                        'messages_sent' => rand(0, 10)
                    ]
                ],
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'FitLive session not found',
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to leave session: ' . $e->getMessage(),
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 500);
        }
     }

    /**
     * Moderate chat in a session (admin/instructor only)
     */
    public function moderateChat(Request $request, string $id): JsonResponse
    {
        try {
            $session = FitLiveSession::findOrFail($id);
            $user = auth()->user();
            
            // Check if user has moderation permissions
            $canModerate = $user->hasRole('admin') || 
                          $user->hasRole('instructor') || 
                          $session->instructor_id == $user->id;
            
            if (!$canModerate) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to moderate this session',
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 403);
            }
            
            // Validate request
            $request->validate([
                'action' => 'required|in:delete_message,mute_user,unmute_user,warn_user,ban_user,clear_chat',
                'target_user_id' => 'required_unless:action,clear_chat|integer',
                'message_id' => 'required_if:action,delete_message|integer',
                'reason' => 'nullable|string|max:255',
                'duration_minutes' => 'nullable|integer|min:1|max:1440' // Max 24 hours
            ]);
            
            $action = $request->input('action');
            $targetUserId = $request->input('target_user_id');
            $messageId = $request->input('message_id');
            $reason = $request->input('reason', 'No reason provided');
            $duration = $request->input('duration_minutes', 30);
            
            // Process moderation action
            $result = [];
            
            switch ($action) {
                case 'delete_message':
                    $result = [
                        'action' => 'delete_message',
                        'message_id' => $messageId,
                        'deleted_by' => $user->name,
                        'reason' => $reason,
                        'deleted_at' => now()->toISOString()
                    ];
                    break;
                    
                case 'mute_user':
                    $result = [
                        'action' => 'mute_user',
                        'target_user_id' => $targetUserId,
                        'muted_by' => $user->name,
                        'reason' => $reason,
                        'duration_minutes' => $duration,
                        'muted_until' => now()->addMinutes($duration)->toISOString(),
                        'muted_at' => now()->toISOString()
                    ];
                    break;
                    
                case 'unmute_user':
                    $result = [
                        'action' => 'unmute_user',
                        'target_user_id' => $targetUserId,
                        'unmuted_by' => $user->name,
                        'reason' => $reason,
                        'unmuted_at' => now()->toISOString()
                    ];
                    break;
                    
                case 'warn_user':
                    $result = [
                        'action' => 'warn_user',
                        'target_user_id' => $targetUserId,
                        'warned_by' => $user->name,
                        'reason' => $reason,
                        'warning_message' => 'You have received a warning from the moderator.',
                        'warned_at' => now()->toISOString()
                    ];
                    break;
                    
                case 'ban_user':
                    $result = [
                        'action' => 'ban_user',
                        'target_user_id' => $targetUserId,
                        'banned_by' => $user->name,
                        'reason' => $reason,
                        'duration_minutes' => $duration,
                        'banned_until' => now()->addMinutes($duration)->toISOString(),
                        'banned_at' => now()->toISOString()
                    ];
                    break;
                    
                case 'clear_chat':
                    $result = [
                        'action' => 'clear_chat',
                        'cleared_by' => $user->name,
                        'reason' => $reason,
                        'messages_cleared' => rand(10, 50), // Mock count
                        'cleared_at' => now()->toISOString()
                    ];
                    break;
            }
            
            // In a real implementation, you would:
            // 1. Execute the moderation action in the database
            // 2. Broadcast the moderation event to all participants
            // 3. Log the moderation action for audit purposes
            // 4. Send notifications to affected users
            
            return response()->json([
                'success' => true,
                'message' => 'Moderation action completed successfully',
                'data' => [
                    'session_id' => $session->id,
                    'session_title' => $session->title,
                    'moderation_action' => $result,
                    'moderator' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'role' => $user->roles->first()->name ?? 'user'
                    ]
                ],
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'FitLive session not found',
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to moderate chat: ' . $e->getMessage(),
                'data' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                    'version' => '1.0'
                ]
            ], 500);
        }
    }
}
