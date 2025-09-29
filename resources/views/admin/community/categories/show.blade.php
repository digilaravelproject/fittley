@extends('layouts.admin')

@section('title', 'Category: ' . $category->name)

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <div class="d-flex align-items-center">
                    <div class="category-icon me-3" style="background-color: {{ $category->color }};">
                        <i class="{{ $category->icon }}"></i>
                    </div>
                    <div>
                        <h1 class="page-title-text mb-0">{{ $category->name }}</h1>
                        <p class="page-subtitle mb-0">Category Details & Analytics</p>
                    </div>
                </div>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.community.categories.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Categories
                </a>
                <a href="{{ route('admin.community.categories.edit', $category->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit Category
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteCategory()">
                    <i class="fas fa-trash me-2"></i>Delete
                </button>
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

    <!-- Statistics Cards -->
    <div class="stats-grid mb-5">
        <div class="row g-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-primary">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $stats['total_posts'] }}</div>
                            <div class="stat-label">Total Posts</div>
                            <div class="stat-trend">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $stats['posts_this_month'] }} this month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-info">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $stats['total_groups'] }}</div>
                            <div class="stat-label">Groups</div>
                            <div class="stat-trend">
                                <i class="fas fa-check"></i>
                                <span>{{ $stats['active_groups'] }} active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-success">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($category->view_count ?? 0) }}</div>
                            <div class="stat-label">Total Views</div>
                            <div class="stat-trend">
                                <i class="fas fa-trending-up"></i>
                                <span>Popular category</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-warning">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-sort-numeric-up"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $category->order }}</div>
                            <div class="stat-label">Display Order</div>
                            <div class="stat-trend">
                                <i class="fas fa-{{ $category->is_active ? 'check text-success' : 'times text-danger' }}"></i>
                                <span>{{ $category->is_active ? 'Active' : 'Inactive' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Category Information -->
        <div class="col-xl-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Category Information</h3>
                </div>
                <div class="card-body">
                    <div class="info-group">
                        <label>Name</label>
                        <p>{{ $category->name }}</p>
                    </div>
                    
                    @if($category->description)
                    <div class="info-group">
                        <label>Description</label>
                        <p>{{ $category->description }}</p>
                    </div>
                    @endif
                    
                    <div class="info-group">
                        <label>Slug</label>
                        <p><code>{{ $category->slug }}</code></p>
                    </div>
                    
                    <div class="info-group">
                        <label>Color & Icon</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="category-icon" style="background-color: {{ $category->color }};">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                            <div>
                                <div><strong>{{ $category->color }}</strong></div>
                                <div><code>{{ $category->icon }}</code></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <label>Status</label>
                        <div>
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-group">
                        <label>Created</label>
                        <p>{{ $category->created_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    
                    <div class="info-group">
                        <label>Last Updated</label>
                        <p>{{ $category->updated_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="col-xl-8">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Recent Posts</h3>
                    <a href="{{ route('admin.community.posts.index', ['category_id' => $category->id]) }}" class="view-all">View all</a>
                </div>
                <div class="card-body">
                    @if($category->posts && $category->posts->count() > 0)
                        <div class="posts-list">
                            @foreach($category->posts as $post)
                                <div class="post-item">
                                    <div class="post-content">
                                        <h6>{{ Str::limit($post->content, 80) }}</h6>
                                        <div class="post-meta">
                                            <span class="text-muted">
                                                <i class="fas fa-user me-1"></i>{{ $post->user->name ?? 'Unknown User' }}
                                            </span>
                                            <span class="text-muted">
                                                <i class="fas fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="post-actions">
                                        <a href="{{ route('admin.community.posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state text-center py-4">
                            <i class="fas fa-comments fa-2x text-muted"></i>
                            <h5 class="mt-3">No Posts Yet</h5>
                            <p class="text-muted">No posts have been created in this category yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Groups -->
            <div class="dashboard-card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Groups in this Category</h3>
                    <a href="{{ route('admin.community.groups.index', ['category_id' => $category->id]) }}" class="view-all">View all</a>
                </div>
                <div class="card-body">
                    @if($category->groups && $category->groups->count() > 0)
                        <div class="groups-list">
                            @foreach($category->groups as $group)
                                <div class="group-item">
                                    <div class="group-content">
                                        <h6>{{ $group->name }}</h6>
                                        <p class="text-muted mb-2">{{ Str::limit($group->description, 100) }}</p>
                                        <div class="group-meta">
                                            <span class="badge bg-primary">{{ $group->members_count }} members</span>
                                            <span class="badge {{ $group->is_active ? 'bg-success' : 'bg-danger' }}">
                                                {{ $group->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="group-actions">
                                        <a href="{{ route('admin.community.groups.show', $group->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state text-center py-4">
                            <i class="fas fa-users fa-2x text-muted"></i>
                            <h5 class="mt-3">No Groups Yet</h5>
                            <p class="text-muted">No groups have been created in this category yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the category "<strong>{{ $category->name }}</strong>"?</p>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This action cannot be undone. All posts and groups in this category will be moved to "Uncategorized".
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('admin.community.categories.destroy', $category->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.category-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
}

.info-group {
    margin-bottom: 1.5rem;
}

.info-group:last-child {
    margin-bottom: 0;
}

.info-group label {
    display: block;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-group p {
    margin: 0;
    color: var(--text-primary);
}

.posts-list, .groups-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.post-item, .group-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: var(--bg-tertiary);
    border-radius: 8px;
    border: 1px solid var(--border-primary);
}

.post-content, .group-content {
    flex: 1;
}

.post-content h6, .group-content h6 {
    margin: 0 0 0.5rem;
    color: var(--text-primary);
}

.post-meta, .group-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
}

.group-meta {
    margin-top: 0.5rem;
    gap: 0.5rem;
}

.empty-state {
    color: var(--text-muted);
}

.empty-state h5 {
    color: var(--text-secondary);
}
</style>
@endpush

@push('scripts')
<script>
function deleteCategory() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush 