

<?php $__env->startSection('title', 'Edit Single Video'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-edit me-3"></i>Edit Single Video
                </h1>
                <p class="page-subtitle">Update your single video content</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?php echo e(route('admin.fitdoc.single.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Single Videos
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="<?php echo e(route('admin.fitdoc.single.update', $fitDoc)); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <input type="hidden" name="type" value="single">
            
            <div class="card-body">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-8">
                        <!-- Basic Information -->
                        <div class="form-group mb-3">
                            <label for="title">Title *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="title" name="title" value="<?php echo e(old('title', $fitDoc->title)); ?>" required>
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="language">Language *</label>
                                    <select class="form-control <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="language" name="language" required>
                                        <option value="">Select Language</option>
                                        <option value="english" <?php echo e(old('language', $fitDoc->language) == 'english' ? 'selected' : ''); ?>>English</option>
                                        <option value="spanish" <?php echo e(old('language', $fitDoc->language) == 'spanish' ? 'selected' : ''); ?>>Spanish</option>
                                        <option value="french" <?php echo e(old('language', $fitDoc->language) == 'french' ? 'selected' : ''); ?>>French</option>
                                        <option value="hindi" <?php echo e(old('language', $fitDoc->language) == 'hindi' ? 'selected' : ''); ?>>Hindi</option>
                                    </select>
                                    <?php $__errorArgs = ['language'];
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
                                <div class="form-group mb-3">
                                    <label for="cost">Cost ($)</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="cost" name="cost" value="<?php echo e(old('cost', $fitDoc->cost)); ?>" min="0" step="0.01">
                                    <?php $__errorArgs = ['cost'];
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

                        <div class="form-group mb-3">
                            <label for="description">Description *</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="description" name="description" rows="4" required><?php echo e(old('description', $fitDoc->description)); ?></textarea>
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="release_date">Release Date *</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['release_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="release_date" name="release_date" value="<?php echo e(old('release_date', $fitDoc->release_date ? $fitDoc->release_date->format('Y-m-d') : '')); ?>" required>
                                    <?php $__errorArgs = ['release_date'];
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
                                <div class="form-group mb-3">
                                    <label for="duration_minutes">Duration (minutes) *</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="duration_minutes" name="duration_minutes" value="<?php echo e(old('duration_minutes', $fitDoc->duration_minutes)); ?>" min="1" required>
                                    <?php $__errorArgs = ['duration_minutes'];
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

                        <!-- Main Video Section -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5>Main Video *</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="video_type">Video Source *</label>
                                            <select class="form-control <?php $__errorArgs = ['video_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                    id="video_type" name="video_type" required>
                                                <option value="">Select Source</option>
                                                <option value="youtube" <?php echo e(old('video_type', $fitDoc->video_type) == 'youtube' ? 'selected' : ''); ?>>YouTube</option>
                                                <option value="s3" <?php echo e(old('video_type', $fitDoc->video_type) == 's3' ? 'selected' : ''); ?>>S3 URL</option>
                                                <option value="upload" <?php echo e(old('video_type', $fitDoc->video_type) == 'upload' ? 'selected' : ''); ?>>Upload File</option>
                                            </select>
                                            <?php $__errorArgs = ['video_type'];
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
                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label id="video-input-label">Video URL/File</label>
                                            <input type="url" class="form-control <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="video_url" name="video_url" value="<?php echo e(old('video_url', $fitDoc->video_url)); ?>" 
                                                   placeholder="Enter video URL" style="display: none;">
                                            <input type="file" class="form-control <?php $__errorArgs = ['video_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="video_file" name="video_file" accept="video/*" style="display: none;">
                                            <?php if($fitDoc->video_file_path): ?>
                                                <div class="current-file">
                                                    <small class="text-muted">Current file: <?php echo e(basename($fitDoc->video_file_path)); ?></small>
                                                </div>
                                            <?php endif; ?>
                                            <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <?php $__errorArgs = ['video_file'];
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
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Current Banner -->
                        <?php if($fitDoc->banner_image_path): ?>
                            <div class="current-banner mb-3">
                                <label>Current Banner</label>
                                <div class="banner-preview">
                                    <img src="<?php echo e(asset('storage/app/public/' . $fitDoc->banner_image_path)); ?>" 
                                         alt="Current banner" class="img-fluid rounded">
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Banner Image -->
                        <div class="form-group mb-3">
                            <label for="banner_image">Banner Image</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="banner_image" name="banner_image" accept="image/*">
                            <small class="form-text text-muted">Max size: 2MB. Leave empty to keep current.</small>
                            <?php $__errorArgs = ['banner_image'];
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

                        <!-- Trailer -->
                        <div class="form-group mb-3">
                            <label for="trailer_type">Trailer (Optional)</label>
                            <select class="form-control <?php $__errorArgs = ['trailer_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="trailer_type" name="trailer_type">
                                <option value="">No Trailer</option>
                                <option value="youtube" <?php echo e(old('trailer_type', $fitDoc->trailer_type) == 'youtube' ? 'selected' : ''); ?>>YouTube</option>
                                <option value="s3" <?php echo e(old('trailer_type', $fitDoc->trailer_type) == 's3' ? 'selected' : ''); ?>>S3 URL</option>
                                <option value="upload" <?php echo e(old('trailer_type', $fitDoc->trailer_type) == 'upload' ? 'selected' : ''); ?>>Upload File</option>
                            </select>
                            <?php $__errorArgs = ['trailer_type'];
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

                        <div class="form-group mb-3" id="trailer-input-group" style="display: none;">
                            <input type="url" class="form-control <?php $__errorArgs = ['trailer_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="trailer_url" name="trailer_url" value="<?php echo e(old('trailer_url', $fitDoc->trailer_url)); ?>" 
                                   placeholder="Enter trailer URL" style="display: none;">
                            <input type="file" class="form-control <?php $__errorArgs = ['trailer_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="trailer_file" name="trailer_file" accept="video/*" style="display: none;">
                            <?php if($fitDoc->trailer_file_path): ?>
                                <div class="current-file">
                                    <small class="text-muted">Current trailer: <?php echo e(basename($fitDoc->trailer_file_path)); ?></small>
                                </div>
                            <?php endif; ?>
                            <?php $__errorArgs = ['trailer_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['trailer_file'];
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

                        <!-- Publish Status -->
                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_published" 
                                       name="is_published" value="1" <?php echo e(old('is_published', $fitDoc->is_published) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_published">
                                    Published
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Single Video
                </button>
                <a href="<?php echo e(route('admin.fitdoc.single.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoTypeSelect = document.getElementById('video_type');
    const trailerTypeSelect = document.getElementById('trailer_type');
    
    // Handle video type change
    function handleVideoTypeChange() {
        const videoUrl = document.getElementById('video_url');
        const videoFile = document.getElementById('video_file');
        const selectedType = videoTypeSelect.value;
        
        videoUrl.style.display = 'none';
        videoFile.style.display = 'none';
        videoUrl.required = false;
        videoFile.required = false;
        
        if (selectedType === 'youtube' || selectedType === 's3') {
            videoUrl.style.display = 'block';
            videoUrl.required = true;
        } else if (selectedType === 'upload') {
            videoFile.style.display = 'block';
        }
    }
    
    // Handle trailer type change
    function handleTrailerTypeChange() {
        const trailerUrl = document.getElementById('trailer_url');
        const trailerFile = document.getElementById('trailer_file');
        const trailerInputGroup = document.getElementById('trailer-input-group');
        const selectedType = trailerTypeSelect.value;
        
        trailerInputGroup.style.display = 'none';
        trailerUrl.style.display = 'none';
        trailerFile.style.display = 'none';
        trailerUrl.required = false;
        trailerFile.required = false;
        
        if (selectedType === 'youtube' || selectedType === 's3') {
            trailerInputGroup.style.display = 'block';
            trailerUrl.style.display = 'block';
        } else if (selectedType === 'upload') {
            trailerInputGroup.style.display = 'block';
            trailerFile.style.display = 'block';
        }
    }
    
    // Event listeners
    videoTypeSelect.addEventListener('change', handleVideoTypeChange);
    trailerTypeSelect.addEventListener('change', handleTrailerTypeChange);
    
    // Initialize on page load
    handleVideoTypeChange();
    handleTrailerTypeChange();
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.banner-preview img {
    max-height: 200px;
    object-fit: cover;
}

.current-file {
    margin-top: 0.5rem;
    padding: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/admin/fitdoc/single/edit.blade.php ENDPATH**/ ?>