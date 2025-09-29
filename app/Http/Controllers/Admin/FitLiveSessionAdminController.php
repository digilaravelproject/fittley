<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FitLiveSession;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Http\Requests\StoreFitLiveSessionRequest;
use App\Services\AgoraService;
use App\Events\FitLiveSessionStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FitLiveSessionAdminController extends Controller
{
    protected $agoraService;

    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FitLiveSession::with(['category', 'subCategory', 'instructor']);

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

        $sessions = $query->latest()->paginate(15);
        $categories = Category::orderBy('name')->get();

        return view('admin.fitlive.sessions.index', compact('sessions', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::with('category')->orderBy('name')->get();
        $instructors = User::role('instructor')->orderBy('name')->get();

        return view('admin.fitlive.sessions.create', compact('categories', 'subCategories', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFitLiveSessionRequest $request)
    {
        $data = $request->validated();
        
        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('fitlive/banners', 'public');
        }
        
        // Generate unique LiveKit room name (if still needed, though Agora is primary)
        $data['livekit_room'] = 'fitlive.' . Str::random(10);

        $session = FitLiveSession::create($data);

        return redirect()->route('admin.fitlive.sessions.index')
            ->with('success', 'FitLive session created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FitLiveSession $fitLiveSession)
    {
        $fitLiveSession->load(['category', 'subCategory', 'instructor', 'chatMessages' => function ($query) {
            $query->with('user')->latest()->limit(50);
        }]);

        $session = $fitLiveSession; // Alias for view compatibility

        return view('admin.fitlive.sessions.show', compact('session', 'fitLiveSession'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FitLiveSession $fitLiveSession)
    {
        $categories = Category::orderBy('name')->get();
        $subCategories = SubCategory::with('category')->orderBy('name')->get();
        $instructors = User::role('instructor')->orderBy('name')->get();
        $session = $fitLiveSession; // Alias for view compatibility

        return view('admin.fitlive.sessions.edit', compact('session', 'categories', 'subCategories', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFitLiveSessionRequest $request, $sessionId)
    {
        $fitLiveSession = FitLiveSession::findOrFail($sessionId);
        $data = $request->validated();
        
        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner if exists
            if ($fitLiveSession->banner_image && Storage::disk('public')->exists($fitLiveSession->banner_image)) {
                Storage::disk('public')->delete($fitLiveSession->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('fitlive/banners', 'public');
        }
        
        $fitLiveSession->update($data);

        return redirect()->route('admin.fitlive.sessions.index')
            ->with('success', 'FitLive session updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FitLiveSession $fitLiveSession)
    {
        if ($fitLiveSession->isLive()) {
            return redirect()->route('admin.fitlive.sessions.index')
                ->with('error', 'Cannot delete a live session. End the session first.');
        }

        $fitLiveSession->delete();

        return redirect()->route('admin.fitlive.sessions.index')
            ->with('success', 'FitLive session deleted successfully.');
    }

    /**
     * Start a live session
     */
    public function startSession(FitLiveSession $fitLiveSession)
    {
        if (!$fitLiveSession->isScheduled()) {
            return redirect()->back()
                ->with('error', 'Only scheduled sessions can be started.');
        }

        $fitLiveSession->update([
            'status' => 'live',
            'started_at' => now()
        ]);

        // Broadcast session status update
        broadcast(new FitLiveSessionStatusUpdated($fitLiveSession));

        return redirect()->route('admin.fitlive.sessions.stream', $fitLiveSession)
            ->with('success', 'Session started successfully.');
    }

    /**
     * End a live session
     */
    public function endSession(FitLiveSession $fitLiveSession)
    {
        if (!$fitLiveSession->isLive()) {
            return redirect()->back()
                ->with('error', 'Only live sessions can be ended.');
        }

        $fitLiveSession->update([
            'status' => 'ended',
            'ended_at' => now()
        ]);

        // Broadcast session status update
        broadcast(new FitLiveSessionStatusUpdated($fitLiveSession));

        return redirect()->route('admin.fitlive.sessions.show', $fitLiveSession)
            ->with('success', 'Session ended successfully.');
    }

    /**
     * Show clean Agora streaming interface
     */
    public function stream(FitLiveSession $fitLiveSession)
    {
        // Generate streaming configuration
        $streamingConfig = [
            'app_id' => config('agora.app_id'),
            'channel' => 'fitlive_' . $fitLiveSession->id,
            'token' => $this->agoraService->generateToken('fitlive_' . $fitLiveSession->id, auth()->id(), 'publisher'),
            'uid' => auth()->id(),
            'role' => 'publisher',
            'configured' => !empty(config('agora.app_id'))
        ];

        $session = $fitLiveSession; // Alias for view compatibility

        return view('admin.fitlive.sessions.stream', compact('session', 'streamingConfig'));
    }

    /**
     * Update stream status (start/end from streaming interface)
     */
    public function updateStream(Request $request, FitLiveSession $fitLiveSession, $action)
    {
        if ($action === 'start') {
            $updateData = [
                'status' => 'live',
                'started_at' => now()
            ];

            // Start recording if enabled
            if ($fitLiveSession->recording_enabled) {
                $recordingResult = $this->agoraService->startRecording(
                    'fitlive_' . $fitLiveSession->id,
                    auth()->id()
                );

                if ($recordingResult['success']) {
                    $updateData['recording_id'] = $recordingResult['recording_id'];
                    $updateData['recording_status'] = 'recording';
                }
            }

            $fitLiveSession->update($updateData);
            
            return response()->json([
                'success' => true,
                'status' => 'live',
                'message' => 'Stream started successfully',
                'recording_enabled' => $fitLiveSession->recording_enabled,
                'recording_status' => $fitLiveSession->recording_status ?? null
            ]);
        }
        
        if ($action === 'end') {
            $updateData = [
                'status' => 'ended',
                'ended_at' => now()
            ];

            // Stop recording if it was started
            if ($fitLiveSession->recording_enabled && $fitLiveSession->recording_id) {
                $recordingResult = $this->agoraService->stopRecording(
                    'fitlive_' . $fitLiveSession->id,
                    $fitLiveSession->recording_id
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

            $fitLiveSession->update($updateData);
            
            return response()->json([
                'success' => true,
                'status' => 'ended',
                'message' => 'Stream ended successfully',
                'recording_status' => $fitLiveSession->recording_status ?? null
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid action'
        ], 400);
    }
}
