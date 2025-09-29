@extends('layouts.app')

@section('title', $category->name . ' - FitLive')

@section('content')
<div class="container-fluid bg-dark text-white min-vh-100">
    <!-- Category Header -->
    <div class="row py-5 bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="display-5 fw-bold mb-2">
                        <i class="fas fa-tag me-3"></i>{{ $category->name }}
                    </h1>
                    <p class="lead mb-0">
                        {{ $sessions->total() }} session(s) in this category
                    </p>
                </div>
                <div>
                    <a href="{{ route('fitlive.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to FitLive
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row py-4">
        <div class="col-12">
            <div class="card bg-secondary border-secondary">
                <div class="card-body">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label text-white">Status</label>
                            <select name="status" class="form-select bg-dark border-secondary text-white">
                                <option value="">All Status</option>
                                <option value="live" {{ request('status') == 'live' ? 'selected' : '' }}>Live Now</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Upcoming</option>
                                <option value="ended" {{ request('status') == 'ended' ? 'selected' : '' }}>Ended</option>
                            </select>
                        </div>
                        
                        @if($category->subCategories->count() > 0)
                        <div class="col-md-3">
                            <label class="form-label text-white">Sub Category</label>
                            <select name="sub_category_id" class="form-select bg-dark border-secondary text-white">
                                <option value="">All Sub Categories</option>
                                @foreach($category->subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" {{ request('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                                        {{ $subCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <div class="col-md-4">
                            <label class="form-label text-white">Search</label>
                            <input type="text" name="search" class="form-control bg-dark border-secondary text-white" 
                                   placeholder="Search sessions..." value="{{ request('search') }}">
                        </div>
                        
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sessions Grid -->
    @if($sessions->count() > 0)
    <div class="row">
        @foreach($sessions as $session)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card bg-secondary h-100 
                    @if($session->status == 'live') border-danger
                    @elseif($session->status == 'scheduled') border-warning
                    @else border-secondary @endif">
                    
                    @if($session->banner_image)
                        <img src="{{ asset('storage/app/public/'.$session->banner_image) }}" 
                             class="card-img-top" 
                             alt="{{ $session->title }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-video fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <!-- Status Badge -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            @switch($session->status)
                                @case('live')
                                    <span class="badge bg-danger blink">LIVE</span>
                                    @break
                                @case('scheduled')
                                    <span class="badge bg-warning">UPCOMING</span>
                                    @break
                                @case('ended')
                                    <span class="badge bg-secondary">ENDED</span>
                                    @break
                            @endswitch
                            
                            @if($session->subCategory)
                                <small class="text-muted">{{ $session->subCategory->name }}</small>
                            @endif
                        </div>
                        
                        <!-- Title and Description -->
                        <h5 class="card-title text-white">{{ $session->title }}</h5>
                        <p class="card-text text-light flex-grow-1">
                            {{ Str::limit($session->description, 100) }}
                        </p>
                        
                        <!-- Session Info -->
                        <div class="mt-auto">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">Instructor:</small><br>
                                    <strong class="text-white">{{ $session->instructor->name }}</strong>
                                </div>
                                <div class="col-6">
                                    @if($session->status == 'live' && $session->viewer_peak)
                                        <small class="text-muted">Viewers:</small><br>
                                        <span class="badge bg-info">{{ $session->viewer_peak }}</span>
                                    @elseif($session->status == 'scheduled' && $session->scheduled_at)
                                        <small class="text-muted">Starts:</small><br>
                                        <strong class="text-warning">{{ $session->scheduled_at->format('M d, g:i A') }}</strong>
                                    @elseif($session->status == 'ended' && $session->viewer_peak)
                                        <small class="text-muted">Peak Viewers:</small><br>
                                        <span class="badge bg-info">{{ $session->viewer_peak }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            @if($session->status == 'live')
                                <a href="{{ route('fitlive.session', $session) }}" 
                                   class="btn btn-danger w-100">
                                    <i class="fas fa-play me-2"></i>Join Live Session
                                </a>
                            @elseif($session->status == 'scheduled')
                                <button class="btn btn-outline-warning w-100" disabled>
                                    <i class="fas fa-clock me-2"></i>Starts {{ $session->scheduled_at->diffForHumans() }}
                                </button>
                            @elseif($session->status == 'ended')
                                @if($session->mp4_path)
                                    <a href="{{ route('fitlive.session', $session) }}" 
                                       class="btn btn-outline-light w-100">
                                        <i class="fas fa-play me-2"></i>Watch Recording
                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary w-100" disabled>
                                        <i class="fas fa-ban me-2"></i>No Recording Available
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($sessions->hasPages())
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $sessions->appends(request()->query())->links() }}
        </div>
    </div>
    @endif

    @else
    <!-- Empty State -->
    <div class="row py-5">
        <div class="col-12 text-center">
            <i class="fas fa-video fa-5x text-muted mb-4"></i>
            <h3 class="text-white">No Sessions Found</h3>
            <p class="text-muted">
                @if(request()->filled('search') || request()->filled('status') || request()->filled('sub_category_id'))
                    Try adjusting your filters or <a href="{{ route('fitlive.category', $category) }}" class="text-info">view all sessions</a> in this category.
                @else
                    No sessions are available in this category yet.
                @endif
            </p>
            <a href="{{ route('fitlive.index') }}" class="btn btn-outline-light mt-3">
                <i class="fas fa-arrow-left me-2"></i>Back to FitLive
            </a>
        </div>
    </div>
    @endif

    <!-- Sub Categories (if available) -->
    @if($category->subCategories->count() > 0 && !request()->filled('sub_category_id'))
    <div class="row py-5">
        <div class="col-12">
            <h3 class="text-white mb-4">
                <i class="fas fa-list me-2"></i>Sub Categories
            </h3>
            <div class="row">
                @foreach($category->subCategories as $subCategory)
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card bg-secondary border-info">
                            <div class="card-body text-center">
                                <h6 class="card-title text-white">{{ $subCategory->name }}</h6>
                                <p class="text-muted mb-2">
                                    {{ $subCategory->fit_live_sessions_count ?? 0 }} sessions
                                </p>
                                <a href="{{ route('fitlive.category', $category) }}?sub_category_id={{ $subCategory->id }}" 
                                   class="btn btn-outline-info btn-sm">
                                    View Sessions
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.blink {
    animation: blink-animation 1s steps(5, start) infinite;
}

@keyframes blink-animation {
    to {
        visibility: hidden;
    }
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}
</style>
@endsection 