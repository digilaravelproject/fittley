

<?php $__env->startSection('title', 'Create Single Video'); ?>

<?php $__env->startSection('content'); ?>
<div class="single-create">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-video me-3"></i>Create Single Video
                </h1>
                <p class="page-subtitle">Create a new educational video</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="<?php echo e(route('admin.fitguide.single.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Singles
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="<?php echo e(route('admin.fitguide.single.store')); ?>" enctype="multipart/form-data" id="singleForm">
        <?php echo csrf_field(); ?>
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-info-circle me-2"></i>Basic Information
                        </h3>
                    </div>
                    <div class="content-card-body">
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

                        <div class="row">
                            <div class="col-md-8">
                                <label for="title" class="form-label required">Title</label>
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
                                       placeholder="Enter video title"
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
                            <div class="col-md-4">
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
                                       placeholder="video-slug">
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
                                <div class="form-text">Leave empty to auto-generate from title</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label required">Description</label>
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
                                      placeholder="Enter video description"
                                      required><?php echo e(old('description')); ?></textarea>
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
                    </div>
                </div>

                <!-- Video Content -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-video me-2"></i>Video Content
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <div class="mb-3">
                            <label for="video_type" class="form-label required">Video Type</label>
                            <select class="form-select <?php $__errorArgs = ['video_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="video_type" 
                                    name="video_type" 
                                    required>
                                <option value="">Select Video Type</option>
                                <option value="youtube" <?php echo e(old('video_type') == 'youtube' ? 'selected' : ''); ?>>YouTube</option>
                                <option value="s3" <?php echo e(old('video_type') == 's3' ? 'selected' : ''); ?>>S3 URL</option>
                                <option value="upload" <?php echo e(old('video_type') == 'upload' ? 'selected' : ''); ?>>Upload</option>
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

                        <div id="video_url_section" class="mb-3" style="display: none;">
                            <label for="video_url" class="form-label required">Video URL</label>
                            <input type="url" 
                                   class="form-control <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="video_url" 
                                   name="video_url" 
                                   value="<?php echo e(old('video_url')); ?>" 
                                   placeholder="Enter video URL">
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
                            <div class="form-text" id="video_url_help">
                                For YouTube: Use full YouTube URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)
                            </div>
                        </div>

                        <div id="video_upload_section" class="mb-3" style="display: none;">
                            <label for="video_file_path" class="form-label required">Upload Video File</label>
                            <input type="file" 
                                   class="form-control <?php $__errorArgs = ['video_file_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="video_file_path" 
                                   name="video_file_path" 
                                   accept="video/*">
                            <?php $__errorArgs = ['video_file_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">
                                Accepted formats: MP4, MOV, AVI, WMV, FLV, WebM. Max size: 500MB
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Assets -->
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h3 class="content-card-title">
                            <i class="fas fa-image me-2"></i>Media Assets
                        </h3>
                    </div>
                    <div class="content-card-body">
                        <!-- Banner Image -->
                        <div class="mb-4">
                            <label for="banner_image_path" class="form-label">Video Banner</label>
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
                            <h5>Video Trailer (Optional)</h5>
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
                                <label for="language" class="form-label required">Language</label>
                                <select class="form-select <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="language" 
                                        name="language"
                                        required>
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
                            <label for="release_date" class="form-label required">Release Date</label>
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
                                   value="<?php echo e(old('release_date')); ?>"
                                   required>
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
                            <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['duration_minutes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="duration_minutes" 
                                   name="duration_minutes" 
                                   value="<?php echo e(old('duration_minutes')); ?>" 
                                   min="1"
                                   placeholder="e.g., 30">
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
                            <div class="form-text">Rate this video from 0 to 5 (optional)</div>
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
                        <div class="form-text">Publish this video immediately</div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="content-card">
                    <div class="content-card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Single Video
                            </button>
                            <a href="<?php echo e(route('admin.fitguide.single.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('fg_category_id');
    const subcategorySelect = document.getElementById('fg_sub_category_id');
    const videoTypeSelect = document.getElementById('video_type');
    const trailerTypeSelect = document.getElementById('trailer_type');
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    // Auto-generate slug from title
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.dataset.autoGenerated) {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.autoGenerated = 'true';
        }
    });

    slugInput.addEventListener('input', function() {
        delete this.dataset.autoGenerated;
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

    // Show/hide video sections based on type
    function toggleVideoSections() {
        const videoUrlSection = document.getElementById('video_url_section');
        const videoUploadSection = document.getElementById('video_upload_section');
        const videoUrlInput = document.getElementById('video_url');
        const videoFileInput = document.getElementById('video_file_path');
        const videoUrlHelp = document.getElementById('video_url_help');
        const selectedType = videoTypeSelect.value;
        
        // Hide all sections first
        videoUrlSection.style.display = 'none';
        videoUploadSection.style.display = 'none';
        
        // Remove required attributes
        videoUrlInput.removeAttribute('required');
        videoFileInput.removeAttribute('required');
        
        // Show relevant section and set required
        if (selectedType === 'youtube' || selectedType === 's3') {
            videoUrlSection.style.display = 'block';
            videoUrlInput.setAttribute('required', 'required');
            
            if (selectedType === 'youtube') {
                videoUrlHelp.textContent = 'For YouTube: Use full YouTube URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)';
            } else {
                videoUrlHelp.textContent = 'Enter the direct S3 URL to your video file';
            }
        } else if (selectedType === 'upload') {
            videoUploadSection.style.display = 'block';
            videoFileInput.setAttribute('required', 'required');
        }
    }

    // Show/hide trailer sections based on type
    function toggleTrailerSections() {
        const trailerUrlSection = document.getElementById('trailer_url_section');
        const trailerUploadSection = document.getElementById('trailer_upload_section');
        const selectedType = trailerTypeSelect.value;
        
        // Hide all sections first
        trailerUrlSection.style.display = 'none';
        trailerUploadSection.style.display = 'none';
        
        // Show relevant section
        if (selectedType === 'youtube' || selectedType === 's3') {
            trailerUrlSection.style.display = 'block';
        } else if (selectedType === 'upload') {
            trailerUploadSection.style.display = 'block';
        }
    }

    // Initialize sections
    toggleVideoSections();
    toggleTrailerSections();
    
    // Handle video type changes
    videoTypeSelect.addEventListener('change', toggleVideoSections);
    trailerTypeSelect.addEventListener('change', toggleTrailerSections);

    // Form validation
    document.getElementById('singleForm').addEventListener('submit', function(e) {
        const videoType = videoTypeSelect.value;
        
        if (!videoType) {
            e.preventDefault();
            alert('Please select a video type.');
            return false;
        }
        
        if ((videoType === 'youtube' || videoType === 's3') && !document.getElementById('video_url').value.trim()) {
            e.preventDefault();
            alert('Please enter a video URL.');
            return false;
        }
        
        if (videoType === 'upload' && !document.getElementById('video_file_path').files.length) {
            e.preventDefault();
            alert('Please select a video file to upload.');
            return false;
        }
    });
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitguide/single/create.blade.php ENDPATH**/ ?>