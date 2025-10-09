

<?php $__env->startSection('content'); ?>
<style>
    .pagination-wrapper {
        display: flex;
        justify-content: space-between; /* info left, controls right */
        align-items: center;
        flex-wrap: wrap;
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

<div class="users-management">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-users me-3"></i>
                    User Management
                </h1>
                <p class="page-subtitle">Manage user accounts, roles, and permissions</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add New User
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid mb-5">
        <div class="row g-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-primary">
                    <div class="stat-card-body">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo e($users->total()); ?></div>
                            <div class="stat-label">Total Users</div>
                            <div class="stat-trend">
                                <i class="fas fa-arrow-up"></i><span>Active accounts</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-success">
                    <div class="stat-card-body">
                        <div class="stat-icon"><i class="fas fa-user-shield"></i></div>
                        <div class="stat-content">
                            <div class="stat-number">
                                <?php echo e($users->filter(fn($u) => $u->roles->contains('name','admin'))->count()); ?>

                            </div>
                            <div class="stat-label">Administrators</div>
                            <div class="stat-trend"><i class="fas fa-shield-alt"></i><span>System admins</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-info">
                    <div class="stat-card-body">
                        <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="stat-content">
                            <div class="stat-number">
                                <?php echo e($users->filter(fn($u) => $u->roles->contains('name','instructor'))->count()); ?>

                            </div>
                            <div class="stat-label">Instructors</div>
                            <div class="stat-trend"><i class="fas fa-graduation-cap"></i><span>Course creators</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6">
                <div class="stat-card stat-card-warning">
                    <div class="stat-card-body">
                        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                        <div class="stat-content">
                            <div class="stat-number">
                                <?php echo e($users->filter(fn($u) => $u->roles->contains('name','user'))->count()); ?>

                            </div>
                            <div class="stat-label">Students</div>
                            <div class="stat-trend"><i class="fas fa-book-open"></i><span>Learners</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="content-card-title"><i class="fas fa-list me-2"></i>All Users</h3>
                    <p class="content-card-subtitle">Complete list of registered users</p>
                </div>
                <div class="table-controls">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search users..." class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="content-card-body p-0">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar"><i class="fas fa-user"></i></div>
                                    <div class="user-details">
                                        <div class="user-name"><?php echo e($user->name); ?></div>
                                        <div class="user-id">#<?php echo e($user->id); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><div class="user-email"><?php echo e($user->email); ?></div></td>
                            <td>
                                <div class="role-badges">
                                    <?php $__empty_2 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <span class="role-badge role-<?php echo e($role->name); ?>">
                                            <?php if($role->name === 'admin'): ?>
                                                <i class="fas fa-crown"></i>
                                            <?php elseif($role->name === 'instructor'): ?>
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            <?php else: ?>
                                                <i class="fas fa-user"></i>
                                            <?php endif; ?>
                                            <?php echo e(ucfirst($role->name)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        <span class="role-badge role-none">No Role</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <div class="date-primary"><?php echo e($user->created_at->format('M d, Y')); ?></div>
                                    <div class="date-secondary"><?php echo e($user->created_at->diffForHumans()); ?></div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-active">
                                    <i class="fas fa-circle"></i> Active
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="action-btn action-btn-warning" title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.users.delete', $user->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="action-btn action-btn-danger" title="Delete User" onclick="return confirm('Delete this user?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-users"></i></div>
                                    <div class="empty-content">
                                        <h4>No Users Found</h4>
                                        <p>There are no users to display at the moment.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if($users->hasPages()): ?>
            <div class="content-card-footer">
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing <?php echo e($users->firstItem()); ?>-<?php echo e($users->lastItem()); ?> of <?php echo e($users->total()); ?> users
                    </div>
                    <div class="pagination-controls">
                        <?php echo e($users->links('pagination.custom')); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u945294333/domains/fittelly.com/public_html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>