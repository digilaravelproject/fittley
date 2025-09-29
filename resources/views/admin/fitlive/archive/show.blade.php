@extends('layouts.admin')

@section('title', 'View Recording - ' . $fitLiveSession->title)

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-play page-title-icon"></i>
                    {{ $fitLiveSession->title }}
                </h1>
                <p class="page-subtitle">Recorded FitLive Session</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.fitlive.archive.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Archive
                </a>
                <a href="{{ route('admin.fitlive.archive.download', $fitLiveSession) }}" class="btn btn-primary">
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
                        @if($fitLiveSession->recording_url && file_exists($fitLiveSession->recording_url))
                            <video id="recording-player" class="video-player" controls preload="metadata" controlslist="nodownload noremoteplayback" disablepictureinpicture oncontextmenu="return false;">
                                <source src="{{ asset('storage/app/public/recordings/' . basename($fitLiveSession->recording_url)) }}" type="video/mp4">
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

            <!-- Session Information -->
            <div class="content-card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Session Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="session-info-grid">
                        <div class="info-section">
                            <h5>Description</h5>
                            <p class="session-description">
                                {{ $fitLiveSession->description ?: 'No description available.' }}
                            </p>
                        </div>
                        
                        <div class="info-section">
                            <h5>Session Details</h5>
                            <div class="info-list">
                                <div class="info-item">
                                    <span class="info-label">Status:</span>
                                    <span class="status-badge status-ended">
                                        <i class="fas fa-stop me-1"></i>Ended
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Category:</span>
                                    <span class="info-value">{{ $fitLiveSession->category->name }}</span>
                                </div>
                                @if($fitLiveSession->subCategory)
                                    <div class="info-item">
                                        <span class="info-label">Subcategory:</span>
                                        <span class="info-value">{{ $fitLiveSession->subCategory->name }}</span>
                                    </div>
                                @endif
                                <div class="info-item">
                                    <span class="info-label">Chat Mode:</span>
                                    <span class="info-value">{{ ucfirst($fitLiveSession->chat_mode) }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Visibility:</span>
                                    <span class="info-value">{{ ucfirst($fitLiveSession->visibility) }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Scheduled:</span>
                                    <span class="info-value">
                                        {{ $fitLiveSession->scheduled_at ? $fitLiveSession->scheduled_at->format('M d, Y g:i A') : 'Not scheduled' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Started:</span>
                                    <span class="info-value">
                                        {{ $fitLiveSession->started_at ? $fitLiveSession->started_at->format('M d, Y g:i A') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Ended:</span>
                                    <span class="info-value">
                                        {{ $fitLiveSession->ended_at ? $fitLiveSession->ended_at->format('M d, Y g:i A') : 'N/A' }}
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Duration:</span>
                                    <span class="info-value">{{ $fitLiveSession->getDuration() ?: 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat History -->
            @if($fitLiveSession->chatMessages->count() > 0)
                <div class="content-card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-comments me-2"></i>Chat History
                            <span class="badge bg-secondary ms-2">{{ $fitLiveSession->chatMessages->count() }} messages</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="chat-history">
                            @foreach($fitLiveSession->chatMessages as $message)
                                <div class="chat-message {{ $message->is_instructor ? 'instructor-message' : 'user-message' }}">
                                    <div class="message-header">
                                        <div class="message-user">
                                            <div class="user-avatar">
                                                @if($message->user->avatar)
                                                    <img src="{{ asset('storage/app/public/' . $message->user->avatar) }}" alt="User">
                                                @else
                                                    <div class="avatar-placeholder-xs">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="user-info">
                                                <span class="user-name">{{ $message->user->name }}</span>
                                                @if($message->is_instructor)
                                                    <span class="user-badge">Instructor</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="message-time">
                                            {{ $message->created_at->format('g:i A') }}
                                        </div>
                                    </div>
                                    <div class="message-content">
                                        {{ $message->message }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
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
                                <div class="stat-value">{{ $fitLiveSession->getFormattedRecordingDuration() }}</div>
                                <div class="stat-label">Recording Duration</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-hdd"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ $fitLiveSession->getFormattedRecordingFileSize() }}</div>
                                <div class="stat-label">File Size</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ number_format($fitLiveSession->viewer_peak) }}</div>
                                <div class="stat-label">Peak Viewers</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ $fitLiveSession->chatMessages->count() }}</div>
                                <div class="stat-label">Chat Messages</div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-value">{{ ucfirst($fitLiveSession->recording_status) }}</div>
                                <div class="stat-label">Recording Status</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructor Information -->
            <div class="content-card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Instructor
                    </h3>
                </div>
                <div class="card-body">
                    <div class="instructor-profile">
                        <div class="instructor-avatar-large">
                            @if($fitLiveSession->instructor->avatar)
                                <img src="{{ asset('storage/app/public/' . $fitLiveSession->instructor->avatar) }}" alt="Instructor">
                            @else
                                <div class="avatar-placeholder-large">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="instructor-info">
                            <h4 class="instructor-name">{{ $fitLiveSession->instructor->name }}</h4>
                            <p class="instructor-email">{{ $fitLiveSession->instructor->email }}</p>
                            @if($fitLiveSession->instructor->bio)
                                <p class="instructor-bio">{{ $fitLiveSession->instructor->bio }}</p>
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
                        <a href="{{ route('admin.fitlive.archive.download', $fitLiveSession) }}" class="btn btn-primary w-100">
                            <i class="fas fa-download me-2"></i>Download Recording
                        </a>
                        <a href="{{ route('admin.fitlive.sessions.show', $fitLiveSession) }}" class="btn btn-secondary w-100">
                            <i class="fas fa-eye me-2"></i>View Session Details
                        </a>
                        <form action="{{ route('admin.fitlive.archive.destroy', $fitLiveSession) }}" 
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

.session-info-grid {
    display: grid;
    gap: 2rem;
}

.info-section h5 {
    color: #f8a721;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.125rem;
}

.session-description {
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

.chat-history {
    max-height: 500px;
    overflow-y: auto;
    padding: 1rem;
    background: #141414;
    border-radius: 12px;
}

.chat-message {
    margin-bottom: 1.5rem;
    padding: 1rem;
    border-radius: 12px;
    border: 1px solid #333333;
}

.instructor-message {
    background: rgba(248, 167, 33, 0.1);
    border-color: rgba(248, 167, 33, 0.3);
}

.user-message {
    background: rgba(255, 255, 255, 0.05);
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.message-user {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-xs {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8a721, #e8950e);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #191919;
    font-size: 0.75rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.user-name {
    font-weight: 600;
    color: #ffffff;
    font-size: 0.875rem;
}

.user-badge {
    background: #f8a721;
    color: #191919;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.625rem;
    font-weight: 600;
    text-transform: uppercase;
}

.message-time {
    font-size: 0.75rem;
    color: #999999;
}

.message-content {
    color: #cccccc;
    line-height: 1.5;
    font-size: 0.875rem;
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

.instructor-profile {
    text-align: center;
}

.instructor-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 1rem;
}

.instructor-avatar-large img {
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

.instructor-name {
    color: #ffffff;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.125rem;
}

.instructor-email {
    color: #f8a721;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.instructor-bio {
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

/* Custom scrollbar for chat history */
.chat-history::-webkit-scrollbar {
    width: 6px;
}

.chat-history::-webkit-scrollbar-track {
    background: #333333;
    border-radius: 3px;
}

.chat-history::-webkit-scrollbar-thumb {
    background: #f8a721;
    border-radius: 3px;
}

.chat-history::-webkit-scrollbar-thumb:hover {
    background: #e8950e;
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