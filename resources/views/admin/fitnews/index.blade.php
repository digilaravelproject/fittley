@extends('layouts.admin')

@section('title', 'FitNews Management')

@section('content')
<style>
    .pagination-wrapper {
        display: flex;
        justify-content: space-between; /* info left, controls right */
        align-items: center;            /* vertical align center */
        flex-wrap: wrap;                /* wrap if screen small */
        width: 100%;
        padding: 10px 15px;
    }
    .pagination-info {
        font-size: 14px;
        color: #aaa;
    }
    .pagination-controls {
        display: flex;
        justify-content: flex-end;
    }
</style>
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-newspaper page-title-icon"></i>
                    FitNews Management
                </h1>
                <p class="page-subtitle">Manage live news streams and broadcasts</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.fitnews.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Stream
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-primary">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $fitNews->total() }}</div>
                            <div class="stat-label">Total Streams</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-success">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $fitNews->where('status', 'live')->count() }}</div>
                            <div class="stat-label">Live Now</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $fitNews->where('status', 'scheduled')->count() }}</div>
                            <div class="stat-label">Scheduled</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $fitNews->sum('viewer_count') }}</div>
                            <div class="stat-label">Total Viewers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list me-2"></i>All Streams
            </h3>
            <div class="card-actions">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control" placeholder="Search streams..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($fitNews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-modern-enhanced">
                        <thead>
                            <tr>
                                <th width="35%">Stream Details</th>
                                <th width="15%">Status & Metrics</th>
                                <th width="20%">Creator & Schedule</th>
                                <th width="30%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fitNews as $news)
                                <tr class="stream-row">
                                    <td>
                                        <div class="stream-details">
                                            <div class="stream-thumbnail">
                                                @if($news->thumbnail)
                                                    <img src="{{ asset('storage/app/public/' . $news->thumbnail) }}" alt="Thumbnail" class="thumbnail-img">
                                                @else
                                                    <div class="thumbnail-placeholder">
                                                        <i class="fas fa-newspaper"></i>
                                                    </div>
                                                @endif
                                                @if($news->status === 'live')
                                                    <div class="live-indicator">
                                                        <span class="live-dot"></span>
                                                        LIVE
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="stream-info">
                                                <h6 class="stream-title">{{ $news->title }}</h6>
                                                @if($news->description)
                                                    <p class="stream-description">{{ Str::limit($news->description, 80) }}</p>
                                                @endif
                                                <div class="stream-meta">
                                                    <span class="meta-item">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        {{ $news->created_at->format('M d, Y') }}
                                                    </span>
                                                    @if($news->recording_enabled)
                                                        <span class="meta-item recording-badge">
                                                            <i class="fas fa-record-vinyl me-1"></i>
                                                            Recording
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="status-metrics">
                                            <div class="status-section">
                                                @switch($news->status)
                                                    @case('draft')
                                                        <span class="status-badge-enhanced status-draft">
                                                            <i class="fas fa-edit me-1"></i>Draft
                                                        </span>
                                                        @break
                                                    @case('scheduled')
                                                        <span class="status-badge-enhanced status-scheduled">
                                                            <i class="fas fa-clock me-1"></i>Scheduled
                                                        </span>
                                                        @break
                                                    @case('live')
                                                        <span class="status-badge-enhanced status-live">
                                                            <i class="fas fa-circle blink me-1"></i>Live Now
                                                        </span>
                                                        @break
                                                    @case('ended')
                                                        <span class="status-badge-enhanced status-ended">
                                                            <i class="fas fa-stop me-1"></i>Ended
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="status-badge-enhanced status-unknown">
                                                            <i class="fas fa-question me-1"></i>{{ ucfirst($news->status) }}
                                                        </span>
                                                @endswitch
                                            </div>
                                            <div class="metrics-section">
                                                <div class="metric-item">
                                                    <span class="metric-value">{{ $news->viewer_count ?? 0 }}</span>
                                                    <span class="metric-label">Viewers</span>
                                                </div>
                                                @if($news->started_at && $news->ended_at)
                                                    <div class="metric-item">
                                                        <span class="metric-value">{{ $news->getDuration() }}</span>
                                                        <span class="metric-label">Duration</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="creator-schedule">
                                            <div class="creator-info">
                                                <div class="creator-avatar">
                                                    @if($news->creator && $news->creator->avatar)
                                                        <img src="{{ asset('storage/app/public/' . $news->creator->avatar) }}" alt="Creator">
                                                    @else
                                                        <div class="avatar-placeholder-sm">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="creator-details">
                                                    <div class="creator-name">{{ $news->creator->name ?? 'Unknown' }}</div>
                                                    <div class="creator-role">Creator</div>
                                                </div>
                                            </div>
                                            <div class="schedule-info">
                                                @if($news->status === 'scheduled' && $news->scheduled_at)
                                                    <div class="schedule-item">
                                                        <i class="fas fa-clock text-warning me-1"></i>
                                                        <span>{{ $news->scheduled_at->format('M d, H:i') }}</span>
                                                    </div>
                                                @elseif($news->started_at)
                                                    <div class="schedule-item">
                                                        <i class="fas fa-play-circle text-success me-1"></i>
                                                        <span>{{ $news->started_at->format('M d, H:i') }}</span>
                                                    </div>
                                                @else
                                                    <div class="schedule-item text-muted">
                                                        <i class="fas fa-calendar-times me-1"></i>
                                                        <span>Not scheduled</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons-enhanced">
                                            <div class="primary-actions">
                                                @if($news->status === 'live')
                                                    <a href="{{ route('admin.fitnews.stream', $news) }}" 
                                                       class="btn btn-action-enhanced btn-live" 
                                                       title="Control Stream">
                                                        <i class="fas fa-video me-2"></i>Stream Control
                                                    </a>
                                                @elseif($news->status === 'draft' || $news->status === 'scheduled')
                                                    <a href="{{ route('admin.fitnews.edit', $news) }}" 
                                                       class="btn btn-action-enhanced btn-edit" 
                                                       title="Edit Stream">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.fitnews.show', $news) }}" 
                                                       class="btn btn-action-enhanced btn-view" 
                                                       title="View Details">
                                                        <i class="fas fa-eye me-2"></i>View
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="secondary-actions">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary-action dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.fitnews.show', $news) }}">
                                                                <i class="fas fa-eye me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.fitnews.edit', $news) }}">
                                                                <i class="fas fa-edit me-2"></i>Edit Stream
                                                            </a>
                                                        </li>
                                                        @if($news->status !== 'live')
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('admin.fitnews.destroy', $news) }}" 
                                                                      method="POST" 
                                                                      class="d-inline"
                                                                      onsubmit="return confirm('Are you sure you want to delete this stream?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash me-2"></i>Delete Stream
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($fitNews->hasPages())
                    <div class="content-card-footer">
                        <div class="pagination-wrapper">
                            <div class="pagination-controls">
                                {{ $fitNews->links('pagination.custom') }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="empty-state-content">
                        <h3 class="empty-state-title">No streams found</h3>
                        <p class="empty-state-description">
                            Get started by creating your first FitNews stream to share fitness news and updates with your audience.
                        </p>
                        <a href="{{ route('admin.fitnews.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Stream
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.3; }
}

.blink {
    animation: blink 1.5s infinite;
}

/* Enhanced Table Styling with Dark Theme */
.table-modern-enhanced {
    background: #191919;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    --bs-table-bg: #191919;
    --bs-table-color: #ffffff;
    --bs-table-border-color: #333333;
    --bs-table-hover-bg: #202020;
    --bs-table-hover-color: #ffffff;
}

.table-modern-enhanced thead th {
    background: #141414;
    color: #ffffff;
    font-weight: 600;
    padding: 1rem;
    border: none;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #f8a721;
}

.table-modern-enhanced tbody .stream-row {
    background: #191919;
    border-bottom: 1px solid #333333;
    transition: all 0.3s ease;
    color: #ffffff;
}

.table-modern-enhanced tbody .stream-row:hover {
    background: #202020;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(248, 167, 33, 0.15);
}

.table-modern-enhanced tbody td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
    border: none;
    color: #ffffff;
}

/* Stream Details Section */
.stream-details {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.stream-thumbnail {
    position: relative;
    width: 80px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.thumbnail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8a721, #e8950e);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #191919;
    font-size: 1.5rem;
}

.live-indicator {
    position: absolute;
    top: 4px;
    right: 4px;
    background: #dc3545;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.625rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.live-dot {
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    animation: blink 1s infinite;
}

.stream-info {
    flex: 1;
    min-width: 0;
}

.stream-title {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.stream-description {
    font-size: 0.875rem;
    color: #cccccc;
    margin: 0 0 0.75rem 0;
    line-height: 1.4;
}

.stream-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
}

.meta-item {
    font-size: 0.75rem;
    color: #999999;
    display: flex;
    align-items: center;
}

.meta-item i {
    color: #f8a721;
}

.recording-badge {
    background: #141414;
    color: #f8a721;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 500;
    border: 1px solid #f8a721;
}

/* Status & Metrics Section */
.status-metrics {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
}

.status-badge-enhanced {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: flex;
    align-items: center;
    white-space: nowrap;
    background: #141414;
}

.status-draft {
    color: #999999;
    border: 1px solid #999999;
}

.status-scheduled {
    color: #f8a721;
    border: 1px solid #f8a721;
}

.status-live {
    color: #28a745;
    border: 1px solid #28a745;
}

.status-ended {
    color: #6c757d;
    border: 1px solid #6c757d;
}

.status-unknown {
    color: #999999;
    border: 1px solid #999999;
}

.metrics-section {
    display: flex;
    gap: 1rem;
}

.metric-item {
    text-align: center;
}

.metric-value {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
    color: #f8a721;
    line-height: 1;
}

.metric-label {
    display: block;
    font-size: 0.625rem;
    color: #999999;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 0.25rem;
}

/* Creator & Schedule Section */
.creator-schedule {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.creator-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.creator-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.creator-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-sm {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8a721, #e8950e);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #191919;
    font-size: 1rem;
}

.creator-details {
    flex: 1;
    min-width: 0;
}

.creator-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #ffffff;
    line-height: 1.2;
}

.creator-role {
    font-size: 0.75rem;
    color: #999999;
    line-height: 1.2;
}

.schedule-item {
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #cccccc;
}

.schedule-item i {
    color: #f8a721;
}

/* Enhanced Actions Section */
.action-buttons-enhanced {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.primary-actions {
    flex: 1;
}

.btn-action-enhanced {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    white-space: nowrap;
}

.btn-live {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    border: 1px solid #28a745;
}

.btn-live:hover {
    background: linear-gradient(135deg, #218838, #1ea085);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    color: white;
}

.btn-edit {
    background: linear-gradient(135deg, #f8a721, #e8950e);
    color: #191919;
    border: 1px solid #f8a721;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #e8950e, #d8840d);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(248, 167, 33, 0.3);
    color: #191919;
}

.btn-view {
    background: #141414;
    color: #f8a721;
    border: 1px solid #f8a721;
}

.btn-view:hover {
    background: #f8a721;
    color: #191919;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(248, 167, 33, 0.3);
}

.btn-secondary-action {
    background: #141414;
    border: 1px solid #333333;
    color: #cccccc;
    padding: 0.75rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-secondary-action:hover {
    background: #f8a721;
    border-color: #f8a721;
    color: #191919;
}

.dropdown-menu {
    background: #191919;
    border: 1px solid #333333;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    padding: 0.5rem 0;
}

.dropdown-item {
    padding: 0.75rem 1rem;
    color: #cccccc;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: #141414;
    color: #f8a721;
}

.dropdown-item.text-danger:hover {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

/* Search Box Styling */
.search-box {
    position: relative;
    width: 250px;
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #999999;
    z-index: 2;
}

.search-box .form-control {
    padding-left: 2.5rem;
    background: #141414;
    border: 1px solid #333333;
    color: #ffffff;
    border-radius: 8px;
}

.search-box .form-control:focus {
    background: #141414;
    border-color: #f8a721;
    box-shadow: 0 0 0 0.2rem rgba(248, 167, 33, 0.25);
    color: #ffffff;
}

.search-box .form-control::placeholder {
    color: #999999;
}

/* Global Text Colors */
.text-muted {
    color: #999999 !important;
}

.text-warning {
    color: #f8a721 !important;
}

.text-success {
    color: #28a745 !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .table-modern-enhanced thead th {
        padding: 0.75rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .table-modern-enhanced tbody td {
        padding: 1rem 0.5rem;
    }
    
    .stream-details {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .stream-thumbnail {
        width: 100%;
        height: 120px;
    }
    
    .action-buttons-enhanced {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .btn-action-enhanced {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection 