

<?php $__env->startSection('title', 'Create FitArena Event'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3">
                <h4 class="mb-sm-0 font-size-18">Create New Event</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.fitarena.index')); ?>">FitArena Events</a></li>
                        <li class="breadcrumb-item active">Create Event</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="card bg-dark text-white">
        <div class="card-header border-secondary">
            <h4 class="card-title text-white">Create New Event</h4>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.fitarena.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <!-- Event Information -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Event Title *</label>
                            <input type="text" class="form-control bg-secondary text-white border-secondary" id="title" name="title" required
                                   placeholder="Enter event title" value="<?php echo e(old('title')); ?>">
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
                                   placeholder="auto-generated-from-title" value="<?php echo e(old('slug')); ?>" readonly>
                            <small class="text-muted">This will be auto-generated from the title</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" id="description" name="description" rows="4" required
                                      placeholder="Describe your event..."><?php echo e(old('description')); ?></textarea>
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
                                    <label for="start_date" class="form-label">Start Date & Time *</label>
                                    <input type="datetime-local" class="form-control bg-secondary text-white border-secondary" id="start_date" name="start_date" required
                                           value="<?php echo e(old('start_date')); ?>">
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
                                    <label for="end_date" class="form-label">End Date & Time</label>
                                    <input type="datetime-local" class="form-control bg-secondary text-white border-secondary" id="end_date" name="end_date"
                                           value="<?php echo e(old('end_date')); ?>">
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control bg-secondary text-white border-secondary" id="location" name="location"
                                           placeholder="e.g., Online, New York, etc." value="<?php echo e(old('location', 'Online')); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="event_type" class="form-label">Event Type</label>
                                    <select class="form-select bg-secondary text-white border-secondary" id="event_type" name="event_type">
                                        <option value="competition" <?php echo e(old('event_type') == 'competition' ? 'selected' : ''); ?>>Competition</option>
                                        <option value="training" <?php echo e(old('event_type') == 'training' ? 'selected' : ''); ?>>Training Session</option>
                                        <option value="workshop" <?php echo e(old('event_type') == 'workshop' ? 'selected' : ''); ?>>Workshop</option>
                                        <option value="challenge" <?php echo e(old('event_type') == 'challenge' ? 'selected' : ''); ?>>Challenge</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="instructor_id" class="form-label">Assign Instructor</label>
                            <select class="form-select bg-secondary text-white border-secondary" id="instructor_id" name="instructor_id">
                                <option value="">Select an instructor (optional)</option>
                                <?php $__currentLoopData = $instructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($instructor->id); ?>" <?php echo e(old('instructor_id') == $instructor->id ? 'selected' : ''); ?>>
                                        <?php echo e($instructor->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-muted">You can also assign instructors to individual sessions later</small>
                        </div>

                        <div class="mb-3">
                            <label for="rules" class="form-label">Event Rules</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" id="rules" name="rules" rows="3"
                                      placeholder="Define the rules and guidelines..."><?php echo e(old('rules')); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="prizes" class="form-label">Prizes & Rewards</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" id="prizes" name="prizes" rows="3"
                                      placeholder="List prizes and rewards..."><?php echo e(old('prizes')); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="sponsors" class="form-label">Sponsors</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" id="sponsors" name="sponsors" rows="2"
                                      placeholder="List event sponsors..."><?php echo e(old('sponsors')); ?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Event Settings -->
                        <div class="card bg-secondary border-secondary mb-3">
                            <div class="card-header border-secondary">
                                <h6 class="card-title text-white mb-0">Event Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select bg-dark text-white border-secondary" id="status" name="status">
                                        <option value="draft" <?php echo e(old('status', 'draft') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                                        <option value="upcoming" <?php echo e(old('status') == 'upcoming' ? 'selected' : ''); ?>>Upcoming</option>
                                        <option value="live" <?php echo e(old('status') == 'live' ? 'selected' : ''); ?>>Live</option>
                                        <option value="completed" <?php echo e(old('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="max_participants" class="form-label">Max Participants</label>
                                    <input type="number" class="form-control bg-dark text-white border-secondary" id="max_participants" name="max_participants"
                                           placeholder="Leave blank for unlimited" value="<?php echo e(old('max_participants')); ?>">
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1"
                                           <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                                    <label class="form-check-label text-white" for="is_featured">
                                        Featured Event
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="registration_required" name="registration_required" value="1"
                                           <?php echo e(old('registration_required', true) ? 'checked' : ''); ?>>
                                    <label class="form-check-label text-white" for="registration_required">
                                        Registration Required
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1"
                                           <?php echo e(old('is_public', true) ? 'checked' : ''); ?>>
                                    <label class="form-check-label text-white" for="is_public">
                                        Public Event
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card bg-secondary border-secondary">
                            <div class="card-header border-secondary">
                                <h6 class="card-title text-white mb-0">Featured Image</h6>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control bg-dark text-white border-secondary" id="featured_image" name="featured_image" accept="image/*">
                                    <?php $__errorArgs = ['featured_image'];
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
                                <div id="image_preview" class="d-none">
                                    <img id="preview_img" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                                <small class="text-muted">Recommended size: 800x600px</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="text-end">
                            <a href="<?php echo e(route('admin.fitarena.index')); ?>" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Event
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitarena/create.blade.php ENDPATH**/ ?>