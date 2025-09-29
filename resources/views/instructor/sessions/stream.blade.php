@extends('layouts.app')

@section('title', 'Streaming Studio - ' . $session->title)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-video text-primary"></i>
            Streaming Studio
        </h1>
        <div class="btn-group">
            <a href="{{ route('instructor.sessions.show', $session) }}" class="btn btn-outline-primary">
                <i class="fas fa-info-circle"></i> Session Details
            </a>
            <a href="{{ route('instructor.sessions') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Sessions
            </a>
        </div>
    </div>

    <!-- Session Info Bar -->
    <div class="alert alert-{{ $session->isLive() ? 'danger' : 'warning' }} mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="alert-heading mb-1">
                    @if($session->isLive())
                        <i class="fas fa-circle text-danger blink"></i> LIVE: {{ $session->title }}
                    @else
                        <i class="fas fa-clock"></i> Ready to Stream: {{ $session->title }}
                    @endif
                </h4>
                <p class="mb-0">
                    Category: {{ $session->category->name ?? 'N/A' }} 
                    @if($session->subCategory)
                        → {{ $session->subCategory->name }}
                    @endif
                    | Scheduled: {{ $session->scheduled_at->format('M d, Y H:i A') }}
                    @if($session->started_at)
                        | Started: {{ $session->started_at->diffForHumans() }}
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-end">
                <div class="h5 mb-0">
                    <span class="badge badge-info">
                        <i class="fas fa-users"></i> Peak: {{ $session->viewer_peak }}
                    </span>
                    <span class="badge badge-{{ $session->chat_mode == 'off' ? 'secondary' : 'success' }}">
                        <i class="fas fa-comments"></i> Chat: {{ ucfirst($session->chat_mode) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Streaming Area -->
        <div class="col-lg-8">
            <!-- Video Preview/Stream -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Live Stream</h6>
                    <div>
                        <span id="stream-status" class="badge badge-secondary">Not Streaming</span>
                        <span id="connection-status" class="badge badge-secondary ml-2">Disconnected</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Video Container -->
                    <div id="video-container" class="position-relative bg-dark" style="height: 400px;">
                        <div id="local-video" class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <div class="text-white text-center">
                                <i class="fas fa-video fa-3x mb-3 opacity-50"></i>
                                <h5>Camera Preview</h5>
                                <p class="mb-0">Click "Start Stream" to begin broadcasting</p>
                            </div>
                        </div>
                        
                        <!-- Video Controls Overlay -->
                        <div class="position-absolute bottom-0 start-0 end-0 p-3" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button id="toggle-camera" class="btn btn-outline-light btn-sm">
                                        <i class="fas fa-video"></i> Camera
                                    </button>
                                    <button id="toggle-mic" class="btn btn-outline-light btn-sm">
                                        <i class="fas fa-microphone"></i> Mic
                                    </button>
                                    <button id="toggle-screen" class="btn btn-outline-light btn-sm">
                                        <i class="fas fa-desktop"></i> Screen
                                    </button>
                                </div>
                                
                                <div class="btn-group">
                                    <button id="start-stream" class="btn btn-success btn-sm">
                                        <i class="fas fa-play"></i> Start Stream
                                    </button>
                                    <button id="end-stream" class="btn btn-danger btn-sm" style="display: none;">
                                        <i class="fas fa-stop"></i> End Stream
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stream Configuration -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Stream Configuration</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Video Quality</label>
                                <select id="video-quality" class="form-select">
                                    <option value="720p">720p HD (Recommended)</option>
                                    <option value="480p">480p Standard</option>
                                    <option value="360p">360p Low Bandwidth</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Audio Quality</label>
                                <select id="audio-quality" class="form-select">
                                    <option value="high">High Quality</option>
                                    <option value="standard" selected>Standard</option>
                                    <option value="low">Low Bandwidth</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Stream Details:</strong><br>
                                <small>
                                    Channel: {{ $streamingConfig['channel'] }}<br>
                                    Role: {{ ucfirst($streamingConfig['role']) }}<br>
                                    Status: <span id="agora-status">Ready</span>
                                </small>
                            </div>
                            <div class="col-md-6">
                                <strong>Public Stream URL:</strong><br>
                                <small>
                                    <a href="{{ route('fitlive.session', $session->id) }}" target="_blank" class="text-decoration-none">
                                        {{ route('fitlive.session', $session->id) }}
                                        <i class="fas fa-external-link-alt ml-1"></i>
                                    </a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Live Chat Monitor -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Live Chat Monitor</h6>
                    <div>
                        <span class="badge badge-{{ $session->chat_mode == 'off' ? 'secondary' : 'success' }}">
                            {{ ucfirst($session->chat_mode) }}
                        </span>
                        <span id="chat-count" class="badge badge-info ml-1">0</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="chat-container" style="height: 250px; overflow-y: auto; padding: 15px; background-color: #f8f9fa;">
                        <div class="text-center text-muted" id="chat-loading">
                            <i class="fas fa-spinner fa-spin"></i> Loading chat...
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Instructor Chat Input -->
                    <div class="mb-2">
                        <div class="input-group input-group-sm">
                            <input type="text" id="instructor-chat-input" class="form-control" placeholder="Reply to viewers..." maxlength="500">
                            <button class="btn btn-primary" id="instructor-send-btn" type="button">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Reply as instructor • Press Enter to send
                        </small>
                    </div>
                </div>
            </div>

            <!-- Session Controls -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Session Controls</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 mb-3">
                        <button id="session-start" class="btn btn-success">
                            <i class="fas fa-play"></i> Start Session
                        </button>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="h4 mb-0" id="viewer-count">0</div>
                            <small class="text-muted">Live Viewers</small>
                        </div>
                        <div class="col-6">
                            <div class="h4 mb-0" id="stream-duration">00:00</div>
                            <small class="text-muted">Duration</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Technical Info -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Technical Info</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Bitrate</small>
                            <div id="bitrate">0 kbps</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">FPS</small>
                            <div id="fps">0</div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Resolution</small>
                            <div id="resolution">0x0</div>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Latency</small>
                            <div id="latency">0ms</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agora SDK -->
<script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.23.4.js"></script>
@vite(['resources/js/app.js', 'resources/css/app.css'])

<script>
// ========================================
// STREAMING STUDIO - COMPLETE REBUILD
// ========================================

// Configuration
const CONFIG = {
    streaming: {
        appId: '{{ $streamingConfig['app_id'] }}',
        channel: '{{ $streamingConfig['channel'] }}',
        token: '{{ $streamingConfig['token'] }}',
        uid: {{ $streamingConfig['uid'] }},
        role: '{{ $streamingConfig['role'] }}',
        configured: {{ $streamingConfig['configured'] ? 'true' : 'false' }}
    },
    session: {
        id: {{ $session->id }},
        status: '{{ $session->status }}',
        chatMode: '{{ $session->chat_mode }}',
        isLive: {{ $session->isLive() ? 'true' : 'false' }}
    },
    csrf: '{{ csrf_token() }}'
};

// Global State
const STATE = {
    agora: {
        client: null,
        localTracks: { video: null, audio: null, screen: null },
        isJoined: false,
        isPublishing: false
    },
    streaming: {
        isActive: false,
        startTime: null
    },
    chat: {
        messages: [],
        channel: null,
        isConnected: false
    },
    ui: {
        cameraEnabled: true,
        micEnabled: true,
        screenSharing: false
    }
};

// ========================================
// INITIALIZATION
// ========================================

document.addEventListener('DOMContentLoaded', async function() {
    try {
        await initializeAgora();
        initializeChat();
        initializeUI();
        
        updateStatus('agora-status', 'Ready');
        updateStatus('connection-status', 'Ready', 'success');
        
    } catch (error) {
        console.error('❌ Initialization failed:', error);
        showNotification('Failed to initialize streaming studio', 'error');
        updateStatus('agora-status', 'Failed');
    }
});

// ========================================
// AGORA STREAMING FUNCTIONS
// ========================================

async function initializeAgora() {
    if (!CONFIG.streaming.configured) {
        throw new Error('Agora streaming not configured');
    }

    try {
        STATE.agora.client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
        await STATE.agora.client.setClientRole("host");
        
        STATE.agora.client.on("user-published", handleUserPublished);
        STATE.agora.client.on("user-unpublished", handleUserUnpublished);
        STATE.agora.client.on("connection-state-changed", handleConnectionStateChanged);
        
    } catch (error) {
        console.error('❌ Agora initialization failed:', error);
        throw error;
    }
}

async function startStreaming() {
    if (STATE.streaming.isActive) {
        showNotification('Stream is already active', 'warning');
        return;
    }

    try {
        showNotification('Starting stream...', 'info');
        updateStatus('connection-status', 'Connecting...', 'warning');
        
        // Join channel
        await STATE.agora.client.join(
            CONFIG.streaming.appId,
            CONFIG.streaming.channel,
            CONFIG.streaming.token,
            CONFIG.streaming.uid
        );
        STATE.agora.isJoined = true;
        
        // Create local tracks
        await createLocalTracks();
        await publishTracks();
        
        // Update state
        STATE.streaming.isActive = true;
        STATE.streaming.startTime = Date.now();
        
        // Update UI
        updateStreamingUI(true);
        updateStatus('connection-status', 'Live', 'success');
        updateStatus('stream-status', 'LIVE', 'danger');
        
        // Start session
        await updateSessionStatus('start');
        
        // Start duration timer
        startDurationTimer();
        
        showNotification('Stream started successfully!', 'success');
        
    } catch (error) {
        console.error('❌ Failed to start stream:', error);
        showNotification('Failed to start stream: ' + error.message, 'error');
        updateStatus('connection-status', 'Error', 'danger');
    }
}

async function endStreaming() {
    if (!STATE.streaming.isActive) {
        showNotification('No active stream to end', 'warning');
        return;
    }

    try {
        showNotification('Ending stream...', 'info');
        
        // Clean up tracks
        if (STATE.agora.localTracks.video) {
            STATE.agora.localTracks.video.stop();
            STATE.agora.localTracks.video.close();
        }
        if (STATE.agora.localTracks.audio) {
            STATE.agora.localTracks.audio.stop();
            STATE.agora.localTracks.audio.close();
        }
        if (STATE.agora.localTracks.screen) {
            STATE.agora.localTracks.screen.stop();
            STATE.agora.localTracks.screen.close();
        }
        
        // Leave channel
        if (STATE.agora.isJoined) {
            await STATE.agora.client.leave();
            STATE.agora.isJoined = false;
        }
        
        // Update state
        STATE.streaming.isActive = false;
        STATE.streaming.startTime = null;
        
        // Update UI
        updateStreamingUI(false);
        updateStatus('connection-status', 'Disconnected', 'secondary');
        updateStatus('stream-status', 'Not Streaming', 'secondary');
        
        // End session
        await updateSessionStatus('end');
        
        showNotification('Stream ended successfully', 'info');
        
    } catch (error) {
        console.error('❌ Failed to end stream:', error);
        showNotification('Error ending stream', 'error');
    }
}

async function createLocalTracks() {
    try {
        STATE.agora.localTracks.audio = await AgoraRTC.createMicrophoneAudioTrack();
        STATE.agora.localTracks.video = await AgoraRTC.createCameraVideoTrack();
        
        STATE.agora.localTracks.video.play("local-video");
    } catch (error) {
        console.error('❌ Failed to create local tracks:', error);
        throw error;
    }
}

async function publishTracks() {
    try {
        const tracks = [];
        if (STATE.agora.localTracks.audio) tracks.push(STATE.agora.localTracks.audio);
        if (STATE.agora.localTracks.video) tracks.push(STATE.agora.localTracks.video);
        
        if (tracks.length > 0) {
            await STATE.agora.client.publish(tracks);
            STATE.agora.isPublishing = true;
        }
        
    } catch (error) {
        console.error('❌ Failed to publish tracks:', error);
        throw error;
    }
}

// ========================================
// MEDIA CONTROLS
// ========================================

async function toggleCamera() {
    if (!STATE.agora.localTracks.video) return;
    
    try {
        const enabled = !STATE.ui.cameraEnabled;
        await STATE.agora.localTracks.video.setEnabled(enabled);
        STATE.ui.cameraEnabled = enabled;
        
        updateControlButton('toggle-camera', enabled, 'video');
        showNotification(`Camera ${enabled ? 'enabled' : 'disabled'}`, 'info');
        
    } catch (error) {
        console.error('❌ Failed to toggle camera:', error);
    }
}

async function toggleMicrophone() {
    if (!STATE.agora.localTracks.audio) return;
    
    try {
        const enabled = !STATE.ui.micEnabled;
        await STATE.agora.localTracks.audio.setEnabled(enabled);
        STATE.ui.micEnabled = enabled;
        
        updateControlButton('toggle-mic', enabled, 'microphone');
        showNotification(`Microphone ${enabled ? 'enabled' : 'disabled'}`, 'info');
        
    } catch (error) {
        console.error('❌ Failed to toggle microphone:', error);
    }
}

// ========================================
// CHAT FUNCTIONS - COMPLETE REBUILD
// ========================================

function initializeChat() {
    // Load initial messages first
    loadChatMessages();
    
    // Initialize instructor chat input
    initializeInstructorChat();
    
    // Set up real-time WebSocket connection
    if (typeof window.Echo === 'undefined') {
        console.warn('⚠️ Laravel Echo not available, using polling fallback');
        startChatPolling();
        return;
    }

    try {
        console.log('🔗 Creating Echo channel for fitlive.' + CONFIG.session.id);
        STATE.chat.channel = window.Echo.channel(`fitlive.${CONFIG.session.id}`);
        
        // Listen for the correct event name as defined in the Event class
        STATE.chat.channel.listen('FitLiveChatMessageSent', (data) => {
            // Process the message data - data.message contains the actual message
            const messageData = data.message || data;
            
            // Ensure proper structure
            const processedMessage = {
                id: messageData.id,
                body: messageData.body,
                sent_at: messageData.sent_at,
                user: messageData.user,
                is_instructor: messageData.is_instructor || false
            };
            
            addChatMessage(processedMessage);
        });
        
        // Add connection event listeners
        STATE.chat.channel.subscribed(() => {
            console.log('✅ Successfully subscribed to WebSocket channel');
            STATE.chat.isConnected = true;
            showNotification('Real-time chat connected!', 'success');
        });
        
        STATE.chat.channel.error((error) => {
            console.error('❌ WebSocket channel error:', error);
            STATE.chat.isConnected = false;
            showNotification('WebSocket connection failed, using polling', 'warning');
            startChatPolling();
        });
        
        // Start polling as backup even if WebSocket is available
        // This ensures we don't miss any messages
        console.log('🔄 Starting backup polling (every 5 seconds)');
        setInterval(() => {
            loadChatMessages();
        }, 5000);
        
    } catch (error) {
        console.error('❌ Chat WebSocket initialization failed:', error);
        showNotification('Real-time chat failed, using polling', 'warning');
        startChatPolling();
    }
}

function initializeInstructorChat() {
    const chatInput = document.getElementById('instructor-chat-input');
    const sendBtn = document.getElementById('instructor-send-btn');
    
    if (!chatInput || !sendBtn) {
        console.error('❌ Instructor chat elements not found');
        return;
    }
    
    // Send message on button click
    sendBtn.addEventListener('click', sendInstructorMessage);
    
    // Send message on Enter key
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendInstructorMessage();
        }
    });
}

async function sendInstructorMessage() {
    const chatInput = document.getElementById('instructor-chat-input');
    const sendBtn = document.getElementById('instructor-send-btn');
    
    if (!chatInput || !sendBtn) return;
    
    const message = chatInput.value.trim();
    if (!message) return;
    
    try {
        const response = await fetch(`/api/fitlive/${CONFIG.session.id}/chat`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CONFIG.csrf
            },
            body: JSON.stringify({
                body: message,
                is_instructor: true
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            chatInput.value = '';
            
            // Always add the message locally immediately for better UX
            // Even if WebSocket is connected, the broadcast might be delayed
            console.log('🔄 Adding instructor message locally for immediate display');
            addChatMessage(data.message);
        } else {
            throw new Error(data.message || 'Failed to send message');
        }
        
    } catch (error) {
        console.error('❌ Failed to send message:', error);
        showNotification('Failed to send message: ' + error.message, 'error');
    } finally {
        chatInput.focus();
    }
}

function startChatPolling() {
    console.log('🔄 Starting chat polling fallback');
    setInterval(() => {
        if (!STATE.chat.isConnected) {
            loadChatMessages();
        }
    }, 3000);
}

async function loadChatMessages() {
    try {
        const response = await fetch(`/api/fitlive/${CONFIG.session.id}/chat/messages`, {
            credentials: 'include',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CONFIG.csrf
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const newMessages = data.messages || [];
            
            // Always update messages to ensure we have the latest
            if (newMessages.length !== STATE.chat.messages.length || newMessages.length === 0) {
                console.log(`🔄 Updating messages: ${STATE.chat.messages.length} → ${newMessages.length}`);
                STATE.chat.messages = newMessages;
                renderChatMessages();
            } else {
                // Check if we have different messages even with same count
                const lastServerMessage = newMessages[newMessages.length - 1];
                const lastLocalMessage = STATE.chat.messages[STATE.chat.messages.length - 1];
                
                if (lastServerMessage && lastLocalMessage && lastServerMessage.id !== lastLocalMessage.id) {
                    console.log('🔄 Same count but different messages, updating...');
                    STATE.chat.messages = newMessages;
                    renderChatMessages();
                }
            }
        } else {
            console.error('❌ Failed to load messages:', data.message);
        }
        
    } catch (error) {
        console.error('❌ Failed to load chat messages:', error);
    }
}

function addChatMessage(messageData) {
    // Avoid duplicates
    const exists = STATE.chat.messages.find(m => m.id === messageData.id);
    if (exists) {
        console.log('⚠️ Duplicate message, skipping');
        return;
    }
    
    const message = {
        id: messageData.id,
        body: messageData.body,
        sent_at: messageData.sent_at,
        user: messageData.user,
        is_instructor: messageData.is_instructor || false
    };
    
    STATE.chat.messages.push(message);
    renderChatMessages();
    
    // Show notification
    const userName = message.user ? message.user.name : 'Unknown';
    const preview = message.body.length > 30 ? message.body.substring(0, 30) + '...' : message.body;
    const userType = message.is_instructor ? 'Instructor' : 'User';
    console.log('🔔 New message notification:', `${userType} ${userName}: ${preview}`);
    showNotification(`${userType} ${userName}: ${preview}`, 'info');
}

function renderChatMessages() {
    const container = document.getElementById('chat-container');
    const loading = document.getElementById('chat-loading');
    
    if (!container) {
        console.error('❌ Chat container not found');
        return;
    }
    
    if (loading) loading.style.display = 'none';
    
    console.log(`🎨 Rendering ${STATE.chat.messages.length} messages`);
    
    if (STATE.chat.messages.length === 0) {
        container.innerHTML = '<div class="text-center text-muted"><i class="fas fa-comments"></i><br>No messages yet<br><small>Viewers will see their messages here</small></div>';
        return;
    }
    
    const recentMessages = STATE.chat.messages.slice(-20);
    const html = recentMessages.map(message => {
        const time = new Date(message.sent_at).toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        const userName = message.user ? message.user.name : 'Unknown';
        const isInstructor = message.is_instructor || false;
        const borderColor = isInstructor ? 'border-success' : 'border-primary';
        const userBadge = isInstructor ? '<span class="badge badge-success badge-sm">Instructor</span>' : '';
        
        return `
            <div class="mb-2 p-2 bg-white rounded shadow-sm border-start border-3 ${borderColor}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong class="${isInstructor ? 'text-success' : 'text-primary'} small">${escapeHtml(userName)}</strong>
                        ${userBadge}
                    </div>
                    <small class="text-muted">${time}</small>
                </div>
                <div class="small mt-1">${escapeHtml(message.body)}</div>
            </div>
        `;
    }).join('');
    
    container.innerHTML = html;
    container.scrollTop = container.scrollHeight;
    
    // Update chat count
    const chatCount = document.getElementById('chat-count');
    if (chatCount) {
        chatCount.textContent = STATE.chat.messages.length;
    }
    
    console.log('✅ Chat messages rendered successfully');
}

// ========================================
// UI FUNCTIONS
// ========================================

function initializeUI() {
    document.getElementById('start-stream')?.addEventListener('click', startStreaming);
    document.getElementById('end-stream')?.addEventListener('click', endStreaming);
    document.getElementById('toggle-camera')?.addEventListener('click', toggleCamera);
    document.getElementById('toggle-mic')?.addEventListener('click', toggleMicrophone);
    document.getElementById('session-start')?.addEventListener('click', () => updateSessionStatus('start'));
}

function updateStreamingUI(isStreaming) {
    const startBtn = document.getElementById('start-stream');
    const endBtn = document.getElementById('end-stream');
    
    if (startBtn) startBtn.style.display = isStreaming ? 'none' : 'inline-block';
    if (endBtn) endBtn.style.display = isStreaming ? 'inline-block' : 'none';
}

function updateControlButton(buttonId, enabled, icon) {
    const button = document.getElementById(buttonId);
    if (!button) return;
    
    button.className = enabled 
        ? 'btn btn-outline-light btn-sm' 
        : 'btn btn-outline-danger btn-sm';
}

function updateStatus(elementId, text, type = 'secondary') {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    element.textContent = text;
    element.className = `badge badge-${type}`;
}

function startDurationTimer() {
    setInterval(() => {
        if (STATE.streaming.isActive && STATE.streaming.startTime) {
            const duration = Math.floor((Date.now() - STATE.streaming.startTime) / 1000);
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            
            document.getElementById('stream-duration').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    }, 1000);
}

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

// ========================================
// UTILITY FUNCTIONS
// ========================================

async function updateSessionStatus(action) {
    try {
        const response = await fetch(`{{ route('instructor.sessions.stream.update', ['session' => $session->id, 'action' => '__ACTION__']) }}`.replace('__ACTION__', action), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CONFIG.csrf
            }
        });
        
        const data = await response.json();
        if (!data.success) {
            throw new Error(data.message);
        }
        
    } catch (error) {
        console.error('❌ Failed to update session status:', error);
        throw error;
    }
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

// Event handlers
function handleUserPublished(user, mediaType) {
    console.log('👤 User published:', user.uid, mediaType);
}

function handleUserUnpublished(user, mediaType) {
    console.log('👤 User unpublished:', user.uid, mediaType);
}

function handleConnectionStateChanged(curState, revState) {
    console.log('🔗 Connection state changed:', curState);
    updateStatus('connection-status', curState, curState === 'CONNECTED' ? 'success' : 'warning');
}

// Cleanup
window.addEventListener('beforeunload', function() {
    if (STATE.streaming.isActive) {
        endStreaming();
    }
    
    if (STATE.chat.channel) {
        STATE.chat.channel.stopListening('chat.message');
        window.Echo.leaveChannel(`fitlive.${CONFIG.session.id}`);
    }
});

</script>

<style>
.blink {
    animation: blink 1s linear infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.3; }
}

#video-container {
    border-radius: 0.375rem;
    overflow: hidden;
}

#chat-container::-webkit-scrollbar {
    width: 6px;
}

#chat-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#chat-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

#chat-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endsection 