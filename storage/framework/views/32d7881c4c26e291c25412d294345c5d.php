<?php $__env->startSection('title', 'Edit Session'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Session: <?php echo e(Str::limit($session->title, 40)); ?>

                    </h3>
                    <a href="<?php echo e(route('admin.fitlive.sessions.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Sessions
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.fitlive.sessions.update', ['fitLiveSession' => $session->id])); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="card bg-secondary border-info mb-4">
                                    <div class="card-header">
                                        <h5 class="text-white mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="title" class="form-label text-white">Session Title *</label>
                                            <input type="text" 
                                                   class="form-control bg-dark border-secondary text-white <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="title" 
                                                   name="title" 
                                                   value="<?php echo e(old('title', $session->title)); ?>" 
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

                                        <div class="mb-3">
                                            <label for="description" class="form-label text-white">Description</label>
                                            <textarea class="form-control bg-dark border-secondary text-white <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="4"><?php echo e(old('description', $session->description)); ?></textarea>
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
                                                <div class="mb-3">
                                                    <label for="category_id" class="form-label text-white">Category *</label>
                                                    <select class="form-select bg-dark border-secondary text-white <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                            id="category_id" 
                                                            name="category_id" 
                                                            required>
                                                        <option value="">Select Category</option>
                                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($category->id); ?>" 
                                                                    <?php echo e(old('category_id', $session->category_id) == $category->id ? 'selected' : ''); ?>>
                                                                <?php echo e($category->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <?php $__errorArgs = ['category_id'];
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
                                                <div class="mb-3">
                                                    <label for="sub_category_id" class="form-label text-white">Sub Category</label>
                                                    <select class="form-select bg-dark border-secondary text-white <?php $__errorArgs = ['sub_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                            id="sub_category_id" 
                                                            name="sub_category_id">
                                                        <option value="">Select Sub Category</option>
                                                        <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($subCategory->id); ?>" 
                                                                    data-category="<?php echo e($subCategory->category_id); ?>"
                                                                    <?php echo e(old('sub_category_id', $session->sub_category_id) == $subCategory->id ? 'selected' : ''); ?>>
                                                                <?php echo e($subCategory->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <?php $__errorArgs = ['sub_category_id'];
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

                                        <div class="mb-3">
                                            <label for="instructor_id" class="form-label text-white">Instructor *</label>
                                            <select class="form-select bg-dark border-secondary text-white <?php $__errorArgs = ['instructor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                    id="instructor_id" 
                                                    name="instructor_id" 
                                                    required>
                                                <option value="">Select Instructor</option>
                                                <?php $__currentLoopData = $instructors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instructor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($instructor->id); ?>" 
                                                            <?php echo e(old('instructor_id', $session->instructor_id) == $instructor->id ? 'selected' : ''); ?>>
                                                        <?php echo e($instructor->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['instructor_id'];
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

                            <!-- Session Settings -->
                            <div class="col-md-4">
                                <div class="card bg-secondary border-warning mb-4">
                                    <div class="card-header">
                                        <h5 class="text-white mb-0">Session Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="scheduled_at" class="form-label text-white">Scheduled Date & Time</label>
                                            <input type="datetime-local" 
                                                   class="form-control bg-dark border-secondary text-white <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="scheduled_at" 
                                                   name="scheduled_at" 
                                                   value="<?php echo e(old('scheduled_at', $session->scheduled_at ? $session->scheduled_at->format('Y-m-d\TH:i') : '')); ?>">
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
                                            <label for="chat_mode" class="form-label text-white">Chat Mode *</label>
                                            <select class="form-select bg-dark border-secondary text-white <?php $__errorArgs = ['chat_mode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                    id="chat_mode" 
                                                    name="chat_mode" 
                                                    required>
                                                <option value="">Select Chat Mode</option>
                                                <option value="during" <?php echo e(old('chat_mode', $session->chat_mode) == 'during' ? 'selected' : ''); ?>>
                                                    During Live
                                                </option>
                                                <option value="after" <?php echo e(old('chat_mode', $session->chat_mode) == 'after' ? 'selected' : ''); ?>>
                                                    After Live
                                                </option>
                                                <option value="off" <?php echo e(old('chat_mode', $session->chat_mode) == 'off' ? 'selected' : ''); ?>>
                                                    Disabled
                                                </option>
                                            </select>
                                            <?php $__errorArgs = ['chat_mode'];
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
                                            <label for="session_type" class="form-label text-white">Session Type *</label>
                                            <select class="form-select bg-dark border-secondary text-white <?php $__errorArgs = ['session_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                    id="session_type" 
                                                    name="session_type" 
                                                    required>
                                                <option value="">Select Session Type</option>
                                                <option value="daily" <?php echo e(old('session_type', $session->session_type) == 'daily' ? 'selected' : ''); ?>>
                                                    Daily
                                                </option>
                                                <option value="one_time" <?php echo e(old('session_type', $session->session_type) == 'one_time' ? 'selected' : ''); ?>>
                                                    One Time
                                                </option>
                                            </select>
                                            <?php $__errorArgs = ['session_type'];
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
                                            <label for="visibility" class="form-label text-white">Visibility *</label>
                                            <select class="form-select bg-dark border-secondary text-white <?php $__errorArgs = ['visibility'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                    id="visibility" 
                                                    name="visibility" 
                                                    required>
                                                <option value="public" <?php echo e(old('visibility', $session->visibility) == 'public' ? 'selected' : ''); ?>>
                                                    Public
                                                </option>
                                                <option value="private" <?php echo e(old('visibility', $session->visibility) == 'private' ? 'selected' : ''); ?>>
                                                    Private
                                                </option>
                                            </select>
                                            <?php $__errorArgs = ['visibility'];
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
                                            <label for="banner_image" class="form-label text-white">Banner Image</label>
                                            <?php if($session->banner_image): ?>
                                                <div class="mb-2">
                                                    <img src="<?php echo e(Storage::url($session->banner_image)); ?>" 
                                                         alt="Current banner" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 100px;">
                                                    <div class="form-text text-muted">Current banner image</div>
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" 
                                                   class="form-control bg-dark border-secondary text-white <?php $__errorArgs = ['banner_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="banner_image" 
                                                   name="banner_image" 
                                                   accept="image/*">
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
                                            <div class="form-text text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</div>
                                        </div>

                                        <!-- Session Status (read-only) -->
                                        <div class="mb-3">
                                            <label class="form-label text-white">Current Status</label>
                                            <div>
                                                <?php switch($session->status):
                                                    case ('scheduled'): ?>
                                                        <span class="badge bg-warning fs-6">Scheduled</span>
                                                        <?php break; ?>
                                                    <?php case ('live'): ?>
                                                        <span class="badge bg-success fs-6">Live</span>
                                                        <?php break; ?>
                                                    <?php case ('ended'): ?>
                                                        <span class="badge bg-secondary fs-6">Ended</span>
                                                        <?php break; ?>
                                                <?php endswitch; ?>
                                            </div>
                                        </div>

                                        <?php if($session->viewer_peak): ?>
                                            <div class="mb-3">
                                                <label class="form-label text-white">Peak Viewers</label>
                                                <div>
                                                    <span class="badge bg-info fs-6"><?php echo e($session->viewer_peak); ?></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card bg-secondary">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="<?php echo e(route('admin.fitlive.sessions.index')); ?>" class="btn btn-secondary">
                                                Cancel
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i>Update Session
                                            </button>
                                        </div>
                                    </div>
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
    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('sub_category_id');
    
    // Filter subcategories based on selected category
    categorySelect.addEventListener('change', function() {
        const selectedCategoryId = this.value;
        const subCategoryOptions = subCategorySelect.querySelectorAll('option');
        
        // Show/hide subcategory options based on selected category
        subCategoryOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else {
                const optionCategoryId = option.getAttribute('data-category');
                option.style.display = optionCategoryId === selectedCategoryId ? 'block' : 'none';
            }
        });
        
        // Reset subcategory if it doesn't belong to selected category
        const currentSubCategoryId = subCategorySelect.value;
        if (currentSubCategoryId) {
            const currentOption = subCategorySelect.querySelector(`option[value="${currentSubCategoryId}"]`);
            if (currentOption && currentOption.getAttribute('data-category') !== selectedCategoryId) {
                subCategorySelect.value = '';
            }
        }
    });
    
    // Trigger initial filtering
    categorySelect.dispatchEvent(new Event('change'));
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/admin/fitlive/sessions/edit.blade.php ENDPATH**/ ?>