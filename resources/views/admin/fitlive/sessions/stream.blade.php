@extends('layouts.admin')

@section('title', 'FitLive Stream - ' . $session->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $session->title }} - Streaming</h3>
                    <div class="d-flex gap-2">
                        <span class="badge bg-{{ $session->isLive() ? 'success' : 'secondary' }} fs-6">
                            {{ ucfirst($session->status) }}
                        </span>
                        <a href="{{ route('admin.fitlive.sessions.index') }}" class="btn btn-secondary">
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
                                        <button id="start-stream" class="btn btn-success" {{ $session->isLive() ? 'style=display:none' : '' }}>
                                            <i class="fas fa-play"></i> Start Stream
                                        </button>
                                        <button id="stop-stream" class="btn btn-danger" {{ !$session->isLive() ? 'style=display:none' : '' }}>
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
                                        {{ $session->title }}
                                    </div>
                                    
                                    @if($session->description)
                                    <div class="mb-3">
                                        <strong>Description:</strong><br>
                                        {{ $session->description }}
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Category:</strong><br>
                                        {{ $session->category->name }}
                                        @if($session->subCategory)
                                            <br><small class="text-muted">{{ $session->subCategory->name }}</small>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <strong>Instructor:</strong><br>
                                        {{ $session->instructor->name }}
                                    </div>

                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        <span id="stream-status" class="badge bg-{{ $session->isLive() ? 'success' : 'secondary' }}">
                                            {{ ucfirst($session->status) }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Peak Viewers:</strong>
                                        <span id="viewer-count" class="badge bg-info">{{ $session->viewer_peak }}</span>
                                    </div>

                                    @if($session->started_at)
                                    <div class="mb-3">
                                        <strong>Started:</strong><br>
                                        <small>{{ $session->started_at->format('M d, Y H:i:s') }}</small>
                                    </div>
                                    @endif

                                    @if($session->scheduled_at)
                                    <div class="mb-3">
                                        <strong>Scheduled:</strong><br>
                                        <small>{{ $session->scheduled_at->format('M d, Y H:i:s') }}</small>
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <strong>Channel:</strong><br>
                                        <code>{{ $session->getChannelName() }}</code>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Public URL:</strong><br>
                                        <a href="{{ route('fitlive.session', $session) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt"></i> View Stream
                                        </a>
                                    </div>

                                    <!-- Session Info -->
                                    <div class="session-info">
                                        <h5>{{ $session->title }}</h5>
                                        @if($session->description)
                                            <p class="text-muted">{{ $session->description }}</p>
                                        @endif
                                        
                                        <div class="info-grid">
                                            <div class="info-item">
                                                <span class="info-label">Status</span>
                                                <span id="stream-status" class="status-badge status-{{ $session->status }}">
                                                    {{ ucfirst($session->status) }}
                                                </span>
                                            </div>
                                            
                                            <div class="info-item">
                                                <span class="info-label">Category</span>
                                                <span class="info-value">{{ $session->category->name }}</span>
                                            </div>
                                            
                                            @if($session->subCategory)
                                            <div class="info-item">
                                                <span class="info-label">Subcategory</span>
                                                <span class="info-value">{{ $session->subCategory->name }}</span>
                                            </div>
                                            @endif
                                            
                                            <div class="info-item">
                                                <span class="info-label">Recording</span>
                                                <span id="recording-status" class="status-badge recording-{{ $session->recording_enabled ? ($session->recording_status ?? 'ready') : 'disabled' }}">
                                                    @if($session->recording_enabled)
                                                        @if($session->recording_status === 'recording')
                                                            <i class="fas fa-circle blink me-1"></i>Recording
                                                        @elseif($session->recording_status === 'completed')
                                                            <i class="fas fa-check me-1"></i>Completed
                                                        @elseif($session->recording_status === 'failed')
                                                            <i class="fas fa-exclamation-triangle me-1"></i>Failed
                                                        @else
                                                            <i class="fas fa-video me-1"></i>Ready
                                                        @endif
                                                    @else
                                                        <i class="fas fa-times me-1"></i>Disabled
                                                    @endif
                                                </span>
                                            </div>
                                            
                                            <div class="info-item">
                                                <span class="info-label">Viewers</span>
                                                <span id="viewer-count" class="info-value">{{ $session->viewer_peak }}</span>
                                            </div>
                                            
                                            @if($session->started_at)
                                            <div class="info-item">
                                                <span class="info-label">Started</span>
                                                <span class="info-value">{{ $session->started_at->format('H:i:s') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Live Chat Monitor -->
                            <div class="card mt-3">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6><i class="fas fa-comments"></i> Live Chat Monitor</h6>
                                    <span class="badge bg-secondary" id="chat-status">
                                        @if($session->chat_mode === 'off')
                                            Chat Disabled
                                        @elseif($session->chat_mode === 'during' && !$session->isLive())
                                            Chat During Live Only
                                        @elseif($session->chat_mode === 'after' && !$session->isLive() && !$session->hasEnded())
                                            Chat After Session
                                        @else
                                            Chat Active
                                        @endif
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div id="admin-chat-messages" style="height: 200px; overflow-y: auto; border: 1px solid #dee2e6; padding: 10px; background-color: #f8f9fa; margin-bottom: 10px;">
                                        <div class="text-center text-muted" id="admin-chat-loading">
                                            <i class="fas fa-spinner fa-spin"></i> Loading chat...
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        Chat Mode: <strong>{{ ucfirst($session->chat_mode) }}</strong><br>
                                        Total Messages: <span id="message-count">0</span>
                                    </small>
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
<script src="{{ asset('js/app.js') }}"></script>

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
        const response = await fetch(`/admin/fitlive/sessions/{{ $session->id }}/${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update status badge
            const statusBadge = document.getElementById("stream-status");
            statusBadge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            statusBadge.className = `status-badge status-${data.status}`;
            
            // Update recording status if available
            if (data.recording_status) {
                const recordingBadge = document.getElementById('recording-status');
                recordingBadge.className = `status-badge recording-${data.recording_status}`;
                
                switch(data.recording_status) {
                    case 'recording':
                        recordingBadge.innerHTML = '<i class="fas fa-circle blink me-1"></i>Recording';
                        break;
                    case 'completed':
                        recordingBadge.innerHTML = '<i class="fas fa-check me-1"></i>Completed';
                        break;
                    case 'failed':
                        recordingBadge.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Failed';
                        break;
                    default:
                        recordingBadge.innerHTML = '<i class="fas fa-video me-1"></i>Ready';
                }
            }
            
            console.log('Stream status updated:', data);
        }
        
    } catch (error) {
        console.error("Failed to update stream status:", error);
        showNotification("Error updating stream status", "error");
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
    @if($session->isLive())
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

// Admin Chat Monitoring with Reverb
const adminChatConfig = {
    sessionId: {{ $session->id }},
    chatMode: '{{ $session->chat_mode }}',
    sessionStatus: '{{ $session->status }}',
    csrfToken: '{{ csrf_token() }}'
};

let adminChatMessages = [];
let adminEchoChannel = null;
let adminChatInterval = null;

// Initialize admin chat monitoring with real-time updates
async function initializeAdminChat() {
    try {
        // Check chat status
        const statusResponse = await fetch(`/api/fitlive/${adminChatConfig.sessionId}/chat/status`);
        const statusData = await statusResponse.json();
        
        if (statusData.success) {
            updateAdminChatStatus(statusData);
            
            if (statusData.chat_enabled || adminChatConfig.chatMode !== 'off') {
                await loadAdminChatMessages();
                initializeAdminRealTimeChat();
                startAdminChatPolling(); // Fallback
            } else {
                showAdminChatDisabled();
            }
        }
    } catch (error) {
        console.error('Failed to initialize admin chat:', error);
        showAdminChatError('Failed to load chat');
    }
}

// Initialize real-time chat monitoring for admin
function initializeAdminRealTimeChat() {
    if (typeof window.Echo === 'undefined') {
        console.warn('Laravel Echo not available for admin chat monitoring');
        return;
    }

    try {
        // Join the FitLive session channel
        adminEchoChannel = window.Echo.channel(`fitlive.${adminChatConfig.sessionId}`);
        
        // Listen for new chat messages
        adminEchoChannel.listen('chat.message', (data) => {
            console.log('Admin received new chat message:', data);
            
            // Add the new message to admin chat
            const newMessage = {
                id: data.id,
                body: data.body,
                sent_at: data.sent_at,
                user: data.user
            };
            
            adminChatMessages.push(newMessage);
            renderAdminChatMessages();
            
            // Update message count
            const messageCountElement = document.getElementById('message-count');
            if (messageCountElement) {
                messageCountElement.textContent = adminChatMessages.length;
            }
        });

        console.log('Admin real-time chat monitoring initialized');
        
    } catch (error) {
        console.error('Failed to initialize admin real-time chat:', error);
    }
}

// Load chat messages for admin monitoring
async function loadAdminChatMessages() {
    try {
        const response = await fetch(`/api/fitlive/${adminChatConfig.sessionId}/chat/messages`);
        const data = await response.json();
        
        if (data.success) {
            adminChatMessages = data.messages;
            renderAdminChatMessages();
            
            const loadingElement = document.getElementById('admin-chat-loading');
            if (loadingElement) {
                loadingElement.style.display = 'none';
            }
            
            // Update message count
            const messageCountElement = document.getElementById('message-count');
            if (messageCountElement) {
                messageCountElement.textContent = adminChatMessages.length;
            }
        } else {
            showAdminChatError(data.message || 'Failed to load messages');
        }
    } catch (error) {
        console.error('Failed to load admin chat messages:', error);
        showAdminChatError('Failed to load messages');
    }
}

// Render chat messages for admin view
function renderAdminChatMessages() {
    const chatContainer = document.getElementById('admin-chat-messages');
    
    if (adminChatMessages.length === 0) {
        chatContainer.innerHTML = '<p class="text-muted text-center small">No messages yet</p>';
        return;
    }
    
    const messagesHTML = adminChatMessages.slice(-20).map(message => {
        const messageTime = new Date(message.sent_at).toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        return `
            <div class="admin-chat-message mb-1 p-1 rounded border-start border-2 border-info bg-light" style="font-size: 0.85em;">
                <div class="d-flex justify-content-between">
                    <strong class="text-primary">${escapeHtmlAdmin(message.user.name)}</strong>
                    <small class="text-muted">${messageTime}</small>
                </div>
                <div class="text-truncate" title="${escapeHtmlAdmin(message.body)}">${escapeHtmlAdmin(message.body)}</div>
            </div>
        `;
    }).join('');
    
    chatContainer.innerHTML = messagesHTML;
    
    // Scroll to bottom
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

// Update admin chat status
function updateAdminChatStatus(statusData) {
    const chatStatus = document.getElementById('chat-status');
    const messageCount = document.getElementById('message-count');
    
    if (chatStatus) {
        if (statusData.chat_enabled) {
            chatStatus.textContent = 'Live Chat Active';
            chatStatus.className = 'badge bg-success';
        } else {
            if (adminChatConfig.chatMode === 'off') {
                chatStatus.textContent = 'Chat Disabled';
                chatStatus.className = 'badge bg-secondary';
            } else if (adminChatConfig.chatMode === 'during') {
                chatStatus.textContent = 'Chat During Live Only';
                chatStatus.className = 'badge bg-warning';
            } else {
                chatStatus.textContent = 'Chat Not Available';
                chatStatus.className = 'badge bg-secondary';
            }
        }
    }
    
    if (messageCount) {
        messageCount.textContent = statusData.message_count || 0;
    }
}

// Show admin chat disabled message
function showAdminChatDisabled() {
    const chatContainer = document.getElementById('admin-chat-messages');
    let message = '';
    
    if (adminChatConfig.chatMode === 'off') {
        message = 'Chat is disabled for this session.';
    } else if (adminChatConfig.chatMode === 'during' && adminChatConfig.sessionStatus !== 'live') {
        message = 'Chat will be available when session goes live.';
    } else {
        message = 'Chat monitoring not available.';
    }
    
    chatContainer.innerHTML = `<p class="text-muted text-center small">${message}</p>`;
    document.getElementById('admin-chat-loading').style.display = 'none';
}

// Show admin chat error
function showAdminChatError(message) {
    const chatContainer = document.getElementById('admin-chat-messages');
    const loadingElement = document.getElementById('admin-chat-loading');
    
    if (chatContainer) {
        chatContainer.innerHTML = `<p class="text-danger text-center small"><i class="fas fa-exclamation-triangle"></i> ${message}</p>`;
    }
    if (loadingElement) {
        loadingElement.style.display = 'none';
    }
}

// Start admin chat polling (fallback for WebSocket failures)
function startAdminChatPolling() {
    if (adminChatInterval) {
        clearInterval(adminChatInterval);
    }
    
    adminChatInterval = setInterval(async () => {
        if (document.visibilityState === 'visible') {
            await loadAdminChatMessages();
        }
    }, 15000); // Poll every 15 seconds as backup for admin
}

// Stop admin chat polling
function stopAdminChatPolling() {
    if (adminChatInterval) {
        clearInterval(adminChatInterval);
        adminChatInterval = null;
    }
}

// Escape HTML for admin view
function escapeHtmlAdmin(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Initialize admin chat when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize admin chat monitoring
    setTimeout(() => {
        initializeAdminChat();
    }, 1000);
});

// Clean up admin chat on page unload
window.addEventListener('beforeunload', function() {
    if (adminEchoChannel) {
        adminEchoChannel.stopListening('chat.message');
        window.Echo.leaveChannel(`fitlive.${adminChatConfig.sessionId}`);
    }
    
    stopAdminChatPolling();
});
</script>

<style>
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: flex;
    align-items: center;
}

.status-live {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1));
    color: #dc3545;
    border: 1px solid #dc3545;
}

.status-scheduled {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
    color: #ffc107;
    border: 1px solid #ffc107;
}

.status-ended {
    background: linear-gradient(135deg, rgba(108, 117, 125, 0.2), rgba(108, 117, 125, 0.1));
    color: #6c757d;
    border: 1px solid #6c757d;
}

.recording-ready {
    background: linear-gradient(135deg, rgba(248, 167, 33, 0.2), rgba(248, 167, 33, 0.1));
    color: #f8a721;
    border: 1px solid #f8a721;
}

.recording-recording {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.2), rgba(220, 53, 69, 0.1));
    color: #dc3545;
    border: 1px solid #dc3545;
}

.recording-completed {
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
    color: #28a745;
    border: 1px solid #28a745;
}

.recording-failed {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 193, 7, 0.1));
    color: #ffc107;
    border: 1px solid #ffc107;
}

.recording-disabled {
    background: linear-gradient(135deg, rgba(108, 117, 125, 0.2), rgba(108, 117, 125, 0.1));
    color: #6c757d;
    border: 1px solid #6c757d;
}

.blink {
    animation: blink-animation 1s steps(5, start) infinite;
}

@keyframes blink-animation {
    to {
        visibility: hidden;
    }
}
</style>
@endsection 