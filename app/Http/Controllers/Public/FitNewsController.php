<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FitNews;
use App\Services\AgoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FitNewsController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    /**
     * Display a listing of live and upcoming news streams
     */
    public function index()
    {
        $liveStreams = FitNews::where('status', 'live')
            ->with('creator')
            ->orderBy('started_at', 'desc')
            ->get();

        $upcomingStreams = FitNews::where('status', 'scheduled')
            ->with('creator')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        $pastStreams = FitNews::where('status', 'ended')
            ->with('creator')
            ->orderBy('ended_at', 'desc')
            ->limit(10)
            ->get();

        return view('public.fitnews.index', compact('liveStreams', 'upcomingStreams', 'pastStreams'));
    }

    /**
     * Show the specified news stream
     */
    public function show(FitNews $fitNews)
    {
        // Generate viewer token if stream is live
        $streamingConfig = null;
        if ($fitNews->isLive()) {
            $streamingConfig = $this->agoraService->getStreamingConfig(
                $fitNews->id,
                Auth::id() ?? 0, // Use 0 for anonymous users
                'subscriber'
            );
        }

        return view('public.fitnews.show', compact('fitNews', 'streamingConfig'));
    }

    /**
     * Join a live stream as viewer
     */
    public function joinStream(FitNews $fitNews)
    {
        if (!$fitNews->isLive()) {
            return response()->json([
                'success' => false,
                'message' => 'Stream is not currently live'
            ], 400);
        }

        // Generate viewer token
        $streamingConfig = $this->agoraService->getStreamingConfig(
            $fitNews->id,
            Auth::id() ?? rand(1000, 9999), // Random ID for anonymous users
            'subscriber'
        );

        // Increment viewer count
        $fitNews->increment('viewer_count');

        return response()->json([
            'success' => true,
            'config' => $streamingConfig,
            'viewer_count' => $fitNews->viewer_count
        ]);
    }

    /**
     * Leave a stream (decrement viewer count)
     */
    public function leaveStream(FitNews $fitNews)
    {
        if ($fitNews->viewer_count > 0) {
            $fitNews->decrement('viewer_count');
        }

        return response()->json([
            'success' => true,
            'viewer_count' => $fitNews->viewer_count
        ]);
    }

    /**
     * Get current stream status
     */
    public function getStreamStatus(FitNews $fitNews)
    {
        return response()->json([
            'status' => $fitNews->status,
            'viewer_count' => $fitNews->viewer_count,
            'is_live' => $fitNews->isLive(),
            'started_at' => $fitNews->started_at,
            'duration' => $fitNews->getDuration()
        ]);
    }
}
