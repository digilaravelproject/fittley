

<?php $__env->startSection('title', 'Show FitFlix Short'); ?>

<?php $__env->startSection('content'); ?>

<style>
  .fitarena_status{
    color: #fff;
  }
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">Show FitFlix Short</h1>
            </div>
            <div>
                <a href="<?php echo e(route('admin.community.fitflix-shorts.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Shorts
                </a>
            </div>
        </div>
    </div>

    <!-- Details -->
    <div class="row">
        <div class="col-lg-8">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="mb-0">Short Details</h5>
                </div>
                <div class="content-card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <p class="form-control-plaintext fitarena_status"><?php echo e($fitflix_short->title); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <p class="form-control-plaintext fitarena_status">
                                    <?php echo e($fitflix_short->category->name ?? '—'); ?>

                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <p class="form-control-plaintext fitarena_status">
                            <?php echo e($fitflix_short->description ?? 'No description provided'); ?>

                        </p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Video File</label>
                                <?php if($fitflix_short->video_path): ?>
                                    <p class="mt-2">Current: <a href="<?php echo e(Storage::url($fitflix_short->video_path)); ?>" target="_blank">View Video</a></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Thumbnail</label>
                                <?php if($fitflix_short->thumbnail_path): ?>
                                    <p class="mt-2">
                                        <img src="<?php echo e(Storage::url($fitflix_short->thumbnail_path)); ?>" alt="Thumbnail" width="120">
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.community.fitflix-shorts.index')); ?>" class="btn btn-outline-secondary">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="content-card">
                <div class="content-card-header">
                    <h5 class="mb-0">Uploader Info</h5>
                </div>
                <div class="content-card-body">
                    <p><strong>Uploaded by:</strong> <?php echo e($fitflix_short->uploader->name ?? 'Unknown'); ?></p>
                    <p><strong>Uploaded at:</strong> <?php echo e($fitflix_short->created_at->format('d M Y, h:i A')); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/community/fitflix-shorts/show.blade.php ENDPATH**/ ?>