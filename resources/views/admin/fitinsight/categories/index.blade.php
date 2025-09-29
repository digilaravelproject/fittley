@extends('layouts.admin')

@section('title', 'FitInsight Categories')

@section('content')

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
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">FitInsight Categories</h1>
                <p class="page-subtitle">Manage blog categories for FitInsight content</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.fitinsight.blogs.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-blog me-2"></i>Manage Blogs
                </a>
                <a href="{{ route('admin.fitinsight.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Category
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="content-card mb-4">
        <div class="content-card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search categories..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="sort_order" {{ request('sort_by') === 'sort_order' ? 'selected' : '' }}>Sort Order</option>
                        <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="blogs_count" {{ request('sort_by') === 'blogs_count' ? 'selected' : '' }}>Blog Count</option>
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Created Date</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.fitinsight.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Categories ({{ $categories->total() }})</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-danger" id="bulk-delete-btn" style="display: none;">
                        <i class="fas fa-trash me-1"></i>Delete Selected
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-success" id="bulk-activate-btn" style="display: none;">
                        <i class="fas fa-check me-1"></i>Activate Selected
                    </button>
                </div>
            </div>
        </div>
        <div class="content-card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </th>
                                <th>Category</th>
                                <th>Icon</th>
                                <th>Blogs</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_categories[]" value="{{ $category->id }}" class="form-check-input category-checkbox">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($category->banner_image_path)
                                                <?php /*<img src="{{ $category->banner_image_url }}" alt="{{ $category->name }}" 
                                                    class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;"> */?>
                                            @else
                                                <?php /*<div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                    style="width: 40px; height: 40px; color: {{ $category->color }};">
                                                    <i class="{{ $category->icon ?: 'fas fa-folder' }}"></i>
                                                </div>*/?>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $category->name }}</div>
                                                @if($category->description)
                                                    <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($category->icon)
                                            <i class="{{ $category->icon }}" style="color: {{ $category->color }};"></i>
                                            <small class="text-muted ms-1">{{ $category->icon }}</small>
                                        @else
                                            <span class="text-muted">No icon</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">{{ $category->published_blogs_count }}</span>
                                            <small class="text-muted">{{ $category->blogs_count }} total</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $category->sort_order }}</span>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" type="checkbox" 
                                                data-id="{{ $category->id }}" 
                                                {{ $category->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $category->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.fitinsight.categories.show', $category) }}" 
                                            class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.fitinsight.categories.edit', $category) }}" 
                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($category->canBeDeleted())
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-category" 
                                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-secondary" disabled title="Cannot delete - has blogs">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
                    </div>
                    {{ $categories->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No categories found</h5>
                    <p class="text-muted">Start by creating your first blog category.</p>
                    <a href="{{ route('admin.fitinsight.categories.create') }}" class="btn btn-primary">
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
                <p>Are you sure you want to delete the category "<span id="category-name"></span>"?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="delete-form" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulk-action-form" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulk-action">
    <input type="hidden" name="categories" id="bulk-categories">
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Select All functionality
    $('#select-all').change(function() {
        $('.category-checkbox').prop('checked', this.checked);
        toggleBulkActions();
    });

    $('.category-checkbox').change(function() {
        toggleBulkActions();
        
        // Update select all checkbox
        const totalCheckboxes = $('.category-checkbox').length;
        const checkedCheckboxes = $('.category-checkbox:checked').length;
        $('#select-all').prop('checked', totalCheckboxes === checkedCheckboxes);
    });

    // Toggle bulk action buttons
    function toggleBulkActions() {
        const checkedCount = $('.category-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#bulk-delete-btn, #bulk-activate-btn').show();
        } else {
            $('#bulk-delete-btn, #bulk-activate-btn').hide();
        }
    }

    // Status toggle
    $('.status-toggle').change(function() {
        const categoryId = $(this).data('id');
        const isActive = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/fitinsight/categories/${categoryId}/toggle-status`,
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Failed to update status');
                }
            },
            error: function() {
                alert('Failed to update status');
            }
        });
    });

    // Delete category
    $('.delete-category').click(function() {
        const categoryId = $(this).data('id');
        const categoryName = $(this).data('name');
        
        $('#category-name').text(categoryName);
        $('#delete-form').attr('action', `/admin/fitinsight/categories/${categoryId}`);
        $('#deleteModal').modal('show');
    });

    // Bulk actions
    $('#bulk-delete-btn').click(function() {
        if (confirm('Are you sure you want to delete the selected categories?')) {
            performBulkAction('delete');
        }
    });

    $('#bulk-activate-btn').click(function() {
        performBulkAction('activate');
    });

    function performBulkAction(action) {
        const selectedCategories = $('.category-checkbox:checked').map(function() {
            return this.value;
        }).get();

        if (selectedCategories.length === 0) {
            alert('Please select categories first');
            return;
        }

        $('#bulk-action').val(action);
        $('#bulk-categories').val(JSON.stringify(selectedCategories));
        $('#bulk-action-form').attr('action', '{{ route("admin.fitinsight.categories.bulk-action") }}').submit();
    }
});
</script>
@endpush 