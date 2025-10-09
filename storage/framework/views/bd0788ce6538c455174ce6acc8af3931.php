<?php $__env->startSection('title', 'FitDoc Overview'); ?>

<?php $__env->startSection('content'); ?>
<div class="fitdoc-overview">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-file-medical me-3"></i>FitDoc
                </h1>
                <p class="page-subtitle">Manage your documentary and educational content</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group">
                    <a href="<?php echo e(route('admin.fitdoc.single.create')); ?>" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add Single Video
                    </a>
                    <a href="<?php echo e(route('admin.fitdoc.series.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Series
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?php echo e($totalContent); ?></div>
                        <div class="stat-label">Total Content</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-success">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?php echo e($singleVideos); ?></div>
                        <div class="stat-label">Single Videos</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-info">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?php echo e($seriesCount); ?></div>
                        <div class="stat-label">Series</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?php echo e($totalEpisodes); ?></div>
                        <div class="stat-label">Total Episodes</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="quick-action-card">
                <div class="quick-action-header">
                    <h4><i class="fas fa-play-circle me-2"></i>Single Videos</h4>
                    <a href="<?php echo e(route('admin.fitdoc.single.index')); ?>" class="btn btn-outline-primary btn-sm">
                        View All
                    </a>
                </div>
                <div class="quick-action-body">
                    <p>Manage standalone documentary videos and educational content.</p>
                    <div class="action-buttons">
                        <a href="<?php echo e(route('admin.fitdoc.single.create')); ?>" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Create Single Video
                        </a>
                        <a href="<?php echo e(route('admin.fitdoc.single.index')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i>Manage Videos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="quick-action-card">
                <div class="quick-action-header">
                    <h4><i class="fas fa-video me-2"></i>Series</h4>
                    <a href="<?php echo e(route('admin.fitdoc.series.index')); ?>" class="btn btn-outline-primary btn-sm">
                        View All
                    </a>
                </div>
                <div class="quick-action-body">
                    <p>Create and manage multi-episode documentary series.</p>
                    <div class="action-buttons">
                        <a href="<?php echo e(route('admin.fitdoc.series.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Create Series
                        </a>
                        <a href="<?php echo e(route('admin.fitdoc.series.index')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-list me-1"></i>Manage Series
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Content -->
    <?php if($recentContent->count() > 0): ?>
        <div class="recent-content-section">
            <h3 class="section-title">Recent Content</h3>
            <div class="row">
                <?php $__currentLoopData = $recentContent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="content-card">
                            <div class="content-image">
                                <?php if($content->banner_image_path): ?>
                                    <img src="<?php echo e(asset('storage/app/public/' . $content->banner_image_path)); ?>" 
                                         alt="<?php echo e($content->title); ?>">
                                <?php else: ?>
                                    <div class="content-placeholder">
                                        <i class="fas fa-<?php echo e($content->type === 'single' ? 'play-circle' : 'video'); ?>"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="content-type-badge">
                                    <?php echo e(ucfirst($content->type)); ?>

                                </div>
                            </div>
                            <div class="content-body">
                                <h5 class="content-title"><?php echo e($content->title); ?></h5>
                                <p class="content-description"><?php echo e(Str::limit($content->description, 100)); ?></p>
                                <div class="content-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-globe me-1"></i><?php echo e(ucfirst($content->language)); ?>

                                    </span>
                                    <?php if($content->cost > 0): ?>
                                        <span class="meta-item">
                                            <i class="fas fa-dollar-sign me-1"></i>$<?php echo e($content->cost); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="meta-item">
                                            <i class="fas fa-gift me-1"></i>Free
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="content-actions">
                                    <?php if($content->type === 'single'): ?>
                                        <a href="<?php echo e(route('admin.fitdoc.single.show', $content)); ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <a href="<?php echo e(route('admin.fitdoc.single.edit', $content)); ?>" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('admin.fitdoc.series.show', $content)); ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <a href="<?php echo e(route('admin.fitdoc.series.edit', $content)); ?>" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state text-center py-5">
            <div class="empty-state-icon mb-4">
                <i class="fas fa-file-medical"></i>
            </div>
            <div class="empty-state-title">No FitDoc Content Yet</div>
            <div class="empty-state-description">
                You haven't created any FitDoc content yet. Start by creating your first documentary or educational content.
            </div>
            <div class="empty-state-actions mt-4">
                <a href="<?php echo e(route('admin.fitdoc.single.create')); ?>" class="btn btn-success me-2">
                    <i class="fas fa-plus me-2"></i>Create Single Video
                </a>
                <a href="<?php echo e(route('admin.fitdoc.series.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Series
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>
/* Fixed: Remove padding override that causes sidebar overlap */
.fitdoc-overview {
    /* The padding: 0 was causing content to go behind sidebar */
    /* padding: 0; */
}

.page-header {
    background: linear-gradient(135deg, rgba(247, 163, 26, 0.1), rgba(247, 163, 26, 0.05));
    padding: 2rem;
    border-radius: 20px;
    border: 1px solid rgba(247, 163, 26, 0.2);
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.page-subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
    margin: 0;
}

.quick-action-card {
    background: var(--bg-card);
    border: 1px solid var(--border-primary);
    border-radius: 16px;
    overflow: hidden;
    height: 100%;
    transition: var(--transition-normal);
}

.quick-action-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-color);
}

.quick-action-header {
    padding: 1.5rem 1.5rem 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.quick-action-header h4 {
    margin: 0;
    color: var(--text-primary);
    font-weight: 600;
}

.quick-action-body {
    padding: 1rem 1.5rem 1.5rem;
}

.quick-action-body p {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

.action-buttons {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--border-primary);
}

.content-card {
    background: var(--bg-card);
    border: 1px solid var(--border-primary);
    border-radius: 16px;
    overflow: hidden;
    transition: var(--transition-normal);
    height: 100%;
}

.content-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-color);
}

.content-image {
    height: 200px;
    position: relative;
    overflow: hidden;
}

.content-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.content-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--bg-tertiary), var(--bg-secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: var(--text-muted);
}

.content-type-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.content-body {
    padding: 1.5rem;
}

.content-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.content-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.content-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    font-size: 0.8rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
}

.content-actions {
    display: flex;
    gap: 0.5rem;
}

.empty-state {
    padding: 4rem 2rem;
}

.empty-state-icon {
    font-size: 4rem;
    color: var(--text-muted);
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state-description {
    color: var(--text-muted);
    font-size: 1rem;
    max-width: 500px;
    margin: 0 auto;
}
</style>
<?php $__env->stopPush(); ?> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitdoc/index.blade.php ENDPATH**/ ?>