@extends('layouts.admin')

@section('title', 'Community Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Header -->
        <div class="col-12">
            <div class="page-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="page-title">
                        <i class="fas fa-users text-primary me-2"></i>
                        Community Dashboard
                    </h1>
                    <div class="page-actions">
                        <a href="{{ route('admin.community.posts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> New Post
                        </a>
                        <a href="{{ route('admin.community.categories.create') }}" class="btn btn-outline-primary ms-2">
                            <i class="fas fa-folder-plus me-1"></i> New Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="card-text text-muted mb-1">Total Posts</p>
                            <h3 class="card-title mb-0">{{ $stats['posts']['total'] ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $stats['posts']['today'] ?? 0 }} today
                            </small>
                        </div>
                        <div class="stats-icon bg-primary">
                            <i class="fas fa-file-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="card-text text-muted mb-1">Active Users</p>
                            <h3 class="card-title mb-0">{{ $stats['users']['total_community_users'] ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $stats['users']['active_today'] ?? 0 }} today
                            </small>
                        </div>
                        <div class="stats-icon bg-success">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="card-text text-muted mb-1">Groups</p>
                            <h3 class="card-title mb-0">{{ $stats['groups']['total'] ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $stats['groups']['active'] ?? 0 }} active
                            </small>
                        </div>
                        <div class="stats-icon bg-info">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="card-text text-muted mb-1">Messages</p>
                            <h3 class="card-title mb-0">{{ $stats['messaging']['messages_this_week'] ?? 0 }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $stats['messaging']['messages_today'] ?? 0 }} today
                            </small>
                        </div>
                        <div class="stats-icon bg-warning">
                            <i class="fas fa-comments"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_activity']) && count($stats['recent_activity']) > 0)
                        <div class="activity-list">
                            @foreach($stats['recent_activity'] as $activity)
                                <div class="activity-item">
                                    <div class="activity-icon activity-{{ $activity['type'] }}">
                                        @switch($activity['type'])
                                            @case('post')
                                                <i class="fas fa-file-text"></i>
                                                @break
                                            @case('group')
                                                <i class="fas fa-layer-group"></i>
                                                @break
                                            @case('badge')
                                                <i class="fas fa-medal"></i>
                                                @break
                                            @case('fittalk')
                                                <i class="fas fa-comments"></i>
                                                @break
                                            @default
                                                <i class="fas fa-info"></i>
                                        @endswitch
                                    </div>
                                    <div class="activity-content">
                                        <p class="activity-text">{{ $activity['message'] }}</p>
                                        <small class="activity-time text-muted">
                                            {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.community.posts.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-file-text me-2"></i>Manage Posts
                        </a>
                        <a href="{{ route('admin.community.categories.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-folder me-2"></i>Manage Categories
                        </a>
                        <a href="{{ route('admin.community.groups.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-layer-group me-2"></i>Manage Groups
                        </a>
                        <a href="{{ route('admin.community.badges.index') }}" class="btn btn-outline-warning">
                            <i class="fas fa-medal me-2"></i>Manage Badges
                        </a>
                        <a href="{{ route('admin.community.moderation.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-shield-alt me-2"></i>Moderation
                        </a>
                    </div>
                </div>
            </div>

            <!-- Top Categories -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Top Categories
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($stats['posts']['by_category']) && count($stats['posts']['by_category']) > 0)
                        @foreach($stats['posts']['by_category'] as $category)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-truncate">{{ $category->name ?? 'Unknown' }}</span>
                                <span class="badge bg-primary">{{ $category->posts_count ?? 0 }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center">
                            <i class="fas fa-chart-bar fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.15s ease-in-out;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.activity-list {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    padding: 0.75rem 0;
    border-bottom: 1px solid #eee;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
    margin-right: 0.75rem;
    flex-shrink: 0;
}

.activity-post { background-color: #007bff; }
.activity-group { background-color: #17a2b8; }
.activity-badge { background-color: #ffc107; }
.activity-fittalk { background-color: #28a745; }

.activity-content {
    flex: 1;
}

.activity-text {
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.activity-time {
    font-size: 0.75rem;
}
</style>
@endsection