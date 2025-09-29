@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-tag me-2"></i>{{ $category->name }}
                    </h3>
                    <div class="btn-group">
                        <a href="{{ route('admin.fitlive.categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.fitlive.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-dark table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td>{{ $category->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug:</th>
                                    <td><code class="text-info">{{ $category->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>Chat Mode:</th>
                                    <td>
                                        @switch($category->chat_mode)
                                            @case('during')
                                                <span class="badge bg-success">During Live</span>
                                                @break
                                            @case('after')
                                                <span class="badge bg-warning">After Live</span>
                                                @break
                                            @case('off')
                                                <span class="badge bg-danger">Disabled</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order:</th>
                                    <td>{{ $category->sort_order }}</td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $category->created_at->format('F d, Y \a\t g:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $category->updated_at->format('F d, Y \a\t g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="card bg-secondary border-info">
                                        <div class="card-body">
                                            <h2 class="text-info">{{ $category->subCategories->count() }}</h2>
                                            <p class="mb-0">Sub Categories</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-secondary border-primary">
                                        <div class="card-body">
                                            <h2 class="text-primary">{{ $category->fitLiveSessions->count() }}</h2>
                                            <p class="mb-0">Sessions</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sub Categories -->
    @if($category->subCategories->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-list me-2"></i>Sub Categories
                    </h4>
                    <a href="{{ route('admin.fitlive.subcategories.create') }}?category_id={{ $category->id }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Add Sub Category
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Sort Order</th>
                                    <th>Sessions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->subCategories as $subCategory)
                                    <tr>
                                        <td>{{ $subCategory->name }}</td>
                                        <td><code class="text-info">{{ $subCategory->slug }}</code></td>
                                        <td>{{ $subCategory->sort_order }}</td>
                                        <td><span class="badge bg-primary">{{ $subCategory->fitLiveSessions->count() }}</span></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.fitlive.subcategories.show', $subCategory) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.fitlive.subcategories.edit', $subCategory) }}" 
                                                   class="btn btn-sm btn-outline-warning">
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
        </div>
    </div>
    @endif

    <!-- Recent Sessions -->
    @if($category->fitLiveSessions->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-video me-2"></i>Recent Sessions
                    </h4>
                    <a href="{{ route('admin.fitlive.sessions.create') }}?category_id={{ $category->id }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Add Session
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Instructor</th>
                                    <th>Status</th>
                                    <th>Scheduled</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($category->fitLiveSessions->take(10) as $session)
                                    <tr>
                                        <td>{{ $session->title }}</td>
                                        <td>{{ $session->instructor->name }}</td>
                                        <td>
                                            @switch($session->status)
                                                @case('scheduled')
                                                    <span class="badge bg-warning">Scheduled</span>
                                                    @break
                                                @case('live')
                                                    <span class="badge bg-success">Live</span>
                                                    @break
                                                @case('ended')
                                                    <span class="badge bg-secondary">Ended</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ $session->scheduled_at ? $session->scheduled_at->format('M d, Y g:i A') : 'Not scheduled' }}</td>
                                        <td>
                                            <a href="{{ route('admin.fitlive.sessions.show', $session) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 