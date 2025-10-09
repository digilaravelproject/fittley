

<?php $__env->startSection('title', $session->title . ' - FitLive'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        :root {
            --primary-color: #f7a31a;
            --primary-dark: #e8941a;
            --primary-light: #f9b847;
            --bg-primary: #0a0a0a;
            --bg-secondary: #141414;
            --bg-tertiary: #1a1a1a;
            --bg-card: #1f1f1f;
            --bg-hover: #2a2a2a;
            --text-primary: #ffffff;
            --text-secondary: #e5e5e5;
            --text-muted: #b3b3b3;
            --border-primary: #333333;
            --transition-fast: 0.15s ease-in-out;
            --transition-normal: 0.3s ease-in-out;
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #000;
            color: #fff;
            overflow: hidden;
        }

        /* Adjust main content for navbar */
        .video-container-wrapper {
            height: calc(100vh - 100px);
            /*margin-top: 76px;*/
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

        /* Chat panel styling */
        #chat-panel {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        #chat-messages {
            scrollbar-width: thin;
            scrollbar-color: #6c757d transparent;
        }

        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background-color: #6c757d;
            border-radius: 3px;
        }

        /* Chat message styling for dark theme */
        .chat-message {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .chat-message .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .chat-message .text-primary {
            color: #0dcaf0 !important;
        }

        .chat-message .text-success {
            color: #20c997 !important;
        }

        .chat-message .text-warning {
            color: #ffc107 !important;
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

        /* Chat toggle button */
        #toggle-chat {
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .video-container-wrapper {
                height: calc(100vh - 145px);
            }

            #chat-panel {
                width: 100% !important;
            }

            .position-absolute.top-0.start-0 .bg-dark {
                max-width: 250px;
                font-size: 0.9rem;
            }

            .position-absolute.top-0.start-0 h5 {
                font-size: 1.1rem;
            }
        }

        /* Hide scrollbars in fullscreen for cleaner look */
        :fullscreen #chat-messages {
            scrollbar-width: none;
        }

        :fullscreen #chat-messages::-webkit-scrollbar {
            display: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="video-container-wrapper position-relative" style="overflow: hidden;">
        <!-- Fullscreen Video Container -->
        <div id="video-container" class="position-absolute top-0 start-0 w-100 h-100 bg-dark">
            <?php if($session->isLive() && $streamingConfig): ?>
                <div id="remote-video" class="w-100 h-100"></div>
            <?php else: ?>
                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white">
                    <div class="text-center">
                        <?php if($session->banner_image): ?>
                            <img src="<?php echo e(asset('storage/app/public/' . $session->banner_image)); ?>" alt="Session banner"
                                class="img-fluid rounded mb-3" style="max-height: 400px;">
                        <?php else: ?>
                            <i class="fas fa-video fa-5x mb-3"></i>
                        <?php endif; ?>
                        <h4>
                            <?php if($session->isScheduled()): ?>
                                Session Scheduled
                            <?php elseif($session->hasEnded()): ?>
                                Session Ended
                            <?php else: ?>
                                Session Not Live
                            <?php endif; ?>
                        </h4>
                        <?php if($session->scheduled_at): ?>
                            <p>Scheduled for: <?php echo e($session->scheduled_at->format('M d, Y H:i')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Top Left Overlay - Live indicator & Session Info -->
            <div class="position-absolute top-0 start-0 p-3" style="z-index: 5;">
                <?php if($session->isLive()): ?>
                    <div class="mb-2">
                        <span class="badge bg-danger fs-6">
                            <i class="fas fa-circle blink"></i> LIVE
                        </span>
                    </div>
                <?php endif; ?>

                <div class="bg-dark bg-opacity-75 text-white p-3 rounded" style="max-width: 300px;">
                    <h5 class="mb-1"><?php echo e($session->title); ?></h5>
                    <small class="d-block mb-1">
                        <i class="fas fa-user"></i> <?php echo e(@$session->instructor->name); ?>

                    </small>
                    <div class="d-flex gap-1 mb-2">
                        <span class="badge bg-info"><?php echo e(@$session->category->name); ?></span>
                        <?php if($session->subCategory): ?>
                            <span class="badge bg-secondary"><?php echo e(@$session->subCategory->name); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if($session->started_at): ?>
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Started <?php echo e($session->started_at->diffForHumans()); ?>

                        </small>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Top Right Overlay - Viewer count & Status -->
            <div class="position-absolute top-0 end-0 p-3" style="z-index: 5;">
                <div class="d-flex flex-column gap-2 align-items-end">
                    <span class="badge bg-dark bg-opacity-75 fs-6">
                        <i class="fas fa-users"></i> <span id="viewer-count"><?php echo e($session->viewer_peak); ?></span>
                    </span>
                    <span id="stream-status"
                        class="badge bg-<?php echo e($session->isLive() ? 'success' : ($session->isScheduled() ? 'warning' : 'secondary')); ?> fs-6">
                        <?php echo e(ucfirst($session->status)); ?>

                    </span>
                </div>
            </div>

            <!-- Bottom Left Overlay - Connection Status & Controls -->
            <div class="position-absolute bottom-0 start-0 p-3" style="z-index: 5;">
                <div class="d-flex gap-2 align-items-center">
                    <span id="connection-status" class="badge bg-info">
                        <?php if($session->isLive() && $streamingConfig): ?>
                            Connecting...
                        <?php else: ?>
                            Not Live
                        <?php endif; ?>
                    </span>

                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light btn-sm" onclick="shareStream()">
                            <i class="fas fa-share"></i>
                        </button>

                        <a href="<?php echo e(route('fitlive.index')); ?>" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left"></i>
                        </a>

                        <button id="toggle-fullscreen" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side Chat Panel -->
        <?php if($session->chat_mode !== 'off'): ?>
            <div id="chat-panel" class="position-absolute top-0 end-0 h-100 bg-dark bg-opacity-90 text-white"
                style="width: 350px; z-index: 15; transform: translateX(0px); transition: transform 0.3s ease;">
                <div class="d-flex flex-column h-100">
                    <!-- Chat Header -->
                    <div class="p-3 border-bottom border-secondary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-comments"></i> Live Chat</h6>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge bg-secondary" id="chat-status">
                                    <?php if($session->chat_mode === 'off'): ?>
                                        Chat Disabled
                                    <?php elseif($session->chat_mode === 'during' && !$session->isLive()): ?>
                                        Chat During Live Only
                                    <?php elseif($session->chat_mode === 'after' && !$session->isLive() && !$session->hasEnded()): ?>
                                        Chat After Session
                                    <?php else: ?>
                                        Chat Active
                                    <?php endif; ?>
                                </span>
                                <button id="close-chat" class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <div class="flex-grow-1 p-3" style="overflow-y: auto;">
                        <div id="chat-messages" style="height: 100%;">
                            <div class="text-center text-muted" id="chat-loading">
                                <i class="fas fa-spinner fa-spin"></i> Loading chat...
                            </div>
                        </div>
                    </div>

                    <!-- Chat Input -->
                    <div class="p-3 border-top border-secondary">
                        <?php if(auth()->guard()->check()): ?>
                            <div id="chat-input-area">
                                <div class="input-group">
                                    <input type="text" id="chat-input" class="form-control" placeholder="Type a message..."
                                        maxlength="500">
                                    <button class="btn btn-primary" id="send-chat-btn">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Press Enter to send</small>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary btn-sm">Login to Chat</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Chat Toggle Button -->
        <?php if($session->chat_mode !== 'off'): ?>
            <button id="toggle-chat" class="position-absolute btn btn-primary"
                style="top: 50%; right: 10px; z-index: 99; transform: translateY(-50%);">
                <i class="fas fa-times"></i>
            </button>
        <?php endif; ?>
    </div>

    <?php if($session->isLive() && $streamingConfig): ?>
        <!-- Agora SDK -->
        <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

        <script>
            // Agora Configuration
            const agoraConfig = {
                appId: '<?php echo e($streamingConfig['app_id']); ?>',
                channel: '<?php echo e($streamingConfig['channel']); ?>',
                token: '<?php echo e($streamingConfig['token']); ?>',
                uid: <?php echo e($streamingConfig['uid']); ?>

        };

            let client = null;
            let isJoined = false;
            let mediaEnabled = false;

            // Initialize Agora
            async function initializeAgora() {
                try {
                    client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
                    client.setClientRole("audience");

                    // Handle autoplay policy - overlay removed as requested
                    AgoraRTC.onAutoplayFailed = () => {
                        console.log("Autoplay failed - auto-enabling media");
                        // Auto-enable media without showing overlay
                        mediaEnabled = true;
                        joinStream();
                    };

                    // Handle remote user events
                    client.on("user-published", async (user, mediaType) => {
                        console.log("User published:", user.uid, mediaType);

                        try {
                            await client.subscribe(user, mediaType);

                            if (mediaType === "video") {
                                const remoteVideoTrack = user.videoTrack;
                                // Ensure video container exists and is visible
                                const videoContainer = document.getElementById("remote-video");
                                if (videoContainer) {
                                    videoContainer.style.display = "block";
                                    videoContainer.style.width = "100%";
                                    videoContainer.style.height = "100%";
                                    remoteVideoTrack.play("remote-video");
                                    updateConnectionStatus("Video Connected", "success");
                                    console.log("Video track playing in remote-video container");
                                } else {
                                    console.error("remote-video container not found");
                                }
                            }

                            if (mediaType === "audio") {
                                const remoteAudioTrack = user.audioTrack;
                                // Always play audio when available
                                remoteAudioTrack.play();
                                console.log("Audio track playing");
                            }
                        } catch (error) {
                            console.error("Failed to subscribe to user:", error);
                            updateConnectionStatus("Subscribe Failed", "danger");
                        }
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

            // Auto-join stream immediately without waiting for user interaction
            setTimeout(() => {
                mediaEnabled = true;
                joinStream();
            }, 1000);

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
                        title: '<?php echo e($session->title); ?>',
                        text: 'Watch this live FitLive session!',
                        url: window.location.href
                    });
                } else {
                    // Fallback: copy to clipboard
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        showNotification("Stream link copied to clipboard!", "success");
                    });
                }
            }

            // Chat toggle function
            function toggleChat() {
                const chatPanel = document.getElementById("chat-panel");
                const toggleBtn = document.getElementById("toggle-chat");

                if (chatPanel) {
                    if (chatPanel.style.transform === "translateX(0px)" || chatPanel.style.transform === "") {
                        // Hide chat
                        chatPanel.style.transform = "translateX(100%)";
                        toggleBtn.innerHTML = '<i class="fas fa-comments"></i>';
                    } else {
                        // Show chat
                        chatPanel.style.transform = "translateX(0px)";
                        toggleBtn.innerHTML = '<i class="fas fa-times"></i>';
                    }
                }
            }

            // Close chat function
            function closeChat() {
                const chatPanel = document.getElementById("chat-panel");
                const toggleBtn = document.getElementById("toggle-chat");

                if (chatPanel) {
                    chatPanel.style.transform = "translateX(100%)";
                    toggleBtn.innerHTML = '<i class="fas fa-comments"></i>';
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

            // Chat state
            const chatState = {
                messages: [],
                isConnected: false
            };

            // Initialize chat
            function initializeChat() {
                // Hide loading indicator and show a welcome message
                const chatLoading = document.getElementById("chat-loading");
                const chatMessages = document.getElementById("chat-messages");

                if (chatLoading) {
                    chatLoading.style.display = "none";
                }

                if (chatMessages) {
                    chatMessages.innerHTML = `
                    <div class="text-center text-muted mb-3">
                        <i class="fas fa-comments fa-2x mb-2"></i>
                        <p>Welcome to the live chat!</p>
                        <small>Chat with other viewers during the session.</small>
                    </div>
                `;
                }

                // Initialize chat input listeners
                const chatInput = document.getElementById('chat-input');
                const sendBtn = document.getElementById('send-chat-btn');

                if (chatInput && sendBtn) {
                    sendBtn.addEventListener('click', sendChatMessage);
                    chatInput.addEventListener('keypress', function (e) {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            sendChatMessage();
                        }
                    });

                    // Load existing messages
                    loadChatMessages();

                    // Start polling for new messages
                    setInterval(loadChatMessages, 3000);
                }
            }

            // Send chat message
            async function sendChatMessage() {
                const chatInput = document.getElementById('chat-input');
                const sendBtn = document.getElementById('send-chat-btn');

                if (!chatInput || !sendBtn) return;

                const message = chatInput.value.trim();
                if (!message) return;

                try {
                    const response = await fetch(`/api/fitlive/<?php echo e($session->id); ?>/chat`, {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            body: message
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        chatInput.value = '';
                        addChatMessage(data.message);
                    } else {
                        throw new Error(data.message || 'Failed to send message');
                    }

                } catch (error) {
                    showNotification('Failed to send message: ' + error.message, 'error');
                } finally {
                    chatInput.focus();
                }
            }

            // Load chat messages
            async function loadChatMessages() {
                try {
                    const response = await fetch(`/api/fitlive/<?php echo e($session->id); ?>/chat/messages`, {
                        credentials: 'include',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        const newMessages = data.messages || [];

                        if (newMessages.length !== chatState.messages.length) {
                            chatState.messages = newMessages;
                            renderChatMessages();
                        }
                    }

                } catch (error) {
                    console.error('Failed to load chat messages:', error);
                }
            }

            // Add new chat message
            function addChatMessage(messageData) {
                const exists = chatState.messages.find(m => m.id === messageData.id);
                if (exists) return;

                chatState.messages.push(messageData);
                renderChatMessages();
            }

            // Render chat messages
            function renderChatMessages() {
                const container = document.getElementById('chat-messages');
                if (!container) return;

                container.innerHTML = '';

                chatState.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `chat-message mb-2 ${message.is_instructor ? 'instructor-message' : ''}`;

                    const userName = message.user ? message.user.name : 'Anonymous';
                    const userType = message.is_instructor ? '👨‍🏫 ' : '';

                    messageDiv.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <strong class="text-primary">${userType}${userName}</strong>
                        <small class="text-muted">${new Date(message.sent_at).toLocaleTimeString()}</small>
                    </div>
                    <div class="message-body">${message.body}</div>
                `;

                    container.appendChild(messageDiv);
                });

                // Scroll to bottom
                container.scrollTop = container.scrollHeight;
            }

            // Event listeners
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize Agora
                initializeAgora();

                // Initialize chat (since it's expanded by default)
                initializeChat();

                // Removed: Enable media button (overlay removed as requested)
                // document.getElementById("enable-media-btn")?.addEventListener('click', enableMedia);

                // Chat toggle
                document.getElementById("toggle-chat")?.addEventListener('click', toggleChat);

                // Close chat
                document.getElementById("close-chat")?.addEventListener('click', closeChat);

                // Fullscreen toggle
                document.getElementById("toggle-fullscreen")?.addEventListener('click', toggleFullscreen);

                // Auto-join stream immediately (overlay removed)
                setTimeout(() => {
                    mediaEnabled = true;
                    joinStream();
                }, 1000);
            });

            // Handle page unload
            window.addEventListener('beforeunload', function () {
                if (isJoined) {
                    leaveStream();
                }
            });
        </script>
    <?php endif; ?>

    <?php if(!$session->isLive() || !$streamingConfig): ?>
        <!-- Non-live session JavaScript -->
        <script>
            // Chat state
            const chatState = {
                messages: [],
                isConnected: false
            };

            // Send chat message
            async function sendChatMessage() {
                const chatInput = document.getElementById('chat-input');
                const sendBtn = document.getElementById('send-chat-btn');

                if (!chatInput || !sendBtn) return;

                const message = chatInput.value.trim();
                if (!message) return;

                try {
                    const response = await fetch(`/api/fitlive/<?php echo e($session->id); ?>/chat`, {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            body: message
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        chatInput.value = '';
                        addChatMessage(data.message);
                    } else {
                        throw new Error(data.message || 'Failed to send message');
                    }

                } catch (error) {
                    showNotification('Failed to send message: ' + error.message, 'error');
                } finally {
                    chatInput.focus();
                }
            }

            // Load chat messages
            async function loadChatMessages() {
                try {
                    const response = await fetch(`/api/fitlive/<?php echo e($session->id); ?>/chat/messages`, {
                        credentials: 'include',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        const newMessages = data.messages || [];

                        if (newMessages.length !== chatState.messages.length) {
                            chatState.messages = newMessages;
                            renderChatMessages();
                        }
                    }

                } catch (error) {
                    console.error('Failed to load chat messages:', error);
                }
            }

            // Add new chat message
            function addChatMessage(messageData) {
                const exists = chatState.messages.find(m => m.id === messageData.id);
                if (exists) return;

                chatState.messages.push(messageData);
                renderChatMessages();
            }

            // Render chat messages
            function renderChatMessages() {
                const container = document.getElementById('chat-messages');
                if (!container) return;

                container.innerHTML = '';

                chatState.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `chat-message mb-2 ${message.is_instructor ? 'instructor-message' : ''}`;

                    const userName = message.user ? message.user.name : 'Anonymous';
                    const userType = message.is_instructor ? '👨‍🏫 ' : '';

                    messageDiv.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <strong class="text-primary">${userType}${userName}</strong>
                        <small class="text-muted">${new Date(message.sent_at).toLocaleTimeString()}</small>
                    </div>
                    <div class="message-body">${message.body}</div>
                `;

                    container.appendChild(messageDiv);
                });

                // Scroll to bottom
                container.scrollTop = container.scrollHeight;
            }

            // Enhanced initializeChat for non-live sessions
            function initializeChat() {
                const chatLoading = document.getElementById("chat-loading");
                const chatMessages = document.getElementById("chat-messages");

                if (chatLoading) {
                    chatLoading.style.display = "none";
                }

                if (chatMessages) {
                    chatMessages.innerHTML = `
                    <div class="text-center text-muted mb-3">
                        <i class="fas fa-comments fa-2x mb-2"></i>
                        <p>Welcome to the chat!</p>
                        <small>Chat with other viewers.</small>
                    </div>
                `;
                }

                // Initialize chat input listeners
                const chatInput = document.getElementById('chat-input');
                const sendBtn = document.getElementById('send-chat-btn');

                if (chatInput && sendBtn) {
                    sendBtn.addEventListener('click', sendChatMessage);
                    chatInput.addEventListener('keypress', function (e) {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            sendChatMessage();
                        }
                    });

                    // Load existing messages
                    loadChatMessages();

                    // Start polling for new messages
                    setInterval(loadChatMessages, 3000);
                }
            }

            // Event listeners for non-live sessions
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize chat (since it's expanded by default)
                initializeChat();

                // Chat toggle
                document.getElementById("toggle-chat")?.addEventListener('click', toggleChat);

                // Close chat
                document.getElementById("close-chat")?.addEventListener('click', closeChat);

                // Fullscreen toggle
                document.getElementById("toggle-fullscreen")?.addEventListener('click', toggleFullscreen);
            });

            // Share stream function
            function shareStream() {
                if (navigator.share) {
                    navigator.share({
                        title: '<?php echo e($session->title); ?>',
                        text: 'Check out this FitLive session!',
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

            // Chat toggle function
            function toggleChat() {
                const chatPanel = document.getElementById("chat-panel");
                const toggleBtn = document.getElementById("toggle-chat");

                if (chatPanel) {
                    if (chatPanel.style.transform === "translateX(0px)" || chatPanel.style.transform === "") {
                        // Hide chat
                        chatPanel.style.transform = "translateX(100%)";
                        toggleBtn.innerHTML = '<i class="fas fa-comments"></i>';
                    } else {
                        // Show chat
                        chatPanel.style.transform = "translateX(0px)";
                        toggleBtn.innerHTML = '<i class="fas fa-times"></i>';
                    }
                }
            }

            // Close chat function
            function closeChat() {
                const chatPanel = document.getElementById("chat-panel");
                const toggleBtn = document.getElementById("toggle-chat");

                if (chatPanel) {
                    chatPanel.style.transform = "translateX(100%)";
                    toggleBtn.innerHTML = '<i class="fas fa-comments"></i>';
                }
            }

            // Initialize chat
            function initializeChat() {
                // Hide loading indicator and show a welcome message
                const chatLoading = document.getElementById("chat-loading");
                const chatMessages = document.getElementById("chat-messages");

                if (chatLoading) {
                    chatLoading.style.display = "none";
                }

                if (chatMessages) {
                    chatMessages.innerHTML = `
                    <div class="text-center text-muted mb-3">
                        <i class="fas fa-comments fa-2x mb-2"></i>
                        <p>Welcome to the chat!</p>
                        <small>Chat will be available when the session is live.</small>
                    </div>
                `;
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
        </script>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/public/fitlive/session.blade.php ENDPATH**/ ?>