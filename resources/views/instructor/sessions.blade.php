@extends('layouts.app')

@section('title', 'My Sessions')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-video text-primary"></i>
            My Sessions
        </h1>
        <a href="{{ route('instructor.sessions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Session
        </a>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('instructor.sessions') }}">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Search sessions...">
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="live" {{ request('status') == 'live' ? 'selected' : '' }}>Live</option>
                            <option value="ended" {{ request('status') == 'ended' ? 'selected' : '' }}>Ended</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('instructor.sessions') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sessions Grid -->
    @if($sessions->count() > 0)
    <div class="row">
        @foreach($sessions as $session)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow h-100">
                <!-- Session Image/Banner -->
                <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" 
                     style="height: 200px; position: relative;">
                    @if($session->banner_image)
                        <img src="{{ $session->banner_image }}" alt="{{ $session->title }}" 
                             class="w-100 h-100" style="object-fit: cover;">
                    @else
                        <div class="text-center text-white">
                            <i class="fas fa-video fa-3x mb-2"></i>
                            <h5>{{ $session->title }}</h5>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge badge-{{ $session->status_color }} badge-lg">
                            @if($session->isLive())
                                <i class="fas fa-circle"></i> LIVE
                            @else
                                {{ ucfirst($session->status) }}
                            @endif
                        </span>
                    </div>
                </div>

                <div class="card-body d-flex flex-column">
                    <!-- Title and Category -->
                    <h5 class="card-title">{{ $session->title }}</h5>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-tag"></i> {{ $session->category->name ?? 'Uncategorized' }}
                        @if($session->subCategory)
                            → {{ $session->subCategory->name }}
                        @endif
                    </p>

                    <!-- Description -->
                    <p class="card-text">{{ Str::limit($session->description, 100) }}</p>

                    <!-- Session Details -->
                    <div class="mb-3 small text-muted">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-calendar"></i> Scheduled:</span>
                            <span>{{ $session->scheduled_at->format('M d, Y H:i A') }}</span>
                        </div>
                        @if($session->started_at)
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-play"></i> Started:</span>
                            <span>{{ $session->started_at->format('M d, H:i A') }}</span>
                        </div>
                        @endif
                        @if($session->ended_at)
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-stop"></i> Ended:</span>
                            <span>{{ $session->ended_at->format('M d, H:i A') }}</span>
                        </div>
                        @endif
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-users"></i> Peak Viewers:</span>
                            <span class="badge badge-info">{{ $session->viewer_peak }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fas fa-comments"></i> Chat:</span>
                            <span class="badge badge-{{ $session->chat_mode == 'off' ? 'secondary' : 'success' }}">
                                {{ ucfirst($session->chat_mode) }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-auto">
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('instructor.sessions.show', $session) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            
                            @if($session->isLive())
                                <a href="{{ route('instructor.sessions.stream', $session) }}" 
                                   class="btn btn-success btn-sm">
                                    <i class="fas fa-video"></i> Enter Studio
                                </a>
                            @elseif($session->isScheduled())
                                <a href="{{ route('instructor.sessions.stream', $session) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-play"></i> Start Stream
                                </a>
                            @else
                                <span class="btn btn-secondary btn-sm disabled">
                                    <i class="fas fa-check"></i> Completed
                                </span>
                            @endif
                        </div>
                        
                        @if($session->isScheduled())
                        <div class="mt-2 text-center">
                            <small class="text-primary">
                                <i class="fas fa-clock"></i>
                                {{ $session->scheduled_at->diffForHumans() }}
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $sessions->appends(request()->query())->links() }}
    </div>

    @else
    <!-- Empty State -->
    <div class="card shadow">
        <div class="card-body text-center py-5">
            <i class="fas fa-video fa-5x text-gray-300 mb-4"></i>
            <h3 class="text-gray-500">No Sessions Found</h3>
            <p class="text-muted mb-4">
                @if(request()->hasAny(['search', 'status', 'category_id']))
                    No sessions match your current filters. Try adjusting your search criteria.
                @else
                    You haven't created any sessions yet. Get started by creating your first session!
                @endif
            </p>
            @if(!request()->hasAny(['search', 'status', 'category_id']))
                <a href="{{ route('instructor.sessions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Your First Session
                </a>
            @else
                <a href="{{ route('instructor.sessions') }}" class="btn btn-outline-primary">
                    <i class="fas fa-undo"></i> Clear Filters
                </a>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
.badge-lg {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.card-img-top {
    border-top-left-radius: calc(0.375rem - 1px);
    border-top-right-radius: calc(0.375rem - 1px);
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
}
</style>
@endsection 