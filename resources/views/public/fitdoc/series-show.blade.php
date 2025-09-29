@extends('layouts.public')

@section('title', $fitDoc->title . ' - FitDoc Series')

@section('content')
<div class="container-fluid bg-dark text-white min-vh-100">
    <!-- Hero Section -->
    <div class="hero-section py-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), url('{{ $fitDoc->banner_image_url ?? 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3' }}') center/cover;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-warning text-dark me-3 px-3 py-2">Documentary Series</span>
                        @if($fitDoc->year)
                            <span class="text-muted">{{ $fitDoc->year }}</span>
                        @endif
                    </div>
                    <h1 class="display-4 fw-bold mb-3">{{ $fitDoc->title }}</h1>
                    @if($fitDoc->description)
                        <p class="lead mb-4">{{ $fitDoc->description }}</p>
                    @endif
                    
                    <!-- Series Info -->
                    <div class="row g-3 mb-4">
                        @if($fitDoc->director)
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-tie me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Director</small>
                                    <span>{{ $fitDoc->director }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($fitDoc->duration)
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Duration</small>
                                    <span>{{ $fitDoc->duration }} min</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($fitDoc->language)
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-globe me-2 text-primary"></i>
                                <div>
                                    <small class="text-muted d-block">Language</small>
                                    <span>{{ ucfirst($fitDoc->language) }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 flex-wrap">
                        @if($fitDoc->video_url)
                            <button class="btn btn-primary btn-lg" onclick="playTrailer()">
                                <i class="fas fa-play me-2"></i>Play Trailer
                            </button>
                        @endif
                        <button class="btn btn-outline-light btn-lg">
                            <i class="fas fa-plus me-2"></i>Add to Watchlist
                        </button>
                        <button class="btn btn-outline-light btn-lg">
                            <i class="fas fa-share me-2"></i>Share
                        </button>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="poster-container">
                        <img src="{{ $fitDoc->poster_image_path ? asset('storage/app/public/' . $fitDoc->poster_image_path) : 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3' }}" 
                             alt="{{ $fitDoc->title }}" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Episodes Section -->
    <div class="episodes-section py-5">
        <div class="container">
            <h2 class="section-title mb-4">
                <i class="fas fa-list me-2"></i>Episodes
            </h2>
            
            @if($fitDoc->episodes && $fitDoc->episodes->count() > 0)
                <div class="row">
                    @foreach($fitDoc->episodes as $index => $episode)
                        <div class="col-lg-6 mb-4">
                            <div class="episode-card bg-secondary rounded overflow-hidden">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <div class="episode-thumbnail position-relative">
                                            <img src="{{ $episode->thumbnail_path ? asset('storage/app/public/' . $episode->thumbnail_path) : 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?ixlib=rb-4.0.3' }}" 
                                                 class="img-fluid h-100 w-100 object-fit-cover" alt="Episode {{ $index + 1 }}">
                                            <div class="play-overlay position-absolute top-50 start-50 translate-middle">
                                                <i class="fas fa-play text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="episode-number text-primary">Episode {{ $index + 1 }}</h6>
                                                @if($episode->duration)
                                                    <small class="text-muted">{{ $episode->duration }} min</small>
                                                @endif
                                            </div>
                                            <h5 class="episode-title mb-2">{{ $episode->title ?? 'Episode ' . ($index + 1) }}</h5>
                                            @if($episode->description)
                                                <p class="episode-description text-muted small mb-2">
                                                    {{ Str::limit($episode->description, 100) }}
                                                </p>
                                            @endif
                                            <button class="btn btn-outline-primary btn-sm mt-2" onclick="playEpisode({{ $episode->id }}, '{{ $episode->title }}', '{{ $episode->video_url ?? ($episode->video_file_path ? asset('storage/app/public/' . $episode->video_file_path) : '') }}')">
                                                <i class="fas fa-play me-1"></i>Watch Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-film fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Episodes Coming Soon</h4>
                    <p class="text-muted">Episodes for this series are being prepared. Check back soon!</p>
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

function playEpisode(episodeId, episodeTitle, videoUrl) {
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
