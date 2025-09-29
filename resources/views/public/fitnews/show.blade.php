<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $fitNews->title }} - FitNews</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #000;
            color: #fff;
            overflow: hidden;
        }

        .blink {
            animation: blink-animation 1s steps(5, start) infinite;
        }

        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }

        /* Fullscreen video styling */
        #video-container {
            background: #000;
        }

        /* Overlay controls styling */
        .position-absolute .btn-outline-light {
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .position-absolute .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .position-absolute.top-0.start-0 .bg-dark {
                max-width: 250px;
                font-size: 0.9rem;
            }
            
            .position-absolute.top-0.start-0 h5 {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>

<div class="position-relative" style="height: 100vh; overflow: hidden;">
    <!-- Fullscreen Video Container -->
    <div id="video-container" class="position-absolute top-0 start-0 w-100 h-100 bg-dark">
        @if($fitNews->isLive() && $streamingConfig)
            <div id="remote-video" class="w-100 h-100"></div>
        @else
            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white">
                <div class="text-center">
                    @if($fitNews->thumbnail)
                        <img src="{{ asset('storage/app/public/' . $fitNews->thumbnail) }}" 
                             alt="Stream thumbnail" class="img-fluid rounded mb-3"
                             style="max-height: 400px;">
                    @else
                        <i class="fas fa-video fa-5x mb-3"></i>
                    @endif
                    <h4>
                        @if($fitNews->isScheduled())
                            Stream Scheduled
                        @elseif($fitNews->hasEnded())
                            Stream Ended
                        @else
                            Stream Not Live
                        @endif
                    </h4>
                    @if($fitNews->scheduled_at)
                        <p>Scheduled for: {{ $fitNews->scheduled_at->format('M d, Y H:i') }}</p>
                    @endif
                </div>
            </div>
        @endif
        
        <!-- Top Left Overlay - Live indicator & Stream Info -->
        <div class="position-absolute top-0 start-0 p-3" style="z-index: 5;">
            @if($fitNews->isLive())
                <div class="mb-2">
                    <span class="badge bg-danger fs-6">
                        <i class="fas fa-circle blink"></i> LIVE
                    </span>
                </div>
            @endif
            
            <div class="bg-dark bg-opacity-75 text-white p-3 rounded" style="max-width: 300px;">
                <h5 class="mb-1">{{ $fitNews->title }}</h5>
                <small class="d-block mb-1">
                    <i class="fas fa-user"></i> {{ $fitNews->creator->name }}
                </small>
                @if($fitNews->started_at)
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> Started {{ $fitNews->started_at->diffForHumans() }}
                    </small>
                @endif
            </div>
        </div>
        
        <!-- Top Right Overlay - Viewer count & Status -->
        <div class="position-absolute top-0 end-0 p-3" style="z-index: 5;">
            <div class="d-flex flex-column gap-2 align-items-end">
                <span class="badge bg-dark bg-opacity-75 fs-6">
                    <i class="fas fa-users"></i> <span id="viewer-count">{{ $fitNews->viewer_count }}</span>
                </span>
                <span id="stream-status" class="badge bg-{{ $fitNews->isLive() ? 'success' : ($fitNews->isScheduled() ? 'warning' : 'secondary') }} fs-6">
                    {{ ucfirst($fitNews->status) }}
                </span>
            </div>
        </div>

        <!-- Bottom Left Overlay - Connection Status & Controls -->
        <div class="position-absolute bottom-0 start-0 p-3" style="z-index: 5;">
            <div class="d-flex gap-2 align-items-center">
                <span id="connection-status" class="badge bg-info">
                    @if($fitNews->isLive() && $streamingConfig)
                        Connecting...
                    @else
                        Not Live
                    @endif
                </span>
                
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-light btn-sm" onclick="shareStream()">
                        <i class="fas fa-share"></i>
                    </button>
                    
                    <a href="{{ route('fitnews.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    
                    <button id="toggle-fullscreen" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@if($fitNews->isLive() && $streamingConfig)
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
let mediaEnabled = false;

// Initialize Agora
async function initializeAgora() {
    try {
        client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
        client.setClientRole("audience");
        
        // Handle autoplay policy
        AgoraRTC.onAutoplayFailed = () => {
            console.log("Autoplay failed, showing overlay");
            document.getElementById("audio-overlay").style.display = "flex";
        };
        
        // Handle remote user events
        client.on("user-published", async (user) => {
            console.log("User published:", user.uid);
            await subscribeToRemoteUser(user);
        });
        
        client.on("user-unpublished", (user, mediaType) => {
            console.log("User unpublished:", user.uid, mediaType);
            if (mediaType === "video") {
                updateConnectionStatus("Stream Ended", "secondary");
            }
        });
        
        client.on("connection-state-changed", (curState, revState) => {
            console.log("Connection state changed:", curState);
            updateConnectionStatus(curState, curState === "CONNECTED" ? "success" : "warning");
        });
        
        console.log("Agora client initialized");
        updateConnectionStatus("Initialized", "info");
        
    } catch (error) {
        console.error("Failed to initialize Agora:", error);
        updateConnectionStatus("Init Failed", "danger");
        showNotification("Failed to initialize stream viewer", "error");
    }
}

// Enable media and hide overlay
async function enableMedia() {
    try {
        mediaEnabled = true;
        document.getElementById("audio-overlay").style.display = "none";
        
        // Resume audio context if needed
        if (typeof AgoraRTC !== 'undefined') {
            await AgoraRTC.resumeAudioContext();
        }
        
        // Join stream automatically
        await joinStream();
        
    } catch (error) {
        console.error("Failed to enable media:", error);
        showNotification("Failed to enable media", "error");
    }
}

// Update connection status
function updateConnectionStatus(status, type) {
    const statusElement = document.getElementById("connection-status");
    if (statusElement) {
        statusElement.textContent = status;
        statusElement.className = `badge bg-${type}`;
    }
}

// Join stream
async function joinStream() {
    try {
        updateConnectionStatus("Connecting...", "warning");
        
        // Check if already joined
        if (isJoined) {
            console.log("Already joined stream");
            return;
        }
        
        await client.join(agoraConfig.appId, agoraConfig.channel, agoraConfig.token, agoraConfig.uid);
        isJoined = true;
        
        // 👉 Immediately subscribe to any users who were already publishing
        for (const remoteUser of client.remoteUsers) {
            await subscribeToRemoteUser(remoteUser);
        }
        
        updateConnectionStatus("Joined", "success");
        console.log("Joined stream successfully");
        
    } catch (error) {
        console.error("Failed to join stream:", error);
        updateConnectionStatus("Join Failed", "danger");
        showNotification("Failed to join stream: " + error.message, "error");
    }
}

// Leave stream
async function leaveStream() {
    try {
        if (isJoined) {
            await client.leave();
            isJoined = false;
        }
        
        updateConnectionStatus("Disconnected", "secondary");
        console.log("Left stream");
        
    } catch (error) {
        console.error("Failed to leave stream:", error);
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

// Share stream function
function shareStream() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $fitNews->title }}',
            text: 'Watch this live FitNews stream!',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            showNotification("Stream link copied to clipboard!", "success");
        });
    }
}

// Toggle fullscreen function
function toggleFullscreen() {
    const toggleBtn = document.getElementById("toggle-fullscreen");
    const icon = toggleBtn.querySelector("i");
    
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().then(() => {
            icon.className = "fas fa-compress";
        });
    } else {
        document.exitFullscreen().then(() => {
            icon.className = "fas fa-expand";
        });
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Agora
    initializeAgora();
    
    // Enable media button
    document.getElementById("enable-media-btn")?.addEventListener('click', enableMedia);
    
    // Fullscreen toggle
    document.getElementById("toggle-fullscreen")?.addEventListener('click', toggleFullscreen);
    
    // Auto-join stream after a delay (but keep overlay for user interaction)
    setTimeout(() => {
        if (!mediaEnabled) {
            // Try to join without audio first
            joinStream();
        }
    }, 2000);
});

// Handle page unload
window.addEventListener('beforeunload', function() {
    if (isJoined) {
        leaveStream();
    }
});

// Helper to subscribe & play a remote user's tracks
async function subscribeToRemoteUser(user) {
    try {
        // Video track
        if (user.hasVideo || user.videoTrack) {
            await client.subscribe(user, "video");
            user.videoTrack?.play("remote-video");
        }

        // Audio track (respect mute state)
        if (user.hasAudio || user.audioTrack) {
            await client.subscribe(user, "audio");
            if (mediaEnabled) {
                user.audioTrack?.play();
            }
        }
    } catch (err) {
        console.error("Failed subscribing to existing user", err);
    }
}
</script>
@endif

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html> 