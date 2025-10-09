

<?php $__env->startSection('title', 'Edit Single Video'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="dashboard-title">Edit Single Video</h1>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('admin.fitguide.single.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.fitguide.single.update', $fgSingle)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h5>Basic Information</h5>
                </div>
                <div class="content-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-select" name="fg_category_id" id="fg_category_id" required>
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e($fgSingle->fg_category_id == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Subcategory *</label>
                                <select class="form-select" name="fg_sub_category_id" id="fg_sub_category_id" required>
                                    <option value="">Select Subcategory</option>
                                    <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subcategory->id); ?>" <?php echo e($fgSingle->fg_sub_category_id == $subcategory->id ? 'selected' : ''); ?>>
                                            <?php echo e($subcategory->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" class="form-control" name="title" value="<?php echo e($fgSingle->title); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <textarea class="form-control" name="description" rows="4" required><?php echo e($fgSingle->description); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Language *</label>
                                <input type="text" class="form-control" name="language" value="<?php echo e($fgSingle->language); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Release Date *</label>
                                <input type="date" class="form-control" name="release_date" value="<?php echo e($fgSingle->release_date->format('Y-m-d')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Duration (Minutes)</label>
                                <input type="number" class="form-control" name="duration_minutes" value="<?php echo e($fgSingle->duration_minutes); ?>" min="1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Cost</label>
                                <input type="number" class="form-control" name="cost" value="<?php echo e($fgSingle->cost); ?>" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h5>Video Content</h5>
                </div>
                <div class="content-card-body">
                    <div class="mb-3">
                        <label class="form-label">Video Type *</label>
                        <select class="form-select" name="video_type" id="video_type" required>
                            <option value="">Select Type</option>
                            <option value="youtube" <?php echo e($fgSingle->video_type == 'youtube' ? 'selected' : ''); ?>>YouTube</option>
                            <option value="s3" <?php echo e($fgSingle->video_type == 's3' ? 'selected' : ''); ?>>S3 URL</option>
                            <option value="upload" <?php echo e($fgSingle->video_type == 'upload' ? 'selected' : ''); ?>>Upload</option>
                        </select>
                    </div>

                    <div id="video_url_section" style="display: <?php echo e(in_array($fgSingle->video_type, ['youtube', 's3']) ? 'block' : 'none'); ?>;">
                        <div class="mb-3">
                            <label class="form-label">Video URL</label>
                            <input type="url" class="form-control" name="video_url" value="<?php echo e($fgSingle->video_url); ?>">
                        </div>
                    </div>

                    <div id="video_upload_section" style="display: <?php echo e($fgSingle->video_type == 'upload' ? 'block' : 'none'); ?>;">
                        <div class="mb-3">
                            <label class="form-label">Upload Video</label>
                            <input type="file" class="form-control" name="video_file_path" accept="video/*">
                            <small class="form-text text-muted">Max size: 500MB</small>
                            <?php if($fgSingle->video_file_path): ?>
                                <p class="mt-2 text-muted">Current file: <?php echo e(basename($fgSingle->video_file_path)); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-card mb-4">
                <div class="content-card-header">
                    <h5>Settings</h5>
                </div>
                <div class="content-card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" <?php echo e($fgSingle->is_published ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_published">Published</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Single Video</button>
                <a href="<?php echo e(route('admin.fitguide.single.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoTypeSelect = document.getElementById('video_type');
    
    // Show/hide video sections based on type
    videoTypeSelect.addEventListener('change', function() {
        const urlSection = document.getElementById('video_url_section');
        const uploadSection = document.getElementById('video_upload_section');
        
        urlSection.style.display = 'none';
        uploadSection.style.display = 'none';
        
        if (this.value === 'youtube' || this.value === 's3') {
            urlSection.style.display = 'block';
        } else if (this.value === 'upload') {
            uploadSection.style.display = 'block';
        }
    });
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitguide/single/edit.blade.php ENDPATH**/ ?>