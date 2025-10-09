

<?php $__env->startSection('title', 'Sub Category Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Sub Category Card -->
                <div class="card bg-dark border-secondary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title text-white mb-0">
                            <i class="fas fa-list me-2"></i><?php echo e($data['name'] ?? 'No Name Available'); ?>

                        </h3>
                        <div class="btn-group">
                            <a href="<?php echo e(route('admin.fitlive.subcategories.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Sub Category Details -->
                            <div class="col-md-6">
                                <table class="table table-dark table-borderless">
                                    <tr>
                                        <th width="30%">ID:</th>
                                        <td><?php echo e($data['id'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Category:</th>
                                        <td>
                                            <?php if(isset($data['category']) && $data['category'] != 'No Category'): ?>
                                                <a href="<?php echo e(route('admin.fitlive.categories.show', $subCategory->category)); ?>"
                                                    class="text-info text-decoration-none">
                                                    <?php echo e($data['category']); ?>

                                                </a>
                                            <?php else: ?>
                                                <span>No Category</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td><?php echo e($data['name'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td><code class="text-info"><?php echo e($data['slug'] ?? 'N/A'); ?></code></td>
                                    </tr>
                                    <tr>
                                        <th>Sort Order:</th>
                                        <td><?php echo e($data['sort_order'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td><?php echo e($data['created_at'] ?? 'N/A'); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Updated:</th>
                                        <td><?php echo e($data['updated_at'] ?? 'N/A'); ?></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Sessions Count -->
                            <div class="col-md-6">
                                <div class="card bg-secondary border-primary">
                                    <div class="card-body text-center">
                                        <h2 class="text-primary"><?php echo e($data['sessions_count'] ?? 0); ?></h2>
                                        <p class="mb-0">Sessions</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Sub Category Card -->
            </div>
        </div>

        <!-- Sessions Table -->
        <?php if($subCategory && $subCategory->fitLiveSessions->count()): ?>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-dark border-secondary">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title text-white mb-0">
                                <i class="fas fa-video me-2"></i> Sessions
                            </h4>
                            <a href="<?php echo e(route('admin.fitlive.sessions.create', ['sub_category_id' => $subCategory->id])); ?>"
                                class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Session
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Instructor</th>
                                            <th>Status</th>
                                            <th>Scheduled</th>
                                            <th>Viewers</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $subCategory->fitLiveSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($session->title); ?></td>
                                                <td><?php echo e(optional($session->instructor)->name); ?></td>
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

                                                        <?php default: ?>
                                                            <span class="badge bg-light text-dark">Unknown</span>
                                                    <?php endswitch; ?>
                                                </td>
                                                <td>
                                                    <?php echo e($session->scheduled_at?->format('M d, Y g:i A') ?? 'Not scheduled'); ?>

                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?php echo e($session->viewer_peak ?? 0); ?></span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="<?php echo e(route('admin.fitlive.sessions.show', $session)); ?>"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?php echo e(route('admin.fitlive.sessions.edit', $session)); ?>"
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
        <!-- /Sessions Table -->
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitlive/subcategories/show.blade.php ENDPATH**/ ?>