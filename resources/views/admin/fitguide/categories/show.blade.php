@extends('layouts.admin')

@section('title', 'View Category - ' . $fgCategory->name)

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="dashboard-title">{{ $fgCategory->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fitguide.index') }}">FitGuide</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.fitguide.categories.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">{{ $fgCategory->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.fitguide.categories.edit', $fgCategory) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Category
                    </a>
                    <a href="{{ route('admin.fitguide.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Categories
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="content-card">
            <div class="content-card-header">
                <h5 class="content-card-title">Category Details</h5>
            </div>
            <div class="content-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Name:</label>
                            <span>{{ $fgCategory->name }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Slug:</label>
                            <span class="text-muted">{{ $fgCategory->slug }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Status:</label>
                            <span class="badge {{ $fgCategory->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $fgCategory->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <label>Sort Order:</label>
                            <span>{{ $fgCategory->sort_order ?? 'Not set' }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Created:</label>
                            <span>{{ $fgCategory->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-item">
                            <label>Last Updated:</label>
                            <span>{{ $fgCategory->updated_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
                
                @if($fgCategory->description)
                    <div class="mt-3">
                        <label>Description:</label>
                        <p class="text-muted">{{ $fgCategory->description }}</p>
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
</style>
@endsection 