@extends('layouts.public')

@section('title', $fitDoc->title . ' - FitDoc Series')

@section('content')
<div class="container text-white min-vh-100 p-0">
<!-- Hero Section -->
<div class="hero-section py-5"
     style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('{{ $fitDoc->poster_image_path ? getImagePath($fitDoc->poster_image_path) : 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3' }}') center center / cover no-repeat;">

    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-8 text-white">
                <div class="d-flex align-items-center mb-3 flex-wrap gap-3">
                    <span class="badge bg-warning text-dark px-3 py-2 fs-6">Documentary Series</span>
                    @if($fitDoc->year)
                        <span class="text-light fs-6">{{ $fitDoc->year }}</span>
                    @endif
                </div>

                <h1 class="display-4 fw-bold mb-3">{{ $fitDoc->title }}</h1>

                @if($fitDoc->description)
                    <p class="lead mb-4 text-light opacity-85">{{ $fitDoc->description }}</p>
                @endif

                <!-- Series Info -->
                <div class="row g-3 mb-4 text-light opacity-90">
                    @if($fitDoc->director)
                    <div class="col-auto">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tie me-2 text-warning fs-5"></i>
                            <div>
                                <small class="d-block text-uppercase fw-semibold">Director</small>
                                <span>{{ $fitDoc->director }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($fitDoc->duration)
                    <div class="col-auto">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-2 text-warning fs-5"></i>
                            <div>
                                <small class="d-block text-uppercase fw-semibold">Duration</small>
                                <span>{{ $fitDoc->duration }} min</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($fitDoc->language)
                    <div class="col-auto">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-globe me-2 text-warning fs-5"></i>
                            <div>
                                <small class="d-block text-uppercase fw-semibold">Language</small>
                                <span>{{ ucfirst($fitDoc->language) }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap gap-3">
                    @if($fitDoc->video_url)
                        <button class="btn btn-warning btn-lg d-flex align-items-center gap-2" onclick="playTrailer()">
                            <i class="fas fa-play"></i> Play Trailer
                        </button>
                    @endif
                    <button class="btn btn-outline-light btn-lg d-flex align-items-center gap-2">
                        <i class="fas fa-plus"></i> Add to Watchlist
                    </button>
                    <button class="btn btn-outline-light btn-lg d-flex align-items-center gap-2" onclick="shareSeries({{ $fitDoc->id }})">
                        <i class="fas fa-share"></i> Share
                    </button>
                </div>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0 text-center">
                <div class="poster-container mx-auto" style="max-width: 320px;">
                    <img
                        src="{{ $fitDoc->poster_image_path ? getImagePath($fitDoc->poster_image_path) : 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3' }}"
                        alt="{{ $fitDoc->title }}"
                        class="img-fluid rounded shadow-lg"
                        style="max-height: 400px; width: 100%; object-fit: cover;"
                    >
                </div>
            </div>

        </div>
    </div>
</div>


    <!-- Episodes Section -->
<div class="episodes-section py-5 bg-dark text-light">
    <div class="container">
        <h2 class="section-title mb-4 d-flex align-items-center gap-2 fs-3 fw-semibold text-white">
            <i class="fas fa-list text-warning"></i> Episodes
        </h2>

        @if($fitDoc->episodes && $fitDoc->episodes->count() > 0)
            <div class="row g-3">
                @foreach($fitDoc->episodes as $index => $episode)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                        <div class="episode-card bg-secondary rounded shadow-sm overflow-hidden h-100 d-flex flex-column" style="cursor: pointer;"
                             onclick="playEpisode({{ $episode->id }}, '{{ $episode->title }}', '{{ $episode->video_url ?? ($episode->video_file_path ? asset('storage/app/public/' . $episode->video_file_path) : '') }}')">

                            <div class="position-relative" style="aspect-ratio: 16 / 9; overflow: hidden; border-radius: 0.375rem;">
                                <img src="{{ $episode->thumbnail_path ? asset('storage/app/public/' . $episode->thumbnail_path) : 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3' }}"
                                     alt="Episode {{ $index + 1 }}"
                                     class="img-fluid w-100 h-100 object-fit-cover">
                                <div class="play-overlay position-absolute top-50 start-50 translate-middle bg-dark bg-opacity-50 rounded-circle p-3">
                                    <i class="fas fa-play text-white fs-5"></i>
                                </div>
                            </div>

                            <div class="card-body p-2 flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="episode-number text-warning mb-1 fw-semibold">Episode {{ $index + 1 }}</h6>
                                    <h6 class="episode-title mb-1 text-white" style="min-height: 2.4em; font-weight: 600; font-size: 0.95rem;">
                                        {{ $episode->title ?? 'Episode ' . ($index + 1) }}
                                    </h6>
                                    @if($episode->duration)
                                        <small class="text-muted">{{ $episode->duration }} min</small>
                                    @endif
                                </div>
                                <button class="btn btn-warning btn-sm mt-2 w-100 d-flex align-items-center justify-content-center gap-1"
                                        onclick="playEpisode({{ $episode->id }}, '{{ $episode->title }}', '{{ $episode->video_url ?? ($episode->video_file_path ? asset('storage/app/public/' . $episode->video_file_path) : '') }}')">
                                    <i class="fas fa-play"></i> Watch
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-film fa-3x mb-3"></i>
                <h4 class="mb-2">Episodes Coming Soon</h4>
                <p>Episodes for this series are being prepared. Check back soon!</p>
            </div>
        @endif
    </div>
</div>





    <!-- Related Series -->
    <?php /*<div class="related-section py-5 bg-secondary">
        <div class="container">
            <h2 class="section-title mb-4">
                <i class="fas fa-tv me-2"></i>More Documentary Series
            </h2>
            <div class="row">
                @foreach(collect([1,2,3,4])->take(4) as $i)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="content-card bg-dark rounded overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3"
                                 class="card-img-top" style="height: 200px; object-fit: cover;" alt="Related Series">
                            <div class="card-body">
                                <h6 class="card-title">Related Series {{ $i }}</h6>
                                <p class="card-text small text-muted">Discover more fitness documentaries...</p>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-play me-1"></i>Watch
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> */?>
</div>

<style>
.object-fit-cover {
    object-fit: cover;
}

.episode-card {
    transition: transform 0.3s ease;
    cursor: pointer;
}

.episode-card:hover {
    transform: translateY(-5px);
}

.play-overlay {
    background: rgba(0,0,0,0.7);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.episode-card:hover .play-overlay {
    background: rgba(247, 163, 26, 0.9);
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

    .episode-card:hover {
        box-shadow: 0 0.5rem 1rem rgb(255 193 7 / 0.5);
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }

    .episode-card img {
        transition: transform 0.3s ease;
    }

    .episode-card:hover img {
        transform: scale(1.05);
    }

    .play-overlay {
        transition: background-color 0.3s ease;
    }

    .episode-card:hover .play-overlay {
        background-color: rgba(255, 193, 7, 0.8); /* amber highlight */
    }

</style>

<script>
function playTrailer() {
    @if($fitDoc->video_url)
        // Open video in modal or redirect to video player
        window.open('{{ $fitDoc->video_url }}', '_blank');
    @else
        alert('Trailer not available');
    @endif
}

function playEpisode(episodeId, episodeTitle, videoUrl) {
    if (!videoUrl) {
        alert('Video not available for this episode');
        return;
    }

    // Remove any existing modal if present
    const existingModal = document.getElementById('episodeModal');
    if (existingModal) existingModal.remove();

    // Detect video type: YouTube or direct video
    let isYouTube = false;
    let youtubeId = null;
    if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
        isYouTube = true;
        // Extract YouTube video ID with regex
        const match = videoUrl.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
        youtubeId = match ? match[1] : null;
    }

    // Modal inner HTML
    const modalHTML = `
    <div class="modal fade show" id="episodeModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.8);" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark text-light" style="border-radius: 12px; overflow: hidden;">
          <div class="modal-header border-secondary">
            <h5 class="modal-title">${episodeTitle}</h5>
            <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
          </div>
          <div class="modal-body p-2 position-relative" style="background: #000; max-height: 70vh; aspect-ratio: 16 / 9; border-radius: 0.5rem;">
            ${isYouTube && youtubeId ? `
              <iframe id="videoPlayer"
                class="w-100 h-100"
                src="https://www.youtube.com/embed/${youtubeId}?autoplay=1&modestbranding=1&enablejsapi=1"
                frameborder="0"
                allow="autoplay; fullscreen"
                allowfullscreen
                style="border-radius: 0.5rem;">
              </iframe>
            ` : `
              <video id="videoPlayer" class="w-100 h-100" preload="metadata" playsinline style="border-radius: 0.5rem; background: #000; cursor: pointer;">
                <source src="${videoUrl}" type="video/mp4" />
                Your browser does not support the video tag.
              </video>
              <div id="videoControls"
                class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 d-flex align-items-center gap-2 px-3 py-2"
                style="border-radius: 0 0 0.5rem 0.5rem;">
                <button id="prevBtn" class="btn btn-sm btn-outline-light" title="Previous">
                    <i class="fas fa-backward"></i>
                </button>

                <button id="playPauseBtn" class="btn btn-sm btn-outline-light" title="Play/Pause">
                    <i id="playPauseIcon" class="fas fa-play"></i>
                </button>

                <button id="nextBtn" class="btn btn-sm btn-outline-light" title="Next">
                    <i class="fas fa-forward"></i>
                </button>

                <input id="progressBar" type="range" min="0" max="100" value="0" class="form-range flex-grow-1"
                    title="Seek" style="margin: 0 10px; cursor: pointer;" />

                <span id="currentTime" class="text-light small" style="min-width: 50px; text-align: center;">0:00</span>
                <span class="text-light small">/</span>
                <span id="duration" class="text-light small" style="min-width: 50px;">0:00</span>

                <button id="muteBtn" class="btn btn-sm btn-outline-light" title="Mute/Unmute">
                    <i id="muteIcon" class="fas fa-volume-up"></i>
                </button>

                <button id="fullscreenBtn" class="btn btn-sm btn-outline-light" title="Fullscreen">
                    <i id="fullscreenIcon" class="fas fa-expand"></i>
                </button>
              </div>
            `}
          </div>
        </div>
      </div>
    </div>
    `;

    // Append modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Get modal and controls
    const modal = document.getElementById('episodeModal');
    const closeBtn = modal.querySelector('.btn-close');

    closeBtn.addEventListener('click', () => {
        // Pause video if playing
        const vid = document.getElementById('videoPlayer');
        if(vid && vid.tagName.toLowerCase() === 'video') {
            vid.pause();
        }
        modal.remove();
    });

    // Close on outside click (modal backdrop)
    modal.addEventListener('click', e => {
        if (e.target === modal) {
            closeBtn.click();
        }
    });

    // If YouTube, no custom controls needed; else init custom controls
    if (!isYouTube) {
        const video = document.getElementById('videoPlayer');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const playPauseIcon = document.getElementById('playPauseIcon');
        const muteBtn = document.getElementById('muteBtn');
        const muteIcon = document.getElementById('muteIcon');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const fullscreenIcon = document.getElementById('fullscreenIcon');
        const progressBar = document.getElementById('progressBar');
        const currentTimeEl = document.getElementById('currentTime');
        const durationEl = document.getElementById('duration');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return mins + ':' + (secs < 10 ? '0' : '') + secs;
        }

        function updateProgress() {
            if (video.duration) {
                const percent = (video.currentTime / video.duration) * 100;
                progressBar.value = percent;
                currentTimeEl.textContent = formatTime(video.currentTime);
            }
        }

        video.addEventListener('loadedmetadata', () => {
            durationEl.textContent = formatTime(video.duration);
            progressBar.value = 0;
            currentTimeEl.textContent = '0:00';
        });

        function togglePlayPause() {
            if (video.paused) video.play();
            else video.pause();
        }

        function updatePlayPauseIcon() {
            playPauseIcon.className = video.paused ? 'fas fa-play' : 'fas fa-pause';
        }

        function toggleMute() {
            video.muted = !video.muted;
            updateMuteIcon();
        }

        function updateMuteIcon() {
            muteIcon.className = video.muted || video.volume === 0 ? 'fas fa-volume-mute' : 'fas fa-volume-up';
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                if (video.parentElement.requestFullscreen) video.parentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) document.exitFullscreen();
            }
        }

        function updateFullscreenIcon() {
            fullscreenIcon.className = document.fullscreenElement ? 'fas fa-compress' : 'fas fa-expand';
        }

        progressBar.addEventListener('input', () => {
            if (video.duration) {
                const seekTo = (progressBar.value / 100) * video.duration;
                video.currentTime = seekTo;
            }
        });

        video.addEventListener('timeupdate', updateProgress);
        video.addEventListener('play', updatePlayPauseIcon);
        video.addEventListener('pause', updatePlayPauseIcon);
        video.addEventListener('volumechange', updateMuteIcon);
        document.addEventListener('fullscreenchange', updateFullscreenIcon);

        playPauseBtn.addEventListener('click', togglePlayPause);
        muteBtn.addEventListener('click', toggleMute);
        fullscreenBtn.addEventListener('click', toggleFullscreen);
        video.addEventListener('click', togglePlayPause);

        prevBtn.addEventListener('click', () => {
            alert('Previous episode functionality not implemented yet.');
        });

        nextBtn.addEventListener('click', () => {
            alert('Next episode functionality not implemented yet.');
        });

        updatePlayPauseIcon();
        updateMuteIcon();
        updateFullscreenIcon();

        // Auto play video on modal open
        video.play();
    }
}


function playEpisode_old(episodeId, episodeTitle, videoUrl) {
    if (!videoUrl) {
        alert('Video not available for this episode');
        return;
    }

    // Create a modal for video playback
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'episodeModal';
    modal.tabIndex = -1;
    modal.innerHTML = `
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white">${episodeTitle}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <video class="w-100" controls autoplay style="max-height: 70vh;">
                        <source src="${videoUrl}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    // Show the modal
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();

    // Remove modal from DOM when hidden
    modal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(modal);
    });
}

function shareSeries(seriesId) {
    navigator.share({
        title: document.title,
        url: window.location.href
    });
}

function playEpisode_old_2(episodeId, episodeTitle, videoUrl) {
    if (!videoUrl) {
        alert('Video not available for this episode');
        return;
    }

    // detect if YouTube URL
    let videoContent = '';
    if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
        // convert watch?v= to embed/
        let embedUrl = videoUrl
            .replace('watch?v=', 'embed/')
            .replace('youtu.be/', 'youtube.com/embed/');
        videoContent = `
            <div class="ratio ratio-16x9">
                <iframe
                    src="${embedUrl}?autoplay=1"
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen>
                </iframe>
            </div>
        `;
    } else {
        // treat as direct MP4 file
        videoContent = `
            <video class="w-100" controls autoplay style="max-height: 70vh;">
                <source src="${videoUrl}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
    }

    // Create a modal for video playback
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'episodeModal';
    modal.tabIndex = -1;
    modal.innerHTML = `
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white">${episodeTitle}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    ${videoContent}
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    // Show the modal
    const modalInstance = new bootstrap.Modal(modal);
    modalInstance.show();

    // Remove modal from DOM when hidden
    modal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(modal);
    });
}


// Make episode cards clickable
document.querySelectorAll('.episode-card').forEach(card => {
    card.addEventListener('click', function() {
        const episodeBtn = this.querySelector('button[onclick*="playEpisode"]');
        if (episodeBtn) {
            episodeBtn.click();
        }
    });
});
</script>
@endsection
