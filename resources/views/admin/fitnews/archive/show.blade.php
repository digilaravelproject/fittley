@extends('layouts.admin')

@section('title', 'View Recording - ' . $fitNews->title)

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-play page-title-icon"></i>
                    {{ $fitNews->title }}
                </h1>
                <p class="page-subtitle">Recorded FitNews Stream</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.fitnews.archive.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Archive
                </a>
                <a href="{{ route('admin.fitnews.archive.download', $fitNews) }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Download
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Video Player Section -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-body p-0">
                    <div class="video-player-container">
                        @if($fitNews->recording_url && file_exists($fitNews->recording_url))
                            <video id="recording-player" class="video-player" controls preload="metadata" controlslist="nodownload noremoteplayback" disablepictureinpicture oncontextmenu="return false;">
                                <source src="{{ asset('storage/app/public/recordings/' . basename($fitNews->recording_url)) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <div class="video-placeholder">
                                <div class="placeholder-content">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <h4>Recording Not Available</h4>
                                    <p>The recording file could not be found or is no longer available.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stream Information -->
            <div class="content-card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Stream Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="stream-info-grid">
                        <div class="info-section">
                            <h5>Description</h5>
                            <p class="stream-description">
                                {{ $fitNews->description ?: 'No description available.' }}
                            </p>
                        </div>
                        
                        <div class="info-section">
                            <h5>Stream Details</h5>
                            <div class="info-list">
                                <div class="info-item">
                                    <span class="info-label">Status:</span>
                                    <span class="status-badge status-ended">
                                        <i class="fas fa-stop me-1"></i>Ended
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Scheduled:</span>
                                    <span class="info-value">
                                        {{ $fitNews->scheduled_at ? $fitNews->scheduled_at->format('M d, Y g:i A') : 'Not scheduled' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Started:</span>
                                    <span class="info-value">
                                        {{ $fitNews->started_at ? $fitNews->started_at->format('M d, Y g:i A') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Ended:</span>
                                    <span class="info-value">
                                        {{ $fitNews->ended_at ? $fitNews->ended_at->format('M d, Y g:i A') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Duration:</span>
                                    <span class="info-value">{{ $fitNews->getDuration() ?: 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Recording Details -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-video me-2"></i>Recording Details
                    </h3>
                </div>
                <div class="card-body">
                    <div class="recording-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ $fitNews->getFormattedRecordingDuration() }}</div>
                                <div class="stat-label">Recording Duration</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-hdd"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ $fitNews->getFormattedRecordingFileSize() }}</div>
                                <div class="stat-label">File Size</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ number_format($fitNews->viewer_count) }}</div>
                                <div class="stat-label">Peak Viewers</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ ucfirst($fitNews->recording_status) }}</div>
                                <div class="stat-label">Recording Status</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Creator Information -->
            <div class="content-card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user me-2"></i>Creator
                    </h3>
                </div>
                <div class="card-body">
                    <div class="creator-profile">
                        <div class="creator-avatar-large">
                            @if($fitNews->creator->avatar)
                                <img src="{{ asset('storage/app/public/' . $fitNews->creator->avatar) }}" alt="Creator">
                            @else
                                <div class="avatar-placeholder-large">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="creator-info">
                            <h4 class="creator-name">{{ $fitNews->creator->name }}</h4>
                            <p class="creator-email">{{ $fitNews->creator->email }}</p>
                            @if($fitNews->creator->bio)
                                <p class="creator-bio">{{ $fitNews->creator->bio }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="content-card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs me-2"></i>Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="action-buttons-vertical">
                        <a href="{{ route('admin.fitnews.archive.download', $fitNews) }}" class="btn btn-primary w-100">
                            <i class="fas fa-download me-2"></i>Download Recording
                        </a>
                        <a href="{{ route('admin.fitnews.show', $fitNews) }}" class="btn btn-secondary w-100">
                            <i class="fas fa-eye me-2"></i>View Stream Details
                        </a>
                        <form action="{{ route('admin.fitnews.archive.destroy', $fitNews) }}" 
                              method="POST" class="w-100"
                              onsubmit="return confirm('Are you sure you want to delete this recording? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Delete Recording
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.video-player-container {
    position: relative;
    width: 100%;
    background: #000;
    border-radius: 12px;
    overflow: hidden;
}

.video-player {
    width: 100%;
    height: auto;
    min-height: 400px;
    display: block;
}

.video-placeholder {
    width: 100%;
    height: 400px;
    background: #141414;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
}

.placeholder-content {
    text-align: center;
    color: #999999;
}

.placeholder-content i {
    font-size: 3rem;
    color: #f8a721;
    margin-bottom: 1rem;
}

.placeholder-content h4 {
    color: #ffffff;
    margin-bottom: 0.5rem;
}

.stream-info-grid {
    display: grid;
    gap: 2rem;
}

.info-section h5 {
    color: #f8a721;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.125rem;
}

.stream-description {
    color: #cccccc;
    line-height: 1.6;
    font-size: 1rem;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #333333;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #ffffff;
    font-size: 0.875rem;
}

.info-value {
    color: #cccccc;
    font-size: 0.875rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: flex;
    align-items: center;
    background: #141414;
}

.status-ended {
    color: #6c757d;
    border: 1px solid #6c757d;
}

.recording-stats {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #141414;
    border-radius: 12px;
    border: 1px solid #333333;
}

.stat-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #f8a721, #e8950e);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #191919;
    font-size: 1.25rem;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #999999;
    line-height: 1;
}

.creator-profile {
    text-align: center;
}

.creator-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 1rem;
}

.creator-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-large {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8a721, #e8950e);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #191919;
    font-size: 2rem;
}

.creator-name {
    color: #ffffff;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.125rem;
}

.creator-email {
    color: #f8a721;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.creator-bio {
    color: #cccccc;
    font-size: 0.875rem;
    line-height: 1.5;
}

.action-buttons-vertical {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.action-buttons-vertical .btn {
    padding: 0.75rem 1rem;
    font-weight: 600;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('recording-player');
    
    if (video) {
        // Add loading state
        video.addEventListener('loadstart', function() {
            console.log('Video loading started');
        });
        
        // Handle video load
        video.addEventListener('loadeddata', function() {
            console.log('Video loaded successfully');
        });
        
        // Handle errors
        video.addEventListener('error', function(e) {
            console.error('Video error:', e);
            const container = video.parentElement;
            container.innerHTML = `
                <div class="video-placeholder">
                    <div class="placeholder-content">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>Error Loading Video</h4>
                        <p>There was an error loading the recording. Please try again or contact support.</p>
                    </div>
                </div>
            `;
        });
    }
});
</script>
@endsection 