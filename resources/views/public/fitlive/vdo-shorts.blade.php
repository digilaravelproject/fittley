@extends('layouts.public')

@section('title', 'FitFlix Shorts')

@section('content')
    <div class="shorts-container row justify-content-center align-items-center">
        <div class="shorts-wrapper">
            @foreach ($shorts as $short)
                <div class="shorts-item">

                    <!-- Video -->
                    <video class="shorts-video" src="{{ asset('storage/app/public/' . $short->video_path) }}"
                        poster="{{ asset('storage/app/public/' . $short->thumbnail_path) }}" playsinline autoplay loop>
                    </video>

                    <!-- Top Left: User Info -->
                    <div class="shorts-user-info">
                        <img src="{{ asset('storage/app/public/default-profile1.png') }}" alt="{{ $short->uploader->name }}"
                            class="user-avatar">
                        <span class="username">{{ '@' . $short->title }}</span><br>
                    </div>

                    <!-- <div class="shorts-description1">
                            <p class="description-text1 line-clamp1">
                                {{ $short->category->name }}
                            </p>
                        </div> -->

                    <!-- Bottom Left: Description -->
                    <div class="shorts-description">
                        <p class="description-text line-clamp" data-full="{{ $short->description }}">
                            {{ $short->description }}
                        </p>
                        <button class="read-more-btn">Read more</button>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="shorts-actions-overlay">
                        <!-- Views -->
                        {{-- <button class="action-btn views-btn" disabled>
                            <i class="fas fa-eye"></i>
                            <span class="count">{{ $short->views_count ?? 0 }}</span>
                        </button> --}}

                        <button class="action-btn like-btn {{ $short->isLiked ? 'active' : '' }}"
                            data-id="{{ $short->id }}">
                            <i class="far fa-thumbs-up"></i>

                            <span class="count">{{ $short->likes_count }}</span>
                        </button>
                        <!-- <button class="action-btn like-btn {{ $short->isUnLiked ? 'active' : '' }}"
                                data-id="{{ $short->id }}">
                                <i class="far fa-thumbs-down"></i>


                                <span class="count">{{ $short->unlikes_count }}</span>
                            </button> -->
                        <!-- <button class="action-btn like-btn" data-id="{{ $short->id }}">
                                <i class="fa-regular fa-comment"></i>


                                <span class="count">{{ $short->comments }}</span>
                            </button> -->

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
        }

        .shorts-description {
            position: absolute;
            bottom: 2rem;
            left: 16px;
            right: 80px;
            z-index: 10;
            color: #fff;
            font-size: 1rem;
        }

        .description-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* show only 3 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .description-text.expanded {
            -webkit-line-clamp: unset;
            /* remove line clamp */
            overflow: visible;
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const videos = document.querySelectorAll('.shorts-video');

            // Auto-play/pause on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    entry.isIntersecting ? video.play() : video.pause();
                });
            }, {
                threshold: 0.75
            });
            videos.forEach(video => observer.observe(video));

            // Like button
            document.querySelectorAll('.like-btn').forEach(btn => {
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

            // Share button
            document.querySelectorAll('.share-btn').forEach(btn => {
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
        });
    </script>
    <script>
        document.querySelectorAll('.read-more-btn').forEach(btn => {
            const descEl = btn.previousElementSibling;
            btn.addEventListener('click', function() {
                descEl.classList.toggle('expanded');
                btn.textContent = descEl.classList.contains('expanded') ? 'Read less' : 'Read more';
            });
        });
    </script>
@endpush
