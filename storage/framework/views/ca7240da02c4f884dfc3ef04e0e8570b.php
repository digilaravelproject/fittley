

<?php $__env->startSection('title', 'FitInsight Blogs'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">FitInsight Blogs</h1>
            <p class="text-muted">Manage your blog posts and articles</p>
        </div>
        <a href="<?php echo e(route('admin.fitinsight.blogs.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Blog
        </a>
    </div>

    <!-- Content -->
    <div class="card">
        <div class="card-body">
            <?php if($blogs->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Views</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($blog->title); ?></td>
                                    <td><?php echo e($blog->category->name); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($blog->status === 'published' ? 'success' : 'secondary'); ?>">
                                            <?php echo e(ucfirst($blog->status)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($blog->author->name); ?></td>
                                    <td><?php echo e($blog->views_count); ?></td>
                                    <td>
                                        <?php echo e($blog->published_at ? $blog->published_at->format('M d, Y') : 'Not published'); ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.fitinsight.blogs.edit', $blog)); ?>" class="btn btn-sm btn-primary">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php echo e($blogs->links()); ?>

            <?php else: ?>
                <div class="text-center py-5">
                    <h5 class="text-muted">No blogs found</h5>
                    <p class="text-muted">Create your first blog post to get started.</p>
                    <a href="<?php echo e(route('admin.fitinsight.blogs.create')); ?>" class="btn btn-primary">
                        Create New Blog
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitinsight/blogs/index.blade.php ENDPATH**/ ?>