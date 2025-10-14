@extends('layouts.public')

@section('title', 'FitFlix Shorts')

@section('content')
    <div class="shorts-container row justify-content-center align-items-center">
        <div class="shorts-wrapper" id="shortsWrapper">
            @foreach ($shorts as $short)
                <div class="shorts-item">

                    <!-- Video -->
                    <video class="shorts-video" preload="metadata" playsinline webkit-playsinline autoplay loop muted
                        defaultMuted poster="{{ asset('storage/app/public/' . $short->thumbnail_path) }}">
                        <source src="{{ asset('storage/app/public/' . $short->video_path) }}" type="video/mp4" />
                        <!-- Fallback text -->
                        Your browser does not support the video tag.
                    </video>

                    <!-- Top Left: User Info -->
                    <div class="shorts-user-info">
                        <img src="{{ asset('storage/app/public/default-profile1.png') }}" alt="{{ $short->uploader->name }}"
                            class="user-avatar">
                        <span class="username">{{ '@ ' . $short->title }}</span><br>
                    </div>

                    <!-- Bottom Left: Description -->
                    <div class="shorts-description">
                        <p class="description-text line-clamp" data-full="{{ $short->description }}">
                            {{ $short->description }}
                        </p>
                        <button class="read-more-btn">Read more</button>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="shorts-actions-overlay">
                        <button class="action-btn like-btn {{ $short->isLiked ? 'active' : '' }}" data-id="{{ $short->id }}">
                            <i class="far fa-thumbs-up"></i>
                            <span class="count">{{ $short->likes_count }}</span>
                        </button>

                        <button class="action-btn share-btn" data-id="{{ $short->id }}">
                            <i class="far fa-share-from-square"></i>
                            <span class="count">{{ $short->shares_count }}</span>
                        </button>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

    <style>
        navbar-expand-lg {
            display: none;
        }

        footer {
            display: none;
        }

        .shorts-container {
            position: fixed;
            top: 3rem;
            bottom: 0;
            left: 0;
            right: 0;
            overflow: hidden;
            background: black;
        }

        .shorts-wrapper {
            height: 100%;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scrollbar-width: none;
            background-size: cover;
            width: 425px !important;
            background-color: black;
            padding: 0;
        }

        .shorts-wrapper::-webkit-scrollbar {
            display: none;
        }

        .shorts-item {
            position: relative;
            height: 100%;
            scroll-snap-align: start;
            display: flex;
            justify-content: center;
            align-items: center;
            background: black;
        }

        .shorts-video {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .shorts-user-info {
            position: absolute;
            bottom: 8rem;
            left: 16px;
            right: 3.9rem;
            display: flex;
            align-items: center;
            z-index: 10;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            background: white !important;
        }

        .username {
            color: white;
            margin-left: 10px;
            font-weight: 600;
            font-size: .78rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            overflow: hidden;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
        }

        .shorts-description {
            position: absolute;
            bottom: 3.8rem;
            left: 16px;
            right: 80px;
            z-index: 10;
            color: #fff;
            font-size: 1rem;
        }

        .description-text {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: -0.5rem;
            font-size: .78rem;
        }

        .description-text.expanded {
            -webkit-line-clamp: unset;
            overflow: visible;
            z-index: 99999;
            position: relative;
            background: #f19d1a45;
            padding: 0 5rem 0px 6px;
            border-radius: 10px;
            max-width: 425px;
            width: 100%;
        }

        .read-more-btn {
            background: none;
            border: none;
            color: #0af;
            font-size: 0.85rem;
            margin-top: 4px;
            padding: 0;
            cursor: pointer;
        }

        .shorts-actions-overlay {
            position: absolute;
            right: 15px;
            bottom: 10%;
            display: flex;
            flex-direction: column;
            gap: .8rem;
            z-index: 10;
        }

        .action-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.2);
        }

        .action-btn.active {
            color: #e74c3c;
        }

        .action-btn .count {
            font-size: 0.75rem;
            margin-top: 2px;
            color: #fff;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const wrapper = document.getElementById('shortsWrapper');
            if (!wrapper) return;

            // Global mute state: true = muted, false = unmuted
            let globalMute = true;

            // Performance tweak: mark videos for compositing
            function hintCompositing(v) {
                try {
                    v.style.willChange = 'transform, opacity';
                    v.setAttribute('playsinline', '');
                    v.setAttribute('webkit-playsinline', '');
                    v.setAttribute('disablePictureInPicture', '');
                    v.setAttribute('controlsList', 'nodownload noremoteplayback');
                    // prefer preload auto for smoother playback on many devices
                    v.preload = 'auto';
                } catch (e) { }
            }

            // Apply global mute to all videos
            function applyGlobalMuteToAll() {
                document.querySelectorAll('.shorts-video').forEach(vid => {
                    vid.muted = globalMute;
                    vid.defaultMuted = globalMute;
                    if (globalMute) vid.setAttribute('muted', '');
                    else vid.removeAttribute('muted');
                });
            }

            // Find best-in-view video (closest center to viewport center)
            function findBestInView() {
                const vids = Array.from(document.querySelectorAll('.shorts-video'));
                const viewportCenterY = window.innerHeight / 2;
                let best = null;
                let bestDist = Infinity;
                vids.forEach(v => {
                    const rect = v.getBoundingClientRect();
                    const centerY = rect.top + rect.height / 2;
                    const dist = Math.abs(centerY - viewportCenterY);
                    if (dist < bestDist) {
                        bestDist = dist;
                        best = v;
                    }
                });
                return best;
            }

            // Safe play helper: play only if paused and document visible
            function safePlay(v) {
                if (!v) return;
                if (document.hidden) return;
                if (!v.paused) return;
                // play attempt
                v.play().catch(() => { /* ignore play errors */ });
            }

            // Safe pause helper
            function safePause(v) {
                if (!v) return;
                try { v.pause(); } catch (e) { }
            }

            // Setup video element interactions
            function setupVideoEl(v) {
                // Defensive attributes & perf hints
                v.setAttribute('muted', '');
                v.muted = true;
                v.defaultMuted = true;
                hintCompositing(v);

                // Remove any loadeddata autoplay to avoid duplicate plays
                // Observe via our rAF-based controller (no IntersectionObserver play calls here)
                // But keep observer only for visibility enforcement (optional)
                if (!v.dataset.setup) {
                    // click/double-click handling
                    let clickTimeout = null;
                    const DOUBLE_DELAY = 250;

                    function handleSingleClick(e) {
                        e.stopPropagation();
                        if (v.paused) safePlay(v);
                        else safePause(v);
                    }
                    function handleDoubleClick(e) {
                        e.stopPropagation();
                        globalMute = !globalMute;
                        applyGlobalMuteToAll();
                    }
                    const onUserClick = function (e) {
                        e.stopPropagation();
                        if (clickTimeout === null) {
                            clickTimeout = setTimeout(() => {
                                clickTimeout = null;
                                handleSingleClick(e);
                            }, DOUBLE_DELAY);
                        } else {
                            clearTimeout(clickTimeout);
                            clickTimeout = null;
                            handleDoubleClick(e);
                        }
                    };

                    v.addEventListener('click', onUserClick);
                    v.addEventListener('touchend', function (e) { setTimeout(() => onUserClick(e), 0); }, { passive: true });

                    v.dataset.setup = '1';
                }
            }

            // Setup read-more and like/share (keeps previous logic)
            function setupReadMore(root) {
                (root.querySelectorAll ? Array.from(root.querySelectorAll('.read-more-btn')) : []).forEach(btn => {
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';
                    const descEl = btn.previousElementSibling;
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        descEl.classList.toggle('expanded');
                        btn.textContent = descEl.classList.contains('expanded') ? 'Read less' : 'Read more';
                    });
                });
            }
            function setupLikeShare(root) {
                (root.querySelectorAll ? Array.from(root.querySelectorAll('.like-btn')) : []).forEach(btn => {
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const videoId = btn.dataset.id;
                        const countEl = btn.querySelector('.count');
                        fetch(`/fitlive/toggle-like/${videoId}`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                        }).then(r => r.json()).then(data => {
                            if (data.success) {
                                btn.classList.toggle('active', data.data.is_liked);
                                countEl.textContent = data.data.likes_count;
                            } else alert(data.message || 'Something went wrong!');
                        }).catch(err => console.error(err));
                    });
                });
                (root.querySelectorAll ? Array.from(root.querySelectorAll('.share-btn')) : []).forEach(btn => {
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const videoId = btn.dataset.id;
                        const countEl = btn.querySelector('.count');
                        fetch(`/fitlive/share-video/${videoId}`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                        }).then(r => r.json()).then(data => {
                            if (data.success) {
                                countEl.textContent = data.data.shares_count;
                                if (data.data.share_link && navigator.clipboard) {
                                    navigator.clipboard.writeText(data.data.share_link).then(() => alert('Share link copied!')).catch(() => { });
                                }
                            } else alert(data.message || 'Failed to share video');
                        }).catch(err => console.error(err));
                    });
                });
            }

            // initialize handlers on existing items
            Array.from(wrapper.querySelectorAll('.shorts-video')).forEach(setupVideoEl);
            setupReadMore(wrapper);
            setupLikeShare(wrapper);
            applyGlobalMuteToAll();

            // rAF-based scroll-settle detection for buttery smooth transitions
            let lastScrollY = wrapper.scrollTop;
            let lastTime = performance.now();
            let scrolling = false;
            let scrollVelocity = 0;
            let settleTimer = null;
            const VELOCITY_THRESHOLD = 0.3; // px/ms
            const SETTLE_DELAY = 80; // ms after velocity below threshold

            function onFrame(now) {
                const currY = wrapper.scrollTop;
                const dt = Math.max(1, now - lastTime);
                const dy = currY - lastScrollY;
                const vel = Math.abs(dy / dt);
                scrollVelocity = vel;
                lastScrollY = currY;
                lastTime = now;

                if (vel > VELOCITY_THRESHOLD) {
                    // still scrolling fast
                    scrolling = true;
                    if (settleTimer) { clearTimeout(settleTimer); settleTimer = null; }
                } else {
                    // slow enough — start settle timer if not already
                    if (scrolling && !settleTimer) {
                        settleTimer = setTimeout(() => {
                            scrolling = false;
                            settleTimer = null;
                            // Play the best-in-view video
                            const best = findBestInView();
                            if (best) {
                                // pause others first
                                document.querySelectorAll('.shorts-video').forEach(v => {
                                    if (v !== best) safePause(v);
                                });
                                // ensure global mute applied
                                best.muted = globalMute;
                                best.defaultMuted = globalMute;
                                if (globalMute) best.setAttribute('muted', ''); else best.removeAttribute('muted');
                                safePlay(best);
                            }
                        }, SETTLE_DELAY);
                    }
                }

                requestAnimationFrame(onFrame);
            }
            requestAnimationFrame(onFrame);

            // Also respond immediately to wheel/touchend to speed up responsiveness
            wrapper.addEventListener('touchend', () => {
                // start a short settle check
                if (settleTimer) clearTimeout(settleTimer);
                settleTimer = setTimeout(() => {
                    scrolling = false;
                    settleTimer = null;
                    const best = findBestInView();
                    if (best) {
                        document.querySelectorAll('.shorts-video').forEach(v => { if (v !== best) safePause(v); });
                        best.muted = globalMute; best.defaultMuted = globalMute;
                        if (globalMute) best.setAttribute('muted', ''); else best.removeAttribute('muted');
                        safePlay(best);
                    }
                }, 60);
            }, { passive: true });

            wrapper.addEventListener('wheel', () => {
                if (settleTimer) clearTimeout(settleTimer);
                settleTimer = setTimeout(() => {
                    scrolling = false; settleTimer = null;
                    const best = findBestInView();
                    if (best) {
                        document.querySelectorAll('.shorts-video').forEach(v => { if (v !== best) safePause(v); });
                        best.muted = globalMute; best.defaultMuted = globalMute;
                        if (globalMute) best.setAttribute('muted', ''); else best.removeAttribute('muted');
                        safePlay(best);
                    }
                }, 80);
            }, { passive: true });

            // Handle tab visibility: pause all when hidden, resume best when visible
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    document.querySelectorAll('.shorts-video').forEach(v => safePause(v));
                } else {
                    const best = findBestInView();
                    if (best) {
                        best.muted = globalMute; best.defaultMuted = globalMute;
                        if (globalMute) best.setAttribute('muted', ''); else best.removeAttribute('muted');
                        safePlay(best);
                        document.querySelectorAll('.shorts-video').forEach(v => { if (v !== best) safePause(v); });
                    }
                }
            });

            // Clones & infinite loop logic preserved — but ensure we reapply handlers after clone adjustments
            // (If you already have cloning logic earlier, keep it. If not, here's a small safe clone step:)
            (function ensureClonesAndInit() {
                let items = Array.from(wrapper.querySelectorAll('.shorts-item'));
                if (items.length > 0) {
                    // If clones not present, create
                    const first = items[0], last = items[items.length - 1];
                    if (!first.dataset.clone && !last.dataset.clone) {
                        const firstClone = first.cloneNode(true);
                        const lastClone = last.cloneNode(true);
                        firstClone.dataset.clone = 'first';
                        lastClone.dataset.clone = 'last';
                        wrapper.insertBefore(lastClone, first);
                        wrapper.appendChild(firstClone);
                        // re-init handlers on new nodes
                        Array.from(wrapper.querySelectorAll('.shorts-video')).forEach(setupVideoEl);
                        setupReadMore(wrapper);
                        setupLikeShare(wrapper);
                        applyGlobalMuteToAll();
                        // snap to first real
                        const pageH = wrapper.clientHeight;
                        requestAnimationFrame(() => {
                            try { wrapper.scrollTo({ top: pageH, behavior: 'instant' in window ? 'instant' : 'auto' }); }
                            catch (e) { wrapper.scrollTop = pageH; }
                        });
                    }
                }
            })();

            // Expose helper to attach handlers for AJAX-added items
            window.fitflixAttachShortsHandlers = function (rootElement) {
                const root = rootElement || document;
                (root.querySelectorAll ? Array.from(root.querySelectorAll('.shorts-video')) : []).forEach(setupVideoEl);
                setupReadMore(root);
                setupLikeShare(root);
                applyGlobalMuteToAll();
            };

            // final safety: play best once on load (after tiny delay to allow layout)
            setTimeout(() => {
                const best = findBestInView();
                if (best) {
                    best.muted = globalMute; best.defaultMuted = globalMute;
                    if (globalMute) best.setAttribute('muted', ''); else best.removeAttribute('muted');
                    safePlay(best);
                    document.querySelectorAll('.shorts-video').forEach(v => { if (v !== best) safePause(v); });
                }
            }, 260);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const wrapper = document.getElementById('shortsWrapper');

            // ---- Helpers to attach handlers to a given root (originals or clones) ----
            function setupVideoEl(v) {
                // Attributes (defensive)
                v.setAttribute('muted', '');
                v.muted = true;
                v.defaultMuted = true;

                v.setAttribute('playsinline', '');
                v.setAttribute('webkit-playsinline', '');
                v.playsInline = true;

                // If Safari blocks autoplay, try after metadata
                v.addEventListener('loadeddata', () => {
                    const playAttempt = v.play();
                    if (playAttempt && typeof playAttempt.catch === 'function') {
                        playAttempt.catch(() => { /* unlocked by user tap */ });
                    }
                }, { once: true });

                // Tap-to-start fallback (only triggers if autoplay was blocked)
                const unlock = () => {
                    v.muted = true; // keep muted to satisfy autoplay policies
                    v.playsInline = true;
                    v.play().catch(() => { });
                    v.removeEventListener('touchstart', unlock);
                    v.removeEventListener('click', unlock);
                };
                v.addEventListener('touchstart', unlock, { passive: true });
                v.addEventListener('click', unlock);

                // Observe for auto play/pause
                observer.observe(v);
            }

            function setupReadMore(root) {
                root.querySelectorAll('.read-more-btn').forEach(btn => {
                    // avoid duplicate bindings
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';

                    const descEl = btn.previousElementSibling;
                    btn.addEventListener('click', function () {
                        descEl.classList.toggle('expanded');
                        btn.textContent = descEl.classList.contains('expanded') ? 'Read less' : 'Read more';
                    });
                });
            }

            function setupLikeShare(root) {
                // Like
                root.querySelectorAll('.like-btn').forEach(btn => {
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';

                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const videoId = btn.dataset.id;
                        const countEl = btn.querySelector('.count');

                        fetch(`/fitlive/toggle-like/${videoId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    btn.classList.toggle('active', data.data.is_liked);
                                    countEl.textContent = data.data.likes_count;
                                } else {
                                    alert(data.message || 'Something went wrong!');
                                }
                            })
                            .catch(err => console.error(err));
                    });
                });

                // Share
                root.querySelectorAll('.share-btn').forEach(btn => {
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';

                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const videoId = btn.dataset.id;
                        const countEl = btn.querySelector('.count');

                        fetch(`/fitlive/share-video/${videoId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    countEl.textContent = data.data.shares_count;
                                    navigator.clipboard.writeText(data.data.share_link)
                                        .then(() => alert('Share link copied!'));
                                } else {
                                    alert(data.message || 'Failed to share video');
                                }
                            })
                            .catch(err => console.error(err));
                    });
                });
            }

            // IntersectionObserver for play/pause
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    if (entry.isIntersecting) {
                        video.muted = true;
                        video.playsInline = true;
                        video.play().catch(() => { });
                    } else {
                        video.pause();
                    }
                });
            }, { threshold: 0.75 });

            // --- 1) Build seamless loop: clone first and last ---
            let items = Array.from(wrapper.querySelectorAll('.shorts-item'));
            if (items.length > 0) {
                const firstClone = items[0].cloneNode(true);
                const lastClone = items[items.length - 1].cloneNode(true);

                // mark clones (optional, not used for styling)
                firstClone.dataset.clone = 'first';
                lastClone.dataset.clone = 'last';

                // insert clones
                wrapper.insertBefore(lastClone, items[0]);
                wrapper.appendChild(firstClone);

                // re-query items after cloning
                items = Array.from(wrapper.querySelectorAll('.shorts-item'));

                // 2) Init handlers on originals and clones
                // videos
                wrapper.querySelectorAll('.shorts-video').forEach(setupVideoEl);
                // read-more
                setupReadMore(wrapper);
                // like/share
                setupLikeShare(wrapper);

                // 3) Snap to the first REAL item on load (index 1 due to prepended lastClone)
                const pageH = wrapper.clientHeight;
                // set after frame to ensure layout done
                requestAnimationFrame(() => {
                    wrapper.scrollTo({ top: pageH, behavior: 'instant' in window ? 'instant' : 'auto' });
                });

                // 4) Keep it looping by jumping when hitting clones
                let scrollDebounce;
                function onScrollEnd() {
                    const page = wrapper.clientHeight; // viewport height
                    const maxIndex = items.length - 2; // real items count
                    const scrollTop = wrapper.scrollTop;

                    // Which "page" are we on (rounded)?
                    const indexApprox = Math.round(scrollTop / page);

                    // If at firstClone (index 0), jump to last real
                    if (indexApprox === 0) {
                        // last real is at index = items.length - 2 (because last item is firstClone)
                        const targetTop = page * (items.length - 2);
                        wrapper.scrollTo({ top: targetTop, behavior: 'auto' });
                    }
                    // If at firstClone-at-end (index = items.length - 1), jump to first real (index 1)
                    else if (indexApprox === items.length - 1) {
                        const targetTop = page; // first real
                        wrapper.scrollTo({ top: targetTop, behavior: 'auto' });
                    }
                }

                wrapper.addEventListener('scroll', () => {
                    // 1-by-1 snap feeling is already handled by CSS scroll-snap
                    // we only detect when snap finished (debounce) to do loop jumps
                    clearTimeout(scrollDebounce);
                    scrollDebounce = setTimeout(onScrollEnd, 120);
                });

                // Optional: keyboard/PageUp/PageDown navigation (doesn't alter your design/logic)
                wrapper.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown' || e.key === 'PageDown') {
                        e.preventDefault();
                        wrapper.scrollBy({ top: wrapper.clientHeight, behavior: 'smooth' });
                    } else if (e.key === 'ArrowUp' || e.key === 'PageUp') {
                        e.preventDefault();
                        wrapper.scrollBy({ top: -wrapper.clientHeight, behavior: 'smooth' });
                    }
                });
                // Make wrapper focusable for keyboard navigation (non-invasive)
                wrapper.setAttribute('tabindex', '0');
            }
        });
    </script>


@endpush