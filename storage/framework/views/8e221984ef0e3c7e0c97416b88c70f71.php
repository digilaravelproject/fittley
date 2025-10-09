

<?php $__env->startSection('title', 'Create FitNews Stream'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-newspaper page-title-icon"></i>
                    Create FitNews Stream
                </h1>
                <p class="page-subtitle">Create a new live news stream for your fitness platform</p>
            </div>
            <div class="page-actions">
                <a href="<?php echo e(route('admin.fitnews.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Streams
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-grid">
        <div class="content-main">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle me-2"></i>Stream Details
                    </h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.fitnews.store')); ?>" method="POST" enctype="multipart/form-data" class="form-modern">
                        <?php echo csrf_field(); ?>
                        
                        <div class="form-section">
                            <div class="form-section-title">Basic Information</div>
                            
                            <div class="form-group">
                                <label for="title" class="form-label">Stream Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="title" 
                                       name="title" 
                                       value="<?php echo e(old('title')); ?>" 
                                       placeholder="Enter stream title..."
                                       required>
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

                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="description" 
                                          name="description" 
                                          rows="4"
                                          placeholder="Describe your news stream..."><?php echo e(old('description')); ?></textarea>
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

                            <div class="form-group">
                                <label for="thumbnail" class="form-label">Thumbnail Image</label>
                                <input type="file" 
                                       class="form-control <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="thumbnail" 
                                       name="thumbnail" 
                                       accept="image/*">
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
                                <div class="form-text">Upload a thumbnail image (JPEG, PNG, JPG, GIF - Max: 2MB)</div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="form-section-title">Stream Settings</div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                id="status" 
                                                name="status" 
                                                required>
                                            <option value="draft" <?php echo e(old('status') === 'draft' ? 'selected' : ''); ?>>Draft</option>
                                            <option value="scheduled" <?php echo e(old('status') === 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                                            <option value="live" <?php echo e(old('status') === 'live' ? 'selected' : ''); ?>>Go Live Now</option>
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
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" id="scheduled-time-group" style="display: none;">
                                        <label for="scheduled_at" class="form-label">Scheduled Time</label>
                                        <input type="datetime-local" 
                                               class="form-control <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="scheduled_at" 
                                               name="scheduled_at" 
                                               value="<?php echo e(old('scheduled_at')); ?>">
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
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check-custom">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="recording_enabled" 
                                           name="recording_enabled" 
                                           value="1" 
                                           <?php echo e(old('recording_enabled') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="recording_enabled">
                                        <strong>Enable Recording</strong>
                                        <span class="form-check-description">Record this stream for later viewing</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Stream
                            </button>
                            <a href="<?php echo e(route('admin.fitnews.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="content-sidebar">
            <div class="content-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Stream Information
                    </h4>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <i class="fas fa-broadcast-tower info-icon"></i>
                            <div class="info-content">
                                <div class="info-title">Channel</div>
                                <div class="info-description">Auto-generated unique channel name</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-video info-icon"></i>
                            <div class="info-content">
                                <div class="info-title">Streaming</div>
                                <div class="info-description">Agora RTC enabled for live streaming</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-users info-icon"></i>
                            <div class="info-content">
                                <div class="info-title">Viewers</div>
                                <div class="info-description">Real-time viewer count tracking</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-record-vinyl info-icon"></i>
                            <div class="info-content">
                                <div class="info-title">Recording</div>
                                <div class="info-description">Optional stream recording for replay</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-lightbulb me-2"></i>Tips for Success
                    </h4>
                </div>
                <div class="card-body">
                    <div class="tips-list">
                        <div class="tip-item">
                            <i class="fas fa-check-circle tip-icon"></i>
                            <span>Use engaging titles that describe your news content</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle tip-icon"></i>
                            <span>Upload high-quality thumbnails to attract viewers</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle tip-icon"></i>
                            <span>Schedule streams in advance for better attendance</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle tip-icon"></i>
                            <span>Enable recording to create content library</span>
                        </div>
                    </div>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitnews/create.blade.php ENDPATH**/ ?>