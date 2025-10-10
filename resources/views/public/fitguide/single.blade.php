@extends('layouts.public')

@section('title', $fgSingle->title . ' - FitGuide')

@section('content')
<div class="container-fluid bg-dark text-white min-vh-100">
    <!-- Hero Section -->
    <div class="hero-section py-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('{{ $fgSingle->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}') center/cover;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-primary me-3 px-3 py-2">Fitness Guide</span>
                        @if($fgSingle->category)
                            <span class="badge bg-secondary me-2">{{ $fgSingle->category->name }}</span>
                        @endif
                        @if($fgSingle->subCategory)
                            <span class="badge bg-outline-light">{{ $fgSingle->subCategory->name }}</span>
                        @endif
                    </div>
                    <h1 class="display-4 fw-bold mb-3">{{ $fgSingle->title }}</h1>
                    @if($fgSingle->description)
                        <p class="lead mb-4">{{ $fgSingle->description }}</p>
                    @endif
                    
                    <!-- Guide Info -->
                    <div class="row g-3 mb-4">
                        @if($fgSingle->duration_minutes)
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Duration</small>
                                    <span>{{ floor($fgSingle->duration_minutes / 60) }}h {{ $fgSingle->duration_minutes % 60 }}m</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($fgSingle->language)
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-globe me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Language</small>
                                    <span>{{ ucfirst($fgSingle->language) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($fgSingle->feedback)
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-star me-2 text-warning"></i>
                                <div>
                                    <small class="text-muted d-block">Rating</small>
                                    <span>{{ $fgSingle->feedback }}/10</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 flex-wrap">
                        @if($fgSingle->video_url || $fgSingle->video_file_path)
                            <button class="btn btn-primary btn-lg" onclick="startGuide()">
                                <i class="fas fa-play me-2"></i>Start Guide
                            </button>
                        @endif
                        @if($fgSingle->trailer_url || $fgSingle->trailer_file_path)
                            <button class="btn btn-outline-light btn-lg" onclick="playTrailer()">
                                <i class="fas fa-video me-2"></i>Watch Trailer
                            </button>
                        @endif
                        <button class="btn btn-outline-light btn-lg">
                            <i class="fas fa-bookmark me-2"></i>Save Guide
                        </button>
                        <button class="btn btn-outline-light btn-lg" onclick="shareCasts({{ $fgSingle->id }})">
                            <i class="fas fa-share"></i> Share
                        </button>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="guide-poster">
                        <img src="{{ $fgSingle->banner_image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3' }}" 
                             alt="{{ $fgSingle->title }}" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
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
                    
                    if ($fgSingle->video_type === 'youtube' && $fgSingle->video_url) {
                        $videoType = 'youtube';
                        // Extract YouTube video ID from URL
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $fgSingle->video_url, $matches);
                        $youtubeId = $matches[1] ?? null;
                    } elseif ($fgSingle->video_type === 's3' && $fgSingle->video_url) {
                        $videoType = 's3';
                        $videoSource = $fgSingle->video_url;
                    } elseif ($fgSingle->video_type === 'upload' && $fgSingle->video_file_path) {
                        $videoType = 'upload';
                        $videoSource = asset('storage/app/public/' . $fgSingle->video_file_path);
                    } elseif ($fgSingle->video_url) {
                        // Fallback to direct URL
                        $videoType = 'direct';
                        $videoSource = $fgSingle->video_url;
                    }
                @endphp

                @if($videoType === 'youtube' && $youtubeId)
                    <!-- YouTube Player -->
                    <div id="youtubePlayerContainer" class="w-100 h-100">
                        <iframe id="youtubePlayer" 
                                width="100%" 
                                height="100%" 
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
                    <video id="guideVideo" class="w-100 h-100" controls style="object-fit: cover;" preload="metadata">
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
                            <p class="text-muted">This guide doesn't have a video configured.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Content Description -->
    @if($fgSingle->description)
    <div class="description-section py-5">
        <div class="container">
            <h2 class="section-title mb-4">
                <i class="fas fa-info-circle me-2"></i>About This Guide
            </h2>
            <div class="row">
                <div class="col-lg-8">
                    <div class="description-content bg-secondary p-4 rounded">
                        <p class="mb-0" style="line-height: 1.8;">{{ $fgSingle->description }}</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="guide-stats bg-secondary p-4 rounded">
                        <h5 class="mb-3">Guide Details</h5>
                        <div class="stat-item d-flex justify-content-between mb-2">
                            <span>Category:</span>
                            <span>{{ $fgSingle->category->name ?? 'N/A' }}</span>
                        </div>
                        @if($fgSingle->subCategory)
                        <div class="stat-item d-flex justify-content-between mb-2">
                            <span>Subcategory:</span>
                            <span>{{ $fgSingle->subCategory->name }}</span>
                        </div>
                        @endif
                        <div class="stat-item d-flex justify-content-between mb-2">
                            <span>Language:</span>
                            <span>{{ ucfirst($fgSingle->language) }}</span>
                        </div>
                        @if($fgSingle->release_date)
                        <div class="stat-item d-flex justify-content-between mb-2">
                            <span>Released:</span>
                            <span>{{ $fgSingle->release_date->format('M Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Related Guides -->
    <!-- <div class="related-section py-5 bg-secondary">
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
    </div> -->
</div>

<style>
.bg-gradient-dark {
    background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0) 100%);
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
</style>

<script>
function startGuide() {
    @if($videoType)
        const videoSection = document.getElementById('videoSection');
        videoSection.style.display = 'block';
        videoSection.scrollIntoView({ behavior: 'smooth' });
        
        @if($videoType === 'youtube')
            // YouTube iframe will auto-load, no need to programmatically play
            console.log('YouTube video loaded');
        @else
            // For HTML5 video players
            const video = document.getElementById('guideVideo');
            if (video) {
                video.play().catch(function(error) {
                    console.log('Auto-play was prevented:', error);
                    // Show play button if auto-play fails
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
    video.pause();
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

// Video progress tracking
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('guideVideo');
    const progressBar = document.getElementById('progressBar');
    
    if (video && progressBar) {
        video.addEventListener('timeupdate', function() {
            if (video.duration && !isNaN(video.duration)) {
                const progress = (video.currentTime / video.duration) * 100;
                progressBar.value = progress;
            }
        });
        
        progressBar.addEventListener('input', function() {
            if (video.duration && !isNaN(video.duration)) {
                const time = (progressBar.value / 100) * video.duration;
                video.currentTime = time;
            }
        });
        
        video.addEventListener('play', updatePlayPauseIcon);
        video.addEventListener('pause', updatePlayPauseIcon);
        
        // Handle video loading errors
        video.addEventListener('error', function(e) {
            console.error('Video failed to load:', e);
            alert('Sorry, there was an error loading the video. Please check your connection and try again.');
        });
        
        // Handle when video data starts loading
        video.addEventListener('loadstart', function() {
            console.log('Video loading started');
        });
        
        // Handle when video is ready to play
        video.addEventListener('canplay', function() {
            console.log('Video is ready to play');
        });
    }
});

function shareCasts(castId) {
    navigator.share({
        title: document.title,
        url: window.location.href
    });
}

</script>
@endsection
