<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FitNews;
use App\Services\AgoraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FitNewsController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fitNews = FitNews::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.fitnews.index', compact('fitNews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fitnews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,scheduled,live',
            'scheduled_at' => 'nullable|date|after:now',
            'recording_enabled' => 'boolean'
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('fitnews/thumbnails', 'public');
        }

        // Generate channel name
        $fitNews = FitNews::create($data);
        $fitNews->update(['channel_name' => $fitNews->generateChannelName()]);

        return redirect()->route('admin.fitnews.index')
            ->with('success', 'FitNews created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FitNews $fitNews)
    {
        return view('admin.fitnews.show', compact('fitNews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FitNews $fitNews)
    {
        return view('admin.fitnews.edit', compact('fitNews'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FitNews $fitNews)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,scheduled,live,ended',
            'scheduled_at' => 'nullable|date',
            'recording_enabled' => 'boolean'
        ]);

        $data = $request->all();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($fitNews->thumbnail) {
                Storage::disk('public')->delete($fitNews->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('fitnews/thumbnails', 'public');
        }

        $fitNews->update($data);

        return redirect()->route('admin.fitnews.index')
            ->with('success', 'FitNews updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FitNews $fitNews)
    {
        // Delete thumbnail
        if ($fitNews->thumbnail) {
            Storage::disk('public')->delete($fitNews->thumbnail);
        }

        $fitNews->delete();

        return redirect()->route('admin.fitnews.index')
            ->with('success', 'FitNews deleted successfully!');
    }

    /**
     * Show streaming interface
     */
    public function stream(FitNews $fitNews)
    {
        // Generate streaming configuration
        $streamingConfig = $this->agoraService->getStreamingConfig(
            $fitNews->id,
            Auth::id(),
            'publisher'
        );

        // Update the news with streaming config
        $fitNews->update([
            'streaming_config' => $streamingConfig,
            'channel_name' => $streamingConfig['channel']
        ]);

        return view('admin.fitnews.stream', compact('fitNews', 'streamingConfig'));
    }

    /**
     * Start streaming
     */
    public function startStream(FitNews $fitNews)
    {
        $updateData = [
            'status' => 'live',
            'started_at' => now()
        ];

        // Start recording if enabled
        if ($fitNews->recording_enabled) {
            $recordingResult = $this->agoraService->startRecording(
                $fitNews->channel_name,
                Auth::id()
            );

            if ($recordingResult['success']) {
                $updateData['recording_id'] = $recordingResult['recording_id'];
                $updateData['recording_status'] = 'recording';
            }
        }

        $fitNews->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Stream started successfully!',
            'status' => 'live',
            'recording_enabled' => $fitNews->recording_enabled,
            'recording_status' => $fitNews->recording_status ?? null
        ]);
    }

    /**
     * End streaming
     */
    public function endStream(FitNews $fitNews)
    {
        $updateData = [
            'status' => 'ended',
            'ended_at' => now()
        ];

        // Stop recording if it was started
        if ($fitNews->recording_enabled && $fitNews->recording_id) {
            $recordingResult = $this->agoraService->stopRecording(
                $fitNews->channel_name,
                $fitNews->recording_id
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

        $fitNews->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Stream ended successfully!',
            'status' => 'ended',
            'duration' => $fitNews->getDuration(),
            'recording_status' => $fitNews->recording_status ?? null
        ]);
    }

    /**
     * Update viewer count
     */
    public function updateViewerCount(Request $request, FitNews $fitNews)
    {
        $fitNews->update([
            'viewer_count' => $request->input('count', 0)
        ]);

        return response()->json(['success' => true]);
    }
} 