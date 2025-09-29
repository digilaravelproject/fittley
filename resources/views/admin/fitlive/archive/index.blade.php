@extends('layouts.admin')

@section('title', 'FitLive Archive')

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-archive page-title-icon"></i>
                    FitLive Archive
                </h1>
                <p class="page-subtitle">View and manage recorded FitLive sessions</p>
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
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $recordings->total() }}</div>
                            <div class="stat-label">Total Recordings</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-success">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($recordings->sum('recording_duration') / 3600, 1) }}h</div>
                            <div class="stat-label">Total Duration</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-info">
                            <i class="fas fa-hdd"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($recordings->sum('recording_file_size') / (1024*1024*1024), 2) }}GB</div>
                            <div class="stat-label">Total Storage</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-warning">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $recordings->sum('viewer_peak') }}</div>
                            <div class="stat-label">Total Peak Views</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-card">
        <form method="GET" class="filters-form">
            <div class="filters-grid">
                <div class="filter-item">
                    <label class="filter-label">Category</label>
                    <select name="category_id" class="form-select filter-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <label class="filter-label">Instructor</label>
                    <select name="instructor_id" class="form-select filter-select">
                        <option value="">All Instructors</option>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <label class="filter-label">Date From</label>
                    <input type="date" name="date_from" class="form-control filter-input" value="{{ request('date_from') }}">
                </div>
                <div class="filter-item">
                    <label class="filter-label">Date To</label>
                    <input type="date" name="date_to" class="form-control filter-input" value="{{ request('date_to') }}">
                </div>
                <div class="filter-item filter-search">
                    <label class="filter-label">Search</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="form-control filter-input" 
                               placeholder="Search recordings..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="filter-item filter-actions">
                    <button type="submit" class="btn btn-filter">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.fitlive.archive.index') }}" class="btn btn-clear">
                        <i class="fas fa-times me-2"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Content -->
    <div class="content-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list me-2"></i>Recorded Sessions
            </h3>
            <div class="card-actions">
                @if($recordings->count() > 0)
                    <button type="button" class="btn btn-danger" onclick="toggleBulkActions()">
                        <i class="fas fa-trash me-2"></i>Bulk Delete
                    </button>
                @endif
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

            @if($recordings->count() > 0)
                <!-- Bulk Actions Form -->
                <form id="bulk-delete-form" action="{{ route('admin.fitlive.archive.bulk-delete') }}" method="POST" style="display: none;">
                    @csrf
                    <div class="bulk-actions-bar">
                        <div class="bulk-actions-info">
                            <span id="selected-count">0</span> recordings selected
                        </div>
                        <div class="bulk-actions-buttons">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the selected recordings?')">
                                <i class="fas fa-trash me-2"></i>Delete Selected
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="toggleBulkActions()">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-modern-enhanced">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" id="select-all" class="bulk-checkbox" style="display: none;">
                                </th>
                                <th width="35%">Session Details</th>
                                <th width="20%">Instructor & Category</th>
                                <th width="15%">Duration & Size</th>
                                <th width="10%">Peak Views</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recordings as $recording)
                                <tr class="recording-row">
                                    <td>
                                        <input type="checkbox" name="recordings[]" value="{{ $recording->id }}" 
                                               class="bulk-checkbox recording-checkbox" style="display: none;">
                                    </td>
                                    <td>
                                        <div class="recording-details">
                                            <div class="recording-thumbnail">
                                                @if($recording->banner_image)
                                                    <img src="{{ asset('storage/app/public/' . $recording->banner_image) }}" 
                                                         alt="Banner" class="thumbnail-img">
                                                @else
                                                    <div class="thumbnail-placeholder">
                                                        <i class="fas fa-broadcast-tower"></i>
                                                    </div>
                                                @endif
                                                <div class="recording-indicator">
                                                    <i class="fas fa-play"></i>
                                                </div>
                                            </div>
                                            <div class="recording-info">
                                                <h6 class="recording-title">{{ $recording->title }}</h6>
                                                @if($recording->description)
                                                    <p class="recording-description">{{ Str::limit($recording->description, 80) }}</p>
                                                @endif
                                                <div class="recording-meta">
                                                    <span class="meta-item">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        Recorded {{ $recording->ended_at->format('M d, Y') }}
                                                    </span>
                                                    <span class="meta-item">
                                                        <i class="fas fa-comments me-1"></i>
                                                        {{ ucfirst($recording->chat_mode) }} Chat
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="instructor-category">
                                            <div class="instructor-info">
                                                <div class="instructor-avatar">
                                                    @if($recording->instructor->avatar)
                                                        <img src="{{ asset('storage/app/public/' . $recording->instructor->avatar) }}" alt="Instructor">
                                                    @else
                                                        <div class="avatar-placeholder-sm">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="instructor-details">
                                                    <div class="instructor-name">{{ $recording->instructor->name }}</div>
                                                    <div class="instructor-role">Instructor</div>
                                                </div>
                                            </div>
                                            <div class="category-info">
                                                <div class="category-primary">{{ $recording->category->name }}</div>
                                                @if($recording->subCategory)
                                                    <div class="category-secondary">{{ $recording->subCategory->name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="recording-metrics">
                                            <div class="metric-item">
                                                <span class="metric-value">{{ $recording->getFormattedRecordingDuration() }}</span>
                                                <span class="metric-label">Duration</span>
                                            </div>
                                            <div class="metric-item">
                                                <span class="metric-value">{{ $recording->getFormattedRecordingFileSize() }}</span>
                                                <span class="metric-label">File Size</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="views-count">
                                            <span class="metric-value">{{ number_format($recording->viewer_peak) }}</span>
                                            <span class="metric-label">Peak Views</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons-enhanced">
                                            <div class="primary-actions">
                                                <a href="{{ route('admin.fitlive.archive.show', $recording) }}" 
                                                   class="btn btn-action-enhanced btn-view" 
                                                   title="View Recording">
                                                    <i class="fas fa-play me-2"></i>Play
                                                </a>
                                            </div>
                                            <div class="secondary-actions">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary-action dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.fitlive.archive.show', $recording) }}">
                                                                <i class="fas fa-play me-2"></i>View Recording
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.fitlive.archive.download', $recording) }}">
                                                                <i class="fas fa-download me-2"></i>Download
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('admin.fitlive.archive.destroy', $recording) }}" 
                                                                  method="POST" class="d-inline"
                                                                  onsubmit="return confirm('Are you sure you want to delete this recording?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash me-2"></i>Delete Recording
                                                                </button>
                                                            </form>
                                                        </li>
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

                @if($recordings->hasPages())
                    <div class="pagination-wrapper">
                        {{ $recordings->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="empty-state-content">
                        <h3 class="empty-state-title">No recordings found</h3>
                        <p class="empty-state-description">
                            Recordings will appear here after FitLive sessions are completed with recording enabled.
                        </p>
                        <a href="{{ route('admin.fitlive.sessions.index') }}" class="btn btn-primary">
                            <i class="fas fa-broadcast-tower me-2"></i>Manage Sessions
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Archive-specific styles extending the dark theme */
.filters-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 2fr auto;
    gap: 1rem;
    align-items: end;
}

.bulk-actions-bar {
    background: #141414;
    border: 1px solid #f8a721;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bulk-actions-info {
    color: #f8a721;
    font-weight: 600;
}

.bulk-actions-buttons {
    display: flex;
    gap: 0.5rem;
}

.recording-details {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.recording-thumbnail {
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

.recording-indicator {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0, 0, 0, 0.7);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.recording-info {
    flex: 1;
    min-width: 0;
}

.recording-title {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.recording-description {
    font-size: 0.875rem;
    color: #cccccc;
    margin: 0 0 0.75rem 0;
    line-height: 1.4;
}

.recording-meta {
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

.instructor-category {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.instructor-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.instructor-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.instructor-avatar img {
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
    font-size: 0.875rem;
}

.instructor-details {
    flex: 1;
    min-width: 0;
}

.instructor-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #ffffff;
    line-height: 1.2;
}

.instructor-role {
    font-size: 0.75rem;
    color: #999999;
    line-height: 1.2;
}

.category-info {
    text-align: left;
}

.category-primary {
    font-size: 0.875rem;
    font-weight: 500;
    color: #ffffff;
    margin-bottom: 0.25rem;
}

.category-secondary {
    font-size: 0.75rem;
    color: #999999;
}

.recording-metrics {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.views-count {
    text-align: center;
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
</style>

<script>
function toggleBulkActions() {
    const form = document.getElementById('bulk-delete-form');
    const checkboxes = document.querySelectorAll('.bulk-checkbox');
    const isVisible = form.style.display !== 'none';
    
    form.style.display = isVisible ? 'none' : 'block';
    checkboxes.forEach(cb => cb.style.display = isVisible ? 'none' : 'inline-block');
    
    if (isVisible) {
        // Reset all checkboxes when hiding
        checkboxes.forEach(cb => cb.checked = false);
        updateSelectedCount();
    }
}

function updateSelectedCount() {
    const selectedCount = document.querySelectorAll('.recording-checkbox:checked').length;
    document.getElementById('selected-count').textContent = selectedCount;
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle select all checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.recording-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });
    
    // Handle individual checkboxes
    document.querySelectorAll('.recording-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
});
</script>
@endsection 