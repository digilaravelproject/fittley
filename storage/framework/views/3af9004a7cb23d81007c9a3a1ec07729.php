

<?php $__env->startSection('title', 'BMR Calculator'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Page header (same style as tools index) -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-title mb-1">
                    <i class="fas fa-fire me-2 text-warning"></i>
                    Calories Consumed
                </h1>
                <p class="page-subtitle text-dark text-white">
                    Coming Soon
                </p>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('tools.index')); ?>" class="btn btn-sm btn-outline-light">
                    ← Back to Tools
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fittley\resources\views/tools/calories.blade.php ENDPATH**/ ?>