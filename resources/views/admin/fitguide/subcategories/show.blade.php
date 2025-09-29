@extends('layouts.admin')

@section('title', 'View Subcategory - ' . $fgSubCategory->name)

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="dashboard-title">{{ $fgSubCategory->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fitguide.index') }}">FitGuide</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fitguide.subcategories.index') }}">Subcategories</a></li>
                        <li class="breadcrumb-item active">{{ $fgSubCategory->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.fitguide.subcategories.edit', $fgSubCategory) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Subcategory
                    </a>
                    <a href="{{ route('admin.fitguide.subcategories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Subcategories
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="content-card">
            <div class="content-card-header">
                <h5 class="content-card-title">Subcategory Details</h5>
            </div>
            <div class="content-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Name:</label>
                            <span>{{ $fgSubCategory->name }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Category:</label>
                            <span>
                                <a href="{{ route('admin.fitguide.categories.show', $fgSubCategory->category) }}">
                                    {{ $fgSubCategory->category->name }}
                                </a>
                            </span>
                        </div>
                        <div class="detail-item">
                            <label>Slug:</label>
                            <span class="text-muted">{{ $fgSubCategory->slug }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Status:</label>
                            <span class="badge {{ $fgSubCategory->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $fgSubCategory->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Sort Order:</label>
                            <span>{{ $fgSubCategory->sort_order ?? 'Not set' }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Created:</label>
                            <span>{{ $fgSubCategory->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Last Updated:</label>
                            <span>{{ $fgSubCategory->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Content Count:</label>
                            <span>
                                {{ $fgSubCategory->singles->count() }} Singles, 
                                {{ $fgSubCategory->series->count() }} Series
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($fgSubCategory->description)
                    <div class="mt-3">
                        <label>Description:</label>
                        <p class="text-muted">{{ $fgSubCategory->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.detail-item {
    margin-bottom: 15px;
}

.detail-item label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
    display: block;
}

.detail-item span {
    color: #6c757d;
}

.detail-item a {
    color: #007bff;
    text-decoration: none;
}

.detail-item a:hover {
    text-decoration: underline;
}
</style>
@endsection 