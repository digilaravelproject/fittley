@extends('layouts.admin')

@section('title', 'Community Categories')

@section('content')
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-folder page-title-icon"></i>
                    Community Categories
                </h1>
                <p class="page-subtitle">Organize community posts with categories</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.community.dashboard') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
                <a href="{{ route('admin.community.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Category
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters and Search -->
    <div class="dashboard-card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Categories</label>
                    <input type="text" id="search" name="search" class="form-control" placeholder="Search by name or description..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Sort By</label>
                    <select id="sort" name="sort" class="form-select">
                        <option value="order" {{ request('sort') === 'order' ? 'selected' : '' }}>Order</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="posts_count" {{ request('sort') === 'posts_count' ? 'selected' : '' }}>Posts Count</option>
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Date Created</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3 class="card-title">Categories ({{ $categories->total() }})</h3>
            <div class="card-actions">
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-primary" id="bulkActionBtn" disabled>
                        <i class="fas fa-tasks me-2"></i>Bulk Actions
                    </button>
                    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" disabled id="bulkDropdown">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-action="activate"><i class="fas fa-check me-2"></i>Activate</a></li>
                        <li><a class="dropdown-item" href="#" data-action="deactivate"><i class="fas fa-ban me-2"></i>Deactivate</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#" data-action="delete"><i class="fas fa-trash me-2"></i>Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 40px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th style="width: 50px;">Order</th>
                                <th>Category</th>
                                <th style="width: 120px;">Posts</th>
                                <th style="width: 120px;">Groups</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 140px;">Created</th>
                                <th style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoriesTable">
                            @foreach($categories as $category)
                                <tr data-category-id="{{ $category->id }}">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input category-checkbox" type="checkbox" value="{{ $category->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $category->order }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="category-icon me-3" style="background-color: {{ $category->color }};">
                                                <i class="{{ $category->icon }}"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $category->name }}</h6>
                                                @if($category->description)
                                                    <small class="text-muted">{{ Str::limit($category->description, 60) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $category->posts_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $category->groups_count }}</span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" 
                                                   data-category-id="{{ $category->id }}" 
                                                   {{ $category->is_active ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $category->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.community.categories.show', $category->id) }}" 
                                               class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.community.categories.edit', $category->id) }}" 
                                               class="btn btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="deleteCategory({{ $category->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} categories
                            </small>
                        </div>
                        <div>
                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="fas fa-folder fa-3x text-muted mb-3"></i>
                    <h4>No Categories Found</h4>
                    <p class="text-muted">Get started by creating your first community category.</p>
                    <a href="{{ route('admin.community.categories.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Create Category
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this category? This action cannot be undone.</p>
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    All posts and groups in this category will be moved to "Uncategorized".
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.category-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.status-toggle {
    cursor: pointer;
}

.table th {
    border-bottom: 2px solid var(--border-primary);
    color: var(--text-primary);
    font-weight: 600;
}

.table-dark th {
    background-color: var(--bg-tertiary);
    border-color: var(--border-secondary);
}

.table-hover tbody tr:hover {
    background-color: var(--bg-hover);
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.empty-state {
    padding: 3rem 1rem;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const bulkDropdown = document.getElementById('bulkDropdown');

    selectAllCheckbox?.addEventListener('change', function() {
        categoryCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkActions();
    });

    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkActions);
    });

    function toggleBulkActions() {
        const selectedCount = document.querySelectorAll('.category-checkbox:checked').length;
        const hasSelection = selectedCount > 0;
        
        bulkActionBtn.disabled = !hasSelection;
        bulkDropdown.disabled = !hasSelection;
        
        if (hasSelection) {
            bulkActionBtn.textContent = `Bulk Actions (${selectedCount})`;
        } else {
            bulkActionBtn.textContent = 'Bulk Actions';
        }
    }

    // Status toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const categoryId = this.dataset.categoryId;
            const isActive = this.checked;
            
            fetch(`/admin/community/categories/${categoryId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ is_active: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    this.checked = !isActive; // Revert on error
                    alert('Error updating category status: ' + data.message);
                }
            })
            .catch(error => {
                this.checked = !isActive; // Revert on error
                console.error('Error:', error);
                alert('Error updating category status');
            });
        });
    });

    // Bulk actions
    document.querySelectorAll('[data-action]').forEach(actionBtn => {
        actionBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const selectedIds = Array.from(document.querySelectorAll('.category-checkbox:checked'))
                .map(checkbox => checkbox.value);

            if (selectedIds.length === 0) {
                alert('Please select categories first');
                return;
            }

            if (action === 'delete' && !confirm('Are you sure you want to delete the selected categories?')) {
                return;
            }

            performBulkAction(action, selectedIds);
        });
    });

    function performBulkAction(action, categoryIds) {
        fetch('{{ route("admin.community.categories.bulk-action") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: action,
                categories: categoryIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error performing bulk action');
        });
    }
});

function deleteCategory(categoryId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    form.action = `/admin/community/categories/${categoryId}`;
    modal.show();
}
</script>
@endpush 