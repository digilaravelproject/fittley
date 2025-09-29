<?php $__env->startSection('title', 'Community Posts'); ?>

<?php $__env->startSection('content'); ?>

<style>
  .fitarena_status{
    color: #000;
  }
</style>
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-comments page-title-icon"></i>
                    Community Posts
                </h1>
                <p class="page-subtitle">Manage user-generated content and discussions</p>
            </div>
            <div class="page-actions">
                <a href="<?php echo e(route('admin.community.dashboard')); ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                <a href="<?php echo e(route('admin.community.posts.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Post
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

    <!-- Filters and Search -->
    <div class="dashboard-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search Posts</label>
                    <input type="text" id="search" name="search" class="form-control" 
                           placeholder="Search content or author..." 
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-2">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">All Posts</option>
                        <option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>Published</option>
                        <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="featured" class="form-label">Featured</label>
                    <select id="featured" name="featured" class="form-select">
                        <option value="">All Posts</option>
                        <option value="1" <?php echo e(request('featured') === '1' ? 'selected' : ''); ?>>Featured</option>
                        <option value="0" <?php echo e(request('featured') === '0' ? 'selected' : ''); ?>>Not Featured</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
                <div class="col-md-1">
                    <a href="<?php echo e(route('admin.community.posts.index')); ?>" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-sync"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">All Posts</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?php echo e(route('admin.community.posts.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Create New Post
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
                                    <th scope="col">Post</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $posts ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="posts[]" value="<?php echo e($post->id); ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0"><?php echo e($post->title); ?></h6>
                                                <p class="text-muted mb-0"><?php echo e(Str::limit($post->content ?? '', 50)); ?></p>
                                                <?php if($post->is_featured ?? false): ?>
                                                    <span class="badge bg-warning">Featured</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($post->author ?? 'Unknown'); ?></td>
                                    <td>
                                        <span class="badge bg-info"><?php echo e($post->category ?? 'General'); ?></span>
                                    </td>
                                    <td>
                                        <?php switch($post->status ?? 'draft'):
                                            case ('published'): ?>
                                                <span class="badge bg-success">Published</span>
                                                <?php break; ?>
                                            <?php case ('draft'): ?>
                                                <span class="badge bg-secondary">Draft</span>
                                                <?php break; ?>
                                            <?php case ('pending'): ?>
                                                <span class="badge bg-warning">Pending Review</span>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <span class="badge bg-light text-dark"><?php echo e(ucfirst($post->status)); ?></span>
                                        <?php endswitch; ?>
                                    </td>
                                    <td><?php echo e($post->created_at ? $post->created_at->format('M d, Y') : 'N/A'); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="<?php echo e(route('admin.community.posts.show', $post)); ?>">
                                                    <i class="fas fa-eye me-2"></i>View
                                                </a>
                                                <?php /*<a class="dropdown-item" href="{{ route('admin.community.posts.edit', $post) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>*/ ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete('<?php echo e($post->id); ?>')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-comments fa-3x mb-3"></i>
                                            <h5>No posts found</h5>
                                            <p>Get started by creating your first community post.</p>
                                            <a href="<?php echo e(route('admin.community.posts.create')); ?>" class="btn btn-primary">
                                                Create Post
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(isset($posts) && method_exists($posts, 'hasPages') && $posts->hasPages()): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <?php echo e($posts->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fitarena_status" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fitarena_status">
                Are you sure you want to delete this post? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDelete(postId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/community/posts/${postId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Select all checkbox functionality
document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="posts[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fittley\resources\views/admin/community/posts/index.blade.php ENDPATH**/ ?>