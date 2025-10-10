@extends('layouts.public')

@section('title', $fgSingle->title . ' - FitGuide')

@section('content')
    <div class="container p-0 text-white min-vh-100 d-flex flex-column">

        <!-- Hero Section -->
        <section class="hero-section py-5 rounded"
            style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.85)), url('{{ getImagePath($fgSingle->banner_image_url ?? null) ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}') center center / cover no-repeat;">
            <div class="container">
                <div class="row align-items-center gy-4">

                    <div class="col-lg-7 col-md-8">
                        <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
                            <span class="badge bg-primary px-3 py-2 fw-semibold text-uppercase">Fitness Guide</span>

                            @if($fgSingle->category)
                                <span
                                    class="badge bg-secondary px-3 py-2 fw-semibold text-uppercase">{{ $fgSingle->category->name }}</span>
                            @endif

                            @if($fgSingle->subCategory)
                                <span
                                    class="badge border border-light text-light px-3 py-2 fw-semibold text-uppercase">{{ $fgSingle->subCategory->name }}</span>
                            @endif
                        </div>

                        <h1 class="display-4 fw-bold mb-3">{{ $fgSingle->title }}</h1>

                        @if($fgSingle->description)
                            <p class="lead mb-4 text-white-75">{{ $fgSingle->description }}</p>
                        @endif

                        <!-- Guide Info -->
                        <div class="d-flex flex-wrap gap-4 mb-4 text-white-50">
                            @if($fgSingle->duration_minutes)
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-clock fa-lg text-primary"></i>
                                    <div>
                                        <small class="d-block">Duration</small>
                                        <span>{{ floor($fgSingle->duration_minutes / 60) }}h
                                            {{ $fgSingle->duration_minutes % 60 }}m</span>
                                    </div>
                                </div>
                            @endif

                            @if($fgSingle->language)
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-globe fa-lg text-primary"></i>
                                    <div>
                                        <small class="d-block">Language</small>
                                        <span>{{ ucfirst($fgSingle->language) }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($fgSingle->feedback)
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-star fa-lg text-warning"></i>
                                    <div>
                                        <small class="d-block">Rating</small>
                                        <span>{{ $fgSingle->feedback }}/10</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap gap-3">
                            @if($fgSingle->video_url || $fgSingle->video_file_path)
                                <button class="btn btn-primary btn-lg shadow-sm" onclick="startGuide()">
                                    <i class="fas fa-play me-2"></i>Start Guide
                                </button>
                            @endif

                            @if($fgSingle->trailer_url || $fgSingle->trailer_file_path)
                                <button class="btn btn-outline-light btn-lg shadow-sm" onclick="playTrailer()">
                                    <i class="fas fa-video me-2"></i>Watch Trailer
                                </button>
                            @endif

                            <button class="btn btn-outline-light btn-lg shadow-sm">
                                <i class="fas fa-bookmark me-2"></i>Save Guide
                            </button>

                            <button class="btn btn-outline-light btn-lg shadow-sm"
                                onclick="shareCasts({{ $fgSingle->id }})">
                                <i class="fas fa-share"></i> Share
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-4 text-center">
                        <img src="{{ getImagePath($fgSingle->banner_image_url ?? null) ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}"
                            alt="{{ $fgSingle->title }}" class="img-fluid rounded shadow-lg"
                            style="max-height: 400px; object-fit: cover; width: 100%;">
                    </div>

                </div>
            </div>
        </section>

        <!-- Video Player Section (Hidden by default) -->
        <section id="videoSection" class="video-section flex-grow-1" style="display: none;">
            <div class="container-fluid p-0">
                <div class="video-container position-relative" style="height: 70vh; background: #000;">
                    @php
                        $videoType = null;
                        $videoSource = null;
                        $youtubeId = null;

                        if ($fgSingle->video_type === 'youtube' && $fgSingle->video_url) {
                            $videoType = 'youtube';
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $fgSingle->video_url, $matches);
                            $youtubeId = $matches[1] ?? null;
                        } elseif ($fgSingle->video_type === 's3' && $fgSingle->video_url) {
                            $videoType = 's3';
                            $videoSource = $fgSingle->video_url;
                        } elseif ($fgSingle->video_type === 'upload' && $fgSingle->video_file_path) {
                            $videoType = 'upload';
                            $videoSource = asset('storage/app/public/' . $fgSingle->video_file_path);
                        } elseif ($fgSingle->video_url) {
                            $videoType = 'direct';
                            $videoSource = $fgSingle->video_url;
                        }
                    @endphp

                    @if($videoType === 'youtube' && $youtubeId)
                        <div id="youtubePlayerContainer" class="w-100 h-100">
                            <iframe id="youtubePlayer" width="100%" height="100%"
                                src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&rel=0&modestbranding=1"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <div
                            class="video-controls position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3 text-white">
                                <i class="fab fa-youtube fa-lg text-danger"></i>
                                <span>YouTube Video</span>
                            </div>
                            <button class="btn btn-outline-light btn-sm" aria-label="Close Video" onclick="closeVideo()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @elseif($videoSource)
                        <video id="guideVideo" class="w-100 h-100" controls style="object-fit: cover;" preload="metadata">
                            <source src="{{ $videoSource }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>

                        <div
                            class="video-controls position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark d-flex align-items-center">
                            <button class="btn btn-outline-light btn-sm me-3" onclick="toggleVideo()"
                                aria-label="Play/Pause Video">
                                <i id="playPauseIcon" class="fas fa-play"></i>
                            </button>

                            @if($videoType === 's3')
                                <i class="fab fa-aws fa-lg text-warning me-2"></i>
                                <span class="text-white me-auto">AWS S3 Video</span>
                            @elseif($videoType === 'upload')
                                <i class="fas fa-upload fa-lg text-success me-2"></i>
                                <span class="text-white me-auto">Uploaded Video</span>
                            @else
                                <i class="fas fa-video fa-lg text-info me-2"></i>
                                <span class="text-white me-auto">Direct Video</span>
                            @endif

                            <input type="range" class="form-range flex-grow-1 mx-3" id="progressBar" min="0" max="100" value="0"
                                aria-label="Video progress bar">

                            <button class="btn btn-outline-light btn-sm" aria-label="Close Video" onclick="closeVideo()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center px-3">
                            <i class="fas fa-video-slash fa-4x text-muted mb-3"></i>
                            <h4 class="text-white">Video Not Available</h4>
                            <p class="text-muted">This guide doesn't have a video configured.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Content Description -->
        @if($fgSingle->description)
            <section class="description-section py-5 bg-secondary text-white">
                <div class="container">
                    <h2 class="section-title mb-4 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-info-circle"></i> About This Guide
                    </h2>
                    <div class="row gy-4">
                        <div class="col-lg-8">
                            <div class="p-4 rounded bg-dark shadow-sm" style="line-height: 1.7;">
                                <p class="mb-0">{{ $fgSingle->description }}</p>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="p-4 rounded bg-dark shadow-sm">
                                <h5 class="mb-3 fw-semibold">Guide Details</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex justify-content-between py-2 border-bottom">
                                        <strong>Category:</strong>
                                        <span>{{ $fgSingle->category->name ?? 'N/A' }}</span>
                                    </li>

                                    @if($fgSingle->subCategory)
                                        <li class="d-flex justify-content-between py-2 border-bottom">
                                            <strong>Subcategory:</strong>
                                            <span>{{ $fgSingle->subCategory->name }}</span>
                                        </li>
                                    @endif

                                    <li class="d-flex justify-content-between py-2 border-bottom">
                                        <strong>Language:</strong>
                                        <span>{{ ucfirst($fgSingle->language) }}</span>
                                    </li>

                                    @if($fgSingle->release_date)
                                        <li class="d-flex justify-content-between py-2">
                                            <strong>Released:</strong>
                                            <span>{{ $fgSingle->release_date->format('M Y') }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Related Guides -->
        {{-- <!-- <div class="related-section py-5 bg-secondary">
                        <div class="container">
                            <h2 class="section-title mb-4">
                                <i class="fas fa-dumbbell me-2"></i>Related Guides
                            </h2>
                            <div class="row">
                                @foreach(collect([1,2,3,4])->take(4) as $i)
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="content-card bg-dark rounded overflow-hidden">
                                            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3"
                                                 class="card-img-top" style="height: 200px; object-fit: cover;" alt="Related Guide">
                                            <div class="card-body">
                                                <h6 class="card-title">Related Guide {{ $i }}</h6>
                                                <p class="card-text small text-muted">Discover more fitness guides...</p>
                                                <button class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-play me-1"></i>Start Guide
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div> --> --}}
    </div>

    <style>
        .bg-gradient-dark {
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0) 100%);
        }

        .section-title {
            font-size: 2rem;
        }

        .video-controls {
            transition: opacity 0.3s ease;
        }

        .video-container:hover .video-controls {
            opacity: 1;
        }

        /* Smooth scale on buttons hover */
        button.btn {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        button.btn-primary:hover {
            background-color: #004085;
            border-color: #004085;
        }

        button.btn-outline-light:hover {
            background-color: #ffffff22;
            color: #fff;
        }
    </style>

    <script>
        // Your existing JS (unchanged)
        function startGuide() {
            @if($videoType)
                const videoSection = document.getElementById('videoSection');
                videoSection.style.display = 'block';
                videoSection.scrollIntoView({ behavior: 'smooth' });

                @if($videoType === 'youtube')
                    console.log('YouTube video loaded');
                @else
                                        const video = document.getElementById('guideVideo');
                    if (video) {
                        video.play().catch(function (error) {
                            console.log('Auto-play was prevented:', error);
                        });
                        updatePlayPauseIcon();
                    }
                @endif
            @else
                alert('Video not available for this guide');
            @endif
            }

        function playTrailer() {
            @if($fgSingle->trailer_url)
                window.open('{{ $fgSingle->trailer_url }}', '_blank');
            @elseif($fgSingle->trailer_file_path)
                window.open('{{ asset('storage/app/public/' . $fgSingle->trailer_file_path) }}', '_blank');
            @else
                alert('Trailer not available');
            @endif
            }

        function toggleVideo() {
            const video = document.getElementById('guideVideo');
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
            updatePlayPauseIcon();
        }

        function closeVideo() {
            const videoSection = document.getElementById('videoSection');
            const video = document.getElementById('guideVideo');
            if (video) video.pause();
            videoSection.style.display = 'none';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function updatePlayPauseIcon() {
            const video = document.getElementById('guideVideo');
            const icon = document.getElementById('playPauseIcon');
            if (video.paused) {
                icon.className = 'fas fa-play';
            } else {
                icon.className = 'fas fa-pause';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const video = document.getElementById('guideVideo');
            const progressBar = document.getElementById('progressBar');

            if (video && progressBar) {
                video.addEventListener('timeupdate', function () {
                    if (video.duration && !isNaN(video.duration)) {
                        const progress = (video.currentTime / video.duration) * 100;
                        progressBar.value = progress;
                    }
                });

                progressBar.addEventListener('input', function () {
                    if (video.duration && !isNaN(video.duration)) {
                        const time = (progressBar.value / 100) * video.duration;
                        video.currentTime = time;
                    }
                });

                video.addEventListener('play', updatePlayPauseIcon);
                video.addEventListener('pause', updatePlayPauseIcon);

                video.addEventListener('error', function (e) {
                    console.error('Video failed to load:', e);
                    alert('Sorry, there was an error loading the video. Please check your connection and try again.');
                });
            }
        });

        function shareCasts(castId) {
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: window.location.href
                }).catch(console.error);
            } else {
                alert('Sharing not supported on this browser.');
            }
        }
    </script>
@endsection