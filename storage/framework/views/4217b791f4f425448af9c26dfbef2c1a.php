

<?php $__env->startSection('content'); ?>
<div class="single-index">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-play-circle me-3"></i>Single Videos
                </h1>
                <p class="page-subtitle">Manage your individual educational videos</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?php echo e(route('admin.fitguide.single.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Single Video
                </a>
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

    <!-- Filter Section -->
    <div class="content-card mb-4">
        <div class="content-card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           placeholder="Search by title or description..." value="<?php echo e($query); ?>">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e($categoryFilter == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" <?php echo e($statusFilter === '1' ? 'selected' : ''); ?>>Published</option>
                        <option value="0" <?php echo e($statusFilter === '0' ? 'selected' : ''); ?>>Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Content Table -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="content-card-title">
                        <i class="fas fa-list me-2"></i>Single Videos
                    </h3>
                    <p class="content-card-subtitle">All individual video content</p>
                </div>
            </div>
        </div>
        <div class="content-card-body p-0">
            <?php if($singles->count() > 0): ?>
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Video</th>
                                <th>Category</th>
                                <th>Duration</th>
                                <th>Video Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $singles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="content-info">
                                            <div class="content-thumbnail">
                                                <?php if($single->banner_image_path): ?>
                                                    <img src="<?php echo e(asset('storage/app/public/' . $single->banner_image_path)); ?>" 
                                                         alt="<?php echo e($single->title); ?>">
                                                <?php else: ?>
                                                    <i class="fas fa-play-circle"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="content-details">
                                                <div class="content-title"><?php echo e($single->title); ?></div>
                                                <div class="content-description"><?php echo e(Str::limit($single->description, 60)); ?></div>
                                                <div class="content-meta">
                                                    <span class="language-tag"><?php echo e(ucfirst($single->language)); ?></span>
                                                    <?php if($single->cost > 0): ?>
                                                        <span class="cost-tag">$<?php echo e($single->cost); ?></span>
                                                    <?php else: ?>
                                                        <span class="cost-tag free">Free</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="category-info">
                                            <div class="category-primary"><?php echo e($single->category->name ?? 'No Category'); ?></div>
                                            <div class="category-secondary"><?php echo e(@$single->subCategory->name); ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($single->duration_minutes): ?>
                                            <span class="duration">
                                                <?php echo e(floor($single->duration_minutes / 60)); ?>h <?php echo e($single->duration_minutes % 60); ?>m
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="video-type <?php echo e($single->video_type); ?>">
                                            <?php switch($single->video_type):
                                                case ('youtube'): ?>
                                                    <i class="fab fa-youtube"></i> YouTube
                                                    <?php break; ?>
                                                <?php case ('s3'): ?>
                                                    <i class="fas fa-cloud"></i> S3
                                                    <?php break; ?>
                                                <?php case ('upload'): ?>
                                                    <i class="fas fa-upload"></i> Upload
                                                    <?php break; ?>
                                            <?php endswitch; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($single->is_published): ?>
                                            <span class="status-badge status-published">
                                                <i class="fas fa-circle"></i>
                                                Published
                                            </span>
                                        <?php else: ?>
                                            <span class="status-badge status-draft">
                                                <i class="fas fa-circle"></i>
                                                Draft
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('admin.fitguide.single.show', $single)); ?>" 
                                               class="action-btn action-btn-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.fitguide.single.edit', $single)); ?>" 
                                               class="action-btn action-btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="action-btn action-btn-success toggle-status-btn" 
                                                    data-id="<?php echo e($single->id); ?>"
                                                    title="Toggle Status">
                                                <i class="fas fa-toggle-<?php echo e($single->is_published ? 'on' : 'off'); ?>"></i>
                                            </button>
                                            <form method="POST" 
                                                  action="<?php echo e(route('admin.fitguide.single.destroy', $single)); ?>" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this video?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="action-btn action-btn-danger" 
                                                        title="Delete">
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
                    <div class="d-flex justify-content-center mt-4 px-4 pb-4">
                        <?php echo e($singles->links()); ?>

                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <div class="empty-title">No Single Videos Found</div>
                    <div class="empty-description">
                        <?php if($query || $categoryFilter || $statusFilter): ?>
                            No videos match your current filters. Try adjusting your search criteria.
                        <?php else: ?>
                            You haven't created any single videos yet. Start by adding your first educational video.
                        <?php endif; ?>
                    </div>
                    <div class="empty-action">
                        <a href="<?php echo e(route('admin.fitguide.single.create')); ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Add Your First Video
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.single-index {
    animation: fadeInUp 0.6s ease-out;
}

.content-thumbnail {
    width: 60px;
    height: 45px;
    border-radius: 8px;
    background: var(--bg-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    overflow: hidden;
}

.content-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.content-thumbnail i {
    font-size: 1.5rem;
    color: var(--text-muted);
}

.content-info {
    display: flex;
    align-items: center;
}

.content-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.content-description {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-bottom: 0.5rem;
}

.content-meta {
    display: flex;
    gap: 0.5rem;
}

.language-tag, .cost-tag {
    font-size: 0.75rem;
    padding: 0.125rem 0.5rem;
    border-radius: 12px;
    font-weight: 500;
}

.language-tag {
    background: var(--info-light);
    color: var(--info-dark);
}

.cost-tag {
    background: var(--warning-light);
    color: var(--warning-dark);
}

.cost-tag.free {
    background: var(--success-light);
    color: var(--success-dark);
}

.category-info .category-primary {
    font-weight: 500;
    color: var(--text-primary);
}

.category-info .category-secondary {
    font-size: 0.875rem;
    color: var(--text-muted);
}

.duration {
    background: var(--bg-light);
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.video-type {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
}

.video-type.youtube {
    background: #ff000020;
    color: #ff0000;
}

.video-type.s3 {
    background: #ff990020;
    color: #ff9900;
}

.video-type.upload {
    background: var(--primary-light);
    color: var(--primary-dark);
}

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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtns = document.querySelectorAll('.toggle-status-btn');
    
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const singleId = this.dataset.id;
            
            fetch(`/admin/fitguide/single/${singleId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Something went wrong');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong');
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitguide/single/index.blade.php ENDPATH**/ ?>