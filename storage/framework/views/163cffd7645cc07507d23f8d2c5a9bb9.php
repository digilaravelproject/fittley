

<?php $__env->startSection('title', 'FitFlix Shorts'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">FitFlix Shorts</h1>
                <p class="page-subtitle">Manage vertical short videos for community engagement</p>
            </div>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.community.fitflix-shorts.categories.index')); ?>" class="btn btn-outline-primary">
                    <i class="fas fa-folder me-2"></i>Manage Categories
                </a>
                <a href="<?php echo e(route('admin.community.fitflix-shorts.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Upload Short
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="content-card mb-4">
        <div class="content-card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search shorts..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>Published</option>
                        <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Featured</label>
                    <select name="featured" class="form-select">
                        <option value="">All</option>
                        <option value="yes" <?php echo e(request('featured') === 'yes' ? 'selected' : ''); ?>>Featured</option>
                        <option value="no" <?php echo e(request('featured') === 'no' ? 'selected' : ''); ?>>Not Featured</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="created_at" <?php echo e(request('sort_by') === 'created_at' ? 'selected' : ''); ?>>Latest</option>
                        <option value="title" <?php echo e(request('sort_by') === 'title' ? 'selected' : ''); ?>>Title</option>
                        <option value="views_count" <?php echo e(request('sort_by') === 'views_count' ? 'selected' : ''); ?>>Views</option>
                        <option value="published_at" <?php echo e(request('sort_by') === 'published_at' ? 'selected' : ''); ?>>Published Date</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="<?php echo e(route('admin.community.fitflix-shorts.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Shorts Grid -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Shorts (<?php echo e($shorts->total()); ?>)</h5>
            </div>
        </div>
        <div class="content-card-body">
            <?php if($shorts->count() > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $shorts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $short): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100">
                                <div class="position-relative">
                                    <?php if($short->thumbnail_url): ?>
                                        <img src="<?php echo e($short->thumbnail_url); ?>" class="card-img-top" 
                                             style="height: 200px; object-fit: cover;" alt="<?php echo e($short->title); ?>">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-light" 
                                             style="height: 200px;">
                                            <i class="fas fa-mobile-alt fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if($short->is_featured): ?>
                                        <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                                            <i class="fas fa-star"></i> Featured
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo e(Str::limit($short->title, 40)); ?></h6>
                                    <p class="card-text text-muted small"><?php echo e(Str::limit($short->description, 60)); ?></p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted"><?php echo e($short->category->name); ?></small>
                                        <span class="badge bg-<?php echo e($short->is_published ? 'success' : 'secondary'); ?>">
                                            <?php echo e($short->is_published ? 'Published' : 'Draft'); ?>

                                        </span>
                                    </div>
                                    
                                    <div class="mt-2 d-flex gap-1">
                                        <a href="<?php echo e(route('admin.community.fitflix-shorts.show', $short)); ?>" 
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.community.fitflix-shorts.edit', $short)); ?>" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="<?php echo e(route('admin.community.fitflix-shorts.destroy', $short)); ?>" 
                                              style="display: inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($shorts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No shorts found</h5>
                    <p class="text-muted">Start by uploading your first FitFlix short video.</p>
                    <a href="<?php echo e(route('admin.community.fitflix-shorts.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Upload Short
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/community/fitflix-shorts/index.blade.php ENDPATH**/ ?>