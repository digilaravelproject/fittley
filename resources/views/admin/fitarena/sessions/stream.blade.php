@extends('layouts.admin')

@section('title', 'Stream FitArena Session')

@section('content')
<div class="container-fluid p-0" style="height: 100vh;">
    <div class="d-flex flex-column h-100">
        <!-- Header -->
        <div class="bg-dark text-white p-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">{{ $session->title }}</h5>
                <small class="text-muted">{{ $event->title }}</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span id="stream-status" class="badge bg-secondary">{{ ucfirst($session->status) }}</span>
                <span id="viewer-count" class="text-muted">0 viewers</span>
                <div class="btn-group" role="group">
                    <button type="button" id="start-stream-btn" class="btn btn-success btn-sm">
                        <i class="fas fa-play"></i> Start Stream
                    </button>
                    <button type="button" id="end-stream-btn" class="btn btn-danger btn-sm" style="display: none;">
                        <i class="fas fa-stop"></i> End Stream
                    </button>
                </div>
                <a href="{{ route('admin.fitarena.show', $event->id) }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Event
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 d-flex">
            <!-- Video Area -->
            <div class="flex-grow-1 bg-black position-relative">
                <div id="video-container" class="w-100 h-100 d-flex align-items-center justify-content-center">
                    <div id="stream-placeholder" class="text-center text-white">
                        <i class="fas fa-video fa-3x mb-3"></i>
                        <h4>FitArena Live Stream</h4>
                        <p class="text-muted">Click "Start Stream" to begin broadcasting</p>
                    </div>
                </div>
                
                <!-- Stream Controls -->
                <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <button type="button" id="toggle-audio" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-microphone"></i>
                            </button>
                            <button type="button" id="toggle-video" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-video"></i>
                            </button>
                            <button type="button" id="share-screen" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-desktop"></i> Share Screen
                            </button>
                        </div>
                        <div class="text-white">
                            <i class="fas fa-circle text-danger me-1"></i>
                            <span id="stream-timer">00:00:00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Panel -->
            <div class="bg-dark text-white" style="width: 350px;">
                <div class="p-3">
                    <h6 class="border-bottom border-secondary pb-2 mb-3">Session Information</h6>
                    
                    <div class="mb-3">
                        <strong>Event:</strong><br>
                        <span class="text-muted">{{ $event->title }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Session:</strong><br>
                        <span class="text-muted">{{ $session->title }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Scheduled Time:</strong><br>
                        <span class="text-muted">{{ $session->scheduled_start->format('M j, Y g:i A') }}</span>
                    </div>
                    
                    @if($session->speakers)
                    <div class="mb-3">
                        <strong>Speakers:</strong><br>
                        @foreach($session->speakers as $speaker)
                            <span class="badge bg-primary me-1">{{ $speaker['name'] }}</span>
                        @endforeach
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <strong>Status:</strong><br>
                        <span class="badge bg-{{ $session->status_color }}">{{ ucfirst($session->status) }}</span>
                    </div>
                    
                    @if($session->recording_enabled)
                    <div class="mb-3">
                        <strong>Recording:</strong><br>
                        <span class="text-success">
                            <i class="fas fa-record-vinyl"></i> Enabled
                        </span>
                    </div>
                    @endif
                </div>
                
                <!-- Stream Statistics -->
                <div class="border-top border-secondary p-3">
                    <h6 class="mb-3">Stream Statistics</h6>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border border-secondary rounded p-2 mb-2">
                                <div class="text-primary h5 mb-0" id="current-viewers">0</div>
                                <small class="text-muted">Live Viewers</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border border-secondary rounded p-2 mb-2">
                                <div class="text-warning h5 mb-0" id="peak-viewers">0</div>
                                <small class="text-muted">Peak Viewers</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="d-flex justify-content-between">
                            <span>Stream Quality:</span>
                            <span id="stream-quality" class="text-success">Good</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Bitrate:</span>
                            <span id="bitrate">-- kbps</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agora SDK -->
<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

<script>
// Configuration
const CONFIG = {
    session: {
        id: {{ $session->id }},
        status: '{{ $session->status }}'
    },
    agora: {
        appId: '{{ $streamingConfig['app_id'] }}',
        channel: '{{ $streamingConfig['channel'] }}',
        token: '{{ $streamingConfig['token'] }}',
        uid: {{ $streamingConfig['uid'] }}
    },
    csrf: '{{ csrf_token() }}'
};

// State
const STATE = {
    isStreaming: {{ $session->status === 'live' ? 'true' : 'false' }},
    client: null,
    localAudioTrack: null,
    localVideoTrack: null,
    screenTrack: null,
    isAudioEnabled: true,
    isVideoEnabled: true,
    streamStartTime: null,
    timerInterval: null
};

// Initialize Agora
async function initializeAgora() {
    try {
        STATE.client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
        STATE.client.setClientRole("host");
        
        // Event listeners
        STATE.client.on("user-joined", handleUserJoined);
        STATE.client.on("user-left", handleUserLeft);
        STATE.client.on("user-published", handleUserPublished);
        STATE.client.on("user-unpublished", handleUserUnpublished);
        
        console.log('✅ Agora client initialized');
    } catch (error) {
        console.error('❌ Failed to initialize Agora:', error);
        showNotification('Failed to initialize streaming', 'error');
    }
}

// Start streaming
async function startStream() {
    try {
        showNotification('Starting stream...', 'info');
        
        // Update session status
        const response = await fetch(`{{ route('admin.fitarena.sessions.stream-status', [$event->id, $session->id]) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CONFIG.csrf
            },
            body: JSON.stringify({ action: 'start' })
        });
        
        const result = await response.json();
        if (!result.success) {
            throw new Error(result.message || 'Failed to start stream');
        }
        
        // Join Agora channel
        await STATE.client.join(CONFIG.agora.appId, CONFIG.agora.channel, CONFIG.agora.token, CONFIG.agora.uid);
        
        // Create local tracks
        [STATE.localAudioTrack, STATE.localVideoTrack] = await AgoraRTC.createMicrophoneAndCameraTracks();
        
        // Play local video
        STATE.localVideoTrack.play("video-container");
        
        // Publish tracks
        await STATE.client.publish([STATE.localAudioTrack, STATE.localVideoTrack]);
        
        // Update UI
        updateStreamingUI(true);
        startTimer();
        
        showNotification('Stream started successfully!', 'success');
        
    } catch (error) {
        console.error('❌ Failed to start stream:', error);
        showNotification('Failed to start stream: ' + error.message, 'error');
    }
}

// End streaming
async function endStream() {
    try {
        showNotification('Ending stream...', 'info');
        
        // Stop local tracks
        if (STATE.localAudioTrack) {
            STATE.localAudioTrack.stop();
            STATE.localAudioTrack.close();
        }
        if (STATE.localVideoTrack) {
            STATE.localVideoTrack.stop();
            STATE.localVideoTrack.close();
        }
        if (STATE.screenTrack) {
            STATE.screenTrack.stop();
            STATE.screenTrack.close();
        }
        
        // Leave channel
        await STATE.client.leave();
        
        // Update session status
        const response = await fetch(`{{ route('admin.fitarena.sessions.stream-status', [$event->id, $session->id]) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CONFIG.csrf
            },
            body: JSON.stringify({ action: 'end' })
        });
        
        const result = await response.json();
        if (!result.success) {
            console.warn('Failed to update session status:', result.message);
        }
        
        // Update UI
        updateStreamingUI(false);
        stopTimer();
        
        showNotification('Stream ended successfully!', 'success');
        
    } catch (error) {
        console.error('❌ Failed to end stream:', error);
        showNotification('Failed to end stream: ' + error.message, 'error');
    }
}

// Toggle audio
async function toggleAudio() {
    if (STATE.localAudioTrack) {
        await STATE.localAudioTrack.setEnabled(!STATE.isAudioEnabled);
        STATE.isAudioEnabled = !STATE.isAudioEnabled;
        
        const btn = document.getElementById('toggle-audio');
        btn.innerHTML = STATE.isAudioEnabled ? 
            '<i class="fas fa-microphone"></i>' : 
            '<i class="fas fa-microphone-slash"></i>';
        btn.classList.toggle('btn-outline-light', STATE.isAudioEnabled);
        btn.classList.toggle('btn-outline-danger', !STATE.isAudioEnabled);
    }
}

// Toggle video
async function toggleVideo() {
    if (STATE.localVideoTrack) {
        await STATE.localVideoTrack.setEnabled(!STATE.isVideoEnabled);
        STATE.isVideoEnabled = !STATE.isVideoEnabled;
        
        const btn = document.getElementById('toggle-video');
        btn.innerHTML = STATE.isVideoEnabled ? 
            '<i class="fas fa-video"></i>' : 
            '<i class="fas fa-video-slash"></i>';
        btn.classList.toggle('btn-outline-light', STATE.isVideoEnabled);
        btn.classList.toggle('btn-outline-danger', !STATE.isVideoEnabled);
    }
}

// Share screen
async function shareScreen() {
    try {
        if (!STATE.screenTrack) {
            STATE.screenTrack = await AgoraRTC.createScreenVideoTrack();
            await STATE.client.unpublish([STATE.localVideoTrack]);
            await STATE.client.publish([STATE.screenTrack]);
            
            STATE.screenTrack.play("video-container");
            
            const btn = document.getElementById('share-screen');
            btn.innerHTML = '<i class="fas fa-desktop"></i> Stop Sharing';
            btn.classList.add('btn-warning');
            btn.classList.remove('btn-outline-light');
        } else {
            await STATE.client.unpublish([STATE.screenTrack]);
            STATE.screenTrack.stop();
            STATE.screenTrack.close();
            STATE.screenTrack = null;
            
            await STATE.client.publish([STATE.localVideoTrack]);
            STATE.localVideoTrack.play("video-container");
            
            const btn = document.getElementById('share-screen');
            btn.innerHTML = '<i class="fas fa-desktop"></i> Share Screen';
            btn.classList.remove('btn-warning');
            btn.classList.add('btn-outline-light');
        }
    } catch (error) {
        console.error('❌ Screen sharing failed:', error);
        showNotification('Screen sharing failed: ' + error.message, 'error');
    }
}

// Update UI based on streaming state
function updateStreamingUI(isStreaming) {
    STATE.isStreaming = isStreaming;
    
    document.getElementById('start-stream-btn').style.display = isStreaming ? 'none' : 'inline-block';
    document.getElementById('end-stream-btn').style.display = isStreaming ? 'inline-block' : 'none';
    
    const statusBadge = document.getElementById('stream-status');
    statusBadge.textContent = isStreaming ? 'Live' : 'Scheduled';
    statusBadge.className = `badge bg-${isStreaming ? 'danger' : 'secondary'}`;
    
    if (!isStreaming) {
        document.getElementById('video-container').innerHTML = `
            <div id="stream-placeholder" class="text-center text-white">
                <i class="fas fa-video fa-3x mb-3"></i>
                <h4>FitArena Live Stream</h4>
                <p class="text-muted">Click "Start Stream" to begin broadcasting</p>
            </div>
        `;
    }
}

// Timer functions
function startTimer() {
    STATE.streamStartTime = Date.now();
    STATE.timerInterval = setInterval(updateTimer, 1000);
}

function stopTimer() {
    if (STATE.timerInterval) {
        clearInterval(STATE.timerInterval);
        STATE.timerInterval = null;
    }
    document.getElementById('stream-timer').textContent = '00:00:00';
}

function updateTimer() {
    if (STATE.streamStartTime) {
        const elapsed = Math.floor((Date.now() - STATE.streamStartTime) / 1000);
        const hours = Math.floor(elapsed / 3600);
        const minutes = Math.floor((elapsed % 3600) / 60);
        const seconds = elapsed % 60;
        
        document.getElementById('stream-timer').textContent = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
}

// Agora event handlers
function handleUserJoined(user, mediaType) {
    console.log('👤 User joined:', user.uid);
}

function handleUserLeft(user) {
    console.log('👤 User left:', user.uid);
}

function handleUserPublished(user, mediaType) {
    console.log('📺 User published:', user.uid, mediaType);
}

function handleUserUnpublished(user, mediaType) {
    console.log('📺 User unpublished:', user.uid, mediaType);
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    initializeAgora();
    
    document.getElementById('start-stream-btn').addEventListener('click', startStream);
    document.getElementById('end-stream-btn').addEventListener('click', endStream);
    document.getElementById('toggle-audio').addEventListener('click', toggleAudio);
    document.getElementById('toggle-video').addEventListener('click', toggleVideo);
    document.getElementById('share-screen').addEventListener('click', shareScreen);
});

// Handle page unload
window.addEventListener('beforeunload', function() {
    if (STATE.isStreaming) {
        endStream();
    }
});
</script>
@endsection
