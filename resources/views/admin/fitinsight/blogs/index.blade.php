@extends('layouts.admin')

@section('title', 'FitInsight Blogs')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">FitInsight Blogs</h1>
            <p class="text-muted">Manage your blog posts and articles</p>
        </div>
        <a href="{{ route('admin.fitinsight.blogs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Blog
        </a>
    </div>

    <!-- Content -->
    <div class="card">
        <div class="card-body">
            @if($blogs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Views</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <td>{{ $blog->title }}</td>
                                    <td>{{ $blog->category->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $blog->status === 'published' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($blog->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $blog->author->name }}</td>
                                    <td>{{ $blog->views_count }}</td>
                                    <td>
                                        {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Not published' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.fitinsight.blogs.edit', $blog) }}" class="btn btn-sm btn-primary">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $blogs->links() }}
            @else
                <div class="text-center py-5">
                    <h5 class="text-muted">No blogs found</h5>
                    <p class="text-muted">Create your first blog post to get started.</p>
                    <a href="{{ route('admin.fitinsight.blogs.create') }}" class="btn btn-primary">
                        Create New Blog
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 