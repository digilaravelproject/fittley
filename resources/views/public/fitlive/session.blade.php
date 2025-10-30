@extends('layouts.public')

@section('title', $session->title . ' - FitLive')

@push('styles')
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
                height: calc(100vh - 12rem);
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
@endpush

@section('content')
    <div class="video-container-wrapper position-relative" style="overflow: hidden;">
        <!-- Fullscreen Video Container -->
        <div id="video-container" class="position-absolute top-0 start-0 w-100 h-100 bg-dark">
            @if ($session->isLive() && $streamingConfig)
                <div id="remote-video" class="w-100 h-100"></div>
            @else
                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white">
                    <div class="text-center">
                        @if ($session->banner_image)
                            <img src="{{ asset('storage/app/public/' . $session->banner_image) }}" alt="Session banner"
                                class="img-fluid rounded mb-3" style="max-height: 400px;">
                        @else
                            <i class="fas fa-video fa-5x mb-3"></i>
                        @endif
                        <h4>
                            @if ($session->isScheduled())
                                Session Scheduled
                            @elseif($session->hasEnded())
                                Session Ended
                            @else
                                Session Not Live
                            @endif
                        </h4>
                        @if ($session->scheduled_at)
                            <p>Scheduled for: {{ $session->scheduled_at->format('M d, Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Top Left Overlay - Live indicator & Session Info -->
            <div class="position-absolute top-0 start-0 p-3" style="z-index: 5;">
                @if ($session->isLive())
                    <div class="mb-2">
                        <span class="badge bg-danger fs-6">
                            <i class="fas fa-circle blink"></i> LIVE
                        </span>
                    </div>
                @endif

                <div class="bg-dark bg-opacity-75 text-white p-3 rounded" style="max-width: 300px;">
                    <h5 class="mb-1">{{ $session->title }}</h5>
                    <small class="d-block mb-1">
                        <i class="fas fa-user"></i> {{ @$session->instructor->name }}
                    </small>
                    <div class="d-flex gap-1 mb-2">
                        <span class="badge bg-info">{{ @$session->category->name }}</span>
                        @if ($session->subCategory)
                            <span class="badge bg-secondary">{{ @$session->subCategory->name }}</span>
                        @endif
                    </div>
                    @if ($session->started_at)
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Started {{ $session->started_at->diffForHumans() }}
                        </small>
                    @endif
                </div>
            </div>

            <!-- Top Right Overlay - Viewer count & Status -->
            <div class="position-absolute top-0 end-0 p-3" style="z-index: 5;">
                <div class="d-flex flex-column gap-2 align-items-end">
                    <span class="badge bg-dark bg-opacity-75 fs-6">
                        <i class="fas fa-users"></i> <span id="viewer-count">{{ $session->viewer_peak }}</span>
                    </span>
                    <span id="stream-status"
                        class="badge bg-{{ $session->isLive() ? 'success' : ($session->isScheduled() ? 'warning' : 'secondary') }} fs-6">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
            </div>

            <!-- Bottom Left Overlay - Connection Status & Controls -->
            <div class="position-absolute bottom-0 start-0 p-3" style="z-index: 5;">
                <div class="d-flex gap-2 align-items-center">
                    <span id="connection-status" class="badge bg-info">
                        @if ($session->isLive() && $streamingConfig)
                            Connecting...
                        @else
                            Not Live
                        @endif
                    </span>

                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-light btn-sm" onclick="shareStream()">
                            <i class="fas fa-share"></i>
                        </button>

                        <a href="{{ route('fitlive.index') }}" class="btn btn-outline-light btn-sm">
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
        @if ($session->chat_mode !== 'off')
            <div id="chat-panel" class="position-absolute top-0 end-0 h-100 bg-dark bg-opacity-90 text-white"
                style="width: 350px; z-index: 15; transform: translateX(0px); transition: transform 0.3s ease;">
                <div class="d-flex flex-column h-100">
                    <!-- Chat Header -->
                    <div class="p-3 border-bottom border-secondary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-comments"></i> Live Chat</h6>
                            <div class="d-flex gap-2 align-items-center">
                                <span class="badge bg-secondary" id="chat-status">
                                    @if ($session->chat_mode === 'off')
                                        Chat Disabled
                                    @elseif($session->chat_mode === 'during' && !$session->isLive())
                                        Chat During Live Only
                                    @elseif($session->chat_mode === 'after' && !$session->isLive() && !$session->hasEnded())
                                        Chat After Session
                                    @else
                                        Chat Active
                                    @endif
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
                        @auth
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
                        @else
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login to Chat</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        @endif

        <!-- Chat Toggle Button -->
        @if ($session->chat_mode !== 'off')
            <button id="toggle-chat" class="position-absolute btn btn-primary"
                style="top: 50%; right: 10px; z-index: 99; transform: translateY(-50%);">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>

    @if ($session->isLive() && $streamingConfig)
        <!-- Agora SDK -->
        <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>

        <script>
            /**
                     * =======================================
                     *  FitLive Agora Streaming + Chat Script
                     * =======================================
                     * Enhanced for reliability, readability, and better end-user experience
                     * without altering core behavior.
                     */

            (() => {
                // ------------------------------
                // Agora Configuration
                // ------------------------------
                const agoraConfig = {
                    appId: '{{ $streamingConfig['app_id'] }}',
                    channel: '{{ $streamingConfig['channel'] }}',
                    token: '{{ $streamingConfig['token'] }}',
                    uid: {{ $streamingConfig['uid'] }}
                        };

                let client = null;
                let isJoined = false;
                let mediaEnabled = false;

                // ------------------------------
                // Initialize Agora
                // ------------------------------
                async function initializeAgora() {
                    try {
                        client = AgoraRTC.createClient({
                            mode: "live",
                            codec: "vp8"
                        });
                        client.setClientRole("audience");
                        // --- Real-time live viewers tracking ---
                        let liveViewers = new Set();

                        // Update viewer counter in UI
                        function updateViewerCountDisplay() {
                            const el = document.getElementById("viewer-count");
                            if (el) el.textContent = liveViewers.size;
                        }

                        // Add yourself (local audience)
                        liveViewers.add(agoraConfig.uid);
                        updateViewerCountDisplay();

                        // When a new remote user joins
                        client.on("user-joined", (user) => {
                            console.log("User joined:", user.uid);
                            liveViewers.add(user.uid);
                            updateViewerCountDisplay();
                        });

                        // When a remote user leaves
                        client.on("user-left", (user) => {
                            console.log("User left:", user.uid);
                            liveViewers.delete(user.uid);
                            updateViewerCountDisplay();
                        });

                        // Handle autoplay policy
                        AgoraRTC.onAutoplayFailed = () => {
                            console.warn("Autoplay blocked by browser; enabling media automatically.");
                            mediaEnabled = true;
                            joinStream();
                        };

                        // Subscribe to remote user’s media
                        client.on("user-published", async (user, mediaType) => {
                            console.log("User published:", user.uid, mediaType);
                            try {
                                await client.subscribe(user, mediaType);

                                if (mediaType === "video") {
                                    const container = document.getElementById("remote-video");
                                    if (container) {
                                        container.style.display = "block";
                                        container.style.width = "100%";
                                        container.style.height = "100%";
                                        user.videoTrack.play("remote-video");
                                        updateConnectionStatus("Video Connected", "success");
                                    } else {
                                        console.error("Video container #remote-video not found");
                                    }
                                }

                                if (mediaType === "audio" && user.audioTrack) {
                                    user.audioTrack.play();
                                    console.log("Audio track playing");
                                }
                            } catch (error) {
                                console.error("Subscription failed:", error);
                                updateConnectionStatus("Subscription Failed", "danger");
                                showNotification("Unable to subscribe to stream. Please refresh.", "error");
                            }
                        });

                        // Handle user-unpublished
                        client.on("user-unpublished", (user, mediaType) => {
                            console.log("User unpublished:", user.uid, mediaType);
                            if (mediaType === "video") {
                                updateConnectionStatus("Stream Ended", "secondary");
                            }
                        });

                        // Connection state updates
                        client.on("connection-state-changed", (curState) => {
                            console.log("Connection state:", curState);
                            updateConnectionStatus(curState, curState === "CONNECTED" ? "success" : "warning");
                        });

                        updateConnectionStatus("Initialized", "info");
                        console.log("Agora client initialized successfully.");

                    } catch (error) {
                        console.error("Agora initialization failed:", error);
                        updateConnectionStatus("Initialization Failed", "danger");
                        showNotification("⚠️ Failed to initialize stream viewer. Please reload.", "error");
                    }
                }

                // ------------------------------
                // Join / Leave Stream
                // ------------------------------
                async function joinStream() {
                    try {
                        if (!client) {
                            await initializeAgora();
                        }

                        if (isJoined) {
                            console.log("Already connected to the stream.");
                            return;
                        }

                        updateConnectionStatus("Connecting...", "warning");
                        await client.join(agoraConfig.appId, agoraConfig.channel, agoraConfig.token, agoraConfig.uid);
                        isJoined = true;
                        updateConnectionStatus("Joined", "success");
                        console.log("Joined stream successfully.");
                    } catch (error) {
                        console.error("Failed to join stream:", error);
                        updateConnectionStatus("Join Failed", "danger");
                        showNotification("Failed to join stream: " + error.message, "error");
                    }
                }

                async function leaveStream() {
                    try {
                        if (isJoined && client) {
                            await client.leave();
                            isJoined = false;
                            updateConnectionStatus("Disconnected", "secondary");
                            console.log("Left stream successfully.");
                        }
                    } catch (error) {
                        console.error("Error leaving stream:", error);
                    }
                }

                // ------------------------------
                // UI Utilities
                // ------------------------------
                function updateConnectionStatus(status, type = "info") {
                    const el = document.getElementById("connection-status");
                    if (!el) return;
                    el.textContent = status;
                    el.className = `badge bg-${type}`;
                }

                function showNotification(message, type = "info") {
                    const div = document.createElement("div");
                    div.className =
                        `alert alert-${type === "error" ? "danger" : type} alert-dismissible fade show position-fixed shadow`;
                    div.style.cssText = "top:20px;right:20px;z-index:9999;min-width:300px;";
                    div.innerHTML = `
                    <div><strong>${capitalize(type)}:</strong> ${message}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                    document.body.appendChild(div);
                    setTimeout(() => div.remove(), 5000);
                }

                function capitalize(str) {
                    return str.charAt(0).toUpperCase() + str.slice(1);
                }

                // ------------------------------
                // Chat Handling
                // ------------------------------
                const chatState = {
                    messages: [],
                    isConnected: false
                };

                async function sendChatMessage() {
                    const chatInput = document.getElementById("chat-input");
                    const sendBtn = document.getElementById("send-chat-btn");
                    if (!chatInput || !sendBtn) return;

                    const message = chatInput.value.trim();
                    if (!message) {
                        showNotification("Please type a message before sending.", "warning");
                        return;
                    }

                    sendBtn.disabled = true;
                    try {
                        const response = await fetch(`/api/fitlive/{{ $session->id }}/chat`, {
                            method: "POST",
                            credentials: "include",
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                body: message
                            })
                        });

                        const data = await response.json();
                        if (!response.ok || !data.success) throw new Error(data.message || "Message send failed.");

                        chatInput.value = "";
                        addChatMessage(data.message);
                    } catch (error) {
                        console.error("Chat send error:", error);
                        showNotification("Failed to send message: " + error.message, "error");
                    } finally {
                        sendBtn.disabled = false;
                        chatInput.focus();
                    }
                }

                async function loadChatMessages() {
                    try {
                        const response = await fetch(`/api/fitlive/{{ $session->id }}/chat/messages`, {
                            credentials: "include",
                            headers: {
                                "Accept": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        const data = await response.json();
                        if (!response.ok || !data.success) return;

                        const newMessages = data.messages || [];
                        if (newMessages.length !== chatState.messages.length) {
                            chatState.messages = newMessages;
                            renderChatMessages();
                        }
                    } catch (error) {
                        console.warn("Failed to load chat messages:", error);
                    }
                }

                function addChatMessage(messageData) {
                    if (!messageData || chatState.messages.find(m => m.id === messageData.id)) return;
                    chatState.messages.push(messageData);
                    renderChatMessages();
                }

                function renderChatMessages() {
                    const container = document.getElementById("chat-messages");
                    if (!container) return;

                    container.innerHTML = "";
                    if (chatState.messages.length === 0) {
                        container.innerHTML =
                            `<div class="text-center text-muted"><p>No messages yet. Start chatting!</p></div>`;
                        return;
                    }

                    chatState.messages.forEach(msg => {
                        const div = document.createElement("div");
                        div.className = `chat-message mb-2 ${msg.is_instructor ? "instructor-message" : ""}`;
                        const userName = msg.user?.name || "Anonymous";
                        const prefix = msg.is_instructor ? "👨‍🏫 " : "";
                        const time = msg.sent_at ? new Date(msg.sent_at).toLocaleTimeString([], {
                            hour: "2-digit",
                            minute: "2-digit"
                        }) : "";
                        div.innerHTML = `
                        <div class="d-flex justify-content-between">
                            <strong class="text-primary">${prefix}${userName}</strong>
                            <small class="text-muted">${time}</small>
                        </div>
                        <div class="message-body mt-1">${escapeHtml(msg.body)}</div>
                    `;
                        container.appendChild(div);
                    });

                    container.scrollTop = container.scrollHeight;
                }

                function escapeHtml(str) {
                    return str.replace(/[&<>"']/g, m => ({
                        "&": "&amp;",
                        "<": "&lt;",
                        ">": "&gt;",
                        '"': "&quot;",
                        "'": "&#039;"
                    })[m]);
                }

                function initializeChat() {
                    const loader = document.getElementById("chat-loading");
                    const messages = document.getElementById("chat-messages");
                    if (loader) loader.style.display = "none";
                    if (messages) {
                        messages.innerHTML = `
                        <div class="text-center text-muted mb-3">
                            <i class="fas fa-comments fa-2x mb-2"></i>
                            <p>Welcome to the live chat!</p>
                            <small>Chat with other viewers during the session.</small>
                        </div>
                    `;
                    }

                    const chatInput = document.getElementById("chat-input");
                    const sendBtn = document.getElementById("send-chat-btn");
                    if (chatInput && sendBtn) {
                        sendBtn.addEventListener("click", sendChatMessage);
                        chatInput.addEventListener("keypress", e => {
                            if (e.key === "Enter" && !e.shiftKey) {
                                e.preventDefault();
                                sendChatMessage();
                            }
                        });

                        loadChatMessages();
                        setInterval(loadChatMessages, 3000);
                    }
                }

                // ------------------------------
                // UI Controls
                // ------------------------------
                function toggleChat() {
                    const chatPanel = document.getElementById("chat-panel");
                    const toggleBtn = document.getElementById("toggle-chat");
                    if (!chatPanel || !toggleBtn) return;

                    const isVisible = chatPanel.style.transform === "translateX(0px)" || !chatPanel.style.transform;
                    chatPanel.style.transform = isVisible ? "translateX(100%)" : "translateX(0px)";
                    toggleBtn.innerHTML = isVisible ? '<i class="fas fa-comments"></i>' : '<i class="fas fa-times"></i>';
                }

                function closeChat() {
                    const chatPanel = document.getElementById("chat-panel");
                    const toggleBtn = document.getElementById("toggle-chat");
                    if (chatPanel) {
                        chatPanel.style.transform = "translateX(100%)";
                        if (toggleBtn) toggleBtn.innerHTML = '<i class="fas fa-comments"></i>';
                    }
                }

                function toggleFullscreen() {
                    const btn = document.getElementById("toggle-fullscreen");
                    const icon = btn?.querySelector("i");
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen()
                            .then(() => icon && (icon.className = "fas fa-compress"))
                            .catch(() => showNotification("Failed to enter fullscreen mode.", "error"));
                    } else {
                        document.exitFullscreen()
                            .then(() => icon && (icon.className = "fas fa-expand"))
                            .catch(() => showNotification("Failed to exit fullscreen mode.", "error"));
                    }
                }

                function shareStream() {
                    if (navigator.share) {
                        navigator.share({
                            title: '{{ $session->title }}',
                            text: 'Watch this live FitLive session!',
                            url: window.location.href
                        }).catch(() => showNotification("Unable to share the session link.", "warning"));
                    } else {
                        navigator.clipboard.writeText(window.location.href)
                            .then(() => showNotification("📋 Stream link copied to clipboard!", "success"))
                            .catch(() => showNotification("Failed to copy link.", "error"));
                    }
                }

                // ------------------------------
                // Init on DOM Ready
                // ------------------------------
                document.addEventListener("DOMContentLoaded", () => {
                    initializeAgora();
                    initializeChat();

                    document.getElementById("toggle-chat")?.addEventListener("click", toggleChat);
                    document.getElementById("close-chat")?.addEventListener("click", closeChat);
                    document.getElementById("toggle-fullscreen")?.addEventListener("click", toggleFullscreen);

                    // Auto-join after short delay
                    setTimeout(() => {
                        mediaEnabled = true;
                        joinStream();
                    }, 1000);
                });

                // Leave stream before unloading
                window.addEventListener("beforeunload", () => {
                    if (isJoined) leaveStream();
                });
            })();
        </script>
    @endif

    @if (!$session->isLive() || !$streamingConfig)
        <!-- Enhanced Non-live Session JavaScript -->
        <script>
            /**
                     * ============================
                     *   FitLive Non-Live Chat JS
                     * ============================
                     * Handles message sending, polling, rendering, and UI interactions
                     * for non-live chat sessions with improved readability and UX.
                     */

            // Global chat state
            const chatState = {
                messages: [],
                isConnected: false
            };

            /**
             * Send a chat message to the server
             */
            async function sendChatMessage() {
                const chatInput = document.getElementById('chat-input');
                const sendBtn = document.getElementById('send-chat-btn');

                if (!chatInput || !sendBtn) return;

                const message = chatInput.value.trim();
                if (!message) {
                    showNotification('Please enter a message before sending.', 'warning');
                    return;
                }

                sendBtn.disabled = true;

                try {
                    const response = await fetch(`/api/fitlive/{{ $session->id }}/chat`, {
                        method: 'POST',
                        credentials: 'include',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            body: message
                        })
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Unable to send message. Please try again.');
                    }

                    if (data.success) {
                        chatInput.value = '';
                        addChatMessage(data.message);
                    } else {
                        showNotification(data.message || 'Failed to send message. Please try again later.', 'error');
                    }

                } catch (error) {
                    console.error('Error sending chat message:', error);
                    showNotification('⚠️ Unable to send message. Please check your connection and try again.', 'error');
                } finally {
                    sendBtn.disabled = false;
                    chatInput.focus();
                }
            }

            /**
             * Load chat messages periodically
             */
            async function loadChatMessages() {
                try {
                    const response = await fetch(`/api/fitlive/{{ $session->id }}/chat/messages`, {
                        credentials: 'include',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error('Failed to load chat messages from the server.');
                    }

                    if (data.success) {
                        const newMessages = data.messages || [];

                        // Only re-render if messages have changed
                        if (newMessages.length !== chatState.messages.length) {
                            chatState.messages = newMessages;
                            renderChatMessages();
                        }
                    }

                } catch (error) {
                    console.warn('Failed to load chat messages:', error);
                }
            }

            /**
             * Add a single new chat message to the state and UI
             */
            function addChatMessage(messageData) {
                if (!messageData || chatState.messages.find(m => m.id === messageData.id)) return;

                chatState.messages.push(messageData);
                renderChatMessages();
            }

            /**
             * Render all chat messages in the chat container
             */
            function renderChatMessages() {
                const container = document.getElementById('chat-messages');
                if (!container) return;

                container.innerHTML = '';

                if (chatState.messages.length === 0) {
                    container.innerHTML = `
                        <div class="text-center text-muted">
                            <p>No messages yet. Start the conversation!</p>
                        </div>
                    `;
                    return;
                }

                chatState.messages.forEach(message => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `chat-message mb-2 ${message.is_instructor ? 'instructor-message' : ''}`;

                    const userName = message.user ? message.user.name : 'Anonymous';
                    const userType = message.is_instructor ? '👨‍🏫 ' : '';
                    const time = message.sent_at ? new Date(message.sent_at).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '';

                    messageDiv.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-primary">${userType}${userName}</strong>
                            <small class="text-muted">${time}</small>
                        </div>
                        <div class="message-body mt-1">${escapeHtml(message.body)}</div>
                    `;

                    container.appendChild(messageDiv);
                });

                container.scrollTop = container.scrollHeight;
            }

            /**
             * Escape HTML to prevent XSS
             */
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            /**
             * Initialize chat UI and event listeners
             */
            function initializeChat() {
                const chatLoading = document.getElementById("chat-loading");
                const chatMessages = document.getElementById("chat-messages");
                const chatInput = document.getElementById('chat-input');
                const sendBtn = document.getElementById('send-chat-btn');

                if (chatLoading) chatLoading.style.display = "none";

                if (chatMessages) {
                    chatMessages.innerHTML = `
                        <div class="text-center text-muted mb-3">
                            <i class="fas fa-comments fa-2x mb-2"></i>
                            <p>Welcome to the chat!</p>
                            <small>Chat with other viewers and share your thoughts.</small>
                        </div>
                    `;
                }

                if (chatInput && sendBtn) {
                    sendBtn.addEventListener('click', sendChatMessage);
                    chatInput.addEventListener('keypress', e => {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            sendChatMessage();
                        }
                    });

                    // Initial load + polling
                    loadChatMessages();
                    setInterval(loadChatMessages, 3000);
                }
            }

            /**
             * Show user-friendly notifications
             */
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className =
                    `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed shadow`;
                notification.style.cssText = `
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    min-width: 320px;
                `;
                notification.innerHTML = `
                    <div><strong>${capitalize(type)}:</strong> ${message}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                document.body.appendChild(notification);

                setTimeout(() => notification.remove(), 5000);
            }

            /**
             * Capitalize first letter of string
             */
            function capitalize(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }

            /**
             * Toggle chat panel visibility
             */
            function toggleChat() {
                const chatPanel = document.getElementById("chat-panel");
                const toggleBtn = document.getElementById("toggle-chat");

                if (!chatPanel || !toggleBtn) return;

                const isVisible = chatPanel.style.transform === "translateX(0px)" || chatPanel.style.transform === "";
                chatPanel.style.transform = isVisible ? "translateX(100%)" : "translateX(0px)";
                toggleBtn.innerHTML = isVisible ? '<i class="fas fa-comments"></i>' : '<i class="fas fa-times"></i>';
            }

            /**
             * Close chat panel
             */
            function closeChat() {
                const chatPanel = document.getElementById("chat-panel");
                const toggleBtn = document.getElementById("toggle-chat");

                if (chatPanel) {
                    chatPanel.style.transform = "translateX(100%)";
                    if (toggleBtn) toggleBtn.innerHTML = '<i class="fas fa-comments"></i>';
                }
            }

            /**
             * Share current session link
             */
            function shareStream() {
                if (navigator.share) {
                    navigator.share({
                        title: '{{ $session->title }}',
                        text: 'Check out this FitLive session!',
                        url: window.location.href
                    }).catch(() => {
                        showNotification('Unable to share at the moment. Please try again.', 'warning');
                    });
                } else {
                    navigator.clipboard.writeText(window.location.href)
                        .then(() => showNotification('📋 Session link copied to clipboard!', 'success'))
                        .catch(() => showNotification('Failed to copy link to clipboard.', 'error'));
                }
            }

            /**
             * Toggle fullscreen mode
             */
            function toggleFullscreen() {
                const toggleBtn = document.getElementById("toggle-fullscreen");
                const icon = toggleBtn?.querySelector("i");

                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen()
                        .then(() => icon && (icon.className = "fas fa-compress"))
                        .catch(() => showNotification('Unable to enter fullscreen mode.', 'error'));
                } else {
                    document.exitFullscreen()
                        .then(() => icon && (icon.className = "fas fa-expand"))
                        .catch(() => showNotification('Unable to exit fullscreen mode.', 'error'));
                }
            }

            /**
             * Initialize when DOM is ready
             */
            document.addEventListener('DOMContentLoaded', () => {
                initializeChat();

                document.getElementById("toggle-chat")?.addEventListener('click', toggleChat);
                document.getElementById("close-chat")?.addEventListener('click', closeChat);
                document.getElementById("toggle-fullscreen")?.addEventListener('click', toggleFullscreen);
            });
        </script>
    @endif

@endsection