<?php $__env->startSection('title', 'User Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="user-dashboard fade-in-up">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-user-circle me-3"></i>
                    Welcome back, <?php echo e(auth()->user()->name); ?>!
                </h1>
                <p class="page-subtitle">Your learning dashboard and progress overview</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?php echo e(route('fitlive.index')); ?>" class="btn btn-primary">
                    <i class="fas fa-broadcast-tower me-2"></i>
                    Browse Live Sessions
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stats-grid mb-5">
        <div class="row g-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-primary">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Sessions Watched</div>
                            <div class="stat-trend">
                                <i class="fas fa-clock"></i>
                                <span>This month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-success">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Favorites</div>
                            <div class="stat-trend">
                                <i class="fas fa-bookmark"></i>
                                <span>Saved content</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-info">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Achievements</div>
                            <div class="stat-trend">
                                <i class="fas fa-medal"></i>
                                <span>Unlocked</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-warning">
                    <div class="stat-card-body">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo e(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse(auth()->user()->created_at))); ?></div>
                            <div class="stat-label">Days Active</div>
                            <div class="stat-trend">
                                <i class="fas fa-user-clock"></i>
                                <span>Member since <?php echo e(auth()->user()->created_at->format('M Y')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Recent Activity -->
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h3 class="content-card-title">
                        <i class="fas fa-history me-2"></i>
                        Recent Activity
                    </h3>
                    <p class="content-card-subtitle">Your latest interactions and progress</p>
                </div>
                <div class="content-card-body">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>No Activity Yet</h3>
                        <p>Start watching sessions to see your activity here!</p>
                        <a href="<?php echo e(route('fitlive.index')); ?>" class="btn btn-primary">
                            <i class="fas fa-play me-2"></i>
                            Start Watching
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h3 class="content-card-title">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h3>
                </div>
                <div class="content-card-body">
                    <div class="d-grid gap-3">
                        <a href="<?php echo e(route('fitlive.index')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-broadcast-tower me-2"></i>
                            Browse Live Sessions
                        </a>
                        <a href="<?php echo e(route('fitnews.index')); ?>" class="btn btn-outline-success">
                            <i class="fas fa-newspaper me-2"></i>
                            Read Fitness News
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="fas fa-user-edit me-2"></i>
                            Update Profile
                        </a>
                        <a href="#" class="btn btn-outline-warning">
                            <i class="fas fa-cog me-2"></i>
                            Account Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Account Info -->
            <div class="content-card">
                <div class="content-card-header">
                    <h3 class="content-card-title">
                        <i class="fas fa-user me-2"></i>
                        Account Info
                    </h3>
                </div>
                <div class="content-card-body">
                    <div class="user-info mb-3">
                        <div class="user-avatar">
                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                        </div>
                        <div class="user-details">
                            <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
                            <div class="user-id"><?php echo e(auth()->user()->email); ?></div>
                        </div>
                    </div>
                    <div class="role-badges">
                        <?php $__currentLoopData = auth()->user()->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="role-badge role-<?php echo e($role->name); ?>">
                                <?php if($role->name === 'admin'): ?>
                                    <i class="fas fa-crown"></i>
                                <?php elseif($role->name === 'instructor'): ?>
                                    <i class="fas fa-chalkboard-teacher"></i>
                                <?php else: ?>
                                    <i class="fas fa-user"></i>
                                <?php endif; ?>
                                <?php echo e(ucfirst($role->name)); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-calendar"></i>
                            Joined <?php echo e(auth()->user()->created_at->format('M d, Y')); ?>

                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Digi_Laravel_Prrojects\Fittelly_github\fittley\resources\views/user/dashboard.blade.php ENDPATH**/ ?>