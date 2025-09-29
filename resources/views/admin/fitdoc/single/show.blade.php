@extends('layouts.admin')

@section('title', $fitDoc->title)

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-play-circle me-3"></i>{{ $fitDoc->title }}
                </h1>
                <p class="page-subtitle">Single Video Details</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitdoc.single.edit', $fitDoc) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="{{ route('admin.fitdoc.single.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Video Player Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-play me-2"></i>Video Player</h5>
                </div>
                <div class="card-body">
                    @if($fitDoc->video_type === 'youtube' && $fitDoc->video_url)
                        <div class="video-container">
                            <iframe src="{{ str_replace('watch?v=', 'embed/', $fitDoc->video_url) }}" 
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                    @elseif($fitDoc->video_type === 's3' && $fitDoc->video_url)
                        <div class="video-container">
                            <video controls
                                   controlslist="nodownload noremoteplayback"
                                   disablepictureinpicture
                                   oncontextmenu="return false;">
                                <source src="{{ $fitDoc->video_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @elseif($fitDoc->video_type === 'upload' && $fitDoc->video_file_path)
                        <div class="video-container">
                            <video controls
                                   controlslist="nodownload noremoteplayback"
                                   disablepictureinpicture
                                   oncontextmenu="return false;">
                                <source src="{{ asset('storage/app/public/' . $fitDoc->video_file_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-video fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No video available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content Details -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Content Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Title</label>
                                <p>{{ $fitDoc->title }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Language</label>
                                <p>{{ ucfirst($fitDoc->language) }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="detail-item">
                                <label>Description</label>
                                <p>{{ $fitDoc->description }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Release Date</label>
                                <p>{{ $fitDoc->release_date ? $fitDoc->release_date->format('F j, Y') : 'Not set' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Duration</label>
                                <p>{{ $fitDoc->formatted_duration }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Cost</label>
                                <p>{{ $fitDoc->cost > 0 ? '$' . number_format($fitDoc->cost, 2) : 'Free' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Status</label>
                                <p>
                                    @if($fitDoc->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Banner Image -->
            @if($fitDoc->banner_image_path)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-image me-2"></i>Banner Image</h5>
                    </div>
                    <div class="card-body p-0">
                        <img src="{{ asset('storage/app/public/' . $fitDoc->banner_image_path) }}" 
                             alt="{{ $fitDoc->title }}" class="img-fluid">
                    </div>
                </div>
            @endif

            <!-- Trailer -->
            @if($fitDoc->trailer_type)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-film me-2"></i>Trailer</h5>
                    </div>
                    <div class="card-body">
                        @if($fitDoc->trailer_type === 'youtube' && $fitDoc->trailer_url)
                            <div class="trailer-container">
                                <iframe src="{{ str_replace('watch?v=', 'embed/', $fitDoc->trailer_url) }}" 
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                        @elseif($fitDoc->trailer_type === 's3' && $fitDoc->trailer_url)
                            <div class="trailer-container">
                                <video controls
                                       controlslist="nodownload noremoteplayback"
                                       disablepictureinpicture
                                       oncontextmenu="return false;">
                                    <source src="{{ $fitDoc->trailer_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @elseif($fitDoc->trailer_type === 'upload' && $fitDoc->trailer_file_path)
                            <div class="trailer-container">
                                <video controls
                                       controlslist="nodownload noremoteplaybook"
                                       disablepictureinpicture
                                       oncontextmenu="return false;">
                                    <source src="{{ asset('storage/app/public/' . $fitDoc->trailer_file_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Statistics -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-bar me-2"></i>Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <span class="stat-label">Created</span>
                        <span class="stat-value">{{ $fitDoc->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Last Updated</span>
                        <span class="stat-value">{{ $fitDoc->updated_at->format('M j, Y') }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Video Source</span>
                        <span class="stat-value">{{ ucfirst($fitDoc->video_type) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.video-container, .trailer-container {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    background: #000;
    border-radius: 8px;
    overflow: hidden;
}

.video-container iframe,
.video-container video,
.trailer-container iframe,
.trailer-container video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.detail-item {
    margin-bottom: 1.5rem;
}

.detail-item label {
    font-weight: 600;
    color: var(--text-primary);
    display: block;
    margin-bottom: 0.5rem;
}

.detail-item p {
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.5;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-primary);
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-label {
    color: var(--text-secondary);
    font-weight: 500;
}

.stat-value {
    color: var(--text-primary);
    font-weight: 600;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
}
</style>
@endpush
@endsection 