@extends('layouts.public')

@section('title', $session->title . ' - FitArena')

@section('content')
<div class="container-fluid p-0" style="height: 100vh;">
    <div class="row g-0 h-100">
        <!-- Main Video Area -->
        <div class="col-lg-12">
            <div class="video-container bg-black position-relative h-100">
                @if($session->isLive() && $streamingConfig)
                    <!-- Live Stream -->
                    <div id="remote-video-container" class="w-100 h-100"></div>
                    
                    <!-- Stream Info Overlay -->
                    <div class="position-absolute top-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger me-3">
                                        <i class="fas fa-circle pulse me-1"></i>LIVE
                                    </span>
                                    <div>
                                        <h5 class="mb-1">{{ $session->title }}</h5>
                                        <small class="text-muted">{{ $session->event->title }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="d-flex align-items-center justify-content-end gap-3">
                                    <span class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        <span id="viewer-count">{{ $session->viewer_count ?? 0 }}</span> viewers
                                    </span>
                                    <button class="btn btn-outline-light btn-sm" onclick="toggleFullscreen()">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stream Controls -->
                    <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                @if($session->speakers)
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">Speakers:</strong>
                                        @foreach($session->speakers as $speaker)
                                            <span class="badge bg-primary me-1">{{ $speaker['name'] }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <button class="btn btn-outline-light btn-sm" onclick="shareStream()">
                                        <i class="fas fa-share"></i> Share
                                    </button>
                                    <div class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        <span id="stream-duration">--:--:--</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Not Live -->
                    <div class="d-flex align-items-center justify-content-center h-100 text-white text-center">
                        <div>
                            @if($session->status === 'scheduled')
                                <i class="fas fa-clock fa-3x mb-3 text-warning"></i>
                                <h3>Session Scheduled</h3>
                                <p class="text-muted">This session will start at:</p>
                                <h4 class="text-warning">{{ $session->scheduled_start->format('M j, Y \a\t g:i A') }}</h4>
                                @if($session->scheduled_start->isFuture())
                                    <p class="text-muted">
                                        <i class="fas fa-hourglass-half me-1"></i>
                                        Starts {{ $session->scheduled_start->diffForHumans() }}
                                    </p>
                                @endif
                            @elseif($session->status === 'ended')
                                <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                                <h3>Session Ended</h3>
                                <p class="text-muted">This session has finished.</p>
                                @if($session->replay_available && $session->recording_url)
                                    <a href="{{ $session->recording_url }}" class="btn btn-primary">
                                        <i class="fas fa-play me-2"></i>Watch Replay
                                    </a>
                                @endif
                            @else
                                <i class="fas fa-video fa-3x mb-3 text-muted"></i>
                                <h3>Session Not Available</h3>
                                <p class="text-muted">This session is currently not streaming.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Session Details Panel (collapsible on mobile) -->
    <div class="session-details bg-dark text-white">
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-md-8">
                    <h4>{{ $session->title }}</h4>
                    <p class="text-muted mb-2">{{ $session->description }}</p>
                    
                    <div class="row g-3 text-sm">
                        <div class="col-md-3">
                            <strong>Event:</strong><br>
                            <a href="{{ route('fitarena.event', $session->event->slug) }}" class="text-decoration-none">
                                {{ $session->event->title }}
                            </a>
                        </div>
                        <div class="col-md-3">
                            <strong>Stage:</strong><br>
                            <span class="text-muted">{{ $session->stage->name ?? 'Main Stage' }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong><br>
                            <span class="badge bg-{{ $session->status_color }}">{{ ucfirst($session->status) }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Duration:</strong><br>
                            <span class="text-muted">{{ $session->getFormattedScheduledDuration() }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="d-flex justify-content-end gap-2">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Watch
                            </a>
                        @else
                            @if(!auth()->user()->hasActiveSubscription())
                                <a href="{{ route('subscription.plans') }}" class="btn btn-warning">
                                    <i class="fas fa-crown me-2"></i>Subscribe to Watch
                                </a>
                            @endif
                        @endguest
                        
                        <button class="btn btn-outline-light" onclick="shareStream()">
                            <i class="fas fa-share me-2"></i>Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($session->isLive() && $streamingConfig)
<!-- Agora SDK -->
<script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

<script>
// Agora Configuration
const agoraConfig = {
    appId: '{{ $streamingConfig['app_id'] }}',
    channel: '{{ $streamingConfig['channel'] }}',
    token: '{{ $streamingConfig['token'] }}',
    uid: {{ $streamingConfig['uid'] }}
};

let client = null;
let isJoined = false;
let streamStartTime = null;

// Initialize Agora
async function initializeAgora() {
    try {
        client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
        client.setClientRole("audience");
        
        // Event listeners
        client.on("user-joined", handleUserJoined);
        client.on("user-left", handleUserLeft);
        client.on("user-published", handleUserPublished);
        client.on("user-unpublished", handleUserUnpublished);
        
        console.log('✅ Agora client initialized');
        
        // Auto-join the channel
        await joinStream();
        
    } catch (error) {
        console.error('❌ Failed to initialize Agora:', error);
        showNotification('Failed to connect to stream', 'error');
    }
}

// Join stream
async function joinStream() {
    try {
        if (isJoined) return;
        
        await client.join(agoraConfig.appId, agoraConfig.channel, agoraConfig.token, agoraConfig.uid);
        isJoined = true;
        streamStartTime = Date.now();
        
        console.log('✅ Joined stream successfully');
        updateStreamDuration();
        
    } catch (error) {
        console.error('❌ Failed to join stream:', error);
        showNotification('Failed to join stream: ' + error.message, 'error');
    }
}

// Leave stream
async function leaveStream() {
    try {
        if (client && isJoined) {
            await client.leave();
            isJoined = false;
            console.log('✅ Left stream successfully');
        }
    } catch (error) {
        console.error('❌ Failed to leave stream:', error);
    }
}

// Handle user published
async function handleUserPublished(user, mediaType) {
    console.log('📺 User published:', user.uid, mediaType);
    
    // Subscribe to remote user
    await client.subscribe(user, mediaType);
    
    if (mediaType === 'video') {
        // Play remote video
        const remoteVideoContainer = document.getElementById('remote-video-container');
        user.videoTrack.play(remoteVideoContainer);
    }
    
    if (mediaType === 'audio') {
        // Play remote audio
        user.audioTrack.play();
    }
}

// Handle user unpublished
function handleUserUnpublished(user, mediaType) {
    console.log('📺 User unpublished:', user.uid, mediaType);
}

// Handle user joined
function handleUserJoined(user, mediaType) {
    console.log('👤 User joined:', user.uid);
}

// Handle user left
function handleUserLeft(user) {
    console.log('👤 User left:', user.uid);
}

// Update stream duration
function updateStreamDuration() {
    if (!streamStartTime) return;
    
    setInterval(() => {
        const elapsed = Math.floor((Date.now() - streamStartTime) / 1000);
        const hours = Math.floor(elapsed / 3600);
        const minutes = Math.floor((elapsed % 3600) / 60);
        const seconds = elapsed % 60;
        
        const durationElement = document.getElementById('stream-duration');
        if (durationElement) {
            durationElement.textContent = 
                `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    }, 1000);
}

// Toggle fullscreen
function toggleFullscreen() {
    const videoContainer = document.querySelector('.video-container');
    
    if (!document.fullscreenElement) {
        videoContainer.requestFullscreen().catch(err => {
            console.error('Error entering fullscreen:', err);
        });
    } else {
        document.exitFullscreen();
    }
}

// Share stream
function shareStream() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $session->title }}',
            text: 'Check out this FitArena session!',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification("Session link copied to clipboard!", "success");
        });
    }
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
});

// Handle page unload
window.addEventListener('beforeunload', function() {
    leaveStream();
});

// Handle fullscreen changes
document.addEventListener('fullscreenchange', function() {
    const fullscreenBtn = document.querySelector('[onclick="toggleFullscreen()"] i');
    if (fullscreenBtn) {
        fullscreenBtn.className = document.fullscreenElement ? 'fas fa-compress' : 'fas fa-expand';
    }
});
</script>
@endif

<style>
.session-details {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transform: translateY(calc(100% - 60px));
    transition: transform 0.3s ease;
}

.session-details:hover {
    transform: translateY(0);
}

.session-details::before {
    content: '';
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 4px;
    background: rgba(255,255,255,0.5);
    border-radius: 2px;
}

.pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

@media (max-width: 768px) {
    .session-details {
        transform: translateY(calc(100% - 50px));
    }
}

.text-sm {
    font-size: 0.875rem;
}
</style>
@endsection
