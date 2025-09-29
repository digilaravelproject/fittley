<?php

namespace App\Http\Controllers\Instructor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FitLiveSession;
use App\Models\FitLiveChatMessage;
use App\Models\FitArenaEvent;
use App\Models\FitArenaSession;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\AgoraService;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class InstructorController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    /**
     * Show the instructor dashboard with comprehensive analytics and session management.
     */
    public function dashboard()
    {
        $instructor = Auth::user();

        // Get sessions with various filters
        $sessions = FitLiveSession::where('instructor_id', $instructor->id)
            ->with(['category', 'subCategory'])
            ->orderBy('scheduled_at', 'desc')
            ->get();

        // Analytics data
        $analytics = $this->getInstructorAnalytics($instructor->id);

        // Recent sessions
        $recentSessions = $sessions->take(5);

        // Upcoming sessions
        $upcomingSessions = $sessions->where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->sortBy('scheduled_at')
            ->take(3);

        // Live sessions
        $liveSessions = $sessions->where('status', 'live');

        // Recent chat messages from instructor's sessions
        $recentChatMessages = FitLiveChatMessage::whereIn('fitlive_session_id', $sessions->pluck('id'))
            ->with(['user', 'fitLiveSession'])
            ->orderBy('sent_at', 'desc')
            ->limit(10)
            ->get();

        // Get FitArena sessions where this instructor is a speaker
        $fitArenaSession = FitArenaSession::with(['event', 'stage'])
            ->whereRaw("JSON_CONTAINS(speakers, JSON_OBJECT('user_id', ?))", [auth()->id()])
            ->orderBy('scheduled_start', 'desc')
            ->get();

        // Separate FitArena sessions by status
        $liveArenaSession = $fitArenaSession->where('status', 'live');
        $upcomingArenaSession = $fitArenaSession->where('status', 'scheduled')
            ->where('scheduled_start', '>', now())
            ->sortBy('scheduled_start')
            ->take(3);

        return view('instructor.dashboard', compact(
            'sessions', 
            'instructor', 
            'analytics', 
            'recentSessions',
            'upcomingSessions',
            'liveSessions',
            'recentChatMessages',
            'fitArenaSession',
            'liveArenaSession', 
            'upcomingArenaSession'
        ));
    }

    /**
     * Get instructor analytics data
     */
    private function getInstructorAnalytics($instructorId)
    {
        $sessions = FitLiveSession::where('instructor_id', $instructorId);

        return [
            'total_sessions' => $sessions->count(),
            'live_sessions' => $sessions->where('status', 'live')->count(),
            'scheduled_sessions' => $sessions->where('status', 'scheduled')->count(),
            'completed_sessions' => $sessions->where('status', 'ended')->count(),
            'total_viewers' => $sessions->sum('viewer_peak'),
            'average_viewers' => $sessions->where('viewer_peak', '>', 0)->avg('viewer_peak') ?: 0,
            'total_chat_messages' => FitLiveChatMessage::whereIn('fitlive_session_id', 
                $sessions->pluck('id'))->count(),
            'this_month_sessions' => $sessions->whereMonth('created_at', now()->month)->count(),
            'this_week_sessions' => $sessions->whereBetween('created_at', [
                now()->startOfWeek(), now()->endOfWeek()
            ])->count(),
            'sessions_by_category' => $sessions->with('category')
                ->get()
                ->groupBy('category.name')
                ->map->count(),
            'monthly_stats' => $this->getMonthlyStats($instructorId)
        ];
    }

    /**
     * Get monthly statistics for charts
     */
    private function getMonthlyStats($instructorId)
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'sessions' => FitLiveSession::where('instructor_id', $instructorId)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
                'viewers' => FitLiveSession::where('instructor_id', $instructorId)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('viewer_peak')
            ];
        }
        return $months;
    }

    /**
     * Show instructor's sessions with filtering and pagination
     */
    public function sessions(Request $request)
    {
        $instructor = Auth::user();
        $query = FitLiveSession::where('instructor_id', $instructor->id)
            ->with(['category', 'subCategory']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $sessions = $query->orderBy('scheduled_at', 'desc')->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('instructor.sessions', compact('sessions', 'categories'));
    }

    /**
     * Show form to create new session
     */
    public function createSession()
    {
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::with('category')->orderBy('name')->get();

        return view('instructor.sessions.create', compact('categories', 'subCategories'));
    }

    /**
     * Store new session
     */
    public function storeSession(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'scheduled_at' => 'required|date|after:now',
            'chat_mode' => 'required|in:during,after,off',
            'session_type' => 'required',
            'visibility' => 'required|in:public,private',
            'banner_image' => 'nullable|string|max:500'
        ]);

        $validated['instructor_id'] = Auth::id();
        $validated['status'] = 'scheduled';

        $session = FitLiveSession::create($validated);

        return redirect()->route('instructor.sessions')
            ->with('success', 'Session created successfully!');
    }

    /**
     * Show session details for instructor
     */
    public function showSession(FitLiveSession $session)
    {
        // Ensure instructor can only view their own sessions
        if ($session->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        $session->load(['category', 'subCategory', 'chatMessages' => function ($query) {
            $query->with('user')->latest()->limit(50);
        }]);

        // Get streaming configuration if session is live or scheduled
        $streamingConfig = null;
        if ($session->isLive() || $session->isScheduled()) {
            $streamingConfig = [
                'app_id' => config('agora.app_id'),
                'channel' => 'fitlive_' . $session->id,
                'token' => $this->agoraService->generateToken('fitlive_' . $session->id, Auth::id(), 'publisher'),
                'uid' => Auth::id(),
                'role' => 'publisher',
                'configured' => !empty(config('agora.app_id'))
            ];
        }

        return view('instructor.sessions.show', compact('session', 'streamingConfig'));
    }

    /**
     * Show streaming interface for instructor
     */
    public function streamSession(FitLiveSession $session)
    {
        // Ensure instructor can only stream their own sessions
        if ($session->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        // Generate streaming configuration
        $streamingConfig = [
            'app_id' => config('agora.app_id'),
            'channel' => 'fitlive_' . $session->id,
            'token' => $this->agoraService->generateToken('fitlive_' . $session->id, Auth::id(), 'publisher'),
            'uid' => Auth::id(),
            'role' => 'publisher',
            'configured' => !empty(config('agora.app_id'))
        ];

        return view('instructor.sessions.stream', compact('session', 'streamingConfig'));
    }

    /**
     * Update session stream status
     */
    public function updateStreamStatus(Request $request, FitLiveSession $session, $action)
    {
        // Ensure instructor can only update their own sessions
        if ($session->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this session.');
        }

        if ($action === 'start') {
            $updateData = [
                'status' => 'live',
                'started_at' => now()
            ];

            // Start recording if enabled
            if ($session->recording_enabled) {
                $recordingResult = $this->agoraService->startRecording(
                    'fitlive_' . $session->id,
                    Auth::id()
                );

                if ($recordingResult['success']) {
                    $updateData['recording_id'] = $recordingResult['recording_id'];
                    $updateData['recording_status'] = 'recording';
                }
            }

            $session->update($updateData);
            
            return response()->json([
                'success' => true,
                'status' => 'live',
                'message' => 'Stream started successfully',
                'recording_enabled' => $session->recording_enabled,
                'recording_status' => $session->recording_status ?? null
            ]);
        }
        
        if ($action === 'end') {
            $updateData = [
                'status' => 'ended',
                'ended_at' => now()
            ];

            // Stop recording if it was started
            if ($session->recording_enabled && $session->recording_id) {
                $recordingResult = $this->agoraService->stopRecording(
                    'fitlive_' . $session->id,
                    $session->recording_id
                );

                if ($recordingResult['success']) {
                    $updateData['recording_url'] = $recordingResult['recording_url'];
                    $updateData['recording_status'] = 'completed';
                    $updateData['recording_duration'] = $recordingResult['duration'] ?? null;
                    $updateData['recording_file_size'] = $recordingResult['file_size'] ?? null;
                } else {
                    $updateData['recording_status'] = 'failed';
                }
            }

            $session->update($updateData);
            
            return response()->json([
                'success' => true,
                'status' => 'ended',
                'message' => 'Stream ended successfully',
                'recording_status' => $session->recording_status ?? null
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid action'
        ], 400);
    }

    /**
     * Show instructor analytics page
     */
    public function analytics()
    {
        $instructor = Auth::user();
        $analytics = $this->getInstructorAnalytics($instructor->id);
        
        // Additional detailed analytics
        $sessions = FitLiveSession::where('instructor_id', $instructor->id)
            ->with(['category', 'subCategory'])
            ->get();

        $topSessions = $sessions->sortByDesc('viewer_peak')->take(10);
        $categoryPerformance = $sessions->groupBy('category.name')
            ->map(function ($categorySessions) {
                return [
                    'sessions' => $categorySessions->count(),
                    'total_viewers' => $categorySessions->sum('viewer_peak'),
                    'avg_viewers' => $categorySessions->avg('viewer_peak') ?: 0
                ];
            });

        return view('instructor.analytics', compact(
            'analytics', 
            'topSessions', 
            'categoryPerformance'
        ));
    }

    /**
     * Show instructor profile/settings
     */
    public function profile()
    {
        $instructor = Auth::user();
        return view('instructor.profile', compact('instructor'));
    }

    /**
     * Update instructor profile
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|string|max:500'
        ]);

        Auth::user()->update($validated);

        return redirect()->route('instructor.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show FitArena sessions for the instructor
     */
    public function fitArenaSessions()
    {
        $instructor = Auth::user();
        
        // Get FitArena sessions where this instructor is a speaker
        $sessions = FitArenaSession::with(['event', 'stage'])
            ->whereRaw("JSON_CONTAINS(speakers, JSON_OBJECT('user_id', ?))", [$instructor->id])
            ->orderBy('scheduled_start', 'desc')
            ->paginate(10);

        return view('instructor.fitarena.sessions', compact('sessions', 'instructor'));
    }

    /**
     * Show FitArena session streaming interface for instructor
     */
    public function streamArenaSession(FitArenaSession $session)
    {
        $instructor = Auth::user();
        
        // Verify instructor is assigned to this session
        $isAssigned = collect($session->speakers)->contains('user_id', $instructor->id);
        if (!$isAssigned) {
            abort(403, 'You are not assigned to this session.');
        }

        // Load relationships
        $session->load('event', 'stage');
        
        // Get Agora configuration
        $streamingConfig = [
            'app_id' => config('agora.app_id'),
            'channel' => 'fitarena_session_' . $session->id,
            'token' => $this->agoraService->generateToken('fitarena_session_' . $session->id, $instructor->id, 'publisher'),
            'uid' => $instructor->id,
            'role' => 'publisher',
            'configured' => !empty(config('agora.app_id'))
        ];
        
        return view('instructor.fitarena.stream', compact('session', 'streamingConfig', 'instructor'));
    }

    /**
     * Update FitArena session streaming status
     */
    public function updateArenaStreamStatus(Request $request, FitArenaSession $session, $action)
    {
        // Validate action parameter from route
        if (!in_array($action, ['start', 'end'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid action. Must be start or end.'
            ], 400);
        }

        $instructor = Auth::user();
        
        // Verify instructor is assigned to this session
        $isAssigned = collect($session->speakers)->contains('user_id', $instructor->id);
        if (!$isAssigned) {
            return response()->json([
                'success' => false,
                'message' => 'You are not assigned to this session.'
            ], 403);
        }

        if ($action === 'start') {
            $updateData = [
                'status' => 'live',
                'actual_start' => now()
            ];

            // Start recording if enabled
            if ($session->recording_enabled && config('agora.enable_recording', false)) {
                $recordingResult = $this->agoraService->startRecording(
                    'fitarena_session_' . $session->id,
                    $instructor->id
                );
                
                if ($recordingResult['success']) {
                    $updateData['recording_status'] = 'recording';
                }
            }

            $session->update($updateData);
            
            return response()->json([
                'success' => true,
                'status' => 'live',
                'message' => 'FitArena session started successfully'
            ]);
        }
        
        if ($action === 'end') {
            $updateData = [
                'status' => 'ended',
                'actual_end' => now()
            ];

            // Stop recording if it was started
            if ($session->recording_status === 'recording') {
                $recordingResult = $this->agoraService->stopRecording(
                    'fitarena_session_' . $session->id,
                    $session->id
                );
                
                if ($recordingResult['success']) {
                    $updateData['recording_status'] = 'completed';
                    $updateData['recording_url'] = $recordingResult['recording_url'] ?? null;
                    $updateData['recording_duration'] = $recordingResult['duration'] ?? null;
                    $updateData['recording_file_size'] = $recordingResult['file_size'] ?? null;
                }
            }

            $session->update($updateData);
            
            return response()->json([
                'success' => true,
                'status' => 'ended',
                'message' => 'FitArena session ended successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid action'
        ], 400);
    }
}
