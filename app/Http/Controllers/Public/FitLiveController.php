<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FitLiveSession;
use App\Models\FitFlixShorts;
use App\Models\FitFlixVideo;
use App\Models\PostLike;
use App\Models\SubCategory;
use App\Models\User;
use App\Services\AgoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FitLiveController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    public function index()
    {
        // Get live sessions
        $liveSessions = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('status', 'live')
            ->where('visibility', 'public')
            ->orderBy('scheduled_at', 'desc')
            ->get();


        $dailylive = SubCategory::where('category_id', 21)
            ->where('id', '!=', 17)
            ->orderBy('sort_order')
            ->get();

        // Get recent ended sessions
        $fitexpert = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('sub_category_id', 21)
            ->where('visibility', 'public')
            ->get();


        // Get categories with session counts
        $categories = Category::withCount('fitLiveSessions')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Get first live session for hero section
        $liveSession = $liveSessions->first();

        return view('public.fitlive.index', compact(
            'liveSessions',
            'dailylive',
            'categories',
            'fitexpert',
            'liveSession'
        ));
    }
    public function index_old()
    {
        // Get live sessions
        $liveSessions = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('status', 'live')
            ->where('visibility', 'public')
            ->orderBy('scheduled_at', 'desc')
            ->get();

        // Get upcoming sessions
        $upcomingSessions = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('status', 'scheduled')
            ->where('visibility', 'public')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->take(6)
            ->get();

        // Get recent ended sessions
        $recentSessions = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('status', 'ended')
            ->where('visibility', 'public')
            ->orderBy('updated_at', 'desc')
            ->take(6)
            ->get();


        // Get categories with session counts
        $categories = Category::withCount('fitLiveSessions')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Get first live session for hero section
        $liveSession = $liveSessions->first();

        return view('public.fitlive.index', compact(
            'liveSessions',
            'upcomingSessions',
            'recentSessions',
            'categories',
            'liveSession'
        ));
    }
    public function fitexpert()
    {
        $fitexpert = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('sub_category_id', 21)
            ->where('visibility', 'public')
            ->get();

        // Get categories with session counts
        $categories = Category::withCount('fitLiveSessions')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();


        return view('public.fitlive.fitexpert', compact(
            'categories',
            'fitexpert'
        ));
    }

    public function show_old($id)
    {
        // Fetch subcategories
        $subcategories = SubCategory::where('category_id', 21)
            ->where('id', '!=', 17)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'id']);

        $selectedSubcategory = $subcategories->firstWhere('id', $id);
        if (!$selectedSubcategory) {
            abort(404);
        }

        $now = Carbon::now();

        // Fetch all today sessions for the selected subcategory
        $sessions = FitLiveSession::liveToday()
            ->where('sub_category_id', $selectedSubcategory->id)
            ->orderBy('scheduled_at')
            ->get();

        // Find live session and upcoming sessions
        $liveSessionId = null;

        foreach ($sessions as $index => $session) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            $nextSession = $sessions->get($index + 1);
            $nextSessionTime = $nextSession ? Carbon::parse($nextSession->scheduled_at) : null;
            if ($now->gte($sessionTime)) {
                if ($nextSessionTime) {
                    // Show as live only if it's before the next session
                    if ($now->lt($nextSessionTime)) {
                        // But not more than 1 hour after start
                        if ($now->lte($sessionTime->copy()->addHour())) {
                            $liveSessionId = $session->id;
                            break;
                        }
                    }
                } else {
                    // No next session — show live only if within 1 hour
                    if ($now->lte($sessionTime->copy()->addHour())) {
                        $liveSessionId = $session->id;
                        break;
                    }
                }
            }
        }

        // Filter sessions to show only live session + upcoming sessions
        $filteredSessions = $sessions->filter(function ($session) use ($now, $liveSessionId) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            if ($session->id === $liveSessionId) {
                return true; // include live session
            }
            return $sessionTime->gte($now); // include upcoming sessions only
        })->values();

        // Prepare liveSlots
        $liveSlots = $filteredSessions->map(function ($session) use ($liveSessionId) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            return [
                'time' => $sessionTime->format('h:i A'),
                'is_live' => $session->id === $liveSessionId,
                'id' => $session->id,
                'title' => $session->title,
                'banner_image_url' => $session->banner_image_url,
            ];
        });

        // Active session is live session if found
        $activeSession = $sessions->firstWhere('id', $liveSessionId);

        // Instructor info
        $instructor = $activeSession ? User::find($activeSession->instructor_id) : null;


        // Archived sessions: today (excluding live/upcoming) + previous days
        $allPastSessions = FitLiveSession::where('sub_category_id', $selectedSubcategory->id)
            ->where('scheduled_at', '<', Carbon::now()) // Anything before now
            ->whereNotNull('ended_at')
            ->orderBy('ended_at', 'desc')
            ->get();

        // Filter out today’s sessions that are still live/upcoming
        $archivedSessions = $allPastSessions->filter(function ($session) use ($liveSlots) {
            // Skip if already shown as live/upcoming
            return !$liveSlots->contains('id', $session->id);
        });

        // Group by date (like 2025-09-26)
        $groupedArchived = $archivedSessions->groupBy(function ($session) {
            return Carbon::parse($session->scheduled_at)->format('Y-m-d');
        });

        return view('tools.active-session', [
            'subcategories' => $subcategories,
            'selectedSubcategory' => $selectedSubcategory,
            'activeSession' => $activeSession,
            'instructor' => $instructor,
            'liveSlots' => $liveSlots,
            'archivedSessions' => $archivedSessions,
            'groupedArchived' => $groupedArchived,
        ]);
    }

    public function show($id)
    {
        // Fetch subcategories
        $subcategories = SubCategory::where('category_id', 21)
            ->where('id', '!=', 17)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug']);

        $selectedSubcategory = $subcategories->firstWhere('id', $id);
        if (!$selectedSubcategory) {
            abort(404);
        }

        $now = Carbon::now();

        // Fetch all today sessions for the selected subcategory
        $sessions = FitLiveSession::liveToday()
            ->where('sub_category_id', $selectedSubcategory->id)
            ->orderBy('scheduled_at')
            ->get();

        // Find live session and upcoming sessions
        $liveSessionId = null;

        foreach ($sessions as $index => $session) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            $nextSession = $sessions->get($index + 1);
            $nextSessionTime = $nextSession ? Carbon::parse($nextSession->scheduled_at) : null;
            if ($now->gte($sessionTime)) {
                if ($nextSessionTime) {
                    // Show as live only if it's before the next session
                    if ($now->lt($nextSessionTime)) {
                        // But not more than 1 hour after start
                        if ($now->lte($sessionTime->copy()->addHour())) {
                            $liveSessionId = $session->id;
                            break;
                        }
                    }
                } else {
                    // No next session — show live only if within 1 hour
                    if ($now->lte($sessionTime->copy()->addHour())) {
                        $liveSessionId = $session->id;
                        break;
                    }
                }
            }
        }

        // Filter sessions to show only live session + upcoming sessions
        $filteredSessions = $sessions->filter(function ($session) use ($now, $liveSessionId) {
            $sessionTime = Carbon::parse($session->scheduled_at);
            if ($session->id === $liveSessionId) {
                return true; // include live session
            }
            // Include upcoming sessions
            if ($sessionTime->gte($now)) {
                return true;
            }

            // Include sessions earlier today (past but same day)
            if ($sessionTime->isSameDay($now)) {
                return true;
            }
        })->values();

        // Prepare liveSlots
        $liveSlots = $filteredSessions->map(function ($session) use ($liveSessionId) {
            $sessionTime = Carbon::parse($session->scheduled_at);

            $now = now();

            // Determine if this session is live
            $isLive = $session->id === $liveSessionId;

            // Determine if the session has fully passed (more than 1 hour ago)
            $isPassed = $sessionTime->copy()->addHour()->lt($now); // no mutation

            return [
                'time' => $sessionTime->format('h:i A'),
                'is_live' => $session->id === $liveSessionId,
                'id' => $session->id,
                'is_passed' => $isPassed,
                'title' => $session->title,
                'banner_image_url' => $session->banner_image_url,
            ];
        });

        // Active session is live session if found
        $activeSession = $sessions->firstWhere('id', $liveSessionId);

        // Instructor info
        $instructor = $activeSession ? User::find($activeSession->instructor_id) : null;

        // Archived sessions: today (excluding live/upcoming) + previous days
        $allPastSessions = FitLiveSession::where('sub_category_id', $selectedSubcategory->id)
            ->where('scheduled_at', '<', Carbon::now()) // Anything before now
            ->whereNotNull('ended_at')
            ->orderBy('ended_at', 'desc')
            ->get();

        // Filter out today’s sessions that are still live/upcoming
        $archivedSessions = $allPastSessions->filter(function ($session) use ($liveSlots) {
            // Skip if already shown as live/upcoming
            return !$liveSlots->contains('id', $session->id);
        });

        // Group by date (like 2025-09-26)
        $groupedArchived = $archivedSessions->groupBy(function ($session) {
            return Carbon::parse($session->scheduled_at)->format('Y-m-d');
        });

        // echo'<pre>';print_r($archivedSessions);die;

        return view('tools.active-session', [
            'subcategories' => $subcategories,
            'selectedSubcategory' => $selectedSubcategory,
            'activeSession' => $activeSession,
            'instructor' => $instructor,
            'liveSlots' => $liveSlots,
            'archivedSessions' => $archivedSessions,
            'groupedArchived' => $groupedArchived,
        ]);
    }

    /**
     * Show the fitflix shorts vdo resource.
     */
    public function fitflixShortsVdo_old()
    {
        $query = FitFlixShorts::with(['category', 'uploader'])->latest();
        $shorts = $query->get();

        return view('public.fitlive.vdo-shorts', compact('shorts'));
    }

    public function fitflixShortsVdo()
    {
        $user = auth()->user();

        $shorts = FitFlixShorts::with(['category', 'uploader'])
            ->latest()
            ->get()
            ->map(function ($short) use ($user) {
                // Check if current user liked this short
                $short->isLiked = $user
                    ? PostLike::where('post_type', 'fit_flix_video')
                    ->where('post_id', $short->id)
                    ->where('user_id', $user->id)
                    ->exists()
                    : false;

                // Count likes and shares
                $short->likes_counts = $short->likes()->count();
                $short->shares_counts = $short->shares_count;

                return $short;
            });

        return view('public.fitlive.vdo-shorts', compact('shorts'));
    }

    public function session($id)
    {
        $session = FitLiveSession::with('category', 'subCategory', 'instructor')->findOrFail($id);

        // Generate streaming configuration only if session is live
        $streamingConfig = null;
        if ($session->isLive()) {
            $viewerId = auth()->check() ? auth()->id() : rand(100000, 999999);

            $streamingConfig = [
                'app_id' => config('agora.app_id'),
                'channel' => 'fitlive_' . $session->id,
                'token' => $this->agoraService->generateToken('fitlive_' . $session->id, $viewerId, 'subscriber'),
                'uid' => $viewerId,
                'role' => 'subscriber',
                'configured' => !empty(config('agora.app_id'))
            ];
        }

        return view('public.fitlive.session', compact('session', 'streamingConfig'));
    }

    public function category(Category $category, Request $request)
    {
        $query = FitLiveSession::with(['category', 'subCategory', 'instructor'])
            ->where('category_id', $category->id)
            ->where('visibility', 'public');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Order by status priority and then by scheduled time
        $query->orderByRaw("
            CASE status
                WHEN 'live' THEN 1
                WHEN 'scheduled' THEN 2
                WHEN 'ended' THEN 3
            END
        ")
            ->orderBy('scheduled_at', 'desc');

        $sessions = $query->paginate(12);

        // Load category with subcategories
        $category->load('subCategories');

        return view('public.fitlive.category', compact('category', 'sessions'));
    }

    /**
     * Like/unlike a FitFlix video and return a view
     */
    public function toggleLike(FitFlixVideo $video, Request $request)
    {
        $user = Auth::user();

        // Toggle like
        $existingLike = PostLike::where('post_type', 'fit_flix_video')
            ->where('post_id', $video->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            // Remove like
            $existingLike->delete();
            $video->decrement('likes_count');
            $isLiked = false;
        } else {
            // Add new like
            PostLike::create([
                'post_type' => 'fit_flix_video',
                'post_id' => $video->id,
                'user_id' => $user->id
            ]);
            $video->increment('likes_count');
            $isLiked = true;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'is_liked' => $isLiked,
                'likes_count' => $video->fresh()->likes_count
            ]
        ]);
    }

    public function shareVideo($shortId)
    {
        try {
            // Find the short video
            $short = FitFlixShorts::findOrFail($shortId);

            // Increment share count
            $short->increment('shares_count');

            return response()->json([
                'success' => true,
                'data' => [
                    'video_id' => $short->id,
                    'share_link' => $this->generateShareLink($short),
                    'shares_count' => $short->fresh()->shares_count
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to share video',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateShareLink($video): string
    {
        return url("/fitflix/videos/{$video->id}");
    }
}
