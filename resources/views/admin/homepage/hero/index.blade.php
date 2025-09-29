@extends('layouts.admin')

@section('title', 'Homepage Heroes')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Homepage Heroes</h1>
                <p class="page-subtitle">Manage hero content for the homepage video background</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.homepage.hero.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Hero Content
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="content-card mb-4">
        <div class="content-card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by title, category..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="sort_order" {{ request('sort_by') === 'sort_order' ? 'selected' : '' }}>Sort Order</option>
                        <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Created Date</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.homepage.hero.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Heroes List -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Homepage Heroes ({{ $heroes->total() }})</h5>
            </div>
        </div>
        <div class="content-card-body">
            @if($heroes->count() > 0)
                <div class="row g-4">
                    @foreach($heroes as $hero)
                    <div class="col-lg-6 col-xl-4">
                        <div class="hero-card">
                            <div class="hero-thumbnail">
                                <img src="{{ $hero->youtube_thumbnail_url }}" alt="{{ $hero->title }}" class="img-fluid">
                                <div class="hero-overlay">
                                    <div class="hero-status">
                                        <span class="badge bg-{{ $hero->is_active ? 'success' : 'secondary' }}">
                                            {{ $hero->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="hero-actions">
                                        <a href="{{ $hero->youtube_embed_url }}" target="_blank" class="btn btn-sm btn-light" title="Preview Video">
                                            <i class="fas fa-play"></i>
                                        </a>
                                        <a href="{{ route('admin.homepage.hero.edit', $hero) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.homepage.hero.destroy', $hero) }}" 
                                              style="display: inline-block;" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="hero-title">{{ $hero->title }}</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                               data-id="{{ $hero->id }}" 
                                               {{ $hero->is_active ? 'checked' : '' }}>
                                    </div>
                                </div>
                                @if($hero->category)
                                    <div class="hero-category mb-2">
                                        <span class="badge bg-primary">{{ $hero->category }}</span>
                                        @if($hero->duration)
                                            <span class="badge bg-info ms-1">{{ $hero->duration }}</span>
                                        @endif
                                        @if($hero->year)
                                            <span class="badge bg-secondary ms-1">{{ $hero->year }}</span>
                                        @endif
                                    </div>
                                @endif
                                <p class="hero-description">{{ Str::limit($hero->description, 100) }}</p>
                                <div class="hero-meta">
                                    <small class="text-muted">
                                        Sort: {{ $hero->sort_order }} | Created: {{ $hero->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $heroes->firstItem() }} to {{ $heroes->lastItem() }} of {{ $heroes->total() }} results
                    </div>
                    {{ $heroes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-video fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No homepage heroes found</h5>
                    <p class="text-muted">Start by creating your first homepage hero content.</p>
                    <a href="{{ route('admin.homepage.hero.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Hero Content
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.hero-card {
    border: 1px solid #e3e6f0;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
}

.hero-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.hero-thumbnail {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.hero-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.7) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
}

.hero-card:hover .hero-overlay {
    opacity: 1;
}

.hero-status {
    align-self: flex-start;
}

.hero-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.hero-content {
    padding: 1rem;
}

.hero-title {
    font-weight: 600;
    margin-bottom: 0;
    color: #2c3e50;
}

.hero-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.hero-meta {
    border-top: 1px solid #e9ecef;
    padding-top: 0.5rem;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status toggle functionality
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const heroId = this.dataset.id;
            const isActive = this.checked;
            
            fetch(`/admin/homepage/hero/${heroId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update status badge
                    const card = this.closest('.hero-card');
                    const statusBadge = card.querySelector('.hero-status .badge');
                    statusBadge.className = `badge bg-${data.is_active ? 'success' : 'secondary'}`;
                    statusBadge.textContent = data.is_active ? 'Active' : 'Inactive';
                    
                    // Show success message
                    showAlert('success', data.message);
                } else {
                    // Revert toggle if failed
                    this.checked = !isActive;
                    showAlert('error', 'Failed to update status');
                }
            })
            .catch(error => {
                // Revert toggle if error
                this.checked = !isActive;
                showAlert('error', 'An error occurred');
            });
        });
    });
});

function showAlert(type, message) {
    // Simple alert implementation
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insert at top of container
    const container = document.querySelector('.container-fluid');
    container.insertAdjacentHTML('afterbegin', alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}
</script>
@endpush
@endsection 