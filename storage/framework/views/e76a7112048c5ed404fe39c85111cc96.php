<?php $__env->startSection('title', 'Category Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-tag me-2"></i><?php echo e($category->name); ?>

                    </h3>
                    <div class="btn-group">
                        <a href="<?php echo e(route('admin.fitlive.categories.edit', $category)); ?>" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="<?php echo e(route('admin.fitlive.categories.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-dark table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td><?php echo e($category->id); ?></td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td><?php echo e($category->name); ?></td>
                                </tr>
                                <tr>
                                    <th>Slug:</th>
                                    <td><code class="text-info"><?php echo e($category->slug); ?></code></td>
                                </tr>
                                <tr>
                                    <th>Chat Mode:</th>
                                    <td>
                                        <?php switch($category->chat_mode):
                                            case ('during'): ?>
                                                <span class="badge bg-success">During Live</span>
                                                <?php break; ?>
                                            <?php case ('after'): ?>
                                                <span class="badge bg-warning">After Live</span>
                                                <?php break; ?>
                                            <?php case ('off'): ?>
                                                <span class="badge bg-danger">Disabled</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Sort Order:</th>
                                    <td><?php echo e($category->sort_order); ?></td>
                                </tr>
                                <tr>
                                    <th>Created:</th>
                                    <td><?php echo e($category->created_at->format('F d, Y \a\t g:i A')); ?></td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td><?php echo e($category->updated_at->format('F d, Y \a\t g:i A')); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="card bg-secondary border-info">
                                        <div class="card-body">
                                            <h2 class="text-info"><?php echo e($category->subCategories->count()); ?></h2>
                                            <p class="mb-0">Sub Categories</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-secondary border-primary">
                                        <div class="card-body">
                                            <h2 class="text-primary"><?php echo e($category->fitLiveSessions->count()); ?></h2>
                                            <p class="mb-0">Sessions</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sub Categories -->
    <?php if($category->subCategories->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-list me-2"></i>Sub Categories
                    </h4>
                    <a href="<?php echo e(route('admin.fitlive.subcategories.create')); ?>?category_id=<?php echo e($category->id); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Add Sub Category
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Sort Order</th>
                                    <th>Sessions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($subCategory->name); ?></td>
                                        <td><code class="text-info"><?php echo e($subCategory->slug); ?></code></td>
                                        <td><?php echo e($subCategory->sort_order); ?></td>
                                        <td><span class="badge bg-primary"><?php echo e($subCategory->fitLiveSessions->count()); ?></span></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('admin.fitlive.subcategories.show', $subCategory)); ?>" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.fitlive.subcategories.edit', $subCategory)); ?>" 
                                                   class="btn btn-sm btn-outline-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recent Sessions -->
    <?php if($category->fitLiveSessions->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white mb-0">
                        <i class="fas fa-video me-2"></i>Recent Sessions
                    </h4>
                    <a href="<?php echo e(route('admin.fitlive.sessions.create')); ?>?category_id=<?php echo e($category->id); ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Add Session
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Instructor</th>
                                    <th>Status</th>
                                    <th>Scheduled</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $category->fitLiveSessions->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($session->title); ?></td>
                                        <td><?php echo e($session->instructor->name); ?></td>
                                        <td>
                                            <?php switch($session->status):
                                                case ('scheduled'): ?>
                                                    <span class="badge bg-warning">Scheduled</span>
                                                    <?php break; ?>
                                                <?php case ('live'): ?>
                                                    <span class="badge bg-success">Live</span>
                                                    <?php break; ?>
                                                <?php case ('ended'): ?>
                                                    <span class="badge bg-secondary">Ended</span>
                                                    <?php break; ?>
                                            <?php endswitch; ?>
                                        </td>
                                        <td><?php echo e($session->scheduled_at ? $session->scheduled_at->format('M d, Y g:i A') : 'Not scheduled'); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.fitlive.sessions.show', $session)); ?>" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digi_Laravel_Prrojects\Fittelly_github\fittley\resources\views/admin/fitlive/categories/show.blade.php ENDPATH**/ ?>