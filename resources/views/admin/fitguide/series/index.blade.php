@extends('layouts.admin')

@section('content')
<div class="series-index">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-video me-3"></i>Video Series
                </h1>
                <p class="page-subtitle">Manage your educational video series</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitguide.series.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Series
                </a>
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
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ $statusFilter === '1' ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ $statusFilter === '0' ? 'selected' : '' }}>Draft</option>
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

    <!-- Content Table -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="content-card-title">
                        <i class="fas fa-list me-2"></i>Video Series
                    </h3>
                    <p class="content-card-subtitle">All series content</p>
                </div>
            </div>
        </div>
        <div class="content-card-body p-0">
            @if($series->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Series</th>
                                <th>Category</th>
                                <th>Episodes</th>
                                <th>Progress</th>
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
                                                    <i class="fas fa-video"></i>
                                                @endif
                                            </div>
                                            <div class="content-details">
                                                <div class="content-title">{{ $seriesItem->title }}</div>
                                                <div class="content-description">{{ Str::limit($seriesItem->description, 60) }}</div>
                                                <div class="content-meta">
                                                    <span class="language-tag">{{ ucfirst($seriesItem->language) }}</span>
                                                    @if($seriesItem->cost > 0)
                                                        <span class="cost-tag">${{ $seriesItem->cost }}</span>
                                                    @else
                                                        <span class="cost-tag free">Free</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="category-info">
                                            <div class="category-primary">{{ $seriesItem->category->name }}</div>
                                            @if($seriesItem->subCategory)
                                                <div class="category-secondary">{{ $seriesItem->subCategory->name }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="episodes-info">
                                            <div class="episodes-count">{{ $seriesItem->episodes_count }}/{{ $seriesItem->total_episodes }}</div>
                                            <div class="episodes-label">Episodes</div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $progress = $seriesItem->total_episodes > 0 ? 
                                                ($seriesItem->episodes_count / $seriesItem->total_episodes) * 100 : 0;
                                        @endphp
                                        <div class="progress-container">
                                            <div class="progress">
                                                <div class="progress-bar" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <div class="progress-text">{{ round($progress) }}%</div>
                                        </div>
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
                                            <a href="{{ route('admin.fitguide.series.episodes', $seriesItem) }}" 
                                               class="action-btn action-btn-info" title="Manage Episodes">
                                                <i class="fas fa-list"></i>
                                            </a>
                                            <a href="{{ route('admin.fitguide.series.edit', $seriesItem) }}" 
                                               class="action-btn action-btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="action-btn action-btn-success toggle-status-btn" 
                                                    data-id="{{ $seriesItem->id }}"
                                                    title="Toggle Status">
                                                <i class="fas fa-toggle-{{ $seriesItem->is_published ? 'on' : 'off' }}"></i>
                                            </button>
                                            <form method="POST" 
                                                  action="{{ route('admin.fitguide.series.destroy', $seriesItem) }}" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this series? All episodes will be deleted as well.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="action-btn action-btn-danger" 
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($series->hasPages())
                    <div class="d-flex justify-content-center mt-4 px-4 pb-4">
                        {{ $series->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="empty-title">No Series Found</div>
                    <div class="empty-description">
                        @if($query || $categoryFilter || $statusFilter)
                            No series match your current filters. Try adjusting your search criteria.
                        @else
                            You haven't created any series yet. Start by creating your first educational series.
                        @endif
                    </div>
                    <div class="empty-action">
                        <a href="{{ route('admin.fitguide.series.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Create Your First Series
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.series-index {
    animation: fadeInUp 0.6s ease-out;
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
    margin-bottom: 0.5rem;
}

.content-meta {
    display: flex;
    gap: 0.5rem;
}

.language-tag, .cost-tag {
    font-size: 0.75rem;
    padding: 0.125rem 0.5rem;
    border-radius: 12px;
    font-weight: 500;
}

.language-tag {
    background: var(--info-light);
    color: var(--info-dark);
}

.cost-tag {
    background: var(--warning-light);
    color: var(--warning-dark);
}

.cost-tag.free {
    background: var(--success-light);
    color: var(--success-dark);
}

.category-info .category-primary {
    font-weight: 500;
    color: var(--text-primary);
}

.category-info .category-secondary {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.episodes-info {
    text-align: center;
}

.episodes-count {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
}

.episodes-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.progress-container {
    min-width: 100px;
}

.progress {
    height: 6px;
    background: var(--bg-light);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 0.25rem;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-align: center;
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtns = document.querySelectorAll('.toggle-status-btn');
    
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const seriesId = this.dataset.id;
            
            fetch(`/admin/fitguide/series/${seriesId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Something went wrong');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong');
            });
        });
    });
});
</script>
@endsection 