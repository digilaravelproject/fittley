

<?php $__env->startSection('title', 'Edit FitNews Stream'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit FitNews Stream</h3>
                    <a href="<?php echo e(route('admin.fitnews.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.fitnews.update', $fitNews)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Stream Title *</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="title" name="title" value="<?php echo e(old('title', $fitNews->title)); ?>" required>
                                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                              id="description" name="description" rows="4"><?php echo e(old('description', $fitNews->description)); ?></textarea>
                                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                    <?php if($fitNews->thumbnail): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(asset('storage/app/public/' . $fitNews->thumbnail)); ?>" 
                                                 alt="Current thumbnail" class="img-thumbnail" style="max-height: 100px;">
                                            <small class="text-muted d-block">Current thumbnail</small>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="thumbnail" name="thumbnail" accept="image/*">
                                    <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">Upload a new thumbnail image (JPEG, PNG, JPG, GIF - Max: 2MB)</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="status" name="status" required>
                                        <option value="draft" <?php echo e(old('status', $fitNews->status) === 'draft' ? 'selected' : ''); ?>>Draft</option>
                                        <option value="scheduled" <?php echo e(old('status', $fitNews->status) === 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                                        <option value="live" <?php echo e(old('status', $fitNews->status) === 'live' ? 'selected' : ''); ?>>Live</option>
                                        <option value="ended" <?php echo e(old('status', $fitNews->status) === 'ended' ? 'selected' : ''); ?>>Ended</option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3" id="scheduled-time-group" style="display: none;">
                                    <label for="scheduled_at" class="form-label">Scheduled Time</label>
                                    <input type="datetime-local" class="form-control <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="scheduled_at" name="scheduled_at" 
                                           value="<?php echo e(old('scheduled_at', $fitNews->scheduled_at ? $fitNews->scheduled_at->format('Y-m-d\TH:i') : '')); ?>">
                                    <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="recording_enabled" 
                                               name="recording_enabled" value="1" 
                                               <?php echo e(old('recording_enabled', $fitNews->recording_enabled) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="recording_enabled">
                                            Enable Recording
                                        </label>
                                    </div>
                                    <div class="form-text">Record this stream for later viewing</div>
                                </div>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Stream Info</h6>
                                        <ul class="list-unstyled mb-0">
                                            <li><small><strong>Channel:</strong> <?php echo e($fitNews->channel_name); ?></small></li>
                                            <li><small><strong>Viewers:</strong> <?php echo e($fitNews->viewer_count); ?></small></li>
                                            <?php if($fitNews->started_at): ?>
                                                <li><small><strong>Started:</strong> <?php echo e($fitNews->started_at->format('M d, Y H:i')); ?></small></li>
                                            <?php endif; ?>
                                            <?php if($fitNews->ended_at): ?>
                                                <li><small><strong>Ended:</strong> <?php echo e($fitNews->ended_at->format('M d, Y H:i')); ?></small></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Stream
                                    </button>
                                    <?php if($fitNews->status === 'draft' || $fitNews->status === 'scheduled'): ?>
                                        <a href="<?php echo e(route('admin.fitnews.stream', $fitNews)); ?>" class="btn btn-success">
                                            <i class="fas fa-video"></i> Go to Stream
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('admin.fitnews.index')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const scheduledGroup = document.getElementById('scheduled-time-group');
    
    function toggleScheduledTime() {
        if (statusSelect.value === 'scheduled') {
            scheduledGroup.style.display = 'block';
            document.getElementById('scheduled_at').required = true;
        } else {
            scheduledGroup.style.display = 'none';
            document.getElementById('scheduled_at').required = false;
        }
    }
    
    statusSelect.addEventListener('change', toggleScheduledTime);
    toggleScheduledTime(); // Initial check
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitnews/edit.blade.php ENDPATH**/ ?>