@extends('layouts.public')

@section('title', $episode->title . ' - ' . $fgSeries->title . ' - FitGuide')

@section('content')
<div class="container min-vh-100">
    <!-- Hero Section -->
    <div class="hero-section py-5"
        style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('{{ $fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}') center/cover;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('fitguide.index') }}"
                                    class="text-light">FitGuide</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fitguide.series.show', $fgSeries->slug) }}"
                                    class="text-light">{{ $fgSeries->title }}</a></li>
                            <li class="breadcrumb-item active text-warning" aria-current="page">Episode {{
                                $episode->episode_number }}</li>
                        </ol>
                    </nav>

                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-3 px-3 py-2">Episode {{ $episode->episode_number }}</span>
                        <span class="badge bg-secondary">{{ $fgSeries->title }}</span>
                    </div>

                    <h1 class="display-4 fw-bold mb-3">{{ $episode->title }}</h1>
                    @if($episode->description)
                    <p class="lead mb-4">{{ $episode->description }}</p>
                    @endif

                    <!-- Episode Info -->
                    <div class="row g-3 mb-4">
                        @if($episode->duration_minutes)
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Duration</small>
                                    <span>{{ $episode->formatted_duration }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-list me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Episode</small>
                                    <span>{{ $episode->episode_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 flex-wrap">
                        @if($episode->video_url || $episode->video_file_path)
                        <button class="btn btn-primary btn-lg" onclick="startEpisode()">
                            <i class="fas fa-play me-2"></i>Watch Episode
                        </button>
                        @endif
                        <a href="{{ route('fitguide.series.show', $fgSeries->slug) }}"
                            class="btn btn-outline-light btn-lg">
                            <i class="fas fa-list me-2"></i>All Episodes
                        </a>
                        <button class="btn btn-outline-light btn-lg">
                            <i class="fas fa-bookmark me-2"></i>Save Episode
                        </button>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="episode-poster">
                        <img src="{{ $fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}"
                            alt="{{ $episode->title }}" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Player Section (Hidden by default) -->
    <div id="videoSection" class="video-section" style="display: none;">
        <div class="container-fluid p-0">
            <div class="video-container position-relative" style="height: 70vh; background: #000;">

                @php
                $videoType = null;
                $videoSource = null;
                $youtubeId = null;

                if ($episode->video_type === 'youtube' && $episode->video_url) {
                $videoType = 'youtube';
                // Extract YouTube video ID from URL
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                $episode->video_url, $matches);
                $youtubeId = $matches[1] ?? null;
                } elseif ($episode->video_type === 's3' && $episode->video_url) {
                $videoType = 's3';
                $videoSource = $episode->video_url;
                } elseif ($episode->video_type === 'upload' && $episode->video_file_path) {
                $videoType = 'upload';
                $videoSource = asset('storage/app/public/' . $episode->video_file_path);
                } elseif ($episode->video_url) {
                // Fallback to direct URL
                $videoType = 'direct';
                $videoSource = $episode->video_url;
                }
                @endphp

                @if($videoType === 'youtube' && $youtubeId)
                <!-- YouTube Player -->
                <div id="youtubePlayerContainer" class="w-100 h-100">
                    <iframe id="youtubePlayer" width="100%" height="100%"
                        src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&rel=0&modestbranding=1"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>

                <!-- YouTube Controls Overlay -->
                <div class="video-controls position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fab fa-youtube text-danger me-2"></i>
                            <span class="text-white">YouTube Video</span>
                        </div>
                        <button class="btn btn-outline-light" onclick="closeVideo()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @elseif($videoSource)
                <!-- HTML5 Video Player (for S3, Upload, Direct URLs) -->
                <video id="episodeVideo" class="w-100 h-100" controls style="object-fit: cover;" preload="metadata">
                    <source src="{{ $videoSource }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                <!-- Video Controls Overlay -->
                <div class="video-controls position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-outline-light" onclick="toggleVideo()">
                                <i id="playPauseIcon" class="fas fa-play"></i>
                            </button>
                            @if($videoType === 's3')
                            <i class="fab fa-aws text-warning me-2"></i>
                            <span class="text-white">AWS S3 Video</span>
                            @elseif($videoType === 'upload')
                            <i class="fas fa-upload text-success me-2"></i>
                            <span class="text-white">Uploaded Video</span>
                            @else
                            <i class="fas fa-video text-info me-2"></i>
                            <span class="text-white">Direct Video</span>
                            @endif
                        </div>
                        <div class="flex-grow-1 mx-3">
                            <input type="range" class="form-range" id="progressBar" min="0" max="100" value="0">
                        </div>
                        <button class="btn btn-outline-light" onclick="closeVideo()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @else
                <!-- No Video Available -->
                <div class="d-flex align-items-center justify-content-center h-100 text-center">
                    <div>
                        <i class="fas fa-video-slash fa-3x text-muted mb-3"></i>
                        <h4 class="text-white">Video Not Available</h4>
                        <p class="text-muted">This episode doesn't have a video configured.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Episode Description -->
    @if($episode->description)
    <div class="description-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="mb-4">About This Episode</h3>
                    <div class="description-content">
                        {!! nl2br(e($episode->description)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Series Episodes -->
    <div class="related-section py-3">
        <div class="container">
            <h2 class="section-title mb-4">
                {{ $fgSeries->title }} - All Episodes
            </h2>
            <div class="row">
                @foreach($fgSeries->episodes->where('is_published', true) as $ep)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div
                        class="content-card bg-dark rounded overflow-hidden {{ $ep->id === $episode->id ? 'border border-primary' : '' }}">
                        <img src="{{ $fgSeries->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}"
                            class="card-img-top" style="height: 200px; object-fit: cover;"
                            alt="Episode {{ $ep->episode_number }}">
                        <div class="card-body">
                            <h6 class="card-title">Episode {{ $ep->episode_number }}: {{ $ep->title }}</h6>
                            <p class="card-text small text-muted">{{ Str::limit($ep->description ?? 'Episode
                                description', 80) }}</p>
                            @if($ep->id === $episode->id)
                            <span class="btn btn-primary btn-sm w-75 d-flex m-auto" onclick="startEpisode()">
                                <i class="fas fa-play me-1"></i>Currently Watching
                            </span>
                            @else
                            <a href="{{ route('fitguide.series.episode', [$fgSeries->slug, $ep->episode_number]) }}"
                                class="btn btn-outline-primary btn-sm w-75 d-flex m-auto">
                                <i class="fas fa-play me-1"></i>Watch Episode
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-dark {
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.4) 50%, rgba(0, 0, 0, 0) 100%);
    }

    .content-card {
        transition: transform 0.3s ease;
    }

    .content-card:hover {
        transform: scale(1.05);
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #ffffff;
    }

    .video-container {
        position: relative;
    }

    .video-controls {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .video-container:hover .video-controls {
        opacity: 1;
    }

    .breadcrumb {
        background: transparent;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        color: #6c757d;
    }
</style>


// <script>
//     $(document).ready(function() {

//     // Function to start the episode
//     function startEpisode() {
//         const videoType = @json($videoType); // Get the video type from Blade to JavaScript

//         if (videoType) {
//             $('#videoSection').fadeIn().scrollIntoView({ behavior: 'smooth' });

//             if (videoType === 'youtube') {
//                 // YouTube iframe will auto-load, no need to programmatically play
//                 console.log('YouTube video loaded');
//             } else {
//                 // For HTML5 video players (like S3 or uploaded videos)
//                 const video = $('#episodeVideo')[0]; // Get the actual video DOM element
//                 if (video) {
//                     video.play().catch(function(error) {
//                         console.log('Auto-play was prevented:', error);
//                         // Optionally show a play button if auto-play fails
//                     });
//                     updatePlayPauseIcon();
//                 }
//             }
//         } else {
//             alert('Video not available for this episode');
//         }
//     }

//     // Toggle play/pause of the video
//     function toggleVideo() {
//         const video = $('#episodeVideo')[0];
//         if (video.paused) {
//             video.play();
//         } else {
//             video.pause();
//         }
//         updatePlayPauseIcon();
//     }

//     // Close the video section
//     function closeVideo() {
//         const video = $('#episodeVideo')[0];
//         if (video) {
//             video.pause();
//         }
//         $('#videoSection').fadeOut();
//         $('html, body').animate({ scrollTop: 0 }, 'smooth');
//     }

//     // Update the play/pause icon
//     function updatePlayPauseIcon() {
//         const video = $('#episodeVideo')[0];
//         const icon = $('#playPauseIcon');
//         if (video && icon.length) {
//             icon.attr('class', video.paused ? 'fas fa-play' : 'fas fa-pause');
//         }
//     }

//     // Video progress tracking
//     const video = $('#episodeVideo')[0];
//     const progressBar = $('#progressBar');

//     if (video && progressBar.length) {
//         // Update progress bar as video plays
//         $(video).on('timeupdate', function() {
//             if (video.duration && !isNaN(video.duration)) {
//                 const progress = (video.currentTime / video.duration) * 100;
//                 progressBar.val(progress);
//             }
//         });

//         // Scrubbing (seeking) via the progress bar
//         progressBar.on('input', function() {
//             if (video.duration && !isNaN(video.duration)) {
//                 const time = (progressBar.val() / 100) * video.duration;
//                 video.currentTime = time;
//             }
//         });

//         // Update play/pause icon when video is played or paused
//         $(video).on('play', updatePlayPauseIcon);
//         $(video).on('pause', updatePlayPauseIcon);

//         // Handle video loading errors
//         $(video).on('error', function(e) {
//             console.error('Video failed to load:', e);
//             alert('Sorry, there was an error loading the video. Please check your connection and try again.');
//         });

//         // Handle when the video is ready to play
//         $(video).on('canplay', function() {
//             console.log('Video is ready to play');
//         });
//     }

//     // Event Listeners for the buttons
//     $('#startEpisodeBtn').on('click', startEpisode); // Assuming button has an id of startEpisodeBtn
//     $('#toggleVideoBtn').on('click', toggleVideo);   // Assuming button has an id of toggleVideoBtn
//     $('#closeVideoBtn').on('click', closeVideo);     // Assuming button has an id of closeVideoBtn
// });
// </script>

<script>
    function startEpisode() {
        const videoType = @json($videoType);
    
        if (videoType) {
            $('#videoSection').fadeIn();
            document.getElementById('videoSection').scrollIntoView({ behavior: 'smooth' });
    
            if (videoType === 'youtube') {
                console.log('YouTube video loaded');
            } else {
                const video = $('#episodeVideo')[0];
                if (video) {
                    video.play().catch(error => console.log('Auto-play prevented:', error));
                    updatePlayPauseIcon();
                }
            }
        } else {
            alert('Video not available for this episode');
        }
    }
    
    function toggleVideo() {
        const video = $('#episodeVideo')[0];
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
        updatePlayPauseIcon();
    }
    
    function closeVideo() {
        const video = $('#episodeVideo')[0];
        if (video) video.pause();
        $('#videoSection').fadeOut();
        $('html, body').animate({ scrollTop: 0 }, 'smooth');
    }
    
    function updatePlayPauseIcon() {
        const video = $('#episodeVideo')[0];
        const icon = $('#playPauseIcon');
        if (video && icon.length) {
            icon.attr('class', video.paused ? 'fas fa-play' : 'fas fa-pause');
        }
    }
    
    $(document).ready(function() {
        const video = $('#episodeVideo')[0];
        const progressBar = $('#progressBar');
    
        if (video && progressBar.length) {
            $(video).on('timeupdate', function() {
                if (video.duration && !isNaN(video.duration)) {
                    progressBar.val((video.currentTime / video.duration) * 100);
                }
            });
    
            progressBar.on('input', function() {
                if (video.duration && !isNaN(video.duration)) {
                    video.currentTime = (progressBar.val() / 100) * video.duration;
                }
            });
    
            $(video).on('play pause', updatePlayPauseIcon);
            $(video).on('canplay', () => console.log('Video ready'));
            $(video).on('error', e => console.error('Video load error:', e));
        }
    });
</script>

@endsection