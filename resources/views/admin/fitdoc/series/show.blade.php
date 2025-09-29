@extends('layouts.admin')

@section('title', $fitDoc->title)

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-tv me-3"></i>{{ $fitDoc->title }}
                </h1>
                <p class="page-subtitle">Series Details</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitdoc.series.episodes', $fitDoc) }}" class="btn btn-info">
                    <i class="fas fa-list me-2"></i>Episodes
                </a>
                <a href="{{ route('admin.fitdoc.series.edit', $fitDoc) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="{{ route('admin.fitdoc.series.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Series Overview -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle me-2"></i>Series Overview</h5>
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
                                <label>Episodes</label>
                                <p>{{ $fitDoc->episodes_count }} episodes</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <label>Total Duration</label>
                                <p>{{ $fitDoc->total_duration_formatted }}</p>
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

            <!-- Episodes List -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-list me-2"></i>Episodes ({{ $fitDoc->episodes->count() }})</h5>
                    <a href="{{ route('admin.fitdoc.series.episodes.create', $fitDoc) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Add Episode
                    </a>
                </div>
                <div class="card-body">
                    @if($fitDoc->episodes->count() > 0)
                        <div class="episode-list">
                            @foreach($fitDoc->episodes->sortBy('episode_number') as $episode)
                                <div class="episode-item">
                                    <div class="episode-poster">
                                        @if($episode->banner_image_path)
                                            <img src="{{ asset('storage/app/public/'. $episode->banner_image_path) }}" alt="Episode {{ $episode->episode_number }}">
                                        @else
                                            <div class="no-poster">
                                                <i class="fas fa-play-circle"></i>
                                            </div>
                                        @endif
                                        <div class="episode-number-overlay">{{ $episode->episode_number }}</div>
                                    </div>
                                    <div class="episode-details">
                                        <div class="episode-title">{{ $episode->title }}</div>
                                        <div class="episode-description">{{ Str::limit($episode->description, 120) }}</div>
                                        <div class="episode-meta">
                                            <span class="duration">
                                                <i class="fas fa-clock me-1"></i>{{ $episode->formatted_duration }}
                                            </span>
                                            <span class="release-date">
                                                <i class="fas fa-calendar me-1"></i>{{ $episode->release_date ? $episode->release_date->format('M j, Y') : 'TBD' }}
                                            </span>
                                            <span class="status">
                                                @if($episode->is_published)
                                                    <span class="badge bg-success">Published</span>
                                                @else
                                                    <span class="badge bg-secondary">Draft</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="episode-actions">
                                        <a href="{{ route('admin.fitdoc.series.episodes.edit', [$fitDoc, $episode]) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.fitdoc.series.episodes.destroy', [$fitDoc, $episode]) }}" 
                                              class="d-inline" onsubmit="return confirm('Are you sure you want to delete this episode?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-video"></i>
                            </div>
                            <h3>No Episodes Yet</h3>
                            <p>Start building your series by adding episodes.</p>
                            <a href="{{ route('admin.fitdoc.series.episodes.create', $fitDoc) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add First Episode
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Banner Image -->
            @if($fitDoc->banner_image_path)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-image me-2"></i>Series Banner</h5>
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
                        <h5><i class="fas fa-film me-2"></i>Series Trailer</h5>
                    </div>
                    <div class="card-body">
                        @if($fitDoc->trailer_type === 'youtube' && $fitDoc->trailer_url)
                            <div class="trailer-container">
                                <iframe src="{{ str_replace('watch?v=', 'embed/', $fitDoc->trailer_url) }}" 
                                        frameborder="0" allowfullscreen></iframe>
                            </div>
                        @elseif($fitDoc->trailer_type === 's3' && $fitDoc->trailer_url)
                            <div class="trailer-container">
                                <video controls>
                                    <source src="{{ $fitDoc->trailer_url }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @elseif($fitDoc->trailer_type === 'upload' && $fitDoc->trailer_file_path)
                            <div class="trailer-container">
                                <video controls>
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
                    <h5><i class="fas fa-chart-bar me-2"></i>Series Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <span class="stat-label">Total Episodes</span>
                        <span class="stat-value">{{ $fitDoc->episodes->count() }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Published Episodes</span>
                        <span class="stat-value">{{ $fitDoc->episodes->where('is_published', true)->count() }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Duration</span>
                        <span class="stat-value">{{ $fitDoc->total_duration_formatted }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Created</span>
                        <span class="stat-value">{{ $fitDoc->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Last Updated</span>
                        <span class="stat-value">{{ $fitDoc->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.trailer-container {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    background: #000;
    border-radius: 8px;
    overflow: hidden;
}

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

.episode-list {
    max-height: 600px;
    overflow-y: auto;
}

.episode-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border: 1px solid var(--border-primary);
    border-radius: 8px;
    margin-bottom: 1rem;
    background: var(--card-bg);
    transition: all 0.3s ease;
}

.episode-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.episode-poster {
    position: relative;
    width: 80px;
    height: 60px;
    border-radius: 6px;
    overflow: hidden;
    margin-right: 1rem;
    flex-shrink: 0;
}

.episode-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-poster {
    width: 100%;
    height: 100%;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
}

.episode-number-overlay {
    position: absolute;
    top: 4px;
    left: 4px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 0.75rem;
    font-weight: 600;
}

.episode-details {
    flex: 1;
}

.episode-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.episode-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.4;
    margin-bottom: 0.75rem;
}

.episode-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.episode-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endpush
@endsection 