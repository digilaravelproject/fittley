

<?php $__env->startSection('title', 'Single Videos'); ?>

<?php $__env->startSection('content'); ?>
<div class="fitdoc-single-index">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-play-circle me-3"></i>
                    Single Videos
                </h1>
                <p class="page-subtitle">Manage your single video content</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?php echo e(route('admin.fitdoc.single.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add Single Video
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
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

    <!-- Search and Filters -->
    <div class="content-card mb-4">
        <div class="content-card-body">
            <form method="GET" action="<?php echo e(route('admin.fitdoc.single.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Search Videos</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control dark-input" 
                                   placeholder="Search videos..." value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Language</label>
                        <select name="language" class="form-select dark-input">
                            <option value="">All Languages</option>
                            <option value="english" <?php echo e(request('language') == 'english' ? 'selected' : ''); ?>>English</option>
                            <option value="spanish" <?php echo e(request('language') == 'spanish' ? 'selected' : ''); ?>>Spanish</option>
                            <option value="french" <?php echo e(request('language') == 'french' ? 'selected' : ''); ?>>French</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select dark-input">
                            <option value="">All Status</option>
                            <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>>Published</option>
                            <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="<?php echo e(route('admin.fitdoc.single.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Videos Table -->
    <div class="content-card">
        <div class="content-card-header">
            <h3 class="content-card-title">
                <i class="fas fa-list me-2"></i>
                All Single Videos
            </h3>
            <p class="content-card-subtitle"><?php echo e($singles->total() ?? 0); ?> videos found</p>
        </div>
        <div class="content-card-body p-0">
            <?php if($singles && $singles->count() > 0): ?>
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Video Info</th>
                                <th>Language & Cost</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $singles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="video-info">
                                        <div class="video-icon">
                                            <?php if($single->video_type === 'youtube'): ?>
                                                <i class="fab fa-youtube text-danger"></i>
                                            <?php elseif($single->video_type === 's3'): ?>
                                                <i class="fas fa-cloud text-info"></i>
                                            <?php else: ?>
                                                <i class="fas fa-play-circle text-primary"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="video-details">
                                            <div class="video-title"><?php echo e($single->title); ?></div>
                                            <div class="video-description"><?php echo e(Str::limit($single->description, 50)); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="language-cost">
                                        <div class="language"><?php echo e(ucfirst($single->language)); ?></div>
                                        <div class="cost"><?php echo e($single->cost > 0 ? '$' . number_format($single->cost, 2) : 'Free'); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="duration-info">
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo e($single->formatted_duration ?? '0h 12m'); ?>

                                    </div>
                                </td>
                                <td>
                                    <?php if($single->is_published): ?>
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Published
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock me-1"></i>
                                            Draft
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <div class="date-primary"><?php echo e($single->created_at->format('M j, Y')); ?></div>
                                        <div class="date-secondary"><?php echo e($single->created_at->format('g:i A')); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo e(route('admin.fitdoc.single.show', $single)); ?>" 
                                           class="action-btn action-btn-primary" 
                                           title="View Video">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.fitdoc.single.edit', $single)); ?>" 
                                           class="action-btn action-btn-secondary" 
                                           title="Edit Video">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="action-btn action-btn-warning toggle-status-btn" 
                                                data-id="<?php echo e($single->id); ?>"
                                                title="Toggle Status">
                                            <i class="fas fa-toggle-<?php echo e($single->is_published ? 'on' : 'off'); ?>"></i>
                                        </button>
                                        <form method="POST" 
                                              action="<?php echo e(route('admin.fitdoc.single.destroy', $single)); ?>" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this video?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="action-btn action-btn-danger" 
                                                    title="Delete Video">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if($singles->hasPages()): ?>
                    <div class="pagination-wrapper">
                        <?php echo e($singles->links()); ?>

                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <h3>No Single Videos Found</h3>
                    <p>There are no single videos created yet. Start by creating your first video.</p>
                    <a href="<?php echo e(route('admin.fitdoc.single.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Create First Video
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.fitdoc-single-index {
    animation: fadeInUp 0.6s ease-out;
}

.page-header {
    margin-bottom: 3rem;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}

.page-subtitle {
    font-size: 1.125rem;
    color: var(--text-muted);
    font-weight: 400;
}

/* Dark Input Styles */
.dark-input {
    background-color: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    color: var(--text-primary);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: var(--transition-fast);
}

.dark-input:focus {
    background-color: var(--bg-secondary);
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(247, 163, 26, 0.25);
    color: var(--text-primary);
}

.dark-input::placeholder {
    color: var(--text-muted);
}

.input-group-text {
    background-color: var(--bg-tertiary);
    border: 1px solid var(--border-primary);
    color: var(--text-muted);
    border-right: none;
}

.form-label {
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

/* Video Info Components */
.video-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.video-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--bg-tertiary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    border: 1px solid var(--border-primary);
}

.video-details {
    flex: 1;
}

.video-title {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.video-description {
    font-size: 0.8rem;
    color: var(--text-muted);
}

/* Language and Cost */
.language-cost {
    text-align: left;
}

.language {
    font-weight: 500;
    color: var(--text-primary);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.cost {
    font-size: 0.8rem;
    color: var(--text-muted);
}

/* Duration Info */
.duration-info {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
}

/* Action Button Styles */
.action-btn-secondary {
    background: linear-gradient(135deg, rgba(0, 208, 132, 0.15), rgba(0, 208, 132, 0.05));
    color: var(--success);
    border: 1px solid rgba(0, 208, 132, 0.2);
}

.action-btn-secondary:hover {
    background: linear-gradient(135deg, rgba(0, 208, 132, 0.25), rgba(0, 208, 132, 0.15));
    border-color: var(--success);
    transform: translateY(-2px);
}

.action-btn-warning {
    background: linear-gradient(135deg, rgba(255, 176, 32, 0.15), rgba(255, 176, 32, 0.05));
    color: var(--warning);
    border: 1px solid rgba(255, 176, 32, 0.2);
}

.action-btn-warning:hover {
    background: linear-gradient(135deg, rgba(255, 176, 32, 0.25), rgba(255, 176, 32, 0.15));
    border-color: var(--warning);
    transform: translateY(-2px);
}

.action-btn-danger {
    background: linear-gradient(135deg, rgba(229, 9, 20, 0.15), rgba(229, 9, 20, 0.05));
    color: var(--error);
    border: 1px solid rgba(229, 9, 20, 0.2);
}

.action-btn-danger:hover {
    background: linear-gradient(135deg, rgba(229, 9, 20, 0.25), rgba(229, 9, 20, 0.15));
    border-color: var(--error);
    transform: translateY(-2px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, rgba(247, 163, 26, 0.1), rgba(247, 163, 26, 0.05));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--primary-color);
    margin: 0 auto 2rem;
    border: 1px solid rgba(247, 163, 26, 0.2);
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.95rem;
    color: var(--text-muted);
    margin-bottom: 2rem;
}

/* Pagination Wrapper */
.pagination-wrapper {
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border-primary);
    background: var(--bg-tertiary);
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .action-btn {
        width: 100%;
        height: 32px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Status functionality
    document.querySelectorAll('.toggle-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const videoId = this.dataset.id;
            const icon = this.querySelector('i');
            
            fetch(`<?php echo e(route('admin.fitdoc.single.index')); ?>/${videoId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update icon
                    icon.className = data.is_published ? 'fas fa-toggle-on' : 'fas fa-toggle-off';
                    
                    // Update status badge in the same row
                    const row = this.closest('tr');
                    const statusBadge = row.querySelector('.status-badge');
                    if (data.is_published) {
                        statusBadge.className = 'status-badge status-active';
                        statusBadge.innerHTML = '<i class="fas fa-check-circle me-1"></i>Published';
                    } else {
                        statusBadge.className = 'status-badge status-pending';
                        statusBadge.innerHTML = '<i class="fas fa-clock me-1"></i>Draft';
                    }
                    
                    // Show success message
                    showToast('success', data.message);
                } else {
                    showToast('error', 'Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'An error occurred while updating status');
            });
        });
    });
});

function showToast(type, message) {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 5000);
}
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/admin/fitdoc/single/index.blade.php ENDPATH**/ ?>