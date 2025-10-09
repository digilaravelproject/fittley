<?php $__env->startSection('title', 'Edit FitArena Event'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-sm-0 font-size-18">Edit Event</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.fitarena.index')); ?>">FitArena Events</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.fitarena.show', $event->id)); ?>"><?php echo e($event->title); ?></a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-white">
        <div class="card-header border-secondary">
            <h4 class="card-title text-white">Edit Event</h4>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.fitarena.update', $event->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <!-- Event Information -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Event Title *</label>
                            <input type="text" class="form-control bg-secondary text-white border-secondary" id="title" name="title" required
                                   placeholder="Enter event title" value="<?php echo e(old('title', $event->title)); ?>">
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Event Slug</label>
                            <input type="text" class="form-control bg-secondary text-white border-secondary" id="slug" name="slug" 
                                   placeholder="auto-generated-from-title" value="<?php echo e(old('slug', $event->slug)); ?>" readonly>
                            <small class="text-muted">This will be auto-generated from the title</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" id="description" name="description" rows="4" required
                                      placeholder="Describe your event..."><?php echo e(old('description', $event->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control bg-secondary text-white border-secondary" id="start_date" name="start_date" required
                                           value="<?php echo e(old('start_date', $event->start_date ? $event->start_date->format('Y-m-d') : '')); ?>">
                                    <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control bg-secondary text-white border-secondary" id="end_date" name="end_date"
                                           value="<?php echo e(old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '')); ?>">
                                    <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control bg-secondary text-white border-secondary" id="location" name="location"
                                   placeholder="Event location (e.g., Online, New York, etc.)" value="<?php echo e(old('location', $event->location)); ?>">
                            <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="instructor_id" class="form-label">Assign Instructor</label>
                            <select class="form-select bg-secondary text-white border-secondary" id="instructor_id" name="instructor_id">
                                <option value="">Select an instructor (optional)</option>
                                <?php $__currentLoopData = $instructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($instructor->id); ?>" <?php echo e(old('instructor_id', $currentInstructorId) == $instructor->id ? 'selected' : ''); ?>>
                                        <?php echo e($instructor->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-muted">Change instructor assignment for this event</small>
                            <?php $__errorArgs = ['instructor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="organizers" class="form-label">Organizers</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" id="organizers" name="organizers" rows="3"
                                      placeholder="Enter organizers, one per line: Name | Role"><?php echo e(old('organizers', $event->organizers ? implode("\n", array_map(fn($org) => $org['name'] . ' | ' . $org['role'], $event->organizers)) : '')); ?></textarea>
                            <small class="text-muted">Format: Name | Role (one per line)</small>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Current Banner Image -->
                        <?php if($event->banner_image): ?>
                            <div class="mb-3">
                                <label class="form-label">Current Banner Image</label>
                                <div class="border border-secondary rounded p-2">
                                    <img src="<?php echo e(Storage::url($event->banner_image)); ?>" alt="Banner" class="img-fluid rounded">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="banner_image" class="form-label"><?php echo e($event->banner_image ? 'Replace Banner Image' : 'Banner Image'); ?></label>
                            <input type="file" class="form-control bg-secondary text-white border-secondary" id="banner_image" name="banner_image" accept="image/*">
                            <small class="text-muted">Recommended size: 1920x1080px</small>
                            <?php $__errorArgs = ['banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Current Logo -->
                        <?php if($event->logo): ?>
                            <div class="mb-3">
                                <label class="form-label">Current Logo</label>
                                <div class="border border-secondary rounded p-2 text-center">
                                    <img src="<?php echo e(Storage::url($event->logo)); ?>" alt="Logo" class="img-fluid" style="max-height: 100px;">
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="logo" class="form-label"><?php echo e($event->logo ? 'Replace Logo' : 'Event Logo'); ?></label>
                            <input type="file" class="form-control bg-secondary text-white border-secondary" id="logo" name="logo" accept="image/*">
                            <small class="text-muted">Recommended size: 400x400px</small>
                            <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="visibility" class="form-label">Visibility *</label>
                            <select class="form-select bg-secondary text-white border-secondary" id="visibility" name="visibility" required>
                                <option value="public" <?php echo e(old('visibility', $event->visibility) === 'public' ? 'selected' : ''); ?>>Public</option>
                                <option value="private" <?php echo e(old('visibility', $event->visibility) === 'private' ? 'selected' : ''); ?>>Private</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="expected_viewers" class="form-label">Expected Viewers</label>
                            <input type="number" class="form-control bg-secondary text-white border-secondary" id="expected_viewers" name="expected_viewers" min="0"
                                   value="<?php echo e(old('expected_viewers', $event->expected_viewers)); ?>">
                        </div>
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div class="card bg-secondary border-secondary mt-4">
                    <div class="card-header">
                        <h5 class="card-title text-white mb-0">DVR & Recording Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="dvr_enabled" name="dvr_enabled" value="1" 
                                           <?php echo e(old('dvr_enabled', $event->dvr_enabled) ? 'checked' : ''); ?>>
                                    <label class="form-check-label text-white" for="dvr_enabled">
                                        Enable DVR (Digital Video Recording)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dvr_hours" class="form-label">DVR Hours</label>
                                    <input type="number" class="form-control bg-dark text-white border-secondary" id="dvr_hours" name="dvr_hours" 
                                           min="1" max="168" value="<?php echo e(old('dvr_hours', $event->dvr_hours ?: 24)); ?>">
                                    <small class="text-muted">Hours to keep recording available (1-168)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Status -->
                <div class="card bg-secondary border-secondary mt-4">
                    <div class="card-header">
                        <h5 class="card-title text-white mb-0">Event Options</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   <?php echo e(old('is_featured', $event->is_featured) ? 'checked' : ''); ?>>
                            <label class="form-check-label text-white" for="is_featured">
                                Featured Event
                            </label>
                            <small class="text-muted d-block">Featured events appear prominently on the homepage</small>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="text-end">
                            <a href="<?php echo e(route('admin.fitarena.show', $event->id)); ?>" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Event
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^\w\s-]/g, '') // Remove special characters
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
        .trim('-'); // Remove leading/trailing hyphens
    
    document.getElementById('slug').value = slug;
});

// Toggle DVR hours input based on DVR enabled checkbox
document.getElementById('dvr_enabled').addEventListener('change', function() {
    const dvrHoursInput = document.getElementById('dvr_hours');
    dvrHoursInput.disabled = !this.checked;
    if (!this.checked) {
        dvrHoursInput.value = '';
    } else {
        dvrHoursInput.value = '24';
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitarena/edit.blade.php ENDPATH**/ ?>