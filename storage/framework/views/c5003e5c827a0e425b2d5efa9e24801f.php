

<?php $__env->startSection('title', 'Edit Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="dashboard-title">Edit Category</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.fitguide.index')); ?>">FitGuide</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.fitguide.categories.index')); ?>">Categories</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('admin.fitguide.categories.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Categories
                </a>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Error!</strong>
                <ul class="mb-0 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="content-card">
            <div class="content-card-header">
                <h5 class="content-card-title">Category Information</h5>
                <p class="content-card-subtitle">Update the category details below</p>
            </div>
            <div class="content-card-body">
                <form action="<?php echo e(route('admin.fitguide.categories.update', $fgCategory)); ?>" method="POST" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?php echo e(old('name', $fgCategory->name)); ?>" 
                                       required>
                                <?php $__errorArgs = ['name'];
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
                                       value="<?php echo e(old('slug', $fgCategory->slug)); ?>"
                                       placeholder="Auto-generated from name if left empty">
                                <div class="form-text">URL-friendly version of the name. Leave empty to auto-generate.</div>
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
                                          id="description" 
                                          name="description" 
                                          rows="4"
                                          placeholder="Brief description of this category"><?php echo e(old('description', $fgCategory->description)); ?></textarea>
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

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Sort Order</label>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="<?php echo e(old('sort_order', $fgCategory->sort_order)); ?>" 
                                       min="0"
                                       placeholder="0">
                                <div class="form-text">Lower numbers appear first</div>
                                <?php $__errorArgs = ['sort_order'];
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
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1"
                                           <?php echo e(old('is_active', $fgCategory->is_active) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="is_active">
                                        Active Status
                                    </label>
                                </div>
                                <div class="form-text">Only active categories are visible to users</div>
                            </div>

                            <div class="category-stats">
                                <h6 class="text-muted mb-3">Category Statistics</h6>
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <div class="stat-value"><?php echo e($fgCategory->sub_categories_count ?? $fgCategory->subCategories->count()); ?></div>
                                        <div class="stat-label">Subcategories</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value"><?php echo e($fgCategory->singles_count ?? $fgCategory->singles->count()); ?></div>
                                        <div class="stat-label">Single Videos</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value"><?php echo e($fgCategory->series_count ?? $fgCategory->series->count()); ?></div>
                                        <div class="stat-label">Series</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Category
                        </button>
                        <a href="<?php echo e(route('admin.fitguide.categories.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        if (!slugInput.dataset.manual) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });
    
    slugInput.addEventListener('input', function() {
        slugInput.dataset.manual = 'true';
    });
    
    // Form validation
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>

<style>
.category-stats {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.stat-item {
    text-align: center;
    padding: 10px;
    background: white;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

.stat-value {
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 12px;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-actions {
    border-top: 1px solid #e9ecef;
    padding-top: 20px;
    margin-top: 30px;
    display: flex;
    gap: 10px;
}
</style>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitguide/categories/edit.blade.php ENDPATH**/ ?>