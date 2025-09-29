@extends('layouts.admin')

@section('content')
<div class="categories-index">
    <!-- Header Section -->
    <div class="page-header mb-5">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="fas fa-folder me-3"></i>FitGuide Categories
                </h1>
                <p class="page-subtitle">Manage categories for your educational content</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('admin.fitguide.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Category
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

    <!-- Content Table -->
    <div class="content-card">
        <div class="content-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="content-card-title">
                        <i class="fas fa-list me-2"></i>Categories
                    </h3>
                    <p class="content-card-subtitle">All categories for FitGuide content</p>
                </div>
            </div>
        </div>
        <div class="content-card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Subcategories</th>
                                <th>Content</th>
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        <div class="category-info">
                                            <div class="category-title">{{ $category->name }}</div>
                                            <div class="category-slug">{{ $category->slug }}</div>
                                            @if($category->description)
                                                <div class="category-description">{{ Str::limit($category->description, 80) }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="count-badge">{{ $category->sub_categories_count }}</span>
                                    </td>
                                    <td>
                                        <div class="content-counts">
                                            <span class="content-count singles">{{ $category->singles_count }} Singles</span>
                                            <span class="content-count series">{{ $category->series_count }} Series</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="sort-order">{{ $category->sort_order }}</span>
                                    </td>
                                    <td>
                                        <div class="status-toggle" data-id="{{ $category->id }}">
                                            @if($category->is_active)
                                                <span class="status-badge status-active">
                                                    <i class="fas fa-circle"></i>
                                                    Active
                                                </span>
                                            @else
                                                <span class="status-badge status-inactive">
                                                    <i class="fas fa-circle"></i>
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.fitguide.categories.show', $category) }}" 
                                               class="action-btn action-btn-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.fitguide.categories.edit', $category) }}" 
                                               class="action-btn action-btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="action-btn action-btn-success toggle-status-btn" 
                                                    data-id="{{ $category->id }}"
                                                    title="Toggle Status">
                                                <i class="fas fa-toggle-{{ $category->is_active ? 'on' : 'off' }}"></i>
                                            </button>
                                            <form method="POST" 
                                                  action="{{ route('admin.fitguide.categories.destroy', $category) }}" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="action-btn action-btn-danger" 
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($categories->hasPages())
                    <div class="d-flex justify-content-center mt-4 px-4 pb-4">
                        {{ $categories->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="empty-title">No Categories Found</div>
                    <div class="empty-description">You haven't created any categories yet. Create your first category to organize your content.</div>
                    <div class="empty-action">
                        <a href="{{ route('admin.fitguide.categories.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Create Your First Category
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.categories-index {
    animation: fadeInUp 0.6s ease-out;
}

.category-info .category-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.category-info .category-slug {
    font-size: 0.875rem;
    color: var(--text-muted);
    font-family: monospace;
    margin-bottom: 0.25rem;
}

.category-info .category-description {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.count-badge {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
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

.status-badge.status-active {
    background: var(--success-light);
    color: var(--success-dark);
}

.status-badge.status-inactive {
    background: var(--warning-light);
    color: var(--warning-dark);
}

.toggle-status-btn {
    cursor: pointer;
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
            const categoryId = this.dataset.id;
            
            fetch(`/admin/fitguide/categories/${categoryId}/toggle-status`, {
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
@endsection 