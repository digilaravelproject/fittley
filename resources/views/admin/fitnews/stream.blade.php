@extends('layouts.admin')

@section('title', 'FitNews Stream - ' . $fitNews->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $fitNews->title }} - Streaming</h3>
                    <div class="d-flex gap-2">
                        <span class="badge bg-{{ $fitNews->isLive() ? 'success' : 'secondary' }} fs-6">
                            {{ ucfirst($fitNews->status) }}
                        </span>
                        <a href="{{ route('admin.fitnews.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Streaming Video Area -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Live Stream</h5>
                                </div>
                                <div class="card-body">
                                    <div id="video-container" class="position-relative bg-dark rounded" style="height: 400px;">
                                        <div id="local-video" class="w-100 h-100"></div>
                                    </div>
                                    
                                    <div class="mt-3 d-flex gap-2">
                                        <button id="start-stream" class="btn btn-success" {{ $fitNews->isLive() ? 'style=display:none' : '' }}>
                                            <i class="fas fa-play"></i> Start Stream
                                        </button>
                                        <button id="stop-stream" class="btn btn-danger" {{ !$fitNews->isLive() ? 'style=display:none' : '' }}>
                                            <i class="fas fa-stop"></i> End Stream
                                        </button>
                                        <button id="toggle-camera" class="btn btn-info">
                                            <i class="fas fa-video"></i> Camera
                                        </button>
                                        <button id="toggle-mic" class="btn btn-warning">
                                            <i class="fas fa-microphone"></i> Mic
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stream Info Panel -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Stream Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Title:</strong><br>
                                        {{ $fitNews->title }}
                                    </div>
                                    
                                    @if($fitNews->description)
                                    <div class="mb-3">
                                        <strong>Description:</strong><br>
                                        {{ $fitNews->description }}
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        <span id="stream-status" class="badge bg-{{ $fitNews->isLive() ? 'success' : 'secondary' }}">
                                            {{ ucfirst($fitNews->status) }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Viewers:</strong>
                                        <span id="viewer-count" class="badge bg-info">{{ $fitNews->viewer_count }}</span>
                                    </div>

                                    <!-- Recording Status -->
                                    <div class="mb-3">
                                        <strong>Recording:</strong>
                                        <span id="recording-status" class="badge bg-{{ $fitNews->recording_enabled ? ($fitNews->recording_status === 'recording' ? 'danger' : 'secondary') : 'dark' }}">
                                            @if($fitNews->recording_enabled)
                                                @if($fitNews->recording_status === 'recording')
                                                    <i class="fas fa-circle blink me-1"></i>Recording
                                                @elseif($fitNews->recording_status === 'completed')
                                                    <i class="fas fa-check me-1"></i>Completed
                                                @elseif($fitNews->recording_status === 'failed')
                                                    <i class="fas fa-exclamation-triangle me-1"></i>Failed
                                                @else
                                                    <i class="fas fa-video me-1"></i>Ready
                                                @endif
                                            @else
                                                <i class="fas fa-times me-1"></i>Disabled
                                            @endif
                                        </span>
                                    </div>

                                    @if($fitNews->started_at)
                                    <div class="mb-3">
                                        <strong>Started:</strong><br>
                                        <small>{{ $fitNews->started_at->format('M d, Y H:i:s') }}</small>
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Channel:</strong><br>
                                        <code>{{ $fitNews->channel_name }}</code>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Public URL:</strong><br>
                                        <a href="{{ route('fitnews.show', $fitNews) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt"></i> View Stream
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Technical Info -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6>Technical Details</h6>
                                </div>
                                <div class="card-body">
                                    <small>
                                        <strong>App ID:</strong> {{ $streamingConfig['app_id'] }}<br>
                                        <strong>Channel:</strong> {{ $streamingConfig['channel'] }}<br>
                                        <strong>Token:</strong> {{ $streamingConfig['configured'] ? 'Generated' : 'Not configured' }}<br>
                                        <strong>Role:</strong> {{ $streamingConfig['role'] }}
                                    </small>
                                </div>
                            </div>
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
// Agora Configuration
const agoraConfig = {
    appId: '{{ $streamingConfig['app_id'] }}',
    channel: '{{ $streamingConfig['channel'] }}',
    token: '{{ $streamingConfig['token'] }}',
    uid: {{ $streamingConfig['uid'] }}
};

let client = null;
let localTracks = {
    videoTrack: null,
    audioTrack: null
};
let isJoined = false;

// Initialize Agora
async function initializeAgora() {
    try {
        client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
        client.setClientRole("host");
        
        console.log("Agora client initialized");
        
        // Pre-load camera and microphone for better UX
        try {
            const tempAudio = await AgoraRTC.createMicrophoneAudioTrack();
            const tempVideo = await AgoraRTC.createCameraVideoTrack();
            
            // Show preview
            tempVideo.play("local-video");
            
            // Store for later use
            localTracks.audioTrack = tempAudio;
            localTracks.videoTrack = tempVideo;
            
            showNotification("Camera and microphone ready", "success");
            
        } catch (deviceError) {
            console.warn("Could not pre-load devices:", deviceError);
            showNotification("Camera/microphone access required for streaming", "warning");
        }
        
    } catch (error) {
        console.error("Failed to initialize Agora:", error);
        showNotification("Failed to initialize streaming", "error");
    }
}

// Join channel and start streaming
async function startStream() {
    try {
        showNotification("Starting stream...", "info");
        
        // Check if already joined
        if (isJoined) {
            showNotification("Already streaming!", "warning");
            return;
        }
        
        // Join the channel first
        await client.join(agoraConfig.appId, agoraConfig.channel, agoraConfig.token, agoraConfig.uid);
        isJoined = true;
        
        // Create tracks if not already created
        if (!localTracks.audioTrack) {
            localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
        }
        if (!localTracks.videoTrack) {
            localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();
            // Play local video
            localTracks.videoTrack.play("local-video");
        }
        
        // Publish tracks
        await client.publish([localTracks.audioTrack, localTracks.videoTrack]);
        
        // Update UI
        document.getElementById("start-stream").style.display = "none";
        document.getElementById("stop-stream").style.display = "inline-block";
        
        // Update stream status on server
        await updateStreamStatus('start');
        
        showNotification("Stream started successfully!", "success");
        
    } catch (error) {
        console.error("Failed to start stream:", error);
        showNotification("Failed to start stream: " + error.message, "error");
        
        // Reset UI on error
        document.getElementById("start-stream").style.display = "inline-block";
        document.getElementById("stop-stream").style.display = "none";
        isJoined = false;
    }
}

// Stop streaming
async function stopStream() {
    try {
        showNotification("Stopping stream...", "info");
        
        // Stop local tracks
        if (localTracks.audioTrack) {
            localTracks.audioTrack.stop();
            localTracks.audioTrack.close();
            localTracks.audioTrack = null;
        }
        if (localTracks.videoTrack) {
            localTracks.videoTrack.stop();
            localTracks.videoTrack.close();
            localTracks.videoTrack = null;
        }
        
        // Leave channel
        if (isJoined) {
            await client.leave();
            isJoined = false;
        }
        
        // Update UI
        document.getElementById("start-stream").style.display = "inline-block";
        document.getElementById("stop-stream").style.display = "none";
        
        // Update stream status on server
        await updateStreamStatus('end');
        
        showNotification("Stream ended successfully!", "success");
        
    } catch (error) {
        console.error("Failed to stop stream:", error);
        showNotification("Failed to stop stream: " + error.message, "error");
    }
}

// Toggle camera
async function toggleCamera() {
    if (localTracks.videoTrack) {
        const enabled = localTracks.videoTrack.enabled;
        await localTracks.videoTrack.setEnabled(!enabled);
        
        const button = document.getElementById("toggle-camera");
        button.innerHTML = enabled ? '<i class="fas fa-video-slash"></i> Camera Off' : '<i class="fas fa-video"></i> Camera';
        button.className = enabled ? 'btn btn-secondary' : 'btn btn-info';
    }
}

// Toggle microphone
async function toggleMic() {
    if (localTracks.audioTrack) {
        const enabled = localTracks.audioTrack.enabled;
        await localTracks.audioTrack.setEnabled(!enabled);
        
        const button = document.getElementById("toggle-mic");
        button.innerHTML = enabled ? '<i class="fas fa-microphone-slash"></i> Mic Off' : '<i class="fas fa-microphone"></i> Mic';
        button.className = enabled ? 'btn btn-secondary' : 'btn btn-warning';
    }
}

// Update stream status on server
async function updateStreamStatus(action) {
    try {
        const response = await fetch(`/admin/fitnews/{{ $fitNews->id }}/${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update status badge
            const statusBadge = document.getElementById('stream-status');
            if (action === 'start') {
                statusBadge.className = 'badge bg-success';
                statusBadge.textContent = 'Live';
            } else {
                statusBadge.className = 'badge bg-secondary';
                statusBadge.textContent = 'Ended';
            }
            
            // Update recording status if available
            if (data.recording_status) {
                const recordingBadge = document.getElementById('recording-status');
                if (data.recording_status === 'recording') {
                    recordingBadge.className = 'badge bg-danger';
                    recordingBadge.innerHTML = '<i class="fas fa-circle blink me-1"></i>Recording';
                } else if (data.recording_status === 'completed') {
                    recordingBadge.className = 'badge bg-success';
                    recordingBadge.innerHTML = '<i class="fas fa-check me-1"></i>Completed';
                } else if (data.recording_status === 'failed') {
                    recordingBadge.className = 'badge bg-warning';
                    recordingBadge.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Failed';
                }
            }
            
            console.log('Stream status updated:', data);
        } else {
            showNotification('Failed to update stream status', 'error');
        }
    } catch (error) {
        console.error('Error updating stream status:', error);
        showNotification('Error updating stream status', 'error');
    }
}

// Show notification
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    initializeAgora();
    
    document.getElementById("start-stream").addEventListener('click', startStream);
    document.getElementById("stop-stream").addEventListener('click', stopStream);
    document.getElementById("toggle-camera").addEventListener('click', toggleCamera);
    document.getElementById("toggle-mic").addEventListener('click', toggleMic);
    
    // Auto-start camera preview if stream is already live
    @if($fitNews->isLive())
        setTimeout(() => {
            startStream();
        }, 1000);
    @endif
});

// Handle page unload
window.addEventListener('beforeunload', function() {
    if (isJoined) {
        stopStream();
    }
});
</script>
@endsection

@push('styles')
<style>
.blink {
    animation: blink-animation 1s steps(5, start) infinite;
}

@keyframes blink-animation {
    to {
        visibility: hidden;
    }
}

.recording-indicator {
    color: #dc3545;
    font-weight: bold;
}
</style>
@endpush

@push('scripts')
<script>
// Update recording status in UI
function updateRecordingStatus(status) {
    const recordingStatusElement = document.getElementById('recording-status');
    if (!recordingStatusElement) return;
    
    recordingStatusElement.className = 'badge';
    
    switch(status) {
        case 'recording':
            recordingStatusElement.className += ' bg-danger';
            recordingStatusElement.innerHTML = '<i class="fas fa-circle blink me-1"></i>Recording';
            break;
        case 'completed':
            recordingStatusElement.className += ' bg-success';
            recordingStatusElement.innerHTML = '<i class="fas fa-check me-1"></i>Completed';
            break;
        case 'failed':
            recordingStatusElement.className += ' bg-warning';
            recordingStatusElement.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Failed';
            break;
        default:
            recordingStatusElement.className += ' bg-secondary';
            recordingStatusElement.innerHTML = '<i class="fas fa-video me-1"></i>Ready';
    }
}
</script>
@endpush 