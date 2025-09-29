@extends('layouts.admin')

@section('title', 'FitFlix Shorts')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">FitFlix Shorts</h1>
                <p class="page-subtitle">Manage vertical short videos for community engagement</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.community.fitflix-shorts.categories.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-folder me-2"></i>Manage Categories
                </a>
                <a href="{{ route('admin.community.fitflix-shorts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Upload Short
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="content-card mb-4">
        <div class="content-card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search shorts..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Featured</label>
                    <select name="featured" class="form-select">
                        <option value="">All</option>
                        <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured</option>
                        <option value="no" {{ request('featured') === 'no' ? 'selected' : '' }}>Not Featured</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Latest</option>
                        <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="views_count" {{ request('sort_by') === 'views_count' ? 'selected' : '' }}>Views</option>
                        <option value="published_at" {{ request('sort_by') === 'published_at' ? 'selected' : '' }}>Published Date</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.community.fitflix-shorts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Shorts Grid -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Shorts ({{ $shorts->total() }})</h5>
            </div>
        </div>
        <div class="content-card-body">
            @if($shorts->count() > 0)
                <div class="row">
                    @foreach($shorts as $short)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <div class="position-relative">
                                    @if($short->thumbnail_url)
                                        <img src="{{ $short->thumbnail_url }}" class="card-img-top" 
                                             style="height: 200px; object-fit: cover;" alt="{{ $short->title }}">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light" 
                                             style="height: 200px;">
                                            <i class="fas fa-mobile-alt fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    @if($short->is_featured)
                                        <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                                            <i class="fas fa-star"></i> Featured
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($short->title, 40) }}</h6>
                                    <p class="card-text text-muted small">{{ Str::limit($short->description, 60) }}</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $short->category->name }}</small>
                                        <span class="badge bg-{{ $short->is_published ? 'success' : 'secondary' }}">
                                            {{ $short->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-2 d-flex gap-1">
                                        <a href="{{ route('admin.community.fitflix-shorts.show', $short) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.community.fitflix-shorts.edit', $short) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.community.fitflix-shorts.destroy', $short) }}" 
                                              style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $shorts->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No shorts found</h5>
                    <p class="text-muted">Start by uploading your first FitFlix short video.</p>
                    <a href="{{ route('admin.community.fitflix-shorts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Upload Short
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 