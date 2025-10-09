

<?php $__env->startSection('content'); ?>
<div class="series-create">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-video me-3"></i>Create Series
                </h1>
                <p class="page-subtitle">Create a new educational video series</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?php echo e(route('admin.fitguide.series.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Series
                </a>
            </div>
        </div>
    </div>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            Please correct the following errors:
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" action="<?php echo e(route('admin.fitguide.series.store')); ?>" enctype="multipart/form-data" id="seriesForm">
        <?php echo csrf_field(); ?>
        
        <div class="row">
            <!-- Main Content Section -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-info-circle me-2"></i>Series Information
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="mb-4">
                            <label for="title" class="form-label required">Series Title</label>
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
                                   placeholder="Enter series title"
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

                        <div class="mb-4">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="slug" 
                                   name="slug" 
                                   value="<?php echo e(old('slug')); ?>" 
                                   placeholder="series-slug">
                            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">URL-friendly version (auto-generated if left empty)</div>
                        </div>

                        <div class="mb-4">
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
                                      rows="5" 
                                      placeholder="Enter series description"><?php echo e(old('description')); ?></textarea>
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
                                <label for="fg_category_id" class="form-label required">Category</label>
                                <select class="form-select <?php $__errorArgs = ['fg_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="fg_category_id" 
                                        name="fg_category_id" 
                                        required>
                                    <option value="">Select Category</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php echo e(old('fg_category_id') == $category->id ? 'selected' : ''); ?>>
                                            <?php echo e($category->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['fg_category_id'];
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
                            <div class="col-md-6">
                                <label for="fg_sub_category_id" class="form-label">Subcategory</label>
                                <select class="form-select <?php $__errorArgs = ['fg_sub_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="fg_sub_category_id" 
                                        name="fg_sub_category_id">
                                    <option value="">Select Subcategory</option>
                                </select>
                                <?php $__errorArgs = ['fg_sub_category_id'];
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

                <!-- Trailer & Banner -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-image me-2"></i>Media Assets
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <!-- Banner Image -->
                        <div class="mb-4">
                            <label for="banner_image_path" class="form-label">Series Banner</label>
                            <input type="file" 
                                   class="form-control <?php $__errorArgs = ['banner_image_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="banner_image_path" 
                                   name="banner_image_path" 
                                   accept="image/*">
                            <?php $__errorArgs = ['banner_image_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">Recommended size: 1920x1080px. Max size: 2MB</div>
                        </div>

                        <!-- Trailer Section -->
                        <div class="trailer-section">
                            <h5>Series Trailer (Optional)</h5>
                            <div class="mb-3">
                                <label for="trailer_type" class="form-label">Trailer Type</label>
                                <select class="form-select <?php $__errorArgs = ['trailer_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="trailer_type" 
                                        name="trailer_type">
                                    <option value="">No Trailer</option>
                                    <option value="youtube" <?php echo e(old('trailer_type') == 'youtube' ? 'selected' : ''); ?>>YouTube</option>
                                    <option value="s3" <?php echo e(old('trailer_type') == 's3' ? 'selected' : ''); ?>>S3 URL</option>
                                    <option value="upload" <?php echo e(old('trailer_type') == 'upload' ? 'selected' : ''); ?>>Upload</option>
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

                            <div id="trailer_url_section" class="mb-3" style="display: none;">
                                <label for="trailer_url" class="form-label">Trailer URL</label>
                                <input type="url" 
                                       class="form-control <?php $__errorArgs = ['trailer_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="trailer_url" 
                                       name="trailer_url" 
                                       value="<?php echo e(old('trailer_url')); ?>" 
                                       placeholder="Enter trailer URL">
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
                            </div>

                            <div id="trailer_upload_section" class="mb-3" style="display: none;">
                                <label for="trailer_file_path" class="form-label">Upload Trailer File</label>
                                <input type="file" 
                                       class="form-control <?php $__errorArgs = ['trailer_file_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="trailer_file_path" 
                                       name="trailer_file_path" 
                                       accept="video/*">
                                <?php $__errorArgs = ['trailer_file_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Max size: 100MB</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Episodes Section -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="content-card-title">
                                <i class="fas fa-list me-2"></i>Episodes
                            </h3>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="addEpisodeBtn">
                                <i class="fas fa-plus me-1"></i>Add Episode
                            </button>
                        </div>
                    </div>
                    <div class="content-card-body">
                        <div id="episodes-container">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                You can add episodes now or create the series first and add episodes later.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Settings -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-cog me-2"></i>Settings
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="language" class="form-label">Language</label>
                                <select class="form-select <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="language" 
                                        name="language">
                                    <option value="english" <?php echo e(old('language', 'english') == 'english' ? 'selected' : ''); ?>>English</option>
                                    <option value="spanish" <?php echo e(old('language') == 'spanish' ? 'selected' : ''); ?>>Spanish</option>
                                    <option value="french" <?php echo e(old('language') == 'french' ? 'selected' : ''); ?>>French</option>
                                    <option value="german" <?php echo e(old('language') == 'german' ? 'selected' : ''); ?>>German</option>
                                    <option value="other" <?php echo e(old('language') == 'other' ? 'selected' : ''); ?>>Other</option>
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
                            <div class="col-md-6">
                                <label for="cost" class="form-label">Cost ($)</label>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="cost" 
                                       name="cost" 
                                       value="<?php echo e(old('cost', 0)); ?>" 
                                       min="0" 
                                       step="0.01">
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

                        <div class="mb-3">
                            <label for="total_episodes" class="form-label">Total Episodes</label>
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['total_episodes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="total_episodes" 
                                   name="total_episodes" 
                                   value="<?php echo e(old('total_episodes', 1)); ?>" 
                                   min="1">
                            <?php $__errorArgs = ['total_episodes'];
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
                            <label for="release_date" class="form-label">Release Date</label>
                            <input type="date" 
                                   class="form-control <?php $__errorArgs = ['release_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="release_date" 
                                   name="release_date" 
                                   value="<?php echo e(old('release_date')); ?>">
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

                        <div class="mb-3">
                            <label for="feedback" class="form-label">Rating</label>
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['feedback'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="feedback" 
                                   name="feedback" 
                                   value="<?php echo e(old('feedback')); ?>" 
                                   min="0" 
                                   max="5" 
                                   step="0.1"
                                   placeholder="0.0">
                            <?php $__errorArgs = ['feedback'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">Rate this series from 0 to 5 (optional)</div>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1"
                                   <?php echo e(old('is_published') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="is_published">
                                Published
                            </label>
                        </div>
                        <div class="form-text">Publish this series immediately</div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="content-card">
                    <div class="content-card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Series
                            </button>
                            <a href="<?php echo e(route('admin.fitguide.series.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Episode Template -->
<template id="episode-template">
    <div class="episode-item mb-4 p-3 border rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Episode <span class="episode-number">1</span></h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-episode">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Episode Title</label>
                    <input type="text" class="form-control episode-title" name="episodes[0][title]" placeholder="Episode title" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Episode Number</label>
                    <input type="number" class="form-control episode-num" name="episodes[0][episode_number]" min="1" required>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control episode-description" name="episodes[0][description]" rows="2" placeholder="Episode description"></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Video Type</label>
                    <select class="form-select episode-video-type" name="episodes[0][video_type]" required>
                        <option value="">Select Type</option>
                        <option value="youtube">YouTube</option>
                        <option value="s3">S3 URL</option>
                        <option value="upload">Upload</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Duration (Minutes)</label>
                    <input type="number" class="form-control episode-duration" name="episodes[0][duration_minutes]" min="1">
                </div>
            </div>
        </div>
        
        <div class="episode-url-section mb-3" style="display: none;">
            <label class="form-label">Video URL</label>
            <input type="url" class="form-control episode-url" name="episodes[0][video_url]" placeholder="Enter video URL">
        </div>
        
        <div class="episode-upload-section mb-3" style="display: none;">
            <label class="form-label">Upload Video File</label>
            <input type="file" class="form-control episode-file" name="episodes[0][video_file_path]" accept="video/*">
            <div class="form-text">Max size: 500MB</div>
        </div>
        
        <div class="form-check">
            <input class="form-check-input episode-published" type="checkbox" name="episodes[0][is_published]" value="1">
            <label class="form-check-label">Published</label>
        </div>
    </div>
</template>

<style>
.series-create {
    animation: fadeInUp 0.6s ease-out;
}

.form-label.required::after {
    content: ' *';
    color: var(--danger-color);
}

.trailer-section {
    border-top: 1px solid var(--border-primary);
    padding-top: 1rem;
    margin-top: 1rem;
}

.episode-item {
    background: var(--bg-light);
    border: 1px solid var(--border-primary) !important;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const categorySelect = document.getElementById('fg_category_id');
    const subcategorySelect = document.getElementById('fg_sub_category_id');
    const trailerTypeSelect = document.getElementById('trailer_type');
    const addEpisodeBtn = document.getElementById('addEpisodeBtn');
    const episodesContainer = document.getElementById('episodes-container');
    let episodeCount = 0;
    
    // Auto-generate slug from title
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated !== 'false') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });
    
    // Mark slug as manually edited
    slugInput.addEventListener('input', function() {
        this.dataset.autoGenerated = 'false';
    });
    
    // Load subcategories when category changes
    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
        
        if (categoryId) {
            fetch(`/admin/fitguide/categories/${categoryId}/subcategories`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subcategorySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading subcategories:', error);
                });
        }
    });
    
    // Show/hide trailer sections based on type
    trailerTypeSelect.addEventListener('change', function() {
        const trailerUrlSection = document.getElementById('trailer_url_section');
        const trailerUploadSection = document.getElementById('trailer_upload_section');
        
        trailerUrlSection.style.display = 'none';
        trailerUploadSection.style.display = 'none';
        
        if (this.value === 'youtube' || this.value === 's3') {
            trailerUrlSection.style.display = 'block';
        } else if (this.value === 'upload') {
            trailerUploadSection.style.display = 'block';
        }
    });
    
    // Add episode functionality
    addEpisodeBtn.addEventListener('click', function() {
        const template = document.getElementById('episode-template');
        const clone = template.content.cloneNode(true);
        
        // Update episode number display
        clone.querySelector('.episode-number').textContent = episodeCount + 1;
        
        // Update all name attributes with correct index
        const inputs = clone.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace('[0]', `[${episodeCount}]`));
            }
        });
        
        // Set episode number value
        clone.querySelector('.episode-num').value = episodeCount + 1;
        
        // Add event listeners for this episode
        const episodeItem = clone.querySelector('.episode-item');
        setupEpisodeEventListeners(episodeItem);
        
        episodesContainer.appendChild(clone);
        episodeCount++;
    });
    
    // Setup event listeners for episode items
    function setupEpisodeEventListeners(episodeItem) {
        const videoTypeSelect = episodeItem.querySelector('.episode-video-type');
        const urlSection = episodeItem.querySelector('.episode-url-section');
        const uploadSection = episodeItem.querySelector('.episode-upload-section');
        const removeBtn = episodeItem.querySelector('.remove-episode');
        
        // Video type change
        videoTypeSelect.addEventListener('change', function() {
            urlSection.style.display = 'none';
            uploadSection.style.display = 'none';
            
            if (this.value === 'youtube' || this.value === 's3') {
                urlSection.style.display = 'block';
            } else if (this.value === 'upload') {
                uploadSection.style.display = 'block';
            }
        });
        
        // Remove episode
        removeBtn.addEventListener('click', function() {
            episodeItem.remove();
        });
    }
    
    // Initialize trailer sections
    if (trailerTypeSelect.value) {
        trailerTypeSelect.dispatchEvent(new Event('change'));
    }
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitguide/series/create.blade.php ENDPATH**/ ?>