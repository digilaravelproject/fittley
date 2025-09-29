<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FitArenaEvent;
use App\Models\FitArenaStage;
use App\Models\FitArenaSession;
use App\Models\FitLiveSession;
use App\Models\PostLike;
use App\Models\FitLiveChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FitArenaApiController extends Controller
{
    /**
     * Get all FitArena events
     */
    public function index(Request $request): JsonResponse
    {
        $query = FitArenaEvent::with(['stages', 'sessions'])
            ->where('visibility', 'public')
            ->orderBy('start_date', 'desc');

        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by featured if provided
        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $events = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $events,
            'message' => 'FitArena events retrieved successfully'
        ]);
    }

    /**
     * Get a specific event with its stages and sessions
     */
    public function show(Request $request, $eventSlug): JsonResponse
    {
        $event = FitArenaEvent::with([
            'stages' => function($query) {
                $query->orderBy('sort_order');
            },
            'stages.sessions' => function($query) {
                $query->orderBy('scheduled_start');
            },
            'sessions' => function($query) {
                $query->orderBy('scheduled_start');
            }
        ])->where('slug', $eventSlug)
          ->where('visibility', 'public')
          ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $event,
            'message' => 'Event details retrieved successfully'
        ]);
    }

    /**
     * Get event stages
     */
    public function stages(Request $request, $eventSlug): JsonResponse
    {
        $event = FitArenaEvent::where('slug', $eventSlug)
            ->where('visibility', 'public')
            ->firstOrFail();

        $stages = FitArenaStage::with(['currentLiveSession', 'nextSession'])
            ->where('event_id', $event->id)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $stages,
            'message' => 'Event stages retrieved successfully'
        ]);
    }

    /**
     * Get stage details with sessions
     */
    public function stageDetails(Request $request, $eventSlug, $stageId): JsonResponse
    {
        $event = FitArenaEvent::where('slug', $eventSlug)
            ->where('visibility', 'public')
            ->firstOrFail();

        $stage = FitArenaStage::with([
            'sessions' => function($query) {
                $query->orderBy('scheduled_start');
            },
            'currentLiveSession',
            'nextSession'
        ])->where('event_id', $event->id)
          ->where('id', $stageId)
          ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $stage,
            'message' => 'Stage details retrieved successfully'
        ]);
    }

    /**
     * Get event agenda/schedule
     */
    public function agenda(Request $request, $eventSlug): JsonResponse
    {
        $event = FitArenaEvent::where('slug', $eventSlug)
            ->where('visibility', 'public')
            ->firstOrFail();

        $date = $request->get('date');
        
        $sessionsQuery = FitArenaSession::with(['stage', 'category', 'subCategory'])
            ->where('event_id', $event->id)
            ->orderBy('scheduled_start');

        if ($date) {
            $targetDate = Carbon::parse($date);
            $sessionsQuery->whereDate('scheduled_start', $targetDate);
        }

        $sessions = $sessionsQuery->get();

        // Group sessions by date and stage
        $agenda = $sessions->groupBy(function($session) {
            return $session->scheduled_start->format('Y-m-d');
        })->map(function($dailySessions) {
            return $dailySessions->groupBy('stage_id');
        });

        return response()->json([
            'success' => true,
            'data' => [
                'event' => $event,
                'agenda' => $agenda,
                'total_sessions' => $sessions->count()
            ],
            'message' => 'Event agenda retrieved successfully'
        ]);
    }

    /**
     * Get session details
     */
    public function sessionDetails(Request $request, $eventSlug, $sessionId): JsonResponse
    {
        $event = FitArenaEvent::where('slug', $eventSlug)
            ->where('visibility', 'public')
            ->firstOrFail();

        $session = FitArenaSession::with(['stage', 'category', 'subCategory'])
            ->where('event_id', $event->id)
            ->where('id', $sessionId)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $session,
            'message' => 'Session details retrieved successfully'
        ]);
    }

    /**
     * Get live sessions for an event
     */
    public function liveSessions(Request $request, $eventSlug): JsonResponse
    {
        $event = FitArenaEvent::where('slug', $eventSlug)
            ->where('visibility', 'public')
            ->firstOrFail();

        $liveSessions = FitArenaSession::with(['stage', 'category'])
            ->where('event_id', $event->id)
            ->where('status', 'live')
            ->orderBy('scheduled_start')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $liveSessions,
            'message' => 'Live sessions retrieved successfully'
        ]);
    }

    /**
     * Get stream URL for a stage (requires authentication)
     */
    public function stageStream(Request $request, $eventSlug, $stageId): JsonResponse
    {
        $event = FitArenaEvent::where('slug', $eventSlug)
            ->where('visibility', 'public')
            ->firstOrFail();

        $stage = FitArenaStage::where('event_id', $event->id)
            ->where('id', $stageId)
            ->firstOrFail();

        // Check if stage is live
        if (!$stage->isLive()) {
            return response()->json([
                'success' => false,
                'message' => 'Stage is not currently live'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'stage' => $stage,
                'hls_url' => $stage->hls_url,
                'channel_name' => $stage->getChannelName(),
                'viewer_count' => $stage->getCurrentViewerCount()
            ],
            'message' => 'Stream URL retrieved successfully'
        ]);
    }

    /**
     * Get replay sessions for an event
     */
    public function replays(Request $request, $eventSlug): JsonResponse
    {
        $event = FitArenaEvent::where('slug', $eventSlug)
            ->where('visibility', 'public')
            ->firstOrFail();

        // Check if DVR is available for this event
        if (!$event->isDvrAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Replay content is no longer available for this event'
            ], 422);
        }

        $replays = FitArenaSession::with(['stage', 'category'])
            ->where('event_id', $event->id)
            ->replayAvailable()
            ->withRecordings()
            ->orderBy('scheduled_start', 'desc')
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $replays,
            'message' => 'Event replays retrieved successfully'
        ]);
    }

    /**
     * Get session replay URL
     */
    public function sessionReplay(Request $request, $eventSlug, $sessionId): JsonResponse
    {
        $event = FitArenaEvent::where('slug', $eventSlug)
            ->where('visibility', 'public')
            ->firstOrFail();

        // Check if DVR is available for this event
        if (!$event->isDvrAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Replay content is no longer available for this event'
            ], 422);
        }

        $session = FitArenaSession::with(['stage'])
            ->where('event_id', $event->id)
            ->where('id', $sessionId)
            ->firstOrFail();

        if (!$session->isReplayAvailable()) {
            return response()->json([
                'success' => false,
                'message' => 'Replay is not available for this session'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'session' => $session,
                'recording_url' => $session->recording_url,
                'duration' => $session->getFormattedRecordingDuration(),
                'file_size' => $session->getFormattedRecordingFileSize()
            ],
            'message' => 'Session replay URL retrieved successfully'
        ]);
    }

    /**
     * Get featured events
     */
    public function featured(Request $request): JsonResponse
    {
        $events = FitArenaEvent::with(['stages', 'sessions'])
            ->where('visibility', 'public')
            ->where('is_featured', true)
            ->orderBy('start_date', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events,
            'message' => 'Featured events retrieved successfully'
        ]);
    }

    /**
     * Get upcoming events
     */
    public function upcoming(Request $request): JsonResponse
    {
        $events = FitArenaEvent::with(['stages'])
            ->where('visibility', 'public')
            ->upcoming()
            ->orderBy('start_date', 'asc')
            ->limit($request->get('limit', 10))
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events,
            'message' => 'Upcoming events retrieved successfully'
        ]);
    }

    /**
     * Like a blog
     */
    public function like_old(Request $request, FitArenaEvent $FitArenaEvent): JsonResponse
    {
        try {
                // Like → increment likes_count
                $FitArenaEvent->increment('likes_count');
                $liked = true;

            return response()->json([
                'success' => true,
                'data' => [
                    'liked' => $liked,
                    'total_likes' => $FitArenaEvent->likes_count
                ],
                'message' => 'Event liked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to like event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Like or unlike an event
     */
    public function like(Request $request, $eventId): JsonResponse
    {
        try {
            // Must be logged in
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to like this event.'
                ], 401);
            }

            $request->validate([
                'post_type' => 'required|in:fit_arena_event' // you can add more types if needed
            ]);

            $user = Auth::user();
            $event = FitArenaEvent::find($eventId);

            if (!$event) {
                return response()->json([
                    'success' => false,
                    'message' => 'Event not found'
                ], 404);
            }

            $existingLike = PostLike::where('post_type', $request->post_type)
                ->where('post_id', $eventId)
                ->where('user_id', $user->id)
                ->first();

            if ($existingLike) {
                // Remove like
                $existingLike->delete();
                $event->decrement('likes_count');
                $isLiked = false;
                $message = 'Like removed';
            } else {
                // Add new like
                PostLike::create([
                    'post_type' => $request->post_type,
                    'post_id' => $eventId,
                    'user_id' => $user->id
                ]);
                $event->increment('likes_count');
                $isLiked = true;
                $message = 'Event liked';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_liked' => $isLiked,
                    'likes_count' => $event->fresh()->likes_count
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
            $FitArenaEvent = FitArenaEvent::find($id);

            if (!$FitArenaEvent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to share event',
                    'error'   => 'Event not found'
                ], 404); // Use 404 since resource not found
            }

            // Increment share count
            $FitArenaEvent->increment('shares_count');

            return response()->json([
                'success' => true,
                'data' => [
                    'share_url' => url("/fitarena/{$FitArenaEvent->slug}"),
                    'total_shares' => $FitArenaEvent->shares_count
                ],
                'message' => 'event shared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get currently live events
     */
    public function live(Request $request): JsonResponse
    {
        $events = FitArenaEvent::with(['stages.currentLiveSession'])
            ->where('visibility', 'public')
            ->live()
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events,
            'message' => 'Live events retrieved successfully'
        ]);
    }

    public function getFitArenaLiveById(Request $request, string $id): JsonResponse
    {
        try {

            $arenaEvents = FitArenaEvent::with(['stages.currentLiveSession'])
                ->where('visibility', 'public')
                ->where('id', $id)
                // ->live()
                ->orderBy('start_date', 'desc')
                ->get();

            // 🔑 Get current user
            $user = auth()->user();

            // 🔎 Append is_like field
            $arenaEvents = $arenaEvents->map(function ($event) use ($user) {
                $event->is_like = false;

                if ($user) {
                    $event->is_like = PostLike::where('post_type', 'fit_series_video')
                        ->where('post_id', $event->id) // ✅ use $event->id, not $series
                        ->where('user_id', $user->id)
                        ->exists();
                }

                return $event;
            });

            return response()->json([
                'success' => true,
                'data' => $arenaEvents,
                'message' => 'Live events retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getFitArenaLiveSessionById(Request $request, string $id): JsonResponse
    {
        try {

            $arenaEvents = FitArenaEvent::with(['stages.currentLiveSession'])
                ->where('visibility', 'public')
                ->where('id', $id)
                ->live()
                ->orderBy('start_date', 'desc')
                ->get();
            
            $session = FitLiveSession::findOrFail($id);
        
            // Allow instructors to always access chat messages for their sessions
            if (Auth::check() && Auth::user()->hasRole('instructor') && $session->instructor_id === Auth::id()) {
                
                $messages = FitLiveChatMessage::with('user:id,name')
                    ->where('fitlive_session_id', $session->id)
                    ->orderBy('sent_at', 'desc')
                    ->limit(50)
                    ->get()
                    ->reverse()
                    ->values();

                return response()->json([
                    'success' => true,
                    'data' => $arenaEvents,
                    'messages' => $messages,
                    'chat_enabled' => true,
                    'instructor_access' => true,
                    'message' => 'Live events retrieved successfully'
                ]);

            }
            
            
            // Check if chat is enabled for this session for regular users
            if ($session->chat_mode === 'off') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat is disabled for this session'
                ], 403);
            }

            // Check chat availability based on session status
            if ($session->chat_mode === 'during' && !$session->isLive()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat is only available during live sessions'
                ], 403);
            }

            $messages = FitLiveChatMessage::with('user:id,name')
                ->where('fitlive_session_id', $session->id)
                ->orderBy('sent_at', 'desc')
                ->limit(50)
                ->get()
                ->reverse()
                ->values();


            return response()->json([
                'success' => true,
                'data' => $arenaEvents,
                'messages' => $messages,
                'chat_enabled' => $this->isChatEnabled($session),
                'instructor_access' => true,
                'message' => 'Live events retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'error'
            ], 403);
        }
    }

    /**
     * Check if chat is enabled for the session
     */
    private function isChatEnabled(FitLiveSession $session)
    {
        if ($session->chat_mode === 'off') {
            return false;
        }

        if ($session->chat_mode === 'during') {
            return $session->isLive();
        }

        if ($session->chat_mode === 'after') {
            return $session->isLive() || $session->hasEnded();
        }

        return false;
    }
} 