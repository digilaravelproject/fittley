

<?php $__env->startSection('title', 'FitLive Sessions'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-video page-title-icon"></i>
                    FitLive Sessions
                </h1>
                <p class="page-subtitle">Manage and monitor live fitness sessions</p>
            </div>
            <div class="page-actions">
                <a href="<?php echo e(route('admin.fitlive.sessions.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Session
                </a>
            </div>
        </div>
    </div>

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
                            <div class="stat-number"><?php echo e($sessions->total()); ?></div>
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
                            <div class="stat-number"><?php echo e($sessions->where('status', 'live')->count()); ?></div>
                            <div class="stat-label">Live Now</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo e($sessions->where('status', 'scheduled')->count()); ?></div>
                            <div class="stat-label">Scheduled</div>
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
                            <div class="stat-number"><?php echo e($sessions->sum('viewer_peak') ?? 0); ?></div>
                            <div class="stat-label">Total Viewers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-card">
        <form method="GET" class="filters-form">
            <div class="filters-grid">
                <div class="filter-item">
                    <label class="filter-label">Status</label>
                    <select name="status" class="form-select filter-select">
                        <option value="">All Status</option>
                        <option value="scheduled" <?php echo e(request('status') == 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                        <option value="live" <?php echo e(request('status') == 'live' ? 'selected' : ''); ?>>Live</option>
                        <option value="ended" <?php echo e(request('status') == 'ended' ? 'selected' : ''); ?>>Ended</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label class="filter-label">Category</label>
                    <select name="category_id" class="form-select filter-select">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e(@$category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="filter-item filter-search">
                    <label class="filter-label">Search</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" class="form-control filter-input" 
                               placeholder="Search sessions..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="filter-item filter-actions">
                    <button type="submit" class="btn btn-filter">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <a href="<?php echo e(route('admin.fitlive.sessions.index')); ?>" class="btn btn-clear">
                        <i class="fas fa-times me-2"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Content -->
    <div class="content-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list me-2"></i>All Sessions
            </h3>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($sessions->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-modern-enhanced">
                        <thead>
                            <tr>
                                <th width="30%">Session Details</th>
                                <th width="20%">Category & Instructor</th>
                                <th width="15%">Status & Schedule</th>
                                <th width="10%">Metrics</th>
                                <th width="25%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="session-row">
                                    <td>
                                        <div class="session-details">
                                            <div class="session-info">
                                                <h6 class="session-title">
                                                    <?php echo e($session->title); ?>

                                                    <?php if($session->status == 'live'): ?>
                                                        <span class="live-badge">
                                                            <span class="live-dot"></span>
                                                            LIVE
                                                        </span>
                                                    <?php endif; ?>
                                                </h6>
                                                <?php if($session->description): ?>
                                                    <p class="session-description"><?php echo e(Str::limit($session->description, 80)); ?></p>
                                                <?php endif; ?>
                                                <div class="session-meta">
                                                    <span class="meta-item">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        <?php echo e($session->created_at->format('M d, Y')); ?>

                                                    </span>
                                                    <span class="visibility-badge visibility-<?php echo e($session->visibility); ?>">
                                                        <i class="fas fa-<?php echo e($session->visibility == 'public' ? 'globe' : 'lock'); ?> me-1"></i>
                                                        <?php echo e(ucfirst($session->visibility)); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="category-instructor">
                                            <div class="category-info">
                                                <span class="category-badge">
                                                    <i class="fas fa-folder me-1"></i>
                                                    <?php echo e(@$session->category->name); ?>

                                                </span>
                                                <?php if($session->subCategory): ?>
                                                    <span class="subcategory-badge">
                                                        <?php echo e(@$session->subCategory->name); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="instructor-info">
                                                <div class="instructor-avatar">
                                                    <?php if($session->instructor->avatar): ?>
                                                        <img src="<?php echo e(asset('storage/app/public/' . $session->instructor->avatar)); ?>" alt="Instructor">
                                                    <?php else: ?>
                                                        <div class="avatar-placeholder-sm">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="instructor-details">
                                                    <div class="instructor-name"><?php echo e(@$session->instructor->name); ?></div>
                                                    <div class="instructor-role">Instructor</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="status-schedule">
                                            <div class="status-section">
                                                <?php switch($session->status):
                                                    case ('scheduled'): ?>
                                                        <span class="status-badge-enhanced status-scheduled">
                                                            <i class="fas fa-clock me-1"></i>Scheduled
                                                        </span>
                                                        <?php break; ?>
                                                    <?php case ('live'): ?>
                                                        <span class="status-badge-enhanced status-live">
                                                            <i class="fas fa-circle blink me-1"></i>Live Now
                                                        </span>
                                                        <?php break; ?>
                                                    <?php case ('ended'): ?>
                                                        <span class="status-badge-enhanced status-ended">
                                                            <i class="fas fa-stop me-1"></i>Ended
                                                        </span>
                                                        <?php break; ?>
                                                <?php endswitch; ?>
                                            </div>
                                            <div class="schedule-section">
                                                <?php if($session->scheduled_at): ?>
                                                    <div class="schedule-item">
                                                        <i class="fas fa-clock text-warning me-1"></i>
                                                        <span><?php echo e($session->scheduled_at->format('M d, H:i')); ?></span>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="schedule-item text-muted">
                                                        <i class="fas fa-calendar-times me-1"></i>
                                                        <span>Not scheduled</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="session-metrics">
                                            <div class="metric-item">
                                                <span class="metric-value"><?php echo e($session->viewer_peak ?? 0); ?></span>
                                                <span class="metric-label">Peak Viewers</span>
                                            </div>
                                            <?php if($session->started_at && $session->ended_at): ?>
                                                <div class="metric-item">
                                                    <span class="metric-value"><?php echo e($session->getDuration()); ?></span>
                                                    <span class="metric-label">Duration</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons-enhanced">
                                            <div class="primary-actions">
                                                <?php if($session->status == 'live'): ?>
                                                    <a href="<?php echo e(route('admin.fitlive.sessions.stream', $session)); ?>" 
                                                       class="btn btn-action-enhanced btn-live" 
                                                       title="Stream Control">
                                                        <i class="fas fa-video me-2"></i>Control
                                                    </a>
                                                <?php elseif($session->status == 'scheduled'): ?>
                                                    <form action="<?php echo e(route('admin.fitlive.sessions.start', $session)); ?>" 
                                                          method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-action-enhanced btn-start" 
                                                                title="Start Session">
                                                            <i class="fas fa-play me-2"></i>Start
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <a href="<?php echo e(route('admin.fitlive.sessions.show', $session)); ?>" 
                                                       class="btn btn-action-enhanced btn-view" 
                                                       title="View Details">
                                                        <i class="fas fa-eye me-2"></i>View
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="secondary-actions">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary-action dropdown-toggle" type="button" 
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo e(route('admin.fitlive.sessions.show', $session)); ?>">
                                                                <i class="fas fa-eye me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="<?php echo e(route('admin.fitlive.sessions.edit', $session)); ?>">
                                                                <i class="fas fa-edit me-2"></i>Edit Session
                                                            </a>
                                                        </li>
                                                        <?php if($session->status == 'live'): ?>
                                                            <li>
                                                                <form action="<?php echo e(route('admin.fitlive.sessions.end', $session)); ?>" 
                                                                      method="POST" class="d-inline">
                                                                    <?php echo csrf_field(); ?>
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-stop me-2"></i>End Session
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if($session->status !== 'live'): ?>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="<?php echo e(route('admin.fitlive.sessions.destroy', $session)); ?>" 
                                                                      method="POST" class="d-inline"
                                                                      onsubmit="return confirm('Are you sure you want to delete this session?')">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash me-2"></i>Delete Session
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($sessions->hasPages()): ?>
                    <div class="pagination-wrapper">
                        <?php echo e($sessions->appends(request()->query())->links()); ?>

                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="empty-state-content">
                        <h3 class="empty-state-title">No sessions found</h3>
                        <p class="empty-state-description">
                            Get started by creating your first FitLive session to engage with your audience.
                        </p>
                        <a href="<?php echo e(route('admin.fitlive.sessions.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Session
                        </a>
                    </div>
                </div>
            <?php endif; ?>
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

/* Filters Card */
.filters-card {
    background: #191919;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #333333;
}

.filters-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 2fr auto;
    gap: 1rem;
    align-items: end;
}

.filter-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #ffffff;
    margin-bottom: 0.5rem;
}

.filter-select, .filter-input {
    background: #141414;
    border: 1px solid #333333;
    color: #ffffff;
    border-radius: 8px;
    padding: 0.75rem;
}

.filter-select:focus, .filter-input:focus {
    background: #141414;
    border-color: #f8a721;
    box-shadow: 0 0 0 0.2rem rgba(248, 167, 33, 0.25);
    color: #ffffff;
}

.search-input-wrapper {
    position: relative;
}

.search-input-wrapper .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #999999;
    z-index: 2;
}

.search-input-wrapper .filter-input {
    padding-left: 2.5rem;
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-filter {
    background: linear-gradient(135deg, #f8a721, #e8950e);
    color: #191919;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
}

.btn-filter:hover {
    background: linear-gradient(135deg, #e8950e, #d8840d);
    color: #191919;
}

.btn-clear {
    background: #141414;
    color: #999999;
    border: 1px solid #333333;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
}

.btn-clear:hover {
    background: #333333;
    color: #ffffff;
}

/* Enhanced Table Styling */
.table-modern-enhanced {
    background: #191919;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    --bs-table-bg: #191919;
    --bs-table-color: #ffffff;
    --bs-table-border-color: #333333;
    --bs-table-hover-bg: #202020;
    --bs-table-hover-color: #ffffff;
}

.table-modern-enhanced thead th {
    background: #141414;
    color: #ffffff;
    font-weight: 600;
    padding: 1rem;
    border: none;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #f8a721;
}

.table-modern-enhanced tbody .session-row {
    background: #191919;
    border-bottom: 1px solid #333333;
    transition: all 0.3s ease;
    color: #ffffff;
}

.table-modern-enhanced tbody .session-row:hover {
    background: #202020;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(248, 167, 33, 0.15);
}

.table-modern-enhanced tbody td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
    border: none;
    color: #ffffff;
}

/* Session Details */
.session-details {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.session-info {
    flex: 1;
    min-width: 0;
}

.session-title {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.live-badge {
    background: #dc3545;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.625rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.live-dot {
    width: 6px;
    height: 6px;
    background: white;
    border-radius: 50%;
    animation: blink 1s infinite;
}

.session-description {
    font-size: 0.875rem;
    color: #cccccc;
    margin: 0 0 0.75rem 0;
    line-height: 1.4;
}

.session-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
}

.meta-item {
    font-size: 0.75rem;
    color: #999999;
    display: flex;
    align-items: center;
}

.meta-item i {
    color: #f8a721;
}

.visibility-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.625rem;
    font-weight: 600;
    display: flex;
    align-items: center;
}

.visibility-public {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    border: 1px solid #28a745;
}

.visibility-private {
    background: #141414;
    color: #f8a721;
    border: 1px solid #f8a721;
}

/* Category & Instructor */
.category-instructor {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.category-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.category-badge {
    background: #141414;
    color: #f8a721;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid #f8a721;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    width: fit-content;
}

.subcategory-badge {
    background: rgba(248, 167, 33, 0.1);
    color: #f8a721;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.625rem;
    font-weight: 500;
    width: fit-content;
}

.instructor-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.instructor-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.instructor-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-sm {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8a721, #e8950e);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #191919;
    font-size: 0.875rem;
}

.instructor-details {
    flex: 1;
    min-width: 0;
}

.instructor-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #ffffff;
    line-height: 1.2;
}

.instructor-role {
    font-size: 0.75rem;
    color: #999999;
    line-height: 1.2;
}

/* Status & Schedule */
.status-schedule {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
}

.status-badge-enhanced {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: flex;
    align-items: center;
    white-space: nowrap;
    background: #141414;
}

.status-scheduled {
    color: #f8a721;
    border: 1px solid #f8a721;
}

.status-live {
    color: #28a745;
    border: 1px solid #28a745;
}

.status-ended {
    color: #6c757d;
    border: 1px solid #6c757d;
}

.schedule-item {
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #cccccc;
}

.schedule-item i {
    color: #f8a721;
}

/* Session Metrics */
.session-metrics {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.metric-item {
    text-align: center;
}

.metric-value {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
    color: #f8a721;
    line-height: 1;
}

.metric-label {
    display: block;
    font-size: 0.625rem;
    color: #999999;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 0.25rem;
}

/* Enhanced Actions */
.action-buttons-enhanced {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.primary-actions {
    flex: 1;
}

.btn-action-enhanced {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    white-space: nowrap;
}

.btn-live {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    border: 1px solid #28a745;
}

.btn-live:hover {
    background: linear-gradient(135deg, #218838, #1ea085);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    color: white;
}

.btn-start {
    background: linear-gradient(135deg, #f8a721, #e8950e);
    color: #191919;
    border: 1px solid #f8a721;
}

.btn-start:hover {
    background: linear-gradient(135deg, #e8950e, #d8840d);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(248, 167, 33, 0.3);
    color: #191919;
}

.btn-view {
    background: #141414;
    color: #f8a721;
    border: 1px solid #f8a721;
}

.btn-view:hover {
    background: #f8a721;
    color: #191919;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(248, 167, 33, 0.3);
}

.btn-secondary-action {
    background: #141414;
    border: 1px solid #333333;
    color: #cccccc;
    padding: 0.75rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-secondary-action:hover {
    background: #f8a721;
    border-color: #f8a721;
    color: #191919;
}

.dropdown-menu {
    background: #191919;
    border: 1px solid #333333;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    padding: 0.5rem 0;
}

.dropdown-item {
    padding: 0.75rem 1rem;
    color: #cccccc;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.dropdown-item:hover {
    background: #141414;
    color: #f8a721;
}

.dropdown-item.text-danger:hover {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filters-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .table-modern-enhanced thead th {
        padding: 0.75rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .table-modern-enhanced tbody td {
        padding: 1rem 0.5rem;
    }
    
    .action-buttons-enhanced {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .btn-action-enhanced {
        width: 100%;
        justify-content: center;
    }
}
</style>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitlive/sessions/index.blade.php ENDPATH**/ ?>