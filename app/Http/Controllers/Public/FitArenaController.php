<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FitArenaEvent;
use App\Models\FitArenaSession;
use App\Services\AgoraService;
use Illuminate\Http\Request;

class FitArenaController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    /**
     * Show FitArena events index page
     */
    public function index()
    {
        // Get live events
        $liveEvents = FitArenaEvent::with(['sessions' => function($query) {
                $query->where('status', 'live');
            }])
            ->where('status', 'live')
            ->where('visibility', 'public')
            ->orderBy('start_date', 'desc')
            ->get();

        // Get upcoming events
        $upcomingEvents = FitArenaEvent::where('status', 'upcoming')
            ->where('visibility', 'public')
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->take(6)
            ->get();

        // Get recent ended events
        $recentEvents = FitArenaEvent::where('status', 'ended')
            ->where('visibility', 'public')
            ->orderBy('end_date', 'desc')
            ->take(6)
            ->get();

        // Get featured events
        $featuredEvents = FitArenaEvent::where('is_featured', true)
            ->where('visibility', 'public')
            ->orderBy('start_date', 'desc')
            ->take(4)
            ->get();

        // Get first live event for hero section
        $heroEvent = $liveEvents->first();

        return view('public.fitarena.index', compact(
            'liveEvents',
            'upcomingEvents', 
            'recentEvents',
            'featuredEvents',
            'heroEvent'
        ));
    }

    /**
     * Show specific FitArena event page
     */
    public function event(FitArenaEvent $event)
    {
        // Load relationships
        $event->load(['stages', 'sessions']);

        // Get current live sessions
        $liveSessions = $event->sessions()
            ->where('status', 'live')
            ->with(['stage'])
            ->get();

        // Get upcoming sessions
        $upcomingSessions = $event->sessions()
            ->where('status', 'scheduled')
            ->where('scheduled_start', '>', now())
            ->with(['stage'])
            ->orderBy('scheduled_start', 'asc')
            ->get();

        return view('public.fitarena.event', compact('event', 'liveSessions', 'upcomingSessions'));
    }

    /**
     * Show specific FitArena session page (similar to FitLive but without chat)
     */
    public function session($eventId, FitArenaSession $session)
    {
        // Load relationships
        $session->load('event', 'stage');

        // Generate streaming configuration only if session is live
        $streamingConfig = null;
        if ($session->isLive()) {
            $viewerId = auth()->check() ? auth()->id() : rand(100000, 999999);
            
            $streamingConfig = [
                'app_id' => config('agora.app_id'),
                'channel' => 'fitarena_session_' . $session->id,
                'token' => $this->agoraService->generateToken('fitarena_session_' . $session->id, $viewerId, 'subscriber'),
                'uid' => $viewerId,
                'role' => 'subscriber',
                'configured' => !empty(config('agora.app_id'))
            ];
        }

        return view('public.fitarena.session', compact('session', 'streamingConfig'));
    }
}