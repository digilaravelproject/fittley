@extends('layouts.admin')

@section('title', 'Community Posts')

@section('content')

<style>
  .fitarena_status{
    color: #000;
  }
</style>
<div class="admin-dashboard">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h1 class="page-title-text">
                    <i class="fas fa-comments page-title-icon"></i>
                    Flagged Posts
                </h1>
                <p class="page-subtitle">Manage flagged post content</p>
            </div>
            <div class="page-actions">
                <a href="{{ route('admin.community.moderation.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">All Posts</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                        </div>
                                    </th>
                                    <th scope="col">Post</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts ?? [] as $post)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="posts[]" value="{{ $post->id }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0">{{ $post->title }}</h6>
                                                <p class="text-muted mb-0">{{ Str::limit($post->content ?? '', 50) }}</p>
                                                @if($post->is_featured ?? false)
                                                    <span class="badge bg-warning">Featured</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $post->author ?? 'Unknown' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $post->category ?? 'General' }}</span>
                                    </td>
                                    <td>
                                        @switch($post->status ?? 'draft')
                                            @case('published')
                                                <span class="badge bg-success">Published</span>
                                                @break
                                            @case('draft')
                                                <span class="badge bg-secondary">Draft</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning">Pending Review</span>
                                                @break
                                            @default
                                                <span class="badge bg-light text-dark">{{ ucfirst($post->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $post->created_at ? $post->created_at->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-comments fa-3x mb-3"></i>
                                            <h5>No posts found</h5>
                                            <p>Get started by creating your first community post.</p>
                                            <a href="{{ route('admin.community.posts.create') }}" class="btn btn-primary">
                                                Create Post
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(isset($posts) && method_exists($posts, 'hasPages') && $posts->hasPages())
                        <div class="row mt-3">
                            <div class="col-12">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fitarena_status" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fitarena_status">
                Are you sure you want to delete this post? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(postId) {
    const form = document.getElementById('deleteForm');
    form.action = `/admin/community/posts/${postId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

// Select all checkbox functionality
document.getElementById('checkAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="posts[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});
</script>
@endpush
@endsection 