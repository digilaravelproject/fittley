@extends('layouts.public')

@section('title', 'FitFlix Shorts')

@section('content')
    <div class="shorts-container row justify-content-center align-items-center">
        <div class="shorts-wrapper" id="shortsWrapper">
            @foreach ($shorts as $short)
                <div class="shorts-item">

                    <!-- Video -->
                    <video class="shorts-video" preload="metadata" playsinline webkit-playsinline autoplay muted defaultMuted
                        poster="{{ getImagePath($short->thumbnail_path) }}" data-src="{{ getImagePath($short->video_path) }}">
                        Your browser does not support the video tag.
                    </video>

                    <!-- Transparent overlay -->
                    <div class="video-overlay"></div>

                    <!-- User Info -->
                    <div class="shorts-user-info">
                        <img src="{{ asset('storage/app/public/default-profile1.png') }}" alt="{{ $short->uploader->name }}"
                            class="user-avatar">
                        <span class="username">{{ '@ ' . $short->title }}</span><br>
                    </div>

                    <!-- Description -->
                    <div class="shorts-description">
                        <p class="description-text line-clamp" data-full="{{ $short->description }}">
                            {{ $short->description }}
                        </p>
                        <button class="read-more-btn">Read more</button>
                    </div>

                    <!-- Actions -->
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
        /* Hide Navbar/Footer */
        navbar-expand-lg {
            display: none;
        }

        footer {
            display: none;
        }

        /* Container & Wrapper */
        .shorts-container {
            position: fixed;
            top: 3rem;
            bottom: 0;
            left: 0;
            right: 0;
            overflow: hidden;
            background: black;
            user-select: none;
        }

        .shorts-wrapper {
            height: 100%;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scrollbar-width: none;
            width: 425px !important;
            background-color: black;
            padding: 0;
            user-select: none;
            -webkit-user-drag: none;
        }

        .shorts-wrapper::-webkit-scrollbar {
            display: none;
        }

        /* Item & Video */
        .shorts-item {
            position: relative;
            height: 100%;
            scroll-snap-align: start;
            display: flex;
            justify-content: center;
            align-items: center;
            background: black;
            user-select: none;
        }

        .shorts-video {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            will-change: transform, opacity;
            -webkit-user-drag: none;
        }

        /* Transparent overlay */
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 5;
        }

        /* User Info */
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

        /* Description */
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
            padding: 0 5rem 0 6px;
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

        /* Actions Overlay */
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
            let userHasUnmuted = false;
            let currentPlaying = null;

            const videos = Array.from(document.querySelectorAll('.shorts-video'));
            const overlays = Array.from(document.querySelectorAll('.video-overlay'));

            // Lazy set video src to hide URL
            videos.forEach(video => video.src = video.dataset.src);

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    if (entry.isIntersecting) {
                        if (currentPlaying && currentPlaying !== video) currentPlaying.pause();
                        currentPlaying = video;
                        video.currentTime = 0;
                        video.muted = !userHasUnmuted;
                        video.play().catch(() => { });
                    } else { video.pause(); }
                });
            }, { threshold: 0.75 });

            videos.forEach((video, idx) => {
                video.muted = true;
                video.defaultMuted = true;
                video.playsInline = true;

                // Disable right-click
                video.addEventListener('contextmenu', e => e.preventDefault());
                // Prevent drag
                video.addEventListener('dragstart', e => e.preventDefault());

                // Prevent long-press mobile
                let touchStartTime = 0;
                video.addEventListener('touchstart', e => touchStartTime = Date.now());
                video.addEventListener('touchend', e => { if (Date.now() - touchStartTime > 500) e.preventDefault(); });

                // Overlay click -> toggle mute
                const overlay = overlays[idx];
                overlay.addEventListener('click', () => {
                    userHasUnmuted = video.muted;
                    video.muted = !userHasUnmuted;
                    video.defaultMuted = !userHasUnmuted;
                    video.play().catch(() => { });
                    videos.forEach(v => { if (v !== video) v.muted = !userHasUnmuted; });
                });

                // Preload next video
                video.addEventListener('playing', () => {
                    const nextItem = video.closest('.shorts-item').nextElementSibling;
                    if (nextItem) {
                        const nextVideo = nextItem.querySelector('video');
                        if (nextVideo) nextVideo.preload = 'metadata';
                    }
                });

                // Adaptive playback rate
                let bufferingCount = 0;
                video.addEventListener('waiting', () => { bufferingCount++; if (bufferingCount > 2) video.playbackRate = 0.9; });
                video.addEventListener('playing', () => { bufferingCount = 0; video.playbackRate = 1.0; });

                // Loop only current
                video.addEventListener('ended', () => { if (video === currentPlaying) video.play(); });

                observer.observe(video);
            });

            // Read More
            function setupReadMore(root) {
                root.querySelectorAll('.read-more-btn').forEach(btn => {
                    if (btn.dataset.bound === '1') return;
                    btn.dataset.bound = '1';
                    const descEl = btn.previousElementSibling;
                    btn.addEventListener('click', () => {
                        descEl.classList.toggle('expanded');
                        btn.textContent = descEl.classList.contains('expanded') ? 'Read less' : 'Read more';
                    });
                });
            }

            // Like & Share
            function setupLikeShare(root) {
                root.querySelectorAll('.like-btn').forEach(btn => {
                    if (btn.dataset.bound === '1') return; btn.dataset.bound = '1';
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        const videoId = btn.dataset.id;
                        const countEl = btn.querySelector('.count');
                        fetch(`/fitlive/toggle-like/${videoId}`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                        }).then(res => res.json())
                            .then(data => {
                                if (data.success) { btn.classList.toggle('active', data.data.is_liked); countEl.textContent = data.data.likes_count; }
                                else alert(data.message || 'Something went wrong!');
                            }).catch(err => console.error(err));
                    });
                });

                root.querySelectorAll('.share-btn').forEach(btn => {
                    if (btn.dataset.bound === '1') return; btn.dataset.bound = '1';
                    btn.addEventListener('click', e => {
                        e.stopPropagation();
                        const videoId = btn.dataset.id;
                        const countEl = btn.querySelector('.count');
                        fetch(`/fitlive/share-video/${videoId}`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                        }).then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    countEl.textContent = data.data.shares_count;
                                    navigator.clipboard.writeText(data.data.share_link).then(() => alert('Share link copied!'));
                                } else alert(data.message || 'Failed to share video');
                            }).catch(err => console.error(err));
                    });
                });
            }

            setupReadMore(wrapper);
            setupLikeShare(wrapper);
        });
    </script>
@endpush