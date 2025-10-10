@extends('layouts.public')

@section('title', 'FitFlix Shorts')

@section('content')
    <div class="shorts-container row justify-content-center align-items-center">
        <div class="shorts-wrapper" id="shortsWrapper">
            @foreach ($shorts as $short)
                <div class="shorts-item">

                    <!-- Video -->
                    <video
                        class="shorts-video"
                        preload="metadata"
                        playsinline
                        webkit-playsinline
                        autoplay
                        loop
                        muted
                        defaultMuted
                        poster="{{ asset('storage/app/public/' . $short->thumbnail_path) }}"
                    >
                        <source
                            src="{{ asset('storage/app/public/' . $short->video_path) }}"
                            type="video/mp4"
                        />
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
                        <button class="action-btn like-btn {{ $short->isLiked ? 'active' : '' }}"
                            data-id="{{ $short->id }}">
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
        navbar-expand-lg { display: none; }
        footer { display: none; }

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
        .shorts-wrapper::-webkit-scrollbar { display: none; }

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
        .action-btn:hover { transform: scale(1.2); }
        .action-btn.active { color: #e74c3c; }
        .action-btn .count {
            font-size: 0.75rem;
            margin-top: 2px;
            color: #fff;
        }
    </style>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
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
            v.play().catch(() => {});
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
            btn.addEventListener('click', function() {
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

            btn.addEventListener('click', function(e) {
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

            btn.addEventListener('click', function(e) {
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
                video.play().catch(() => {});
            } else {
                video.pause();
            }
        });
    }, { threshold: 0.75 });

    // --- 1) Build seamless loop: clone first and last ---
    let items = Array.from(wrapper.querySelectorAll('.shorts-item'));
    if (items.length > 0) {
        const firstClone = items[0].cloneNode(true);
        const lastClone  = items[items.length - 1].cloneNode(true);

        // mark clones (optional, not used for styling)
        firstClone.dataset.clone = 'first';
        lastClone.dataset.clone  = 'last';

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
