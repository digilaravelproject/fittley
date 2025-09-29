@extends('layouts.admin')

@section('content')
<div class="fitguide-index">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-graduation-cap me-3"></i>FitGuide
                </h1>
                <p class="page-subtitle">Manage your educational and tutorial content</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.fitguide.single.create') }}" class="btn btn-success">
                        <i class="fas fa-play me-2"></i>Add Single Video
                    </a>
                    <a href="{{ route('admin.fitguide.series.create') }}" class="btn btn-primary">
                        <i class="fas fa-tv me-2"></i>Add Series
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-primary">
                <div class="stat-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $singles->count() }}</div>
                    <div class="stat-label">Single Videos</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success">
                <div class="stat-icon">
                    <i class="fas fa-tv"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $series->count() }}</div>
                    <div class="stat-label">Series</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-info">
                <div class="stat-icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $categories->count() }}</div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-warning">
                <div class="stat-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">
                        <a href="{{ route('admin.fitguide.categories.index') }}" class="text-white text-decoration-none">
                            Manage
                        </a>
                    </div>
                    <div class="stat-label">Categories</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="content-card mb-4">
        <div class="content-card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="Search by title or description..." value="{{ $query }}">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $categoryFilter == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="single" {{ $typeFilter == 'single' ? 'selected' : '' }}>Single Videos</option>
                        <option value="series" {{ $typeFilter == 'series' ? 'selected' : '' }}>Series</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Singles Section -->
    @if($singles->count() > 0)
        <div class="content-card mb-4">
            <div class="content-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="content-card-title">
                        <i class="fas fa-play-circle me-2"></i>Single Videos
                    </h3>
                    <a href="{{ route('admin.fitguide.single.index') }}" class="btn btn-outline-primary btn-sm">
                        View All Singles
                    </a>
                </div>
            </div>
            <div class="content-card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Content</th>
                                <th>Category</th>
                                <th>Language</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($singles as $single)
                                <tr>
                                    <td>
                                        <div class="content-info">
                                            <div class="content-thumbnail">
                                                @if($single->banner_image_path)
                                                    <img src="{{ asset('storage/app/public/' . $single->banner_image_path) }}" 
                                                         alt="{{ $single->title }}">
                                                @else
                                                    <i class="fas fa-play-circle"></i>
                                                @endif
                                            </div>
                                            <div class="content-details">
                                                <div class="content-title">{{ $single->title }}</div>
                                                <div class="content-description">{{ Str::limit($single->description, 60) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="category-info">
                                            <div class="category-primary">{{ $single->category->name ?? 'No Category' }}</div>
                                            <div class="category-secondary">{{ @$single->subCategory->name }}</div>
                                        </div>
                                    </td>
                                    <td>{{ ucfirst($single->language) }}</td>
                                    <td>
                                        @if($single->duration_minutes)
                                            {{ floor($single->duration_minutes / 60) }}h {{ $single->duration_minutes % 60 }}m
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($single->is_published)
                                            <span class="status-badge status-published">
                                                <i class="fas fa-circle"></i>
                                                Published
                                            </span>
                                        @else
                                            <span class="status-badge status-draft">
                                                <i class="fas fa-circle"></i>
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.fitguide.single.show', $single) }}" 
                                               class="action-btn action-btn-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.fitguide.single.edit', $single) }}" 
                                               class="action-btn action-btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Series Section -->
    @if($series->count() > 0)
        <div class="content-card">
            <div class="content-card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="content-card-title">
                        <i class="fas fa-tv me-2"></i>Series
                    </h3>
                    <a href="{{ route('admin.fitguide.series.index') }}" class="btn btn-outline-primary btn-sm">
                        View All Series
                    </a>
                </div>
            </div>
            <div class="content-card-body p-0">
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Content</th>
                                <th>Category</th>
                                <th>Language</th>
                                <th>Episodes</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($series as $seriesItem)
                                <tr>
                                    <td>
                                        <div class="content-info">
                                            <div class="content-thumbnail">
                                                @if($seriesItem->banner_image_path)
                                                    <img src="{{ asset('storage/app/public/' . $seriesItem->banner_image_path) }}" 
                                                         alt="{{ $seriesItem->title }}">
                                                @else
                                                    <i class="fas fa-tv"></i>
                                                @endif
                                            </div>
                                            <div class="content-details">
                                                <div class="content-title">{{ $seriesItem->title }}</div>
                                                <div class="content-description">{{ Str::limit($seriesItem->description, 60) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="category-info">
                                            <div class="category-primary">{{ $seriesItem->category->name ?? 'No Category' }}</div>
                                            <div class="category-secondary">{{ $seriesItem->subCategory->name ?? '' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ ucfirst($seriesItem->language) }}</td>
                                    <td>
                                        <span class="episode-count">{{ $seriesItem->total_episodes }} Episodes</span>
                                    </td>
                                    <td>
                                        @if($seriesItem->is_published)
                                            <span class="status-badge status-published">
                                                <i class="fas fa-circle"></i>
                                                Published
                                            </span>
                                        @else
                                            <span class="status-badge status-draft">
                                                <i class="fas fa-circle"></i>
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.fitguide.series.show', $seriesItem) }}" 
                                               class="action-btn action-btn-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.fitguide.series.edit', $seriesItem) }}" 
                                               class="action-btn action-btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if($singles->count() == 0 && $series->count() == 0)
        <div class="content-card">
            <div class="content-card-body">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="empty-title">No Content Found</div>
                    <div class="empty-description">
                        @if($query || $categoryFilter || $typeFilter)
                            No content matches your current filters. Try adjusting your search criteria.
                        @else
                            You haven't created any FitGuide content yet. Start by creating categories and then add your educational content.
                        @endif
                    </div>
                    <div class="empty-action">
                        @if(!$query && !$categoryFilter && !$typeFilter)
                            <a href="{{ route('admin.fitguide.categories.create') }}" class="btn btn-outline-primary me-2">
                                <i class="fas fa-folder-plus me-2"></i>Create Category First
                            </a>
                        @endif
                        <a href="{{ route('admin.fitguide.single.create') }}" class="btn btn-success me-2">
                            <i class="fas fa-play me-2"></i>Add Single Video
                        </a>
                        <a href="{{ route('admin.fitguide.series.create') }}" class="btn btn-primary">
                            <i class="fas fa-tv me-2"></i>Add Series
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.fitguide-index {
    animation: fadeInUp 0.6s ease-out;
}

.stat-card {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.stat-card.bg-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.stat-card.bg-info {
    background: linear-gradient(135deg, #17a2b8, #117a8b);
}

.stat-card.bg-warning {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}

.stat-icon {
    font-size: 2.5rem;
    margin-right: 1rem;
    opacity: 0.8;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
    margin-top: 0.25rem;
}

.content-thumbnail {
    width: 60px;
    height: 45px;
    border-radius: 8px;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    overflow: hidden;
}

.content-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.content-thumbnail i {
    font-size: 1.5rem;
    color: var(--text-muted);
}

.content-info {
    display: flex;
    align-items: center;
}

.content-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.content-description {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.category-info .category-primary {
    font-weight: 500;
    color: var(--text-primary);
}

.category-info .category-secondary {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.episode-count {
    background: var(--bg-light);
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-secondary);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection 