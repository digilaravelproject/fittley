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

            // -----------------------------
            // 🔊 Global Mute State
            // -----------------------------
            let globalMute = true;

            // -----------------------------
            // ⚙️ Helper Functions
            // -----------------------------
            const safePlay = v => {
                if (v && v.paused && !document.hidden) v.play().catch(() => { });
            };
            const safePause = v => {
                if (v) try {
                    v.pause();
                } catch { }
            };

            const applyGlobalMuteToAll = () => {
                document.querySelectorAll('.shorts-video').forEach(v => {
                    v.muted = globalMute;
                    v.defaultMuted = globalMute;
                    if (globalMute) v.setAttribute('muted', '');
                    else v.removeAttribute('muted');
                });
            };

            // Return the video whose center is closest to viewport center
            const findBestInView = () => {
                const vids = [...document.querySelectorAll('.shorts-video')];
                const centerY = window.innerHeight / 2;
                let best = null,
                    bestDist = Infinity;
                vids.forEach(v => {
                    const r = v.getBoundingClientRect();
                    const d = Math.abs((r.top + r.height / 2) - centerY);
                    if (d < bestDist) {
                        bestDist = d;
                        best = v;
                    }
                });
                return best;
            };

            // -----------------------------
            // 🧩 Setup for Each Video
            // -----------------------------
            function setupVideo(v) {
                if (v.dataset.setup) return;
                v.dataset.setup = '1';

                v.muted = true;
                v.defaultMuted = true;
                v.setAttribute('muted', '');
                v.setAttribute('playsinline', '');
                v.setAttribute('webkit-playsinline', '');
                v.playsInline = true;
                v.preload = 'auto';

                // single vs double tap
                let clickTimeout = null;
                const DOUBLE_DELAY = 250;
                v.addEventListener('click', e => {
                    e.stopPropagation();
                    if (clickTimeout === null) {
                        clickTimeout = setTimeout(() => {
                            clickTimeout = null;
                            if (v.paused) safePlay(v);
                            else safePause(v);
                        }, DOUBLE_DELAY);
                    } else {
                        clearTimeout(clickTimeout);
                        clickTimeout = null;
                        globalMute = !globalMute;
                        applyGlobalMuteToAll();
                    }
                });

                // touch support
                v.addEventListener('touchend', e => {
                    setTimeout(() => v.click(), 0);
                }, {
                    passive: true
                });
            }

            // -----------------------------
            // 📝 Setup Read More
            // -----------------------------
            function setupReadMore(root = document) {
                root.querySelectorAll('.read-more-btn').forEach(btn => {
                    if (btn.dataset.bound) return;
                    btn.dataset.bound = '1';
                    const desc = btn.previousElementSibling;
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        desc.classList.toggle('expanded');
                        btn.textContent = desc.classList.contains('expanded') ? 'Read less' :
                            'Read more';
                    });
                });
            }

            // -----------------------------
            // ❤️ Setup Like & Share
            // -----------------------------
            function setupLikeShare(root = document) {
                // Like
                root.querySelectorAll('.like-btn').forEach(btn => {
                    if (btn.dataset.bound) return;
                    btn.dataset.bound = '1';
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        const id = btn.dataset.id;
                        if (!id) {
                            console.error('Like button clicked but data-id missing:', btn);
                            return; // stop here to avoid crash
                        }
                        const countEl = btn.querySelector('.count');
                        fetch(`/fitlive/toggle-like/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(r => r.json()).then(data => {
                            if (data.success) {
                                btn.classList.toggle('active', data.data.is_liked);
                                countEl.textContent = data.data.likes_count;
                            } else alert(data.message || 'Something went wrong!');
                        }).catch(console.error);
                    });
                });

                // Share
                root.querySelectorAll('.share-btn').forEach(btn => {
                    if (btn.dataset.bound) return;
                    btn.dataset.bound = '1';
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        const id = btn.dataset.id;
                        const countEl = btn.querySelector('.count');
                        fetch(`/fitlive/share-video/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(r => r.json()).then(data => {
                            if (data.success) {
                                countEl.textContent = data.data.shares_count;
                                if (data.data.share_link && navigator.clipboard) {
                                    navigator.clipboard.writeText(data.data.share_link)
                                        .then(() => alert('Share link copied!'));
                                }
                            } else alert(data.message || 'Failed to share video');
                        }).catch(console.error);
                    });
                });
            }

            // -----------------------------
            // 🔁 Infinite Loop Setup
            // -----------------------------
            function setupInfiniteLoop() {
                let items = [...wrapper.querySelectorAll('.shorts-item')];
                if (items.length < 2) return;

                if (wrapper.dataset.looped) return;
                wrapper.dataset.looped = '1';

                const firstClone = items[0].cloneNode(true);
                const lastClone = items[items.length - 1].cloneNode(true);
                firstClone.dataset.clone = 'first';
                lastClone.dataset.clone = 'last';

                wrapper.insertBefore(lastClone, items[0]);
                wrapper.appendChild(firstClone);

                // initialize for clones too
                wrapper.querySelectorAll('.shorts-video').forEach(setupVideo);
                setupReadMore(wrapper);
                setupLikeShare(wrapper);
                applyGlobalMuteToAll();

                const pageH = wrapper.clientHeight;
                requestAnimationFrame(() => wrapper.scrollTo({
                    top: pageH
                }));

                let scrollDebounce;
                wrapper.addEventListener('scroll', () => {
                    clearTimeout(scrollDebounce);
                    scrollDebounce = setTimeout(() => {
                        const page = wrapper.clientHeight;
                        const maxIndex = wrapper.querySelectorAll('.shorts-item').length - 2;
                        const top = wrapper.scrollTop;
                        const index = Math.round(top / page);
                        if (index === 0) {
                            wrapper.scrollTo({
                                top: page * (maxIndex),
                                behavior: 'auto'
                            });
                        } else if (index === maxIndex + 1) {
                            wrapper.scrollTo({
                                top: page,
                                behavior: 'auto'
                            });
                        }
                    }, 120);
                });
            }

            // -----------------------------
            // 🎬 Scroll-Based Playback
            // -----------------------------
            let lastScrollY = wrapper.scrollTop;
            let lastTime = performance.now();
            let scrolling = false;
            let settleTimer = null;
            const VELOCITY_THRESHOLD = 0.3;
            const SETTLE_DELAY = 100;

            function onFrame(now) {
                const y = wrapper.scrollTop;
                const dt = Math.max(1, now - lastTime);
                const dy = y - lastScrollY;
                const vel = Math.abs(dy / dt);
                lastScrollY = y;
                lastTime = now;

                if (vel > VELOCITY_THRESHOLD) {
                    scrolling = true;
                    if (settleTimer) {
                        clearTimeout(settleTimer);
                        settleTimer = null;
                    }
                } else if (scrolling && !settleTimer) {
                    settleTimer = setTimeout(() => {
                        scrolling = false;
                        settleTimer = null;
                        const best = findBestInView();
                        if (best) {
                            document.querySelectorAll('.shorts-video').forEach(v => v !== best && safePause(
                                v));
                            best.muted = globalMute;
                            best.defaultMuted = globalMute;
                            if (globalMute) best.setAttribute('muted', '');
                            else best.removeAttribute('muted');
                            safePlay(best);
                        }
                    }, SETTLE_DELAY);
                }
                requestAnimationFrame(onFrame);
            }

            // -----------------------------
            // 🧠 Tab Visibility
            // -----------------------------
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    document.querySelectorAll('.shorts-video').forEach(safePause);
                } else {
                    const best = findBestInView();
                    if (best) {
                        applyGlobalMuteToAll();
                        safePlay(best);
                        document.querySelectorAll('.shorts-video').forEach(v => v !== best && safePause(v));
                    }
                }
            });

            // -----------------------------
            // 🚀 Init
            // -----------------------------
            wrapper.querySelectorAll('.shorts-video').forEach(setupVideo);
            setupReadMore(wrapper);
            setupLikeShare(wrapper);
            setupInfiniteLoop();
            applyGlobalMuteToAll();

            // Play one on load
            setTimeout(() => {
                const best = findBestInView();
                if (best) {
                    best.muted = globalMute;
                    best.defaultMuted = globalMute;
                    safePlay(best);
                    document.querySelectorAll('.shorts-video').forEach(v => v !== best && safePause(v));
                }
            }, 400);

            requestAnimationFrame(onFrame);
        });
    </script>
@endpush