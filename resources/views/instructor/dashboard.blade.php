@extends('layouts.app')

@section('title', 'Instructor Dashboard')

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-chalkboard-teacher page-title-icon"></i>
                    Welcome back, {{ $instructor->name }}!
                </h1>
                <p class="page-subtitle">Manage your live fitness sessions and track your performance</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('instructor.sessions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New Session
                </a>
                <a href="{{ route('instructor.analytics') }}" class="btn btn-secondary">
                    <i class="fas fa-chart-bar me-2"></i>Analytics
                </a>
            </div>
        </div>
    </div>

    <!-- Live Sessions Alert -->
    @if($liveSessions->count() > 0)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-broadcast-tower fa-2x me-3"></i>
            <div class="flex-grow-1">
                <h4 class="alert-heading mb-2">
                    You have {{ $liveSessions->count() }} live session(s) running!
                </h4>
                @foreach($liveSessions as $liveSession)
                <div class="d-flex justify-content-between align-items-center {{ !$loop->last ? 'mb-2' : '' }}">
                    <div>
                        <strong>{{ $liveSession->title }}</strong>
                        <small class="text-muted d-block">Started {{ $liveSession->started_at->diffForHumans() }}</small>
                    </div>
                    <a href="{{ route('instructor.sessions.stream', $liveSession) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-video me-1"></i>Enter Studio
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Live FitArena Sessions Alert -->
    @if(isset($liveArenaSession) && $liveArenaSession->count() > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-trophy fa-2x me-3"></i>
            <div class="flex-grow-1">
                <h4 class="alert-heading mb-2">
                    You have {{ $liveArenaSession->count() }} live FitArena session(s) running!
                </h4>
                @foreach($liveArenaSession as $arenaSession)
                <div class="d-flex justify-content-between align-items-center {{ !$loop->last ? 'mb-2' : '' }}">
                    <div>
                        <strong>{{ $arenaSession->title }}</strong>
                        <small class="text-muted d-block">{{ $arenaSession->event->title }} • Started {{ $arenaSession->actual_start->diffForHumans() }}</small>
                    </div>
                    <a href="{{ route('instructor.fitarena.sessions.stream', $arenaSession) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-trophy me-1"></i>Enter Arena
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-primary">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $analytics['total_sessions'] }}</div>
                            <div class="stat-label">Total Sessions</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-success">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $analytics['live_sessions'] }}</div>
                            <div class="stat-label">Live Sessions</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($analytics['total_viewers']) }}</div>
                            <div class="stat-label">Total Viewers</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-warning">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ number_format($analytics['average_viewers'], 1) }}</div>
                            <div class="stat-label">Avg. Viewers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Recent Sessions -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history me-2"></i>Recent Sessions
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('instructor.sessions') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>View All Sessions
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentSessions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th>Session</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Scheduled</th>
                                        <th>Viewers</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSessions as $session)
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    @if($session->banner_image)
                                                        <img src="{{ Storage::url($session->banner_image) }}" alt="Session">
                                                    @else
                                                        <div class="avatar-placeholder">
                                                            <i class="fas fa-video"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="user-details">
                                                    <div class="user-name">{{ $session->title }}</div>
                                                    @if($session->isLive())
                                                        <div class="user-role">
                                                            <span class="status-badge status-danger">
                                                                <i class="fas fa-circle blink me-1"></i>LIVE
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-metric">
                                                {{ $session->category->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            @switch($session->status)
                                                @case('live')
                                                    <span class="status-badge status-success">
                                                        <i class="fas fa-circle me-1"></i>Live
                                                    </span>
                                                    @break
                                                @case('scheduled')
                                                    <span class="status-badge status-warning">
                                                        <i class="fas fa-clock me-1"></i>Scheduled
                                                    </span>
                                                    @break
                                                @case('ended')
                                                    <span class="status-badge status-secondary">
                                                        <i class="fas fa-stop me-1"></i>Ended
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="status-badge status-secondary">
                                                        <i class="fas fa-circle me-1"></i>{{ ucfirst($session->status) }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="date-info">
                                                <div class="date-primary">{{ $session->scheduled_at->format('M d, Y') }}</div>
                                                <div class="date-secondary">{{ $session->scheduled_at->format('H:i') }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-metric">
                                                <i class="fas fa-users me-1"></i>{{ $session->viewer_peak }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('instructor.sessions.show', $session) }}" 
                                                   class="btn btn-action btn-info" 
                                                   title="View Session">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($session->isLive())
                                                    <a href="{{ route('instructor.sessions.stream', $session) }}" 
                                                       class="btn btn-action btn-success" 
                                                       title="Enter Studio">
                                                        <i class="fas fa-video"></i>
                                                    </a>
                                                @elseif($session->isScheduled())
                                                    <a href="{{ route('instructor.sessions.stream', $session) }}" 
                                                       class="btn btn-action btn-warning" 
                                                       title="Start Session">
                                                        <i class="fas fa-play"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="empty-state-content">
                                <h3 class="empty-state-title">No sessions yet</h3>
                                <p class="empty-state-description">
                                    Get started by creating your first live fitness session.
                                </p>
                                <a href="{{ route('instructor.sessions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create First Session
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="content-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h4>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="{{ route('instructor.sessions.create') }}" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="quick-action-content">
                                <div class="quick-action-title">Create Session</div>
                                <div class="quick-action-description">Schedule a new live session</div>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('instructor.sessions') }}" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="quick-action-content">
                                <div class="quick-action-title">Manage Sessions</div>
                                <div class="quick-action-description">View and edit your sessions</div>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('instructor.fitarena.sessions') }}" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="quick-action-content">
                                <div class="quick-action-title">FitArena Sessions</div>
                                <div class="quick-action-description">Manage arena competitions</div>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('instructor.analytics') }}" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <div class="quick-action-content">
                                <div class="quick-action-title">View Analytics</div>
                                <div class="quick-action-description">Track your performance</div>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('instructor.profile') }}" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="quick-action-content">
                                <div class="quick-action-title">Update Profile</div>
                                <div class="quick-action-description">Manage your information</div>
                            </div>
                            <div class="quick-action-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Upcoming Sessions -->
            @if($upcomingSessions->count() > 0)
            <div class="content-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-clock me-2"></i>Upcoming Sessions
                    </h4>
                </div>
                <div class="card-body">
                    <div class="upcoming-sessions">
                        @foreach($upcomingSessions as $session)
                        <div class="upcoming-session-item">
                            <div class="session-time">
                                <div class="session-date">{{ $session->scheduled_at->format('M d') }}</div>
                                <div class="session-hour">{{ $session->scheduled_at->format('H:i') }}</div>
                            </div>
                            <div class="session-details">
                                <div class="session-title">{{ $session->title }}</div>
                                <div class="session-category">{{ $session->category->name ?? 'N/A' }}</div>
                                <div class="session-countdown">{{ $session->scheduled_at->diffForHumans() }}</div>
                            </div>
                            <div class="session-actions">
                                <a href="{{ route('instructor.sessions.stream', $session) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Performance Summary -->
            <div class="content-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-trophy me-2"></i>Performance Summary
                    </h4>
                </div>
                <div class="card-body">
                    <div class="performance-metrics">
                        <div class="metric-item">
                            <div class="metric-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="metric-content">
                                <div class="metric-value">{{ number_format($analytics['average_viewers'], 1) }}</div>
                                <div class="metric-label">Avg. Viewers per Session</div>
                            </div>
                        </div>
                        
                        <div class="metric-item">
                            <div class="metric-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="metric-content">
                                <div class="metric-value">{{ $analytics['total_hours'] ?? '0' }}h</div>
                                <div class="metric-label">Total Streaming Hours</div>
                            </div>
                        </div>
                        
                        <div class="metric-item">
                            <div class="metric-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="metric-content">
                                <div class="metric-value">{{ $analytics['sessions_this_month'] ?? '0' }}</div>
                                <div class="metric-label">Sessions This Month</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.3; }
}

.blink {
    animation: blink 1.5s infinite;
}

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.quick-action-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.quick-action-item:hover {
    background: var(--bg-tertiary);
    border-color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(247, 163, 26, 0.15);
    color: var(--text-primary);
}

.quick-action-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-primary);
    margin-right: 1rem;
}

.quick-action-content {
    flex: 1;
}

.quick-action-title {
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.quick-action-description {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.quick-action-arrow {
    color: var(--text-muted);
    transition: transform 0.3s ease;
}

.quick-action-item:hover .quick-action-arrow {
    transform: translateX(4px);
    color: var(--primary-color);
}

.upcoming-sessions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.upcoming-session-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
}

.session-time {
    text-align: center;
    margin-right: 1rem;
    min-width: 60px;
}

.session-date {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
}

.session-hour {
    font-size: 1rem;
    font-weight: 600;
    color: var(--primary-color);
}

.session-details {
    flex: 1;
}

.session-title {
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.session-category {
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}

.session-countdown {
    font-size: 0.75rem;
    color: var(--primary-color);
    font-weight: 500;
}

.performance-metrics {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.metric-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-primary);
    border-radius: 12px;
}

.metric-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--bg-primary);
    margin-right: 1rem;
}

.metric-content {
    flex: 1;
}

.metric-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.metric-label {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.date-info {
    text-align: left;
}

.date-primary {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
}

.date-secondary {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.badge-metric {
    background: rgba(247, 163, 26, 0.1);
    color: var(--primary-color);
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
}
</style>
@endsection