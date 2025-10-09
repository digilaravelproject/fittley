

<?php $__env->startSection('content'); ?>
<div class="subcategories-index">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-folder-open me-3"></i>FitGuide Subcategories
                </h1>
                <p class="page-subtitle">Manage subcategories for your educational content</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?php echo e(route('admin.fitguide.subcategories.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Subcategory
                </a>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Content Table -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="content-card-title">
                        <i class="fas fa-list me-2"></i>Subcategories
                    </h3>
                    <p class="content-card-subtitle">All subcategories for FitGuide content</p>
                </div>
            </div>
        </div>
        <div class="content-card-body p-0">
            <?php if($subCategories->count() > 0): ?>
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Subcategory</th>
                                <th>Parent Category</th>
                                <th>Content</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="subcategory-info">
                                            <div class="subcategory-title"><?php echo e($subcategory->name); ?></div>
                                            <div class="subcategory-slug"><?php echo e($subcategory->slug); ?></div>
                                            <?php if($subcategory->description): ?>
                                                <div class="subcategory-description"><?php echo e(Str::limit($subcategory->description, 80)); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="parent-category">
                                            <?php echo e($subcategory->category->name); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="content-counts">
                                            <span class="content-count singles"><?php echo e($subcategory->singles_count ?? 0); ?> Singles</span>
                                            <span class="content-count series"><?php echo e($subcategory->series_count ?? 0); ?> Series</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="sort-order"><?php echo e($subcategory->sort_order); ?></span>
                                    </td>
                                    <td>
                                        <?php if($subcategory->is_active): ?>
                                            <span class="status-badge status-active">
                                                <i class="fas fa-circle"></i>
                                                Active
                                            </span>
                                        <?php else: ?>
                                            <span class="status-badge status-inactive">
                                                <i class="fas fa-circle"></i>
                                                Inactive
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('admin.fitguide.subcategories.show', $subcategory)); ?>" 
                                               class="action-btn action-btn-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.fitguide.subcategories.edit', $subcategory)); ?>" 
                                               class="action-btn action-btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="action-btn action-btn-success toggle-status-btn" 
                                                    data-id="<?php echo e($subcategory->id); ?>"
                                                    title="Toggle Status">
                                                <i class="fas fa-toggle-<?php echo e($subcategory->is_active ? 'on' : 'off'); ?>"></i>
                                            </button>
                                            <form method="POST" 
                                                  action="<?php echo e(route('admin.fitguide.subcategories.destroy', $subcategory)); ?>" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="action-btn action-btn-danger" 
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if($subCategories->hasPages()): ?>
                    <div class="d-flex justify-content-center mt-4 px-4 pb-4">
                        <?php echo e($subCategories->links()); ?>

                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="empty-title">No Subcategories Found</div>
                    <div class="empty-description">You haven't created any subcategories yet. Create your first subcategory to better organize your content.</div>
                    <div class="empty-action">
                        <a href="<?php echo e(route('admin.fitguide.subcategories.create')); ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Create Your First Subcategory
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.subcategories-index {
    animation: fadeInUp 0.6s ease-out;
}

.subcategory-info .subcategory-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.subcategory-info .subcategory-slug {
    font-size: 0.875rem;
    color: var(--text-muted);
    font-family: monospace;
    margin-bottom: 0.25rem;
}

.subcategory-info .subcategory-description {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.parent-category {
    background: var(--primary-light);
    color: var(--primary-dark);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    display: inline-block;
}

.content-counts {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.content-count {
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.125rem 0.5rem;
    border-radius: 12px;
}

.content-count.singles {
    background: var(--success-light);
    color: var(--success-dark);
}

.content-count.series {
    background: var(--info-light);
    color: var(--info-dark);
}

.sort-order {
    background: var(--bg-light);
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-weight: 500;
    color: var(--text-secondary);
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
    const toggleBtns = document.querySelectorAll('.toggle-status-btn');
    
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const subcategoryId = this.dataset.id;
            
            fetch(`/admin/fitguide/subcategories/${subcategoryId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Something went wrong');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong');
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/fitguide/subcategories/index.blade.php ENDPATH**/ ?>