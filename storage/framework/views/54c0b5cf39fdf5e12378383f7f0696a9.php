

<?php $__env->startSection('title', 'FitLive Categories'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .pagination-wrapper {
        display: flex;
        justify-content: space-between; /* info left, controls right */
        align-items: center;            /* vertical align center */
        flex-wrap: wrap;                /* wrap if screen small */
        width: 100%;
        padding: 10px 15px;
    }
    .pagination-info {
        font-size: 14px;
        color: #aaa;
    }
    .pagination-controls {
        display: flex;
        justify-content: flex-end;
    }
</style>
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-folder page-title-icon"></i>
                    FitLive Categories
                </h1>
                <p class="page-subtitle">Manage live session categories and organization</p>
            </div>
            <div class="page-actions">
                <a href="<?php echo e(route('admin.fitlive.categories.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Category
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-primary">
                            <i class="fas fa-folder"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo e($categories->total()); ?></div>
                            <div class="stat-label">Total Categories</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-success">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo e($categories->sum('sub_categories_count') ?? 0); ?></div>
                            <div class="stat-label">Subcategories</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-info">
                            <i class="fas fa-broadcast-tower"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo e($categories->sum('fit_live_sessions_count') ?? 0); ?></div>
                            <div class="stat-label">Live Sessions</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-card-body">
                        <div class="stat-icon stat-icon-warning">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo e($categories->where('chat_mode', 'during')->count()); ?></div>
                            <div class="stat-label">Chat Enabled</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list me-2"></i>All Categories
            </h3>
            <div class="card-actions">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control" placeholder="Search categories..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($categories->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Chat Mode</th>
                                <th>Sort Order</th>
                                <th>Content</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <div class="avatar-placeholder">
                                                    <i class="fas fa-folder"></i>
                                                </div>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name"><?php echo e($category->name); ?></div>
                                                <div class="user-role"><?php echo e($category->slug); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php switch($category->chat_mode):
                                            case ('during'): ?>
                                                <span class="status-badge status-success">
                                                    <i class="fas fa-circle me-1"></i>During Live
                                                </span>
                                                <?php break; ?>
                                            <?php case ('after'): ?>
                                                <span class="status-badge status-warning">
                                                    <i class="fas fa-circle me-1"></i>After Live
                                                </span>
                                                <?php break; ?>
                                            <?php case ('off'): ?>
                                                <span class="status-badge status-secondary">
                                                    <i class="fas fa-circle me-1"></i>Disabled
                                                </span>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <span class="status-badge status-secondary">
                                                    <i class="fas fa-circle me-1"></i>Unknown
                                                </span>
                                        <?php endswitch; ?>
                                    </td>
                                    <td>
                                        <div class="badge-metric">
                                            Order #<?php echo e($category->sort_order); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="content-stats">
                                            <span class="stat-item">
                                                <i class="fas fa-folder-open me-1"></i>
                                                <?php echo e($category->sub_categories_count ?? 0); ?> Subcategories
                                            </span>
                                            <span class="stat-item">
                                                <i class="fas fa-video me-1"></i>
                                                <?php echo e($category->fit_live_sessions_count ?? 0); ?> Sessions
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="date-primary"><?php echo e($category->created_at->format('M d, Y')); ?></div>
                                            <div class="date-secondary"><?php echo e($category->created_at->diffForHumans()); ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('admin.fitlive.categories.show', $category)); ?>" 
                                               class="btn btn-action btn-info" 
                                               title="View Category">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.fitlive.categories.edit', $category)); ?>" 
                                               class="btn btn-action btn-warning" 
                                               title="Edit Category">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.fitlive.categories.destroy', $category)); ?>" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="btn btn-action btn-danger" 
                                                        title="Delete Category">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php if($categories->hasPages()): ?>
                    <div class="content-card-footer">
                        <div class="pagination-wrapper">
                            <div class="pagination-controls">
                                <?php echo e($categories->links('pagination.custom')); ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="empty-state-content">
                        <h3 class="empty-state-title">No categories found</h3>
                        <p class="empty-state-description">
                            Get started by creating your first category to organize your live sessions.
                        </p>
                        <a href="<?php echo e(route('admin.fitlive.categories.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Category
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Dark Theme Table Styling */
.table-modern {
    background: #191919;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    --bs-table-bg: #191919;
    --bs-table-color: #ffffff;
    --bs-table-border-color: #333333;
    --bs-table-hover-bg: #202020;
    --bs-table-hover-color: #ffffff;
}

.table-modern thead th {
    background: #141414;
    color: #ffffff;
    font-weight: 600;
    padding: 1rem;
    border: none;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 2px solid #f8a721;
}

.table-modern tbody tr {
    background: #191919;
    border-bottom: 1px solid #333333;
    transition: all 0.3s ease;
    color: #ffffff;
}

.table-modern tbody tr:hover {
    background: #202020;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(248, 167, 33, 0.15);
}

.table-modern tbody td {
    padding: 1rem;
    vertical-align: middle;
    border: none;
    color: #ffffff;
}

/* Status Badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: flex;
    align-items: center;
    white-space: nowrap;
    background: #141414;
}

.status-success {
    color: #28a745;
    border: 1px solid #28a745;
}

.status-warning {
    color: #f8a721;
    border: 1px solid #f8a721;
}

.status-secondary {
    color: #999999;
    border: 1px solid #999999;
}

/* User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8a721, #e8950e);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #191919;
    font-size: 1.25rem;
}

.user-details {
    flex: 1;
    min-width: 0;
}

.user-name {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    line-height: 1.2;
    margin-bottom: 0.25rem;
}

.user-role {
    font-size: 0.875rem;
    color: #999999;
    line-height: 1.2;
}

/* Content Stats */
.content-stats {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-item {
    font-size: 0.875rem;
    color: #cccccc;
    display: flex;
    align-items: center;
}

.stat-item i {
    color: #f8a721;
    margin-right: 0.5rem;
}

/* Date Info */
.date-info {
    text-align: left;
}

.date-primary {
    font-size: 0.875rem;
    font-weight: 500;
    color: #ffffff;
    margin-bottom: 0.25rem;
}

.date-secondary {
    font-size: 0.75rem;
    color: #999999;
}

/* Badge Metric */
.badge-metric {
    background: #141414;
    color: #f8a721;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    border: 1px solid #f8a721;
    text-align: center;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-action {
    padding: 0.5rem;
    border-radius: 6px;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
}

.btn-info {
    background: #141414;
    color: #f8a721;
    border: 1px solid #f8a721;
}

.btn-info:hover {
    background: #f8a721;
    color: #191919;
    transform: translateY(-2px);
}

.btn-warning {
    background: #141414;
    color: #f8a721;
    border: 1px solid #f8a721;
}

.btn-warning:hover {
    background: #f8a721;
    color: #191919;
    transform: translateY(-2px);
}

.btn-danger {
    background: #141414;
    color: #dc3545;
    border: 1px solid #dc3545;
}

.btn-danger:hover {
    background: #dc3545;
    color: #ffffff;
    transform: translateY(-2px);
}

/* Search Box */
.search-box {
    position: relative;
    width: 250px;
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #999999;
    z-index: 2;
}

.search-box .form-control {
    padding-left: 2.5rem;
    background: #141414;
    border: 1px solid #333333;
    color: #ffffff;
    border-radius: 8px;
}

.search-box .form-control:focus {
    background: #141414;
    border-color: #f8a721;
    box-shadow: 0 0 0 0.2rem rgba(248, 167, 33, 0.25);
    color: #ffffff;
}

.search-box .form-control::placeholder {
    color: #999999;
}

/* Global Text Colors */
.text-muted {
    color: #999999 !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .table-modern thead th {
        padding: 0.75rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .table-modern tbody td {
        padding: 0.75rem 0.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('tbody tr');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\fittley\resources\views/admin/fitlive/categories/index.blade.php ENDPATH**/ ?>