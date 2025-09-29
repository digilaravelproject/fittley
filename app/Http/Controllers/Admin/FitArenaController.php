<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FitArenaEvent;
use Illuminate\Http\Request;

class FitArenaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\FitArenaEvent::withCount(['stages', 'sessions']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by featured
        if ($request->has('featured')) {
            $query->where('is_featured', $request->featured === '1');
        }

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.fitarena.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructors = \App\Models\User::role('instructor')->get();
        return view('admin.fitarena.create', compact('instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:fitarena_events',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'event_type' => 'nullable|string|max:255',
            'rules' => 'nullable|string',
            'prizes' => 'nullable|string',
            'sponsors' => 'nullable|string',
            'status' => 'required|in:draft,upcoming,live,completed',
            'max_participants' => 'nullable|integer|min:1',
            'is_featured' => 'boolean',
            'registration_required' => 'boolean',
            'is_public' => 'boolean',
            'featured_image' => 'nullable|image|max:2048',
            'instructor_id' => 'nullable|exists:users,id',
        ]);

        try {

            $data = $request->only([
                'title', 'description', 'slug', 'start_date', 'end_date', 
                'location', 'event_type', 'rules', 'prizes', 'sponsors',
                'status', 'max_participants', 'is_featured','instructor_id'
            ]);
            

            // Log incoming data for debugging
            \Log::info('FitArena Event Creation Data:', $data);

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $data['banner_image'] = $request->file('featured_image')
                    ->store('fitarena/banners', 'public');
            }

            // Set visibility based on is_public checkbox
            $data['visibility'] = $request->boolean('is_public', true) ? 'public' : 'private';

            // Set defaults
            $data['peak_viewers'] = 0;
            $data['dvr_enabled'] = true;
            $data['dvr_hours'] = 24;
            $data['is_featured'] = $request->boolean('is_featured', false);
            $data['expected_viewers'] = $request->max_participants ?: 0;
            
            // Status mapping
            if ($data['status'] === 'draft') {
                $data['status'] = 'upcoming';
            }

            \Log::info('Final FitArena Event Data before creation:', $data);
            // echo'<pre>';print_r($data);die;
            $event = FitArenaEvent::create($data);

            // Create default stage
            $stage = $event->stages()->create([
                'name' => 'Main Stage',
                'description' => 'Main stage for ' . $event->title,
                'is_primary' => true,
                'sort_order' => 1
            ]);

            // Create default session (always)
            $speakers = [];
            if ($request->instructor_id) {
                $instructor = \App\Models\User::find($request->instructor_id);
                $speakers = [[
                    'name' => $instructor->name,
                    'role' => 'Instructor',
                    'user_id' => $instructor->id
                ]];
            }
            
            $session = $event->sessions()->create([
                'stage_id' => $stage->id,
                'title' => $event->title . ' - Live Session',
                'description' => $event->description,
                'speakers' => $speakers,
                'scheduled_start' => $event->start_date,
                'scheduled_end' => $event->end_date ?: $event->start_date->addHours(2),
                'status' => 'scheduled',
                'session_type' => 'live_session',
                'recording_enabled' => true
            ]);

            \Log::info('FitArena Event created successfully:', ['id' => $event->id, 'title' => $event->title]);

            return redirect()->route('admin.fitarena.show', $event->id)
                ->with('success', 'Event created successfully!');

        } catch (\Exception $e) {
            \Log::error('FitArena Event Creation Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'Error creating event: ' . $e->getMessage())
                ->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(FitArenaEvent $event)
    {
        $event->load(['stages', 'sessions'])
            ->loadCount(['stages', 'sessions']);

        return view('admin.fitarena.show', compact('event'));
    }


    public function edit(FitArenaEvent $event)
    {
        $instructors = \App\Models\User::role('instructor')->get();
        
        // Get current instructor from first session if exists
        $currentInstructorId = null;
        $firstSession = $event->sessions()->first();
        if ($firstSession && $firstSession->speakers) {
            $speaker = collect($firstSession->speakers)->first(function($speaker) {
                return isset($speaker['user_id']);
            });
            $currentInstructorId = $speaker['user_id'] ?? null;
        }
        
        return view('admin.fitarena.edit', compact('event', 'instructors', 'currentInstructorId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FitArenaEvent $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:fitarena_events,slug,' . $event->id,
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'location' => 'nullable|string|max:255',
            'visibility' => 'required|in:public,private',
            'dvr_enabled' => 'boolean',
            'dvr_hours' => 'nullable|integer|min:1|max:168',
            'organizers' => 'nullable|string',
            'expected_viewers' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'banner_image' => 'nullable|image|max:2048',
            'logo' => 'nullable|image|max:2048',
            'instructor_id' => 'nullable|exists:users,id',
        ]);

        try {
            $data = $request->only([
                'title', 'description', 'slug', 'start_date', 'end_date', 
                'location', 'visibility', 'expected_viewers', 'is_featured'
            ]);

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                if ($event->banner_image && \Storage::disk('public')->exists($event->banner_image)) {
                    \Storage::disk('public')->delete($event->banner_image);
                }
                $data['banner_image'] = $request->file('banner_image')->store('fitarena/banners', 'public');
            }

            // Handle logo upload
            if ($request->hasFile('logo')) {
                if ($event->logo && \Storage::disk('public')->exists($event->logo)) {
                    \Storage::disk('public')->delete($event->logo);
                }
                $data['logo'] = $request->file('logo')->store('fitarena/logos', 'public');
            }

            // Process organizers JSON
            if ($request->organizers) {
                $organizers = [];
                $organizerLines = explode("\n", $request->organizers);
                foreach ($organizerLines as $line) {
                    $line = trim($line);
                    if ($line) {
                        $parts = explode('|', $line, 2);
                        $organizers[] = [
                            'name' => trim($parts[0]),
                            'role' => isset($parts[1]) ? trim($parts[1]) : 'Organizer'
                        ];
                    }
                }
                $data['organizers'] = $organizers;
            }

            // Handle settings
            $data['dvr_enabled'] = $request->boolean('dvr_enabled', false);
            $data['dvr_hours'] = $request->dvr_hours ?: 24;
            $data['is_featured'] = $request->boolean('is_featured', false);

            $event->update($data);

            // Handle instructor assignment changes
            $instructorId = $request->input('instructor_id');
            $firstSession = $event->sessions()->first();
            
            if ($firstSession) {
                if ($instructorId) {
                    // Assign instructor to session
                    $instructor = \App\Models\User::find($instructorId);
                    $speakers = [[
                        'name' => $instructor->name,
                        'role' => 'Instructor',
                        'user_id' => $instructor->id
                    ]];
                } else {
                    // Remove instructor assignment
                    $speakers = [];
                }
                
                $firstSession->update([
                    'speakers' => $speakers
                ]);
            }

            return redirect()->route('admin.fitarena.show', $event->id)
                ->with('success', 'Event updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating event: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FitArenaEvent $event)
    {
        try {
            // Delete associated images
            if ($event->banner_image && \Storage::disk('public')->exists($event->banner_image)) {
                \Storage::disk('public')->delete($event->banner_image);
            }
            if ($event->logo && \Storage::disk('public')->exists($event->logo)) {
                \Storage::disk('public')->delete($event->logo);
            }

            // Delete the event (cascade will handle stages and sessions)
            $event->delete();
            
            return redirect()->route('admin.fitarena.index')
                ->with('success', 'Event deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting event: ' . $e->getMessage());
        }
    }

    /**
     * Display stages for the specified event.
     */
    public function stages($eventId)
    {
        // TODO: Implement stages listing
        return view('admin.fitarena.stages', compact('eventId'));
    }

    /**
     * Show the form for creating a new stage.
     */
    public function createStage($eventId)
    {
        // TODO: Implement stage creation form
        return view('admin.fitarena.stages.create', compact('eventId'));
    }

    /**
     * Store a newly created stage.
     */
    public function storeStage(Request $request, $eventId)
    {
        // TODO: Implement stage storage
        return redirect()->route('admin.fitarena.stages', $eventId)
            ->with('success', 'Stage created successfully!');
    }

    /**
     * Show the form for editing a stage.
     */
    public function editStage($eventId, $stageId)
    {
        // TODO: Implement stage edit form
        return view('admin.fitarena.stages.edit', compact('eventId', 'stageId'));
    }

    /**
     * Update the specified stage.
     */
    public function updateStage(Request $request, $eventId, $stageId)
    {
        // TODO: Implement stage update
        return redirect()->route('admin.fitarena.stages', $eventId)
            ->with('success', 'Stage updated successfully!');
    }

    /**
     * Remove the specified stage.
     */
    public function destroyStage($eventId, $stageId)
    {
        // TODO: Implement stage deletion
        return redirect()->route('admin.fitarena.stages', $eventId)
            ->with('success', 'Stage deleted successfully!');
    }

    /**
     * Display sessions for the specified event.
     */
    public function sessions($eventId)
    {
        // TODO: Implement sessions listing
        return view('admin.fitarena.sessions', compact('eventId'));
    }

    /**
     * Show the form for creating a new session.
     */
    public function createSession($eventId)
    {
        // TODO: Implement session creation form
        return view('admin.fitarena.sessions.create', compact('eventId'));
    }

    /**
     * Store a newly created session.
     */
    public function storeSession(Request $request, $eventId)
    {
        // TODO: Implement session storage
        return redirect()->route('admin.fitarena.sessions', $eventId)
            ->with('success', 'Session created successfully!');
    }

    /**
     * Show the form for editing a session.
     */
    public function editSession($eventId, $sessionId)
    {
        // TODO: Implement session edit form
        return view('admin.fitarena.sessions.edit', compact('eventId', 'sessionId'));
    }

    /**
     * Update the specified session.
     */
    public function updateSession(Request $request, $eventId, $sessionId)
    {
        // TODO: Implement session update
        return redirect()->route('admin.fitarena.sessions', $eventId)
            ->with('success', 'Session updated successfully!');
    }

    /**
     * Remove the specified session.
     */
    public function destroySession($eventId, $sessionId)
    {
        // TODO: Implement session deletion
        return redirect()->route('admin.fitarena.sessions', $eventId)
            ->with('success', 'Session deleted successfully!');
    }

    /**
     * Show bulk session creation form.
     */
    public function bulkCreateSessions($eventId)
    {
        // TODO: Implement bulk session creation
        return view('admin.fitarena.sessions.bulk-create', compact('eventId'));
    }

    /**
     * Store bulk sessions.
     */
    public function storeBulkSessions(Request $request, $eventId)
    {
        // TODO: Implement bulk session storage
        return redirect()->route('admin.fitarena.sessions', $eventId)
            ->with('success', 'Sessions created successfully!');
    }

    /**
     * Show streaming interface for a session
     */
    public function streamSession($eventId, $sessionId)
    {
        $event = \App\Models\FitArenaEvent::findOrFail($eventId);
        $session = \App\Models\FitArenaSession::where('event_id', $eventId)
            ->findOrFail($sessionId);
        
        // Verify admin or assigned instructor access
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin');
        $isAssignedInstructor = collect($session->speakers)->contains('user_id', $user->id);
        
        if (!$isAdmin && !$isAssignedInstructor) {
            abort(403, 'You are not authorized to stream this session.');
        }
        
        // Get Agora configuration
        $agoraService = app(\App\Services\AgoraService::class);
        $streamingConfig = [
            'app_id' => config('agora.app_id'),
            'channel' => 'fitarena_session_' . $session->id,
            'token' => $agoraService->generateToken('fitarena_session_' . $session->id, auth()->id(), 'publisher'),
            'uid' => auth()->id(),
            'role' => 'publisher',
            'configured' => !empty(config('agora.app_id'))
        ];
        
        return view('admin.fitarena.sessions.stream', compact('event', 'session', 'streamingConfig'));
    }

    /**
     * Update streaming status for a session
     */
    public function updateStreamStatus(Request $request, $eventId, $sessionId)
    {
        $request->validate([
            'action' => 'required|in:start,end'
        ]);

        $session = \App\Models\FitArenaSession::where('event_id', $eventId)
            ->findOrFail($sessionId);
        $action = $request->input('action');

        // Verify admin or assigned instructor access
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin');
        $isAssignedInstructor = collect($session->speakers)->contains('user_id', $user->id);
        
        if (!$isAdmin && !$isAssignedInstructor) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to manage this session.'
            ], 403);
        }

        // Start Agora recording if configured
        $agoraService = app(\App\Services\AgoraService::class);

        if ($action === 'start') {
            $updateData = [
                'status' => 'live',
                'actual_start' => now()
            ];

            // Start recording if enabled
            if ($session->recording_enabled && config('agora.enable_recording', false)) {
                $recordingResult = $agoraService->startRecording(
                    'fitarena_session_' . $session->id,
                    auth()->id()
                );
                
                if ($recordingResult['success']) {
                    $updateData['recording_status'] = 'recording';
                }
            }

            $session->update($updateData);
            
            return response()->json([
                'success' => true,
                'status' => 'live',
                'message' => 'Stream started successfully'
            ]);
        }
        
        if ($action === 'end') {
            $updateData = [
                'status' => 'ended',
                'actual_end' => now()
            ];

            // Stop recording if it was started
            if ($session->recording_status === 'recording') {
                $recordingResult = $agoraService->stopRecording(
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
                'message' => 'Stream ended successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid action'
        ], 400);
    }
} 